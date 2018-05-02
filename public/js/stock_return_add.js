! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#returnAdd',
        data: {
          stockReturnAdd: _schemas.stockReturnAdd,
          currentMaterial: '',
          currentMaterialName: '',

          currentMaterialListDialog: false,
          currentMaterialListLoader: true,
          currentMaterialList: [],

          throttle: {
            stock_timer: null,
            project_timer: null,
            material_timer: null,
            project_content_timer: null
          }
        },
        mounted() {
          this.stockReturnAdd.returnee = $('#returneeVal').val() || ''
          $('#returnAdd').removeClass('invisible')
        },
        computed: {
          sumAmount() {
            const list = this.stockReturnAdd.lists
            if (!list.length) {
              return 0
            }
            let sum = 0
            list.forEach((it, index) => {
              const number = it.number
              if (number) {
                sum += number * (it.price || 0)
              }
            })
            return sum
          }
        },
        methods: {

          /**
           * 搜索相关
           */
          querySearch(queryString, cb) {
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

          handleSelect(item) {
            this.stockReturnAdd.project_id = item.id
            this.stockReturnAdd.project_number = item.number
            this.stockReturnAdd.project_content = item.name
            this.stockReturnAdd.project_manger = item.pm
          },

          querySearchContent(queryString, cb) {
            if (this.throttle.project_content_timer) {
              clearTimeout(this.throttle.project_content_timer)
            }
            this.throttle.project_content_timer = setTimeout(() => {
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

          //仓库搜索       
          handleSelectStock(item) {
            this.stockReturnAdd.warehouse_id = item.id
            this.stockReturnAdd.warehouse_name = item.name
            this.stockReturnAdd.worker = item.manager
          },
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

          //物料
          querySearchMaterial(queryString, cb) {
            if (this.throttle.material_timer) {
              clearTimeout(this.throttle.material_timer)
            }
            this.throttle.material_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.MaterialManager.searchMaterial(searchKey)
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
            this.currentMaterialName = item.name
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
            const list = this.stockReturnAdd.lists
            const currentMaterial = this.currentMaterial
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
              material_id: currentMaterial.id,
              price: currentMaterial.price,
              number: 0,
              material: currentMaterial
            }
            this.stockReturnAdd.lists.push(data)
          },

          //删除
          deleteItem(name, item, index) {
            this.stockReturnAdd[name].splice(index, 1)
          },

          dataFormat() {
            const data = this.stockReturnAdd
            const list = data.lists
            let result = {
              project_id: data.project_id,
              warehouse_id: data.warehouse_id,
              worker: data.worker,
              returnee: data.returnee,
              lists: []
            }
            list.forEach(it => {
              lists.push({
                id: it.material_id,
                number: it.number,
                price: it.price
              })
            })
            return result
          },

          //提交
          submit() {
            const postData = this.dataFormat()
            console.log(postData)
            _http.StockManager.createReturnAdd(postData)
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

          //查询单价
          checkPrice() {
            if (!this.currentMaterial.id) {
              this.$notify({
                title: '错误',
                message: '请先选择物料',
                type: 'error'
              })
              return false
            }
            this.currentMaterialListLoader = true
            this.currentMaterialListDialog = true

            _http.StockManager.searchStockMaterial({
                material_id: this.currentMaterial.id
              })
              .then(res => {
                if (res.data.code === '200') {
                  this.currentMaterialList = res.data.data
                  this.currentMaterialListLoader = false
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