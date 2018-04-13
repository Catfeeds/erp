! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#paymentFinish',
        data: {
          form: {
            pay_date: '',
            remark: '',
            bank: ''
          },
        },
        mounted() {
          this.form.pay_date = $('#hiddenDate').val() || ''
          this.form.bank = $('#bankAccount').val() || ''
          $('.ui.dropdown').dropdown()
        },
        methods: {

          //提交
          submitForm() {
            console.log(this.form)
            this.$notify({
              title: '成功',
              message: '提交成功！',
              type: 'success'
            })
          },
        }
      })
    })
}()