! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataPaymentEdit',
        data: {
          paymentForm: {
            id: '',
            list: [],
            realList: []
          },
          inputValue: '',
          inputVisible: false
        },
        mounted() {
          $('#dataPaymentEdit').removeClass('invisible')
          this.paymentForm.id = $('#paymentType').val()
          this.paymentForm.list = JSON.parse($('#paymentList').text())
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
              this.paymentForm.list.push({
                name: inputValue
              })
            }
            this.inputVisible = false
            this.inputValue = ''
          },
          //提交
          submit() {
            for (let it of this.paymentForm.list) {
              this.paymentForm.realList.push(it.name)
            }
            console.log(this.paymentForm)
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