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
            material_timer: null
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
            this.stockReturnAdd.project_id = item.id
            this.stockReturnAdd.project_content = item.name
            this.stockReturnAdd.project_manger = item.manager
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
              _http.MaterialManager.searchProjectMaterial(searchKey)
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

          //提交
          submit() {
            console.log(this.stockReturnAdd)
            _http.StockManager.createReturnAdd(data)
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
            setTimeout(() => {
              this.currentMaterialListLoader = false
              this.currentMaterialList = [{
                  id: 1,
                  get_id: 'LL23213123',
                  stock: 'xxx仓库',
                  material_name: '线缆',
                  material_parameter: '这是参数技术',
                  material_model: '1k23',
                  material_manufacturer: 'xxx工厂',
                  material_unit: '个',
                  material_price: 123,
                  count: 2221,
                  amount: 12523,
                  project_id: 'XM2312321',
                  project_content: '这是内容xxx',
                  project_manager: '陈一发',
                  people: '刘义克'
                },
                {
                  id: 2,
                  get_id: 'LL23213123',
                  stock: 'xxx仓库',
                  material_name: '线缆',
                  material_parameter: '这是参数技术',
                  material_model: '1k23',
                  material_manufacturer: 'xxx工厂',
                  material_unit: '个',
                  material_price: 123,
                  count: 11,
                  amount: 5232,
                  project_id: 'XM2312321',
                  project_content: '这是内容xxx',
                  project_manager: '陈一发',
                  people: '刘义克'
                },
                {
                  id: 3,
                  get_id: 'LL23213123',
                  stock: 'xxx仓库',
                  material_name: '线缆',
                  material_parameter: '这是参数技术',
                  material_model: '1k23',
                  material_manufacturer: 'xxx工厂',
                  material_unit: '个',
                  material_price: 111,
                  count: 254,
                  amount: 5253,
                  project_id: 'XM2312321',
                  project_content: '这是内容xxx',
                  project_manager: '陈一发',
                  people: '刘义克'
                }

              ]
            }, 1000)
          }
        }
      })
    })
}()