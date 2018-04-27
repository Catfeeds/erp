! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildFinishAdd',
        data: {
          buildFinishAdd: _schemas.buildFinishAdd,

          //施工队
          build_teams: [],

          //项目
          projects: [],

          checkedMen: [],
          menList: [],
          selectData: {
            id: ''
          },

          throttle: {
            id_timer: null,
            name_timer: null,
            team_timer: null
          }
        },
        mounted() {
          $('#buildFinishAdd').removeClass('invisible')
          this.buildFinishAdd.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },
        computed: {
          sumAmount() {
            const list = this.buildFinishAdd.lists
            if (!list.length) {
              return 0
            }
            let sum = 0
            list.forEach((it, index) => {
              const amount = it.total
              if (amount) {
                sum += amount * 1
              }
            })
            return sum
          }
        },
        methods: {
          querySearchBuild(queryString, cb) {
            if (this.throttle.team_timer) {
              clearTimeout(this.throttle.team_timer)
            }
            this.throttle.team_timer = setTimeout(() => {
              const searchKey = {
                id: queryString
              }
              _http.TeamManager.searchTeam(searchKey)
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
          handleSelectBuild(item) {
            this.buildFinishAdd.team = item.id
            this.buildFinishAdd.build_name = item.name
            this.buildFinishAdd.build_manager = item.manager
          },

          //项目搜索
          querySearchProjectId(queryString, cb) {
            if (this.throttle.id_timer) {
              clearTimeout(this.throttle.id_timer)
            }
            this.throttle.id_timer = setTimeout(() => {
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
          handleSelectProjectId(item) {
            this.payForm.project_id = item.number
            this.payForm.project_content = item.name
            this.buildFinishAdd.project_manager = item.pm
          },
          querySearchProjectContent(queryString, cb) {
            if (this.throttle.name_timer) {
              clearTimeout(this.throttle.name_timer)
            }
            this.throttle.name_timer = setTimeout(() => {
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
          handleSelectProjectContent(item) {
            this.buildFinishAdd.project_id = item.number
            this.buildFinishAdd.project_content = item.name
            this.buildFinishAdd.project_manager = item.pm
          },

          //提交
          submit() {
            console.log(this.buildFinishAdd)
            _http.TeamManager.createFinish(this.buildFinishAdd)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
                  })
                  this.selectData.id = res.data.data.id
                  _http.UserManager.searchAuthUsers({
                      role: 'build_finish_check'
                    })
                    .then(resp => {
                      if (resp.data.code === '200') {
                        this.menList = resp.data.data
                        $('.ui.dimmer').addClass('active')
                      } else {
                        this.$notify({
                          title: '错误',
                          message: resp.data.msg,
                          type: 'error'
                        })
                      }
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

          //新增项
          addItem() {
            const list = this.buildFinishAdd.lists
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
            }
            this.buildFinishAdd.lists.push(data)
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
            let postData = this.selectData
            postData.users = this.checkedMen
            _http.TeamManager.selectFinishCheck(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '已选择了复核人',
                    type: 'success'
                  })
                  $('.ui.dimmer').removeClass('active')
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