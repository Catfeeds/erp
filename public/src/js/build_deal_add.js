! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildDealAdd',
        data: {
          buildDealAdd: _schemas.buildDealAdd,

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
          ]
        },
        mounted() {
          $('#buildDealAdd').removeClass('invisible')
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
            this.buildDealAdd.build_id = item.id
            this.buildDealAdd.build_name = item.name
            this.buildDealAdd.build_manager = item.manager
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
            this.buildDealAdd.project_id = item.id
            this.buildDealAdd.project_content = item.content
            this.buildDealAdd.project_manager = item.manager
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
            this.buildDealAdd.project_id = item.id
            this.buildDealAdd.project_content = item.content
            this.buildDealAdd.project_manager = item.manager
          },


          //合同上传
          uploadContract(e) {
            const files = e.target.files
            if (files.length < 1) {
              return
            }
            const contracts = this.buildDealAdd.list
            for (let i = 0; i < files.length; i++) {
              const data = {
                id: contracts.length > 0 ? contracts[contracts.length - 1].id ? contracts[contracts.length - 1].id + 1 : 1 : 1,
                name: files[i].name,
                url: 'http://xxx.com/upload/' + files[i].name
              }
              this.buildDealAdd.list.push(data)
            }
          },

          //删除项
          deleteItem(name, item, index) {
            this.buildDealAdd[name].splice(index, 1)
          },

          //提交
          submit() {
            console.log(this.buildDealAdd)
          }
        }
      })
    })
}()