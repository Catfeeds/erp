! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#payAdd',
        data: {

          payForm: {
            apply_user: '',
            date: '',
            price: '',
            application: '',
            project_id: '',
            project_content: '',
          },

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
            id_timer: null,
            name_timer: null,
          }
        },
        mounted() {
          $('#payAdd').removeClass('invisible')
          this.payForm.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },
        methods: {

          //项目搜索
          querySearchProjectId(queryString, cb) {
            clearTimeout(this.throttle.id_timer)
            this.throttle.id_timer = setTimeout(() => {
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
            this.payForm.project_id = item.id
            this.payForm.project_content = item.name
          },

          querySearchProjectContent(queryString, cb) {
            clearTimeout(this.throttle.name_timer)
            this.throttle.name_timer = setTimeout(() => {
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
            this.payForm.project_id = item.id
            this.payForm.project_content = item.name
          },

          //提交
          submit() {
            _http.PaymentManager.createPayAdd(this.payForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
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
          //选择审批人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审批人
          confirmRecheck() {
            this.$notify({
              title: '成功',
              message: '已选择了审批人',
              type: 'success'
            })
            $('.ui.dimmer').removeClass('active')
          }
        }
      })
    })
}()