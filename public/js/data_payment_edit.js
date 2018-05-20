! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataPaymentEdit',
        data: {
          paymentForm: {
            id: '',
            list: [],
            kinds: []
          },
          inputValue: '',
          inputVisible: false
        },
        mounted() {
          this.paymentForm.id = $('#paymentType').val()
          this.paymentForm.title = $('#paymentName').val()
          const list = $('#paymentList').text().trim()
          this.paymentForm.list = list === '' ? [] : JSON.parse(list)
          $('#dataPaymentEdit').removeClass('invisible')
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
              this.paymentForm.kinds.push(it.name)
            }
            console.log(this.paymentForm)
            _http.PaymentManager.createPayment(this.paymentForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.paymentForm.title = ''
                  this.paymentForm.kinds = []
                  this.$notify({
                    title: '成功',
                    message: '修改成功',
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