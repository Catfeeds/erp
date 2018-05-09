! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#loanSubmitOther',
        data: {

          submitProjectForm: {
            loan_user: '',
            date: '',
            price: '',
            project_id: '',
            project_content: '',
            lists: [],
          },

          //费用类型
          paymentData: {
            currentTypeIndex: '',
            currentType: {},
            typeList: [],
            currentDetailTypeIndex: '',
            currentDetailType: {},
            detailTypeList: []
          },

          checkedMen: [],
          menList: [],

          selectData: {
            id: ''
          },

          throttle: {
            project_id_timer: null,
            project_content_timer: null,
          }
        },
        mounted() {
          _http.LoanManager.searchCategory()
            .then(res => {
              if (res.data.code === '200') {
                this.paymentData.typeList = res.data.data
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

          this.submitProjectForm.price = $('#topAmount').val()
          this.submitProjectForm.date = $('#date').val() || _helper.timeFormat(new Date(), 'YYYY-MM-DD')
          this.submitProjectForm.loan_user = $('#loanUser').val()
          this.submitProjectForm.project_id = $('#projectId').val()
          this.submitProjectForm.project_number = $('#projectNumber').val()
          this.submitProjectForm.project_content = $('#projectContent').val()
          const dataList = $('#lists').text().trim()
          this.submitProjectForm.lists = dataList === '' ? [] : JSON.parse(dataList)
          $('#loanSubmitOther').removeClass('invisible')
        },
        computed: {

          sumAmount() {
            const list = this.submitProjectForm.lists
            if (!list.length) {
              return 0
            }
            let sum = 0
            list.forEach((it, index) => {
              const amount = it.price
              if (amount) {
                sum += amount * 1
              }
            })
            return sum
          }
        },
        methods: {

          //项目搜索
          querySearchProjectId(queryString, cb) {
            if (this.throttle.project_id_timer) {
              clearTimeout(this.throttle.project_id_timer)
            }
            this.throttle.project_id_timer = setTimeout(() => {
              const searchKey = {
                id: queryString
              }
              _http.ProjectManager.searchProject(searchKey)
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
          handleSelectProjectId(item) {
            this.submitProjectForm.project_id = item.id
            this.submitProjectForm.project_number = item.number
            this.submitProjectForm.project_content = item.name
          },

          querySearchProjectContent(queryString, cb) {
            if (this.throttle.project_content_timer) {
              clearTimeout(this.throttle.project_content_timer)
            }
            this.throttle.project_content_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.ProjectManager.searchProject(searchKey)
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
          handleSelectProjectContent(item) {
            this.submitProjectForm.project_id = item.id
            this.submitProjectForm.project_number = item.number
            this.submitProjectForm.project_content = item.name
          },

          //新增项
          addItem() {

            const category_id = this.paymentData.currentType.id
            const kind_id = this.paymentData.currentDetailType.id
            if (category_id !== '') {
              const list = this.submitProjectForm.lists
              let data = {
                id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
                kind_id: kind_id,
                category_id: category_id,
                type: this.paymentData.currentType.title,
                detailType: this.paymentData.currentDetailType.title,
              }
              this.submitProjectForm.lists.push(data)
            } else {
              this.$notify({
                title: '错误',
                message: '请先选择具体事项',
                type: 'error'
              })
            }
          },

          //删除
          deleteItem(name, item, index) {
            this.submitProjectForm[name].splice(index, 1)
          },

          //选择器
          typeChange(typeIndex) {
            const currentType = this.paymentData.typeList[typeIndex]
            this.paymentData.currentType = currentType
            this.paymentData.currentDetailTypeIndex = ''
            this.paymentData.detailTypeList = currentType.kinds.length ? currentType.kinds : []

          },

          detailTypeChange(detailTypeIndex) {
            const currentDetailType = this.paymentData.detailTypeList[detailTypeIndex]
            this.paymentData.currentDetailType = currentDetailType
          },

          formatData(data) {
            let result = {
              loan_user: data.loan_user,
              date: data.date,
              price: data.price,
              project_id: data.project_id,
              lists: []
            }
            const list = data.lists
            for (let i = 0; i < list.length; i++) {
              let tmp = {
                category_id: list[i].category_id,
                kind_id: list[i].kind_id,
                remark: list[i].remark,
                number: list[i].number,
                price: list[i].price,
              }
              result.lists.push(tmp)
            }
            return result
          },

          //提交
          submit() {
            const postData = this.formatData(this.submitProjectForm)
            console.log(postData)
            _http.LoanManager.createSubmitProject(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
                  })
                  this.selectData.id = res.data.data.id
                  console.log('send')
                  _http.UserManager.searchAuthUsers({
                      role: 'loan_project_submit_check',
                      project_id: this.submitProjectForm.project_id
                    })
                    .then(resp => {
                      if (resp.data.code === '200') {
                        this.menList = resp.data.data
                        $('.ui.dimmer').addClass('active')
                      } else {
                        this.$notify({
                          title: '错误',
                          message: resp.data.msg,
                          type: 'error'
                        })
                      }
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
          },
          //选择审批人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交复核人
          confirmRecheck() {
            let postData = this.selectData
            postData.users = this.checkedMen
            _http.LoanManager.selectCheckSubmit(postData)
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