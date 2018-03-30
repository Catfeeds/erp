! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildFinishAdd',
        data: {
          buildFinishAdd: _schemas.buildFinishAdd,

          //施工队
          build_teams: [{
              id: 1,
              name: '施工队一',
              manager: '陈经理'
            },
            {
              id: 2,
              name: '施工队二',
              manager: '刘经理'
            },
            {
              id: 3,
              name: '施工队三',
              manager: '海经理'
            }
          ],

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
          $('#buildFinishAdd').removeClass('invisible')
          this.buildFinishAdd.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },
        computed: {
          sumAmount() {
            const list = this.buildFinishAdd.list
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
          querySearchBuild(queryString, cb) {
            var build_teams = this.build_teams
            var results = queryString ? build_teams.filter(this.createFilterBuild(queryString)) : build_teams;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilterBuild(queryString) {
            return (restaurant) => {
              return (restaurant.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelectBuild(item) {
            this.buildFinishAdd.build_id = item.id
            this.buildFinishAdd.build_name = item.name
            this.buildFinishAdd.build_manager = item.manager
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
            return (restaurant) => {
              return (restaurant.id.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelectProjectId(item) {
            this.buildFinishAdd.project_id = item.id
            this.buildFinishAdd.project_content = item.content
            this.buildFinishAdd.project_manager = item.manager
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
            return (restaurant) => {
              return (restaurant.content.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelectProjectContent(item) {
            this.buildFinishAdd.project_id = item.id
            this.buildFinishAdd.project_content = item.content
            this.buildFinishAdd.project_manager = item.manager
          },

          //提交
          submit() {
            console.log(this.buildFinishAdd)
            this.$notify({
              title: '成功',
              message: '提交成功',
              type: 'success'
            })
            $('.ui.dimmer').addClass('active')
          },

          //新增项
          addItem() {
            const list = this.buildFinishAdd.list
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
            }
            this.buildFinishAdd.list.push(data)
          },

          //删除
          deleteItem(name, item, index) {
            this.buildFinishAdd[name].splice(index, 1)
          },
          //选择审核人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审核人
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