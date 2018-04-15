! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#payPay',
        data: {

          payForm: {
            people: '',
            date: '',
            cash: '',
            amount: '',
            others: '',
            bank: '',
            account: '',
            remark: '',
          },

        },
        mounted() {
          $('#payPay').removeClass('invisible')
          this.payForm.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },
        methods: {

          //提交
          submit() {
            this.$notify({
              title: '成功',
              message: '提交成功',
              type: 'success'
            })
            $('.ui.dimmer').addClass('active')
          },
        }
      })
    })
}()