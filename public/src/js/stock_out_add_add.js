! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#outAddAdd',
        data: {
          stockOutAdd: {
            date: '',
            reason: '',
            list: [],
            stock_id: ''
          },
          stocks: [{
              id: 1,
              name: '仓库一',
              manager: '陈先生'
            },
            {
              id: 2,
              name: '仓库二',
              manager: '刘先生'
            },
            {
              id: 3,
              name: '仓库三',
              manager: '洪先生'
            }
          ],

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
          materials: [{
              id: 1,
              name: '物料一',
              model: '型号一',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家',
              buy_count: 5221,
              buy_amount: 2523,
              price: 11
            },
            {
              id: 2,
              name: '物料二',
              model: '型号二',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家',
              buy_count: 22,
              buy_amount: 62312,
              price: 22
            },
            {
              id: 3,
              name: '物料三',
              model: '型号三',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家',
              buy_count: 12,
              buy_amount: 55,
              price: 412
            },
            {
              id: 4,
              name: '物料四',
              model: '型号四',
              unit: '个',
              parameter: '这是参数型号',
              manufacturer: 'xx厂家',
              buy_count: 3,
              buy_amount: 156,
              price: 3
            },
          ],

        },
        mounted() {
          $('#outAddAdd').removeClass('invisible')
        },
        methods: {
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
            return (item) => {
              return (item.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
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
          handleSelectStock(item) {
            this.stockOutAdd.stock_id = item.id
            this.current.stock.name = item.name
            this.current.stock.stock = item
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
            const list = this.stockOutAdd.list
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
              material: this.current.material.material
            }
            this.stockOutAdd.list.push(data)
          },

          //删除
          deleteItem(name, item, index) {
            this.stockOutAdd[name].splice(index, 1)
          },

          //提交
          submit() {
            console.log(this.stockOutAdd)
          },

        }
      })
    })
}()