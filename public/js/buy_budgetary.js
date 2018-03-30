! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buyBudgetary',
        data: {
          project: {
            content: '',
            id: ''
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

          materialType: _schemas.budget_type_reverse,
          //预算物料列表
          preMaterialsList: {
            count1: 123123,
            count2: 4224231,
            count3: 2414214124,
            data: [{
                id: 1,
                name: '物料一',
                parameter: '参数一。性能一',
                model: '型号一',
                manufacturer: '厂家一',
                unit: '个',
                prePrice: 213,
                preQuantity: 21321,
                preAmount: 5213123,
                type: 1,
                realQuantity: 2431,
                realAmount: 52132,
                leftQuantity: 25321,
                leftAmount: 53213,
              },
              {
                id: 2,
                name: '物料二',
                parameter: '参数二。性能二',
                model: '型号二',
                manufacturer: '厂家二',
                unit: '件',
                prePrice: 213,
                preQuantity: 2413,
                preAmount: 52132312123,
                type: 2,
                realQuantity: 21,
                realAmount: 5212332,
                leftQuantity: 1223,
                leftAmount: 2423232,
              }
            ]
          },

          //物料 dialog
          materialsDialog: false,
          loader: true,
          materialsDetail: {}
        },
        mounted() {
          $('#buyBudgetary').removeClass('invisible')
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
            return (item) => {
              return (item.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelect(item) {
            this.project.id = item.id
            this.project.content = item.name
          },

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


          //查询明细
          checkDetail(item, index) {
            this.loader = true
            this.materialsDialog = true
            setTimeout(() => {
              this.loader = false
              this.materialsDetail = {
                name: '物料一',
                parameter: '这是性能参数这是性能参数',
                model: 'ak-47',
                unit: '个',
                manufacturer: 'xxx厂家',
                pre: {
                  quantity: 50,
                  price: 500,
                  amount: 52500
                },
                data: [{
                    id: 1,
                    number: 'CG123151231232',
                    quantity: -5,
                    price: 500,
                    amount: -2500,
                    manufacturer: 'aaa供货商'
                  },
                  {
                    id: 2,
                    number: 'CG123123242122',
                    quantity: -50,
                    price: 500,
                    amount: -25000,
                    manufacturer: 'bbb供货商'
                  }
                ],
                left: {
                  quantity: 0,
                  amount: 0
                }
              }
            }, 1000)
          },

          //提交
          submit() {
            if (this.project.id && this.project.content) {
              _helper.fullWindow(`../buy/budgetary_buy.html?id=${this.project.id}`)
            } else {
              this.$notify({
                type: 'error',
                title: '错误',
                message: '请先选择项目'
              })
            }
          }
        }
      })
    })
}()