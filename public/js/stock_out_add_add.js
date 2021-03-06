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
              this.current.material.name = ''
              this.current.material.material = ''
              this.current.material.data = ''
              this.stockOutAdd.lists =[]
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
            this.current.material.name = item.material.name
            this.current.material.material = item.material
              this.current.material.data = item
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
            const currentValue = this.current.material
            const material = currentValue.material
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
              material: material,
              material_id: this.current.material.data.id,
              number: 0,
                stock_number :this.current.material.data.number || 0,
              price: this.current.material.data.price || 0,
              sum: this.current.material.data.sum || 0,
              cost:this.current.material.data.cost || 0
            }
            console.log(data)
            this.stockOutAdd.lists.push(data)
          },

          //删除
          deleteItem(name, item, index) {
            this.stockOutAdd[name].splice(index, 1)
          },

          formateData(data) {
            let result = {
              date: data.date,
              reason: data.reason,
              lists: [],
              warehouse_id: data.warehouse_id,
              purchase_id: data.purchase_id,
            }

            const list = data.lists
            list.forEach(item => {
              result.lists.push({
                id: item.material_id,
                number: item.number
              })
            })

            return result
          },

          //提交
          submit() {
            const postData = this.formateData(this.stockOutAdd)
            _http.StockManager.createOutAdd(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
                  })
                  setTimeout(() => {
                      window.close();
              }, 2000)
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