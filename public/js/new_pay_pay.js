! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#payPay',
        data: {

          payForm: {
            worker: '',
            pay_date: '',
            cash: '',
            transfer: '',
            other: '',
            bank: '',
            account: '',
            remark: '',
            bankIndex: ''
          },

          bankList: [],
          postForm: {
            request_id: '',
            lists: []
          },
          bankMap: {}

        },
        mounted() {
          const bankList = $('#bankList').text().trim()
          const payList = $('#payList').text().trim()
          this.postForm.request_id = $('#requestId').val() || ''
          this.worker = $('#worker').val() || ''

          this.bankList = bankList === '' ? [] : JSON.parse(bankList)
          this.bankList.forEach(item => {
            this.bankMap[item.id] = {
              name: item.name,
              id: item.id,
              account: item.account
            } 
          })
          this.postForm.lists = payList === '' ? [] : JSON.parse(payList)
          this.postForm.lists.forEach(item => {
            item.account = this.bankMap[item.bank].account || ''
          })
          $('#payPay').removeClass('invisible')
          if (!this.postForm.lists.length) this.addItem()
        },
        methods: {

          //添加项目
          addItem() {
            const data = {
              pay_date: _helper.timeFormat(new Date(), 'YYYY-MM-DD'),
              worker: this.worker,
              bank: '',
              account: '',
              transfer: '',
              cash: ''
            }
            this.postForm.lists.push(data)
          },
          //删除项
          deleteItem(item, index) {
            this.postForm.lists.splice(index, 1)
          },

          selectBank(bankId, itemIndex) {
            let findItem = this.bankMap[bankId]
            this.postForm.lists[itemIndex].bank = findItem.id
            this.postForm.lists[itemIndex].account = findItem.account
          },

          //提交
          submit() {
            _http.PaymentManager.createNewPayPay(this.postForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify.success({
                    title: '成功',
                    message: '提交成功！'
                  })
                  $('.ui.dimmer').addClass('active')
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