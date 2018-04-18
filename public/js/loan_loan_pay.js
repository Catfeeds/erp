! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#loanLoanPay',
        data: {

          loanForm: {
            manager: '',
            pay_data: '',
            bank: '',
            account: '',
            pay_type: '',
          },

        },
        mounted() {
          this.loanForm.id = $('#payId').val() || ''
          this.loanForm.manager = $('#manager').val() || ''
          this.loanForm.bank = $('#bank').val() || ''
          this.loanForm.account = $('#account').val() || ''
          $('#loanLoanPay').removeClass('invisible')
          this.loanForm.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },
        methods: {

          //提交
          submit() {
            _http.LoanManager.payLoan(this.loanForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify.success({
                    title: '成功',
                    message: '提交成功！'
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
        }
      })
    })
}()