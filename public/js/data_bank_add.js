! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataBankAdd',
        data: {
          bankForm: {
            id: '',
            name: '',
            account: '',
          }
        },
        mounted() {
          this.bankForm.id = $('#bankId').val() || ''
          this.bankForm.name = $('#bankName').val() || ''
          this.bankForm.account = $('#bankAccount').val() || ''
        },
        methods: {
          //提交
          submit() {
            _http.BankManager.createBank(this.bankForm)
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