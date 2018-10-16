! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#payInvoiceCreate',
        data: {
          invoiceCreate: _schemas.invoiceCreate,

          invoiceType: []
        },
        mounted() {
          const invoiceType = $('#invoiceType').text().trim()
          this.invoiceType = invoiceType === '' ? [] : JSON.parse(invoiceType)
          this.invoiceCreate.purchase_id = $('#purchaseId').val()
          this.invoiceCreate.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')

          const invoiceEdit = $('#invoiceEdit').text().trim()
          // 数据结构
          // const invoiceEdit = {
          //   date: '2018-01-11', //收票日期
          //   pay_id: '',
          //   purchase_id: 1,
          //   lists: [{ 
          //     id: 1,
          //     date: '2018-01-11',
          //     number: '123123123',
          //     type: 1,
          //     without_tax: 123,
          //     tax: 21,
          //     with_tax: 12
          //   }]
          // }

          if (invoiceEdit) {
            this.invoiceCreate = invoiceEdit === '' ? [] : JSON.parse(invoiceEdit)
            // this.invoiceCreate = invoiceEdit
          }
          $('#payInvoiceCreate').removeClass('invisible')

        },
        methods: {
            add() {
                if (!arguments.length) return 0
                let start = new BigNumber(arguments[0] || 0)
                for(let i = 1; i < arguments.length ; i++){
                    start = start.plus(arguments[i])
                }
                return start
            },
          //添加项目
          addItem() {
            const list = this.invoiceCreate.lists
            const data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
            }
            this.invoiceCreate.lists.push(data)
          },

          //删除项
          deleteItem(name, item, index) {
            this.invoiceCreate[name].splice(index, 1)
          },

          //提交
          submitForm() {
            _http.BuyManager.createCostInvoice(this.invoiceCreate)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
                  })
                  // setTimeout(() => {
                  //   window.close();
                  // }, 2000)
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
          }
        }
      })
    })
}()