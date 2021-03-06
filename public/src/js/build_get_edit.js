! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#buildGetEdit',
        data: {
          form: {
            get_date: '',
            invoice_date: '',
            type: ''
          }
        },
        mounted() {
          this.form.get_date = $('#getDate').val()
          this.form.invoice_date = $('#invoiceDate').val()
          this.form.type = $('#invoiceType').val()
          $('#buildGetEdit').removeClass('invisible')
        },
        methods: {}
      })
    })
}()