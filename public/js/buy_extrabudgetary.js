! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#buyExtrabudgetary',
        data: {

          //预算外采购表结构
          extrabudgetary: _schemas.extrabudgetary,

          //新增物料
          newMaterial: {},

          throttle: {
            id_timer: null,
            name_timer: null,
            supplier_timer: null,
            material_timer: null
          }
        },

        mounted() {
          this.extrabudgetary.info.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
          const invoiceType = $('#invoiceType').text().trim()
          this.invoiceType = invoiceType === '' ? [] : JSON.parse(invoiceType)
          $('#buyExtrabudgetary').removeClass('invisible')
        },


        computed: {
          amount() {
            const vm = this
            const lists = vm.extrabudgetary.lists
            if (lists.length < 1) {
              return 0
            }

            let amount = 0

            for (let i = 0; i < lists.length; i++) {
              const cost = lists[i].cost
              if (cost) {
                amount += parseFloat(lists[i].cost)
              }
            }

            return amount
          }
        },
        methods: {
          //项目搜索
          querySearchProjectId(queryString, cb) {
            clearTimeout(this.throttle.id_timer)
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
            this.extrabudgetary.project_id = item.id
            this.extrabudgetary.project_number = item.number
            this.extrabudgetary.project_content = item.name
          },

          querySearchProjectContent(queryString, cb) {
            clearTimeout(this.throttle.name_timer)
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
            this.extrabudgetary.project_id = item.id
            this.extrabudgetary.project_number = item.number
            this.extrabudgetary.project_content = item.name
          },

          //供应商输入提示
          handleSelectSupplier(item) {
            this.extrabudgetary.info.supplier_id = item.id
            this.extrabudgetary.info.supplier_name = item.name
            this.extrabudgetary.info.bank = item.bank
            this.extrabudgetary.info.account = item.account
          },
          querySearchSupplier(queryString, cb) {

            if (this.throttle.supplier_timer) {
              clearTimeout(this.throttle.supplier_timer)
            }
            this.throttle.supplier_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.SupplierManager.searchSuppliers(searchKey)
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

          //添加物料
          addMaterial() {
            const list = this.extrabudgetary.lists
            const newMaterial = this.newMaterial
            let data = {
              own_id: list.length > 0 ? list[list.length - 1].own_id ? list[list.length - 1].own_id + 1 : 1 : 1,
              __type: newMaterial.status ? 'old' : 'new'
            }

            if (newMaterial.status) {
              data.material = newMaterial
              data.material_id = newMaterial.id
            } else {
              data.name = newMaterial.name
            }
            console.log(data, '============================')
            this.extrabudgetary.lists.push(data)
          },

          //物料自动提示函数

          querySearchMaterial(queryString, cb) {

            if (this.throttle.material_timer) {
              clearTimeout(this.throttle.material_timer)
            }
            this.throttle.material_timer = setTimeout(() => {
              const searchKey = {
                name: queryString,
                project_id: this.extrabudgetary.project_id || ''
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
            this.newMaterial = Object.assign({}, item)
            this.newMaterial.status = true
          },
          materialInput() {
            this.newMaterial.status = false
          },

          //删除项
          deleteItem(name, item, index) {
            this.extrabudgetary[name].splice(index, 1)
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
                    const resData = res.data.data
                    this.extrabudgetary.contracts.push({
                      id: resData.size,
                      name: resData.name,
                      href: resData.url
                    })
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

          dataFormat(data) {
            let result = {
              info: data.info,
              project_id: data.project_id,
              contracts: data.contracts,
              lists: []
            }

            const list = data.lists
            for (let i = 0; i < list.length; i++) {
              const currentData = list[i]
              let tmp = {
                material_id: currentData.material_id || ''
              }
              if (currentData.__type === 'new') {
                tmp.name = currentData.name
                tmp.param = currentData.param
                tmp.model = currentData.model
                tmp.factory = currentData.factory
                tmp.unit = currentData.unit
                tmp.price = currentData.price
              }
              tmp.number = currentData.number
              tmp.cost = currentData.cost
              tmp.warranty_date = currentData.warranty_date
              tmp.warranty_time = currentData.warranty_time
              result.lists.push(tmp)
            }
            return result
          },

          //提交
          submitForm() {
            const postData = this.dataFormat(this.extrabudgetary)
            console.log(postData)
            _http.BuyManager.createPurchase(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify.success({
                    title: '成功',
                    message: '提交成功！'
                  })
                  $('.ui.dimmer').addClass('active')
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