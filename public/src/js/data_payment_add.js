! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataPaymentAdd',
        data: {
          paymentForm: {
            name: '',
            list: []
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
            console.log(this.paymentForm)
            this.paymentForm.name = ''
            this.paymentForm.list = []
            this.$notify({
              title: '成功',
              message: '提交成功',
              type: 'success'
            })
          },
        }
      })
    })
}()