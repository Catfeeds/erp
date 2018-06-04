! function () {
  $(document)
    .ready(() => {
      const currentType = $('#type').val()
      const projectId = $('#projectId').val()
      const loanId = $('#loanId').val()
      new Vue({
        el: '#submitSingleDialog',
        data: {
          checkedMen: [],
          menList: [],
          selectData: {
            id: ''
          }
        },
        mounted() {
          const self = this
          $('#submitSingleDelete').on('click', function () {
            self.$confirm('确认删除该内容, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              })
              .then(() => {
                _http.LoanManager.deleteSubmit({
                    id: loanId
                  })
                  .then(res => {
                    if (res.data.code === '200') {
                      $(this).parents('div').html(`
                      <h3 class="ui header aligned center" style="text-align:center;color:rgba(,.8);">已删除</h3>
                      `)
                      self.$notify({
                        title: '成功',
                        message: '已删除',
                        type: 'success'
                      })
                    } else {
                      self.$notify({
                        title: '错误',
                        message: res.data.msg,
                        type: 'error'
                      })
                    }
                  })
                  .catch(err => {
                    self.$notify({
                      title: '错误',
                      message: '服务器出错',
                      type: 'error'
                    })
                  })
              })
              .catch(() => {
                self.$message({
                  type: 'info',
                  message: '已取消'
                });
              });
          })

          $('#submitSingleCheck').on('click', function () {
            _http.LoanManager.checkSubmit({
                id: loanId
              })
              .then(res => {
                if (res.data.code === '200') {
                  self.$notify({
                    title: '成功',
                    message: `已复核`,
                    type: 'success'
                  })
                  $(this).parents('button').remove()
                  self.selectData.id = res.data.data.id
                  _http.UserManager.searchAuthUsers({
                      role: currentType == 1 ? 'loan_submit_pass' : 'loan_project_submit_pass',
                      project_id: projectId
                    })
                    .then(resp => {
                      if (resp.data.code === '200') {
                        self.menList = resp.data.data
                        $('.ui.dimmer').addClass('active')
                      } else {
                        self.$notify({
                          title: '错误',
                          message: res.data.msg,
                          type: 'error'
                        })
                      }
                    })
                } else {
                  self.$notify({
                    title: '错误',
                    message: res.data.msg,
                    type: 'error'
                  })
                }
              })
              .catch(err => {
                self.$notify({
                  title: '错误',
                  message: '服务器出错',
                  type: 'error'
                })
              })
          })

          $("#submitSinglePass").on('click', function () {
            self.$confirm('确认审批, 是否继续?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              _http.LoanManager.passSubmit({
                  id: loanId
                })
                .then(res => {
                  if (res.data.code === '200') {
                    self.$notify({
                      title: '成功',
                      message: '已审批',
                      type: 'success'
                    })
                  } else {
                    self.$notify({
                      title: '错误',
                      message: res.data.msg,
                      type: 'error'
                    })
                  }
                })
                .catch(err => {
                  self.$notify({
                    title: '错误',
                    message: '服务器出错',
                    type: 'error'
                  })
                })
            }).catch(() => {
              self.$message({
                type: 'info',
                message: '已取消'
              });
            });
          })
        },
        methods: {

          //选择审批人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审批人
          confirmRecheck() {
            let postData = this.selectData
            postData.users = this.checkedMen
            _http.LoanManager.selectPassSubmit(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '已选择了审批人',
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