! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'projectList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })

      const projectId = $('#projectId').val() || ''

      new Vue({
        el: '#projectCheckDialog',
        data: {
          checkedMen: [],
          menList: [],
          selectData: {
            id: ''
          }
        },
        mounted() {
          const self = this
          // $('#projectCheckBtn').on('click', function () {
          //   _http.ProjectManager.checkProject({
          //       id: projectId
          //     })
          //     .then(res => {
          //       if (res.data.code === '200') {
          //         self.$notify({
          //           title: '成功',
          //           message: `已复核`,
          //           type: 'success'
          //         })
          //         $(this).remove()
          //         self.selectData.id = res.data.data.id
          //         _http.UserManager.searchAuthUsers({
          //             role: 'project_pass'
          //           })
          //           .then(resp => {
          //             if (resp.data.code === '200') {
          //               self.menList = resp.data.data
          //               $('.ui.dimmer').addClass('active')
          //             } else {
          //               self.$notify({
          //                 title: '错误',
          //                 message: res.data.msg,
          //                 type: 'error'
          //               })
          //             }
          //           })
          //       } else {
          //         self.$notify({
          //           title: '错误',
          //           message: res.data.msg,
          //           type: 'error'
          //         })
          //       }
          //     })
          //     .catch(err => {
          //       self.$notify({
          //         title: '错误',
          //         message: '服务器出错',
          //         type: 'error'
          //       })
          //     })
          // })

          // $("#projectPass").on('click', function () {
          //   self.$confirm('确认审批, 是否继续?', '提示', {
          //     confirmButtonText: '确定',
          //     cancelButtonText: '取消',
          //     type: 'warning'
          //   }).then(() => {
          //     _http.ProjectManager.passProject({
          //         id: projectId
          //       })
          //       .then(res => {
          //         if (res.data.code === '200') {
          //           $(this).remove()
          //           self.$notify({
          //             title: '成功',
          //             message: '已审批',
          //             type: 'success'
          //           })
          //         } else {
          //           self.$notify({
          //             title: '错误',
          //             message: res.data.msg,
          //             type: 'error'
          //           })
          //         }
          //       })
          //       .catch(err => {
          //         self.$notify({
          //           title: '错误',
          //           message: '服务器出错',
          //           type: 'error'
          //         })
          //       })
          //   }).catch(() => {
          //     self.$message({
          //       type: 'info',
          //       message: '已取消'
          //     });
          //   });
          // })

          $('#projectConfirm').on('click', function () {
            self.$confirm('确认该项目后无法删除, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              })
              .then(() => {
                _http.ProjectManager.confirmProject({
                    id: projectId
                  })
                  .then(res => {
                    if (res.data.code === '200') {
                      self.$notify({
                        title: '成功',
                        message: '已确认',
                        type: 'success'
                      })
                      $('#projectDelete').remove()
                      $(this).remove()
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


          $('#projectDelete').on('click', function () {
            self.$confirm('删除改项目, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              })
              .then(() => {
                _http.ProjectManager.deleteProject({
                    id: projectId
                  })
                  .then(res => {
                    if (res.data.code === '200') {
                      $('#projectBtns').html(`
                      <h3 class="ui header aligned center" style="color:#db2828;opacity: 0.8;text-align: center;">已删除</h3>
                      `)
                      self.$notify({
                        title: '成功',
                        message: '已确认',
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
        },
        methods: {

          //选择审批人
          // handleCheckManChange(value) {
          //   console.log(this.checkedMen)
          // },

          // //提交审批人
          // confirmRecheck() {
          //   let postData = this.selectData
          //   postData.users = this.checkedMen
          //   _http.ProjectManager.selectProjectPass(postData)
          //     .then(res => {
          //       if (res.data.code === '200') {
          //         this.$notify({
          //           title: '成功',
          //           message: '已选择了审批人',
          //           type: 'success'
          //         })
          //         $('.ui.dimmer').removeClass('active')
          //       } else {
          //         this.$notify({
          //           title: '错误',
          //           message: res.data.msg,
          //           type: 'error'
          //         })
          //       }
          //     })
          //     .catch(err => {
          //       this.$notify({
          //         title: '错误',
          //         message: '服务器出错',
          //         type: 'error'
          //       })
          //     })
          // }
        }
      })
    })
}()