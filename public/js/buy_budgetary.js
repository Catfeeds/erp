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

          materialType: _schemas.budget_type_reverse,
          //预算物料列表
          preMaterialsList: [],

          //物料 dialog
          materialsDialog: false,
          loader: true,
          currentMaterial: {},
          materialsDetail: [],
          throttle: {
            project_id_timer: null,
            project_content_timer: null
          }
        },
        mounted() {
          $('#buyBudgetary').removeClass('invisible')
        },

        computed: {
          amountCost() {
            const list = this.preMaterialsList
            let result = {
              count1: 0,
              count2: 0,
              count3: 0
            }

            if (list.lenght) {
              list.forEach((item, index) => {
                result.count1 += item.cost
                result.count2 += item.buy_number * item.price
                result.count3 += item.need_buy * item.price
              })
            }

            return result
          },

          singleCost() {
            const list = this.materialsDetail
            let result = {
              number: 0,
              amount: 0
            }

            let count = 0
            let sum = 0
            if (list.lenght) {
              list.forEach((item, index) => {
                count += item.number
                sum += parseFloat(item.cost) * item.price
              })
              result.number = this.currentMaterial.number - count
              result.amount = this.currentMaterial.number * this.currentMaterial.price - sum
            }

            return result
          }

        },
        methods: {

          /**
           * 搜索相关
           */
          querySearch(queryString, cb) {
            if (this.throttle.project_content_timer) {
              clearTimeout(this.throttle.project_content_timer)
            }
            this.throttle.project_content_timer = setTimeout(() => {
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
          handleSelect(item) {
            this.project.id = item.number
            this.project.project_id = item.id
            this.project.content = item.name
            this.searchMaterials()
          },

          //项目搜索
          querySearchProjectId(queryString, cb) {
            if (this.throttle.project_id_timer) {
              clearTimeout(this.throttle.project_id_timer)
            }
            this.throttle.project_id_timer = setTimeout(() => {
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
            this.project.id = item.number
            this.project.project_id = item.id
            this.project.content = item.name
            this.searchMaterials()
          },

          searchMaterials() {

            _http.MaterialManager.searchBudgetMaterial(this.project.id, {})
              .then(res => {
                if (res.data.code === '200') {
                  this.preMaterialsList = res.data.data
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
          },


          //查询明细
          checkDetail(item, index) {
            this.loader = true
            this.materialsDialog = true
            this.currentMaterial = item

            _http.MaterialManager.searchPurchase(item.id)
              .then(res => {
                if (res.data.code === '200') {
                  this.materialsDetail = res.data.data
                  this.loader = false
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

          },

          submit() {
            console.log(1)
            if (this.project.id && this.project.content) {
              _helper.fullWindow(`../buy/budgetary_buy?id=${this.project.project_id}`)
            } else {
              this.$notify({
                type: 'error',
                title: '错误',
                message: '请先选择项目'
              })
              return false
            }
          }

        }
      })
    })
}()