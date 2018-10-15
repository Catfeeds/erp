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
            amount_without_tax: '',
            tax: ''
          },
          invoice_type: []
        },
        mounted() {
          const invoice_type = $("#invoiceTypeList").text().trim()
          this.invoice_type = invoice_type === '' ? [] : JSON.parse(invoice_type)
          this.form.get_date = $('#getDate').val()
          this.form.invoice_date = $('#invoiceDate').val()
          this.form.type = $('#invoiceType').val()
          $('#buildGetEdit').removeClass('invisible')
        },
        computed: {
          withTax() {
            const amount = this.form.amount_without_tax
            const tax = this.form.tax
            return new BigNumber(amount).plus(tax)
          }
        },
        methods: {}
      })
    })
}()