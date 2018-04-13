! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#budgetCreate',
        data: {
          budgetType: _schemas.budget_type,
          newBudget: _schemas.budget,
          budgetForm: new Array(),
          project_id: ''
        },
        mounted() {
          $('#budgetCreate').removeClass('invisible')
          this.project_id = $('#budgetCreate').data('id')
        },
        methods: {

          //新增预算
          addNewBudget() {
            let newData = Object.assign({}, this.newBudget)
            for (let it in newData) {
              if (newData[it] === '' || typeof newData[it] === 'undefined') {
                this.$notify.error({
                  title: '错误',
                  message: '请确保已填写所有项！'
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