! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildPayApply',
        data: {
          applyForm: {
            date: _helper.timeFormat(new Date(), 'YYY-MM-DD'),
            price: '',
            payee: '',
            bank: '',
            account: '',
            project_id: '',
            team_id: ''
          },

          checkedMen: [],
          menList: [],
          selectData: {
            id: ''
          }
        },
        mounted() {
          let teamInfo = $('#teamInfo').text().trim()
            teamInfo = JSON.parse(teamInfo)
            console.log(teamInfo.name)
          this.applyForm.project_id = $('#projectId').val()
          this.applyForm.team_id = $('#teamId').val()
          this.applyForm.bank = teamInfo.bank
          this.applyForm.account = teamInfo.account
          this.applyForm.payee = teamInfo.name

        },
        methods: {

          submit() {
            _http.TeamManager.createPayApply(this.applyForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
                  })
                  this.selectData.id = res.data.data.id
                  _http.UserManager.searchAuthUsers({
                      role: 'build_pay_check'
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
            _http.TeamManager.selectPayCheck(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功', 
                    message: '已选择了复核人',
                    type: 'success'
                  })
                  $('.ui.dimmer').removeClass('active')
                  setTimeout(() => {
                      window.close();
              }, 2000)
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