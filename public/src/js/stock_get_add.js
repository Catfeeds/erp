! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#stockGetAdd',
        data: {
          stockGetAdd: _schemas.stockGetAdd,
          commodities: [],
          currentType: 1,
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
              manufacturer: 'xx厂家',
              price: 321
            },
            {
              id: 2,
              name: '物料二',
              model: '型号二',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家',
              price: 55
            },
            {
              id: 3,
              name: '物料三',
              model: '型号三',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家',
              price: 11
            },
            {
              id: 4,
              name: '物料四',
              model: '型号四',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家',
              price: 142
            },
          ],
        },
        mounted() {
          this.commodities = this.loadAll()
          $('.ui.checkbox').checkbox()
          $('#stockGetAdd').removeClass('invisible')
        },
        computed: {
          sumAmount() {
            const list = this.stockGetAdd.list
            if (!list.length) {
              return 0
            }
            let sum = 0
            list.forEach((it, index) => {
              const return_quantity = it.return_quantity
              if (return_quantity) {
                sum += return_quantity * it.material.avg_price
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
            var commodities = this.commodities
            var results = queryString ? commodities.filter(this.createFilter(queryString)) : commodities;
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
          loadAll() {
            return [{
                "id": 1,
                "name": "三全鲜食（北新泾店）",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号一",
                "unit": "间",
                "address": "长宁区新渔路144号"
              },
              {
                "id": 2,
                "name": "Hot honey 首尔炸鸡（仙霞路）",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号二",
                "unit": "个",
                "address": "上海市长宁区淞虹路661号"
              },
              {
                "id": 3,
                "name": "新旺角茶餐厅",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号三",
                "unit": "只",
                "address": "上海市普陀区真北路988号创邑金沙谷6号楼113"
              },
              {
                "id": 4,
                "name": "泷千家(天山西路店)",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号四",
                "unit": "件",
                "address": "天山西路438号"
              },
              {
                "id": 5,
                "name": "胖仙女纸杯蛋糕（上海凌空店）",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号五",
                "unit": "间",
                "address": "上海市长宁区金钟路968号1幢18号楼一层商铺18-101"
              },
              {
                "id": 6,
                "name": "贡茶",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号六",
                "unit": "间",
                "address": "上海市长宁区金钟路633号"
              },
              {
                "id": 7,
                "name": "豪大大香鸡排超级奶爸",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号七",
                "unit": "间",
                "address": "上海市嘉定区曹安公路曹安路1685号"
              },
              {
                "id": 8,
                "name": "茶芝兰（奶茶，手抓饼）",
                "parameter": "这些是一些参数和性能数据",
                "model": "型号八",
                "unit": "间",
                "address": "上海市普陀区同普路1435号"
              },
            ]
          },
          handleSelect(item) {
            this.stockGetAdd.project_id = item.id
            this.stockGetAdd.project_content = item.parameter
            this.stockGetAdd.project_manger = item.model
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
            }
          },
          handleSelectStock(item) {
            this.stockGetAdd.stock_id = item.id
            this.stockGetAdd.stock_name = item.name
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
            const list = this.stockGetAdd.list
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
              material: this.currentMaterial
            }
            this.stockGetAdd.list.push(data)
          },
          //删除
          deleteItem(name, item, index) {
            this.stockGetAdd[name].splice(index, 1)
          },

          //提交
          submit() {
            console.log(this.stockReturnAdd)
          }
        }
      })
    })
}()