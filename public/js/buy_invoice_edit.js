! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#buyInvoiceEdit',
        data: {
          form: {
            date: '',
            invoice_date: '',
            type: '',
            with_tax: '',
            without_tax: ''
          },
          invoiceType: []
        },
        mounted() {
          this.form.id = $('editId').val() || ''
          this.form.date = $('#getDate').val()
          this.form.invoice_date = $('#invoiceDate').val()
          this.form.number = $('#invoiceDate').val()
          this.form.type = $('#type').val()
          this.form.with_tax = $('#withTax').val()
          this.form.without_tax = $('#withoutTax').val()
          const invoiceType = $('#invoiceType').text().val()
          this.invoiceType = invoiceType === '' ? [] : JSON.parse(invoiceType)
          $('#buyInvoiceEdit').removeClass('invisible')
        },
        methods: {
          submit() {
            _http.BuyManager.editInvoice(postData)
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
          }
        }
      })
    })
}()