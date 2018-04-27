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
          $('#navbar').removeClass('invisible')
        },
        methods: {
          recheckFnc() {
            _http.TeamManager.checkFinish()
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
          passFnc(){
            _http.TeamManager.passFinish(postData)
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