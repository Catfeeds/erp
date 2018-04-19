! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataInvoiceAdd',
        data: {
          invoiceForm: {
            id: '',
            name: '',
            remark: '',
            rate: '',
          }
        },
        mounted() {
          this.invoiceForm.id = $('#invoiceId').val()
          this.invoiceForm.name = $('#invoiceName').val()
          this.invoiceForm.rate = $('#invoiceRate').val()
          this.invoiceForm.remark = $('#invoiceRemark').val()
        },
        methods: {
          //提交
          submit() {
            _http.InvoiceManager.createInvoice(this.invoiceForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '提交成功',
                    type: 'success'
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