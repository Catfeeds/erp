! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataPaymentAdd',
        data: {
          paymentForm: {
            title: '',
            kinds: []
          },
          inputValue: '',
          inputVisible: false
        },
        mounted() {
          $('#dataPaymentAdd').removeClass('invisible')
        },
        methods: {

          //移除标签
          handleClose(tag, index) {
            this.paymentForm.list.splice(index, 1)
          },
          showInput() {
            this.inputVisible = true
            this.$nextTick(_ => {
              this.$refs.saveTagInput.$refs.input.focus()
            })
          },
          handleInputConfirm() {
            let inputValue = this.inputValue
            if (inputValue) {
              this.paymentForm.list.push(inputValue)
            }
            this.inputVisible = false
            this.inputValue = ''
          },
          //提交
          submit() {
            _http.PaymentManager.createPayment(this.paymentForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.paymentForm.title = ''
                  this.paymentForm.kinds = []
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