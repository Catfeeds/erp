! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#outAddAdd',
        data: {
          stockOutAdd: {
            date: '',
            reason: '',
            lists: [],
            warehouse_id: '',
            purchase_id: '',
          },

          current: {
            material: {
              name: '',
              material: ''
            },
            stock: {
              name: '',
              stock: ''
            }
          },

          throttle: {
            material_timer: null,
            stock_timer: null
          }

        },
        mounted() {
          this.stockOutAdd.purchase_id = $('#purchaseId').val() || ''
          $('#outAddAdd').removeClass('invisible')
        },
        methods: {
          //仓库名称
          querySearchStock(queryString, cb) {
            if (this.throttle.stock_timer) {
              clearTimeout(this.throttle.stock_timer)
            }
            this.throttle.stock_timer = setTimeout(() => {
              const searchKey = {
                name: queryString,
                purchase_id: this.stockOutAdd.purchase_id
              }
              _http.StockManager.searchOutStock(searchKey)
                .then(res => {
                  if (res.data.code === '200') {
                    cb(res.data.data)
                  } else {
                    this.$notify({
                      title: '错误',
                      message: res.data.msg || '未知错误',
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
            }, 500)
          },

          handleSelectStock(item) {
            this.stockOutAdd.warehouse_id = item.id
            this.current.stock.name = item.name
            this.current.stock.stock = item
          },

          //物料
          querySearchMaterial(queryString, cb) {
            if (this.throttle.material_timer) {
              clearTimeout(this.throttle.material_timer)
            }
            this.throttle.material_timer = setTimeout(() => {
              const searchKey = {
                name: queryString,
                purchase_id: this.stockOutAdd.purchase_id || '',
                warehouse_id: this.stockOutAdd.warehouse_id
              }
              _http.MaterialManager.searchBuyMaterial(searchKey)
                .then(res => {
                  if (res.data.code === '200') {
                    cb(res.data.data)
                  } else {
                    this.$notify({
                      title: '错误',
                      message: res.data.msg || '未知错误',
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
            }, 500)
          },
          handleSelectMaterial(item) {
            this.current.material.name = item.name
            this.current.material.material = item
          },

          //新增项
          addItem() {
            if (this.current.material.name === '') {
              this.$notify.error({
                title: '错误',
                message: '请选择一项'
              })
              return false
            }
            const list = this.stockOutAdd.lists
            const material = this.current.material.material
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
              material: material,
              material_id: material.id,
              number: 0
            }
            this.stockOutAdd.lists.push(data)
          },

          //删除
          deleteItem(name, item, index) {
            this.stockOutAdd[name].splice(index, 1)
          },

          //提交
          submit() {
            console.log(this.stockOutAdd)
            _http.StockManager.createOutAdd(this.stockOutAdd)
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