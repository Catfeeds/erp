! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#budgetaryBuy',
        data: {
          budgetary_buy: _schemas.budgetary_buy,

          invoiceType: [],

          //物料
          materials: [],

          //复核人dialog
          checkedMen: [],
          menList: [{
              id: 1,
              name: '张先生'
            },
            {
              id: 2,
              name: '陈一发'
            },
            {
              id: 3,
              name: '刘芳芳'
            },
            {
              id: 4,
              name: '乌达奇'
            },
            {
              id: 5,
              name: '何求'
            }
          ],

          throttle: {
            supplier_timer: null,
          }
        },
        mounted() {
          this.budgetary_buy.info.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
          const invoiceType = $('#invoiceType').text().trim()
          this.invoiceType = invoiceType === '' ? [] : JSON.parse(invoiceType)
          const materials = $('#materials').text().trim()
          this.materials = materials === '' ? [] : JSON.parse(materials)
          this.budgetary_buy.project_id = $('#projectId').val()
          $('#budgetaryBuy').removeClass('invisible')
        },

        computed: {
          materialsComputed() {
            const vm = this
            if (vm.materials.length < 1) {
              return []
            }
            if (vm.budgetary_buy.lists.length < 1) {
              const dataStr = JSON.stringify(vm.materials)
              return JSON.parse(dataStr)
            }

            const dataStr = JSON.stringify(vm.materials)
            let result = JSON.parse(dataStr)
            let list = vm.budgetary_buy.lists
            let sum = 0
            for (let i in list) {
              let item = list[i]
              let material = item.material
              if (typeof item.number === 'undefined') break
              sum += parseFloat(item.cost || 0)
              let materialIndex = material.index
              result[materialIndex].need_number -= parseInt(item.number || 0)
            }
            vm.budgetary_buy.amount = sum || 0
            return result
          }
        },
        methods: {
          
          //供应商输入提示
          handleSelectSupplier(item) {
            this.budgetary_buy.info.supplier_id = item.id
            this.budgetary_buy.info.supplier_name = item.name
            this.budgetary_buy.info.bank = item.bank
            this.budgetary_buy.info.account = item.account
          },
          querySearchSupplier(queryString, cb) {

            if (this.throttle.supplier_timer) {
              clearTimeout(this.throttle.supplier_timer)
            }
            this.throttle.supplier_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.SupplierManager.searchSuppliers(searchKey)
                .then(res => {
                  if (res.data.code === '200') {
                    cb(res.data.data)
                  } else {
                    this.$notify({
                      title: '错误',
                      message: res.data.msg || '未知错误',
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
            }, 500)
          },

          //物料选择
          addMaterial(item, index) {
            const list = this.budgetary_buy.lists
            let data = {
              own_id: list.length > 0 ? list[list.length - 1].own_id ? list[list.length - 1].own_id + 1 : 1 : 1,
              material: item,
              material_id: item.id
            }
            data.material.index = index
            this.budgetary_buy.lists.push(data)
          },

          //删除项
          deleteItem(name, item, index) {
            this.budgetary_buy[name].splice(index, 1)
          },

          //合同上传
          uploadContract(e) {
            const files = e.target.files
            if (files.length < 1) {
              return
            }
            let fileArr = []
            for (let file of files) {
              let formData = new FormData()
              formData.append('image', file)
              _http.UploadManager.createUpload(formData)
                .then(res => {
                  if (res.data.code === '200') {
                    const resData = res.data.data
                    this.budgetary_buy.contracts.push({
                      id: resData.size,
                      name: resData.name,
                      href: resData.url
                    })
                    this.$notify({
                      title: '成功',
                      message: `${resData.name} 上传成功`,
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
          
          dataFormat(data) {
            let result = {
              info: data.info,
              project_id: data.project_id,
              contracts: data.contracts,
              lists: []
            }

            const list = data.lists
            for (let i = 0; i < list.length; i++) {
              const currentData = list[i]
              let tmp = {
                material_id: currentData.material_id || ''
              }
              tmp.number = currentData.number
              tmp.price = currentData.price
              tmp.cost = currentData.cost
              tmp.warranty_date = currentData.warranty_date
              tmp.warranty_time = currentData.warranty_time
              result.lists.push(tmp)
            }
            return result
          },

          //提交
          submitForm() {
            const postData = this.dataFormat(this.budgetary_buy)
            console.log(postData)
            _http.BuyManager.createPurchase(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify.success({
                    title: '成功',
                    message: '提交成功！'
                  })
                  $('.ui.dimmer').addClass('active')
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

          //选择审核人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审核人
          confirmRecheck() {
            this.$notify({
              title: '成功',
              message: '已选择了复核人',
              type: 'success'
            })
            $('.ui.dimmer').removeClass('active')
          }
        }
      })
    })
}()