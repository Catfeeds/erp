! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#paymentCreate',
        data: {
          form: {
            date: '',
            price: '',
            purchase_id: ''
          },
          checkedMen: [],
          menList: [{
              id: 1,
              name: '张先生'
            },
            {
              id: 2,
              name: '陈一发'
            },
            {
              id: 3,
              name: '刘芳芳'
            },
            {
              id: 4,
              name: '乌达奇'
            },
            {
              id: 5,
              name: '何求'
            }
          ],
        },
        mounted() {
          this.form.purchase_id = $('#purchaseId').val() || ''
          this.form.date = $('#hiddenDate').val() || ''
          this.form.price = $('#hiddenAmount').val() || ''
        },
        methods: {

          //提交
          submitForm() {
            for (let it in this.form) {
              if (this.form[it] === '') {
                this.$notify({
                  title: '错误',
                  message: '不能有空信息！',
                  type: 'error'
                })
                return false
              }
            }
            $('.ui.dimmer').addClass('active')
          },

          //选择审核人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审核人
          confirmRecheck() {
            let data = this.form
            data.user_id = this.checkedMen
            _http.BuyManager.createPayApply(data)
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
                $('.ui.dimmer').removeClass('active')
              })
              .catch(err => {
                this.$notify({
                  title: '错误',
                  message: '服务器出错',
                  type: 'error'
                })
                $('.ui.dimmer').removeClass('active')
              })
          }
        }
      })
    })
}()