! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataWarehouseAdd',
        data: {
          warehouseForm: {
            id: '',
            name: '',
            address: '',
            admin: ''
          }
        },
        mounted() {
          this.warehouseForm.id = $('#warehouseId').val() || ''
          this.warehouseForm.name = $('#warehouseName').val() || ''
          this.warehouseForm.address = $('#warehouseAddress').val() || ''
          this.warehouseForm.admin = $('#warehouseAdmin').val() || ''
        },
        methods: {
          //提交
          submit() {
            _http.WarehouseManager.createWarehouse(this.warehouseForm)
              .then(res => {
                if (res.data.code === '200') {
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