! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#buildGetAdd',
        data: {
          invoiceCreate: _schemas.invoiceCreate,
          invoiceType: []
        },
        mounted() {
          const invoiceType = $('#invoiceType').text().trim()
          this.invoiceType = invoiceType === '' ? [] : JSON.parse(invoiceType)

          this.invoiceCreate.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
          $('#buildGetAdd').removeClass('invisible')
        },
        methods: {

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
            _http.TeamManager.createGetAdd(this.invoiceCreate)
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
          }
        }
      })
    })
}()