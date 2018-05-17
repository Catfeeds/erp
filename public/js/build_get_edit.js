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
          },
          invoice_type: []
        },
        mounted() {
          const invoice_type = $("#invoiceTypeList").text().trim()
          this.invoice_type = invoice_type === ''?[]:JSON.parse(invoice_type)
          this.form.get_date = $('#getDate').val()
          this.form.invoice_date = $('#invoiceDate').val()
          this.form.type = $('#invoiceType').val()
          $('#buildGetEdit').removeClass('invisible')
        },
        methods: {}
      })
    })
}()