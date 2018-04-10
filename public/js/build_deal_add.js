! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildDealAdd',
        data: {
          buildDealAdd: _schemas.buildDealAdd,

          //施工队
          build_teams: [],

          //项目
          projects: [],

          throttle: {
            id_timer: null,
            name_timer: null,
            team_timer: null
          }
        },
        mounted() {
          $('#buildDealAdd').removeClass('invisible')
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
            this.buildDealAdd.team = item.id
            this.buildDealAdd.build_name = item.name
            this.buildDealAdd.build_manager = item.manager
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
            this.buildDealAdd.project_manager = item.pm
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
            this.buildDealAdd.project_id = item.number
            this.buildDealAdd.project_content = item.name
            this.buildDealAdd.project_manager = item.pm
          },


          //合同上传
          uploadContract(e) {
            const files = e.target.files
            if (files.length < 1) {
              return
            }
            let fileArr = []
            for (let file of files) {
              let formData = new FormData()
              formData.append('image', file)
              _http.UploadManager.createUpload(formData)
                .then(res => {
                  if (res.data.code === '200') {
                    const buildDealAdd = res.data.data
                    this.buildDealAdd.lists.push({
                      id: resData.size,
                      name: resData.name,
                      url: resData.url
                    })
                    this.buildDealAdd.lists.push(resData.url)
                    this.$notify({
                      title: '成功',
                      message: `${resData.name} 上传成功`,
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
            }

          },

          //删除项
          deleteItem(name, item, index) {
            if (name === 'list') {
              this.buildDealAdd[list].splice(index, 1)
              this.buildDealAdd[lists].splice(index, 1)
            } else {
              this.buildDealAdd[name].splice(index, 1)
            }
          },

          //提交
          submit() {
            console.log(this.buildDealAdd)
            _http.TeamManager.createContract(this.buildDealAdd)
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
          }
        }
      })
    })
}()