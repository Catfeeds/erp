! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildPaySingle',
        data: {
          checkedMen: [],
          menList: [],
          selectData: {
            id: ''
          }
        },
        mounted() {
          const vm = this
          $('.paySingleBtn').on('click', function () {
            vm.$confirm('确定复核, 是否继续?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              _http.TeamManager.checkPay({
                  id: $(this).data('id')
                })
                .then(res => {
                  if (res.data.code === '200') {
                    vm.$message({
                      type: 'success',
                      message: '已复核!'
                    })
                    $(this).remove()
                    vm.selectData.id = res.data.data.id
                    _http.UserManager.searchAuthUsers({
                        role: 'build_finish_pass'
                      })
                      .then(resp => {
                        if (resp.data.code === '200') {
                          vm.menList = resp.data.data
                          $('.ui.dimmer').addClass('active')
                        } else {
                          vm.$notify({
                            title: '错误',
                            message: resp.data.msg,
                            type: 'error'
                          })
                        }
                      })
                  } else {
                    vm.$notify({
                      title: '错误',
                      message: res.data.msg,
                      type: 'error'
                    })
                  }
                })
                .catch(err => {
                  vm.$notify({
                    title: '错误',
                    message: '服务器出错',
                    type: 'error'
                  })
                })
            }).catch(() => {
              vm.$message({
                type: 'info',
                message: '已取消'
              })
            })
          })

          $('.payPassBtn').on('click', function () {
            vm.$confirm('确定审批, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              })
              .then(() => {
                _http.TeamManager.passPay({
                    id: $(this).data('id')
                  })
                  .then(res => {
                    if (res.data.code === '200') {
                      vm.$notify({
                        title: '成功',
                        message: '审批成功',
                        type: 'success'
                      })
                      $(this).remove()
                    } else {
                      vm.$notify({
                        title: '错误',
                        message: res.data.msg,
                        type: 'error'
                      })
                    }
                  })
                  .catch(err => {
                    vm.$notify({
                      title: '错误',
                      message: '服务器出错',
                      type: 'error'
                    })
                  })
              })
              .catch(() => {
                vm.$message({
                  type: 'info',
                  message: '已取消'
                })
              })
          })
        },
        methods: {
          //选择审核人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审核人
          confirmRecheck() {
            let postData = this.selectData
            postData.users = this.checkedMen
            _http.TeamManager.selectPayPasser(postData)
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