! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#loanLoanPay',
        data: {

          loanForm: {
            manager: '',
            bank: '',
            account: '',
            pay_type: '',
            date: ''
          },
          date: '',
          bankList: []

        },
        created() {
          this.loanForm.id = $('#payId').val() || ''
          this.loanForm.manager = $('#manager').val() || ''
          this.loanForm.bank = $('#bank').val() || ''
          this.loanForm.account = $('#account').val() || ''
          this.loanForm.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
          console.log(this.loanForm)
          const bankList = $('#banks').text().trim()
          this.bankList = bankList === '' ? [] : JSON.parse(bankList)
          $('#loanLoanPay').removeClass('invisible')
        },
        methods: {

          bankChange(index) {
            try {
              this.loanForm.account = this.bankList[index].account
              this.loanForm.bank = this.bankList[index].id
            } catch (error) {
              console.log(error)
            }
          },

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