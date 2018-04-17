! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#loanLoanPay',
        data: {

          loanForm: {
            people: '',
            data: '',
            bank: '',
            account: '',
            type: '',
          },

        },
        mounted() {
          $('#loanLoanPay').removeClass('invisible')
          this.loanFomr.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },
        methods: {

          //提交
          submit() {
            this.$notify({
              title: '成功',
              message: '提交成功',
              type: 'success'
            })
          },
        }
      })
    })
}()