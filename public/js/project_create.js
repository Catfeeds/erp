! function () {
  $(document)
    .ready(function () {

      const contractContent = $('#contractContent').text().trim() === '' ? [] : JSON.parse($('#contractContent').text().trim())
      // const contractTax = $('#contractTax').text().trim() === '' ? [] : JSON.parse($('#contractTax').text().trim())
      const projectData = $('#projectData').text().trim() === '' ? false : JSON.parse($('#projectData').text().trim())

      function idSearch(value) {
        let newObj = {}
        for (let it of value) {
          newObj[it.id] = it.name
        }
        return newObj
      }

      function idSearch2(value) {
        let newObj = {}
        for (let it of value) {
          newObj[it.id] = it.rate
        }
        return newObj
      }

      function idSearch3(value) {
        let newObj = {}
        for (let it of value) {
          newObj[it.name] = it.id
        }
        return newObj
      }

      const ContentIDMap = idSearch(contractContent)
      const TaxIDMap = idSearch2(contractContent)
      const ContentNameMap = idSearch3(contractContent)

      new Vue({
        el: '#projectCreate',
        data: {
          project: _schemas.projects,
          contractContent,
          TaxIDMap,
          ContentIDMap,
          checkedMen: [],
          menList: [],
          selectData: {
            id: ''
          }
        },
        mounted() {
          if (projectData) {
            this.project = _helper.projectGetFormat(projectData, ContentNameMap)
          }
          $('#projectCreate').removeClass('invisible')
        },
        computed: {
          sumAmount() {
            const vm = this
            const masterContract = vm.project.masterContract
            const subContract = vm.project.subContract
            let sum = 0
            let result = []

            function calc(name, value) {
              if (value.length < 1) {
                return false
              }
              value.forEach((item, index) => {
                const amount = item.amount ? parseFloat(item.amount) : 0
                sum += amount
                result.push({
                  head: index === 0,
                  id: name + item.id,
                  amount: amount.toLocaleString('en-US'),
                  type: name
                })
              })
            }

            calc('m', masterContract)
            calc('s', subContract)

            return {
              sum: sum.toLocaleString('en-US'),
              result
            }
          },

          sumContent() {
            const vm = this
            const masterContract = vm.project.masterContract
            const subContract = vm.project.subContract
            let sum = 0
            let resultObj = {}
            let result = []
            if (!masterContract || !subContract) {
              return undefined
            }

            function calc(value) {
              value.forEach((father, fatherIndex) => {
                const details = father.details
                if (!details || details.length < 1) {
                  return false
                }
                details.forEach((item, index) => {
                  const amount = item.amount ? parseFloat(item.amount) : 0
                  sum += amount
                  if (typeof item.name !== 'undefined') {
                    // const key = item.name + '' + item.tax
                    const key = item.name
                    resultObj[key] = resultObj[key] ? resultObj[key] + amount : amount
                  }
                })
              })
            }

            calc(masterContract)
            calc(subContract)

            for (let it in resultObj) {
              // const val = it.split('')
              // const contentData = vm.ContentIDMap[val[0]]
              // const taxData = vm.TaxIDMap[val[1]]
              const contentData = vm.ContentIDMap[it]
              const taxData = vm.TaxIDMap[it]
              result.push({
                name: contentData,
                tax: taxData,
                amount: resultObj[it]
              })
            }

            return {
              sum: sum,
              result
            }
          },

          sumMargins() {
            const vm = this
            const margins = vm.project.margins
            let sum = {
              sumGuaranteeAmount: 0,
              sumGuaranteeCost: 0,
              sumPaymentCost: 0,
            }

            if (margins.length < 1) {
              return sum
            }

            margins.forEach((item, index) => {
              sum.sumGuaranteeAmount += item.guarantee_amount ? parseFloat(item.guarantee_amount) : 0
              sum.sumGuaranteeCost += item.guarantee_cost ? parseFloat(item.guarantee_cost) : 0
              sum.sumPaymentCost += item.payment_amount ? parseFloat(item.payment_amount) : 0
            })
            return sum
          },

          sumPaymentConditions() {
            const vm = this
            const payment = vm.project.paymentConditions
            let sum = 0

            if (payment.length < 1) {
              return sum
            }

            payment.forEach((item, index) => {
              sum += item.expected ? parseFloat(item.expected) : 0
            })
            return sum
          }
        },
        methods: {

          //第一层数据操作
          addFirstItem(name) {
            const project = this.project[name]
            const length = project.length
            let id
            if (length > 0) {
              id = project[length - 1].id + 1
            } else {
              id = 1
            }
            if (name === 'masterContract' || name === 'subContract') {
              this.project[name].push({
                id,
                details: new Array()
              })
            } else {
              this.project[name].push({
                id
              })
            }
          },

          //第一层数据操作，删除
          deleteFirstItem(name, item, index) {
            this.project[name].splice(index, 1)
          },

          //第二层数据操作
          addSecondItem(name, index) {
            let details = this.project[name][index].details || []
            const length = details.length
            let id
            if (length > 0) {
              id = details[length - 1].id + 1
            } else {
              id = 1
            }
            this.project[name][index].details.push({
              id
            })
          },

          //第二层数据操作，删除
          deleteSecondItem(name, index, subIndex, item) {
            this.project[name][index].details.splice(subIndex, 1)
          },

          //文件上传
          fileUpload(e) {
            const files = e.target.files
            let fileArr = []
            for (let file of files) {
              let formData = new FormData()
              formData.append('image', file)
              _http.UploadManager.createUpload(formData)
                .then(res => {
                  if (res.data.code === '200') {
                    const resData = res.data.data
                    this.project.contracts.push({
                      id: resData.size,
                      name: resData.name,
                      url: resData.url
                    })
                    this.$notify({
                      title: '成功',
                      message: `${resData.name} 提交成功`,
                      type: 'success'
                    })
                  } else {
                    this.$notify({
                      title: '错误',
                      message: res.data.msg,
                      type: 'error'
                    })
                  }
                })
                .catch(err => {
                  this.$notify({
                    title: '错误',
                    message: '服务器出错',
                    type: 'error'
                  })
                })
            }
          },

          //提交
          submit() {
            const postData = _helper.projectCreatFormat(this.project, ContentIDMap, TaxIDMap)
            _http.ProjectManager.createProject(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
                  })
                  // this.selectData.id = res.data.data.id
                  // _http.UserManager.searchAuthUsers({
                  //     role: 'project_check'
                  //   })
                  //   .then(resp => {
                  //     if (resp.data.code === '200') {
                  //       this.menList = resp.data.data
                  //       $('.ui.dimmer').addClass('active')
                  //     } else {
                  //       this.$notify({
                  //         title: '错误',
                  //         message: res.data.msg,
                  //         type: 'error'
                  //       })
                  //     }
                  //   })
                } else {
                  this.$notify({
                    title: '错误',
                    message: res.data.msg,
                    type: 'error'
                  })
                }
              })
              .catch(err => {
                this.$notify({
                  title: '错误',
                  message: '服务器出错',
                  type: 'error'
                })
              })
          },


          //选择复核人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交复核人
          confirmRecheck() {
            let postData = this.selectData
            postData.users = this.checkedMen
            _http.ProjectManager.selectProjectCheck(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '已选择了复核人',
                    type: 'success'
                  })
                  $('.ui.dimmer').removeClass('active')
                } else {
                  this.$notify({
                    title: '错误',
                    message: res.data.msg,
                    type: 'error'
                  })
                }
              })
              .catch(err => {
                this.$notify({
                  title: '错误',
                  message: '服务器出错',
                  type: 'error'
                })
              })
          }
        }
      })
    })
}()