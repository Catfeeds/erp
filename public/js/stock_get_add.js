! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#stockGetAdd',
        data: {
          stockGetAdd: _schemas.stockGetAdd,
          currentType: 1,

          currentMaterial: {
            material: {}
          },
          currentMaterialName: '',

          throttle: {
            project_timer: null,
            project_id_timer: null,
            material_timer: null,
            stock_timer: null
          }
        },
        mounted() {
          $('.ui.checkbox').checkbox()
          $('#stockGetAdd').removeClass('invisible')
        },
        computed: {
          sumAmount() {
            const list = this.stockGetAdd.lists
            if (!list.length) {
              return 0
            }
            let sum = 0
            list.forEach((it, index) => {
              const number = it.number
              if (number) {
                sum += number * parseFloat(it.price)
              }
            })
            return sum
          }
        },
        methods: {

          /**
           * 搜索相关
           */
          querySearchProjectId(queryString, cb) {
            if (this.throttle.project_timer) {
              clearTimeout(this.throttle.project_timer)
            }
            this.throttle.project_timer = setTimeout(() => {
              const searchKey = {
                id: queryString
              }
              _http.ProjectManager.searchProject(searchKey)
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
          querySearch(queryString, cb) {
            if (this.throttle.project_id_timer) {
              clearTimeout(this.throttle.project_id_timer)
            }
            this.throttle.project_id_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.ProjectManager.searchProject(searchKey)
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

          handleSelect(item) {
            this.stockGetAdd.project_id = item.id
            this.stockGetAdd.project_number = item.number
            this.stockGetAdd.project_content = item.name
            this.stockGetAdd.project_manger = item.pm
          },

          //仓库名称
          querySearchStock(queryString, cb) {
            if (this.throttle.stock_timer) {
              clearTimeout(this.throttle.stock_timer)
            }
            this.throttle.stock_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.StockManager.searchStock(searchKey)
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
            this.stockGetAdd.warehouse_id = item.id
            this.stockGetAdd.warehouse_name = item.name
          },


          //物料
          querySearchMaterial(queryString, cb) {
            if (this.throttle.material_timer) {
              clearTimeout(this.throttle.material_timer)
            }
            this.throttle.material_timer = setTimeout(() => {
              const searchKey = {
                name: queryString,
                id: this.stockGetAdd.warehouse_id || ''
              }
              _http.StockManager.searchStockMaterialSpecial(searchKey)
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
            this.currentMaterial = item
            this.currentMaterialName = item.material.name
          },

          //新增项
          addItem() {
            if (this.currentMaterialName === '') {
              this.$notify.error({
                title: '错误',
                message: '请选择一项'
              })
              return false
            }
            const list = this.stockGetAdd.lists
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
              material: this.currentMaterial.material,
              price: this.currentMaterial.price,
              material_id: this.currentMaterial.id,
              number: 0
            }
            this.stockGetAdd.lists.push(data)
          },
          //删除
          deleteItem(name, item, index) {
            this.stockGetAdd[name].splice(index, 1)
          },

          dataFormat() {
            const data = this.stockGetAdd
            const list = data.lists
            let result = {
              type: this.currentType,
              project_id: data.project_id,
              warehouse_id: data.warehouse_id,
              worker: data.worker,
              lists: []
            }

            list.forEach(it => {
              result.lists.push({
                id: it.material_id,
                number: it.number
              })
            })

            return result
          },

          //提交
          submit() {
            const postData = this.dataFormat()
            console.log(postData)
            _http.StockManager.createGetAdd(postData)
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