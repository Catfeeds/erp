! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#checkInvoice',
        data: {
          invoiceForm: _schemas.checkInvoice,

          invoiceType: [],

          throttle: {
            unit_timer: null
          },
          project_id: ''
        },
        mounted() {
          $('#checkInvoice').removeClass('invisible')
          this.invoiceForm.project_id = $('#projectId').val()
          const invoiceType = $('#invoiceType').text().trim()
          this.invoiceType = invoiceType === '' ? [] : JSON.parse(invoiceType)
        },
        methods: {
          //单位搜索
          querySearchCompany(queryString, cb) {

            if (this.throttle.unit_timer) {
              clearTimeout(this.throttle.unit_timer)
            }
            this.throttle.unit_timer = setTimeout(() => {
              const searchKey = {
                payee: queryString,
                project_id: this.invoiceForm.project_id || ''
              }
              _http.ProjectManager.searchProjectUnit(searchKey)
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
          handleSelectCompany(item) {
            this.invoiceForm.payee = item
          },

          //删除第一层数据
          deleteItem(name, item, index) {
            this.invoiceForm[name].splice(index, 1)
          },

          //新增第一层数据
          addItem(name) {
            const invoiceForm = this.invoiceForm[name]
            const length = invoiceForm.length
            let id
            if (length > 0) {
              id = invoiceForm[length - 1].id + 1
            } else {
              id = 1
            }
            this.invoiceForm[name].push({
              id
            })
          },

          submit() {
            _http.CheckManager.createProjectInvoice(this.invoiceForm)
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