! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#budgetCreate',
        data: {
          budgetType: _schemas.budget_type,
          newBudget: _schemas.budget,
          newMaterial: _schemas.budget,
          budgetForm: new Array(),
          project_id: '',
          throttle: {
            material_timer: null
          }
        },
        mounted() {
          $('#budgetCreate').removeClass('invisible')
          this.project_id = $('#budgetCreate').data('id')
        },
        methods: {


          //物料搜索
          querySearchMaterial(queryString, cb) {
            if (this.throttle.material_timer) {
              clearTimeout(this.throttle.material_timer)
            }
            this.throttle.material_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.MaterialManager.searchMaterial(searchKey)
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
          handleSelectMaterial(item) {
            this.newMaterial.material_id = item.id
            this.newMaterial.param = item.param
            this.newMaterial.model = item.model
            this.newMaterial.factory = item.factory
            this.newMaterial.unit = item.unit
            this.newMaterial.name = item.name
          },

          //检索物料添加
          addOriginMaterial() {
            let newData = Object.assign({}, this.newMaterial)
            console.log(newData)
            for (let it in newData) {
              if (newData[it] === '' || typeof newData[it] === 'undefined') {
                this.$notify.error({
                  title: '错误',
                  message: '请确保已填写所有项！'
                })
                return false
              }
            }

            const lastOne = this.budgetForm[this.budgetForm.length - 1]
            this.newData.id = lastOne.id ? lastOne.id * 1 + 1 : 1
            this.budgetForm.push(lastOne)
          },

          //新增预算
          addNewBudget() {
            let newData = Object.assign({}, this.newBudget)
            const type = newData.type
            if (type == 1) {
              for (let it in newData) {
                if (newData[it] === '' || typeof newData[it] === 'undefined') {
                  this.$notify.error({
                    title: '错误',
                    message: '请确保已填写所有项！'
                  })
                  return false
                }
              }
            } else {
              if (!newData.name || newData.price === '' || newData.number === '') {
                this.$notify.error({
                  title: '错误',
                  message: '物料名称、物料价格、物料数量必填！'
                })
                return false
              }
            }
            this.budgetForm.push(newData)

            for (let it in this.newBudget) {
              if (it !== 'id') {
                this.newBudget[it] = ''
              } else if (it === 'id') {
                this.newBudget.id++
              }
            }
            this.$notify.success({
              title: '成功',
              message: '已添加'
            })
          },

          //删除预算
          deleteBudget(item, index) {
            this.budgetForm.splice(index, 1)
          },

          //提交
          submit() {
            _http.BudgetManager.createBudget(this.project_id, this.budgetForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '提交成功',
                    type: 'success'
                  })
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
          }
        }
      })
    })
}()