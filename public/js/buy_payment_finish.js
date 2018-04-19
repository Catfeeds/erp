! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#paymentFinish',
        data: {
          form: {
            pay_date: '',
            remark: '',
            bank_id: ''
          },
          banks: []
        },
        mounted() {
          this.getBanks()
          this.form.pay_date = $('#hiddenDate').val() || ''
          this.form.bank_id = $('#bankAccount').val() || ''
          this.form.id = $('#askId').val() || ''
          this.form.remark = $('#remark').val() || ''
          $('.ui.dropdown').dropdown()
          $('#paymentFinish').removeClass('invisible')
        },
        methods: {

          //获取银行账号
          getBanks() {
            _http.BankManager.searchBank()
              .then(res => {
                if (res.data.code === '200') {
                  this.banks = res.data.data
                } else {
                  this.banks = []
                }
              })
              .catch(err => {
                this.banks = []
              })
          },

          //提交
          submitForm() {
            console.log(this.form)
            _http.BuyManager.createPaymentAdd(this.form)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
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