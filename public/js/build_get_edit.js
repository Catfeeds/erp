! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#buildGetEdit',
        data: {
          form: {
            get_date: '',
            invoice_date: '',
            type: '',
            number: '',
            tax: '',
              without_tax:''
          },
            invoiceType: []
        },
        mounted() {
          const invoice_type = $("#invoiceTypeList").text().trim()
          this.invoiceType = invoice_type === ''?[]:JSON.parse(invoice_type)
          this.form.get_date = $('#getDate').val()
          this.form.invoice_date = $('#invoiceDate').val()
          this.form.type = $('#invoiceType').val()
          this.form.tax = $('#tax').val()
          this.form.without_tax = $('#withoutTax').val()
          this.form.number = $('#number').val()
            console.log(this.form)
          $('#buildGetEdit').removeClass('invisible')
        },
        methods: {}
      })
    })
}()