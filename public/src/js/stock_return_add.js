! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#returnAdd',
        data: {
          projects: [{
              id: 'XM21232312222',
              name: '项目一',
              manager: '刘经理'
            },
            {
              id: 'XM21235671222',
              name: '项目二',
              manager: '陈经理'
            },
            {
              id: 'XM2126783222',
              name: '项目三',
              manager: '刘经理'
            }
          ],
          stockReturnAdd: _schemas.stockReturnAdd,
          stocks: [{
              id: 1,
              name: '仓库一',
              manger: '陈先生'
            },
            {
              id: 2,
              name: '仓库二',
              manger: '刘先生'
            },
            {
              id: 3,
              name: '仓库三',
              manger: '洪先生'
            }
          ],
          currentMaterial: '',
          currentMaterialName: '',
          materials: [{
              id: 1,
              name: '物料一',
              model: '型号一',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家'
            },
            {
              id: 2,
              name: '物料二',
              model: '型号二',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家'
            },
            {
              id: 3,
              name: '物料三',
              model: '型号三',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家'
            },
            {
              id: 4,
              name: '物料四',
              model: '型号四',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家'
            },
          ],

          currentMaterialListDialog: false,
          currentMaterialListLoader: true,
          currentMaterialList: [],
        },
        mounted() {
          $('#returnAdd').removeClass('invisible')
          this.commodities = this.loadAll()
        },
        computed: {
          sumAmount() {
            const list = this.stockReturnAdd.list
            if (!list.length) {
              return 0
            }
            let sum = 0
            list.forEach((it, index) => {
              const return_quantity = it.return_quantity
              if (return_quantity) {
                sum += return_quantity * (it.price || 0)
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
            var projects = this.projects
            var results = queryString ? projects.filter(this.createFilter(queryString)) : projects;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilter(queryString) {
            return (restaurant) => {
              return (restaurant.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },

          //仓库名称
          querySearchStock(queryString, cb) {
            var stocks = this.stocks
            var results = queryString ? stocks.filter(this.createFilterStock(queryString)) : stocks;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilterStock(queryString) {
            return (restaurant) => {
              return (restaurant.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },

          //物料
          querySearchMaterial(queryString, cb) {
            var materials = this.materials
            var results = queryString ? materials.filter(this.createFilterMaterial(queryString)) : materials;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilterMaterial(queryString) {
            return (restaurant) => {
              return (restaurant.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelect(item) {
            this.stockReturnAdd.project_id = item.id
            this.stockReturnAdd.project_content = item.name
            this.stockReturnAdd.project_manger = item.manager
          },
          handleSelectStock(item) {
            this.stockReturnAdd.stock_id = item.id
            this.stockReturnAdd.stock_name = item.name
            this.stockReturnAdd.receiver = item.manger
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
            const list = this.stockReturnAdd.list
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
              material: this.currentMaterial
            }
            this.stockReturnAdd.list.push(data)
          },

          //删除
          deleteItem(name, item, index) {
            this.stockReturnAdd[name].splice(index, 1)
          },

          //提交
          submit() {
            console.log(this.stockReturnAdd)
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