! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#buyExtrabudgetary',
        data: {
          project: {
            content: '',
            number: ''
          },

          projects: [{
              id: 'XM23141231232',
              name: '项目一'
            },
            {
              id: 'XM23523111232',
              name: '项目二'
            },
            {
              id: 'XM23145423121',
              name: '项目三'
            }
          ],

          //预算外采购表结构
          extrabudgetary: _schemas.extrabudgetary,

          //供应商
          suppliers: [{
              id: 1,
              name: '和桥开发商',
              bank: '中国银行',
              account: 63242362342342343256,
            },
            {
              id: 2,
              name: '永益供应商',
              bank: '广发银行',
              account: 63242362342342343256,
            },
            {
              id: 3,
              name: '乐音货行',
              bank: '平安银行',
              account: 62343252342323413423,
            }
          ],

          //物料列表
          materials: [{
              id: 1,
              name: '物料一',
              parameter: '参数一',
              model: '型号一',
              manufacturer: '厂家一',
              unit: '个',
              price: 253,
              quantity: 2534,
              buy_number: 1500,
              left_number: 1034,
            },
            {
              id: 2,
              name: '物料二',
              parameter: '参数二',
              model: '型号二',
              manufacturer: '厂家二',
              unit: '件',
              price: 2542,
              quantity: 500,
              buy_number: 300,
              left_number: 200,
            },
            {
              id: 4,
              name: '物料三',
              parameter: '参数三',
              model: '型号三',
              manufacturer: '厂家三',
              unit: '间',
              price: 123,
              quantity: 5000,
              buy_number: 2300,
              left_number: 2700,
            },
            {
              id: 3,
              name: '物料四',
              parameter: '参数四',
              model: '型号四',
              manufacturer: '厂家四',
              unit: '间',
              price: 542,
              quantity: 5000,
              buy_number: 5000,
              left_number: 0,
            }
          ],
          //新增物料
          newMaterial: {}
        },

        mounted() {
          this.extrabudgetary.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
          $('#buyExtrabudgetary').removeClass('invisible')
        },
        methods: {
          //项目搜索
          querySearchProjectId(queryString, cb) {
            var projects = this.projects
            var results = queryString ? projects.filter(this.createFilterProjectId(queryString)) : projects;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilterProjectId(queryString) {
            return (item) => {
              return (item.id.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelectProjectId(item) {
            this.project.id = item.id
            this.project.content = item.name
          },
          //项目自动提示函数
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
            return (item) => {
              return (item.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelect(item) {
            this.project.id = item.id
            this.project.content = item.name
          },

          //供应商输入提示
          handleSelectSupplier(item) {
            this.extrabudgetary.supplier = item
          },
          querySearchSupplier(queryString, cb) {
            const suppliers = this.suppliers
            const results = queryString ? suppliers.filter(this.createFilterSupplier(queryString)) : suppliers;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilterSupplier(queryString) {
            return (suppliers) => {
              return (suppliers.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },

          //添加物料
          addMaterial() {
            const list = this.extrabudgetary.list
            const newMaterial = this.newMaterial
            const data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
              __type: newMaterial.status ? 'old' : 'new',
              material: newMaterial.status ? newMaterial : {
                name: newMaterial.name
              },
            }
            this.extrabudgetary.list.push(data)
          },

          //物料自动提示函数

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
            return (material) => {
              return (material.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelectMaterial(item) {
            this.newMaterial = Object.assign({}, item)
            this.newMaterial.status = true
          },
          materialInput() {
            this.newMaterial.status = false
          },

          //删除项
          deleteItem(name, item, index) {
            this.extrabudgetary[name].splice(index, 1)
          },

          //合同上传
          uploadContract(e) {
            const files = e.target.files
            if (files.length < 1) {
              return
            }
            const contracts = this.extrabudgetary.contracts
            for (let i = 0; i < files.length; i++) {
              const data = {
                id: contracts.length > 0 ? contracts[contracts.length - 1].id ? contracts[contracts.length - 1].id + 1 : 1 : 1,
                name: files[i].name,
                url: 'http://xxx.com/upload/' + files[i].name
              }
              this.extrabudgetary.contracts.push(data)
            }
          },

          //提交
          submitForm() {}

        }
      })
    })
}()