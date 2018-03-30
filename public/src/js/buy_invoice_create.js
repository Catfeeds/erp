! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#buyInvoiceCreate',
        data: {
          invoiceCreate: _schemas.invoiceCreate
        },
        mounted() {
          $('#buyInvoiceCreate').removeClass('invisible')
          this.invoiceCreate.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },
        methods: {

          //添加项目
          addItem() {
            const list = this.invoiceCreate.list
            const data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
            }
            this.invoiceCreate.list.push(data)
          },

          //删除项
          deleteItem(name, item, index) {
            this.invoiceCreate[name].splice(index, 1)
          },

          //提交
          submitForm() {}
        }
      })
    })
}()