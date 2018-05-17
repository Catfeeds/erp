! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#budgetaryCheck',
        data: {
          checkedMen: [],
          menList: [],
          selectData: {
            id: ''
          }
        },

        mounted() {
          const vm = this
          $('#budgetaryCheckRecheck').on('click', function () {
            vm.$confirm('确定复核, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              })
              .then(() => {
                _http.BuyManager.createCheck({
                  id: $(this).data('id')
                })
                  .then(res => {
                    if (res.data.code === '200') {
                      const data = res.data.data
                      const currentType = data.type == 1 ? 'rolebuy_bugetary_pass' : 'buy_extrabugetary_pass'
                      vm.selectData.id = data.id
                      vm.$message({
                        type: 'success',
                        message: '已复核!'
                      })
                      _http.UserManager.searchAuthUsers({
                          role: currentType,
                          // project_id: this.budgetary_buy.project_id
                        })
                        .then(resp => {
                          if (resp.data.code === '200') {
                            vm.menList = resp.data.data
                            $('.ui.dimmer').addClass('active')
                          } else {
                            vm.$notify({
                              title: '错误',
                              message: res.data.msg,
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
              })
              .catch(() => {
                vm.$message({
                  type: 'info',
                  message: '已取消'
                })
              })
          })


          $('#budgetaryCheckPass').on('click', function () {
            vm.$confirm('确定审批, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              })
              .then(() => {
                _http.BuyManager.createPass({
                    id: $(this).data('id')
                  })
                  .then(res => {
                    if (res.data.code === '200') {
                      vm.$message({
                        type: 'success',
                        message: '已审批!'
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
          //选择审批人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审批人
          confirmRecheck() {
            this.selectData.users = this.checkedMen
            _http.BuyManager.selectPass(this.selectData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '已选择了审批人',
                    type: 'success'
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
          }
        }
      })
    })
}()