! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataSupplierAdd',
        data: {
          supplierForm: {
            id: '',
            name: '',
            bank: '',
            account: ''
          }
        },
        mounted() {
          this.supplierForm.id = $('#supplierId').val() || ''
          this.supplierForm.name = $('#supplierName').val() || ''
          this.supplierForm.bank = $('#supplierBank').val() || ''
          this.supplierForm.account = $('#supplierAccount').val() || ''
        },
        methods: {
          //提交
          submit() {
            _http.SupplierManager.createSupplier(this.supplierForm)
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