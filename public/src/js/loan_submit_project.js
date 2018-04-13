! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#loanSubmitOther',
        data: {

          submitProjectForm: {
            people: '',
            date: '',
            amount: '',
            project_id: '',
            project_content: '',
            list: []
          },

          //费用类型
          paymentData: {
            currentTypeIndex: '',
            currentType: {},
            typeList: [{
                id: 1,
                name: '交通运输费',
              },
              {
                id: 2,
                name: '业务招待费',
              },
              {
                id: 3,
                name: '差旅费',
              }
            ],
            currentDetailTypeIndex: '',
            currentDetailType: {},
            detailTypeList: []
          },

          //项目
          projects: [{
              id: 1,
              content: '这是内容一',
              manager: '陈经理'
            },
            {
              id: 2,
              content: '这是内容三',
              manager: '刘经理'
            },
            {
              id: 3,
              content: '这是内容三',
              manager: '张经理'
            }
          ],

          checkedMen: [],
          menList: [{
              id: 1,
              name: '张先生'
            },
            {
              id: 2,
              name: '陈一发'
            },
            {
              id: 3,
              name: '刘芳芳'
            },
            {
              id: 4,
              name: '乌达奇'
            },
            {
              id: 5,
              name: '何求'
            }
          ],
        },
        mounted() {
          $('#loanSubmitOther').removeClass('invisible')
          this.submitProjectForm.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },
        computed: {

          sumAmount() {
            const list = this.submitProjectForm.list
            if (!list.length) {
              return 0
            }
            let sum = 0
            list.forEach((it, index) => {
              const amount = it.amount
              if (amount) {
                sum += amount * 1
              }
            })
            return sum
          }
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
            this.submitProjectForm.project_id = item.id
            this.submitProjectForm.project_content = item.content
          },

          querySearchProjectContent(queryString, cb) {
            var projects = this.projects
            var results = queryString ? projects.filter(this.createFilterProjectContent(queryString)) : projects;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilterProjectContent(queryString) {
            return (item) => {
              return (item.content.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelectProjectContent(item) {
            this.submitProjectForm.project_id = item.id
            this.submitProjectForm.project_content = item.content
          },

          //新增项
          addItem() {
            if (this.paymentData.currentDetailTypeIndex !== '') {
              const list = this.submitProjectForm.list
              let data = {
                id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
                type: this.paymentData.currentType.name,
                detailType: this.paymentData.currentDetailType.name,
              }
              this.submitProjectForm.list.push(data)
            } else {
              this.$notify({
                title: '错误',
                message: '请先选择具体事项',
                type: 'error'
              })
            }
          },

          //删除
          deleteItem(name, item, index) {
            this.submitProjectForm[name].splice(index, 1)
          },

          //选择器
          typeChange(typeIndex) {
            let data = {
              1: [{
                  id: 1,
                  name: '油费',
                },
                {
                  id: 2,
                  name: '路桥费',
                },
                {
                  id: 3,
                  name: '汽车维修费',
                },
                {
                  id: 4,
                  name: '车辆保修',
                }
              ],
              2: [{
                  id: 1,
                  name: '餐费'
                },
                {
                  id: 2,
                  name: '其他'
                }
              ],
              3: [{
                  id: 1,
                  name: '打车费'
                },
                {
                  id: 2,
                  name: '餐补'
                },
                {
                  id: 3,
                  name: '其他'
                }
              ]
            }

            const currentType = this.paymentData.typeList[typeIndex]
            this.paymentData.currentType = currentType
            const tmp = data[currentType.id]
            this.paymentData.currentDetailTypeIndex = ''
            this.paymentData.detailTypeList = tmp.length ? tmp : []
          },

          detailTypeChange(detailTypeIndex) {
            const currentDetailType = this.paymentData.detailTypeList[detailTypeIndex]
            this.paymentData.currentDetailType = currentDetailType
          },

          //提交
          submit() {
            this.$notify({
              title: '成功',
              message: '提交成功',
              type: 'success'
            })
            $('.ui.dimmer').addClass('active')
          },
          //选择审批人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交复核人
          confirmRecheck() {
            this.$notify({
              title: '成功',
              message: '已选择了复核人',
              type: 'success'
            })
            $('.ui.dimmer').removeClass('active')
          }
        }
      })
    })
}()