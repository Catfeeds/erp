! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#paymentCreate',
        data: {
          form: {
            date: '',
            price: '',
            purchase_id: ''
          },
          checkedMen: [],
          menList: [],
          project_id: '',
          selectData: {
            id: ''
          }
        },
        mounted() {
          this.form.purchase_id = $('#purchaseId').val() || ''
          this.form.date = $('#hiddenDate').val() || ''
          this.form.price = $('#hiddenAmount').val() || ''
          this.project_id = $('#projectId').val() || ''
        },
        methods: {

          //提交
          submitForm() {
            for (let it in this.form) {
              if (this.form[it] === '') {
                this.$notify({
                  title: '错误',
                  message: '不能有空信息！',
                  type: 'error'
                })
                return false
              }
            }
            _http.BuyManager.createPayment(this.form)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
                  })
                  this.selectData.id = res.data.data.id
                  _http.UserManager.searchAuthUsers({
                    role: 'buy_pay_pass',
                    project_id: this.project_id
                  })
                    .then(resp => {
                      if (resp.data.code === '200') {
                        this.menList = resp.data.data
                        $('.ui.dimmer').addClass('active')
                      } else {
                        this.$notify({
                          title: '错误',
                          message: res.data.msg,
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
            this.selectData.users = this.checkedMen
            _http.BuyManager.selectPaymentCheck(this.selectData)
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