! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildFinishSingle',
        data: {
          checkedMen: [],
          menList: [],
          selectData: {
            id: ''
          },
          isHide: true,
          isHide2: true
        },
        mounted() {
          this.get_id = $('#getId').val() || ''
          $('#navbar').removeClass('invisible')
        },
        methods: {
          removeFnc() {

            this.$confirm('此操作将删除该请款, 是否继续?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              _http.TeamManager.deleteFinish({
                  id: this.get_id || ''
                })
                .then(res => {
                  $('#btnGroup').html(`<h3 class="ui header aligned center" style="color: rgba(0,0,0,.6);">已删除</h3>`)
                  this.$message({
                    type: 'success',
                    message: '删除成功!'
                  });
                })
            }).catch(() => {
              this.$message({
                type: 'info',
                message: '已取消删除'
              });
            });
          },
          recheckFnc() {
            _http.TeamManager.checkFinish({
                id: this.get_id
              })
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '复核成功',
                    type: 'success'
                  })
                  this.isHide = false
                  this.selectData.id = res.data.data.id
                  _http.UserManager.searchAuthUsers({
                      role: 'build_finish_pass'
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
          //选择审核人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审核人
          confirmRecheck() {
            let postData = this.selectData
            postData.users = this.checkedMen
            _http.TeamManager.selectFinishPass(postData)
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
          },

          //审批
          passFnc() {
            _http.TeamManager.passFinish({
                id: this.get_id
              })
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '审批成功',
                    type: 'success'
                  })
                  this.isHide2 = false
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