! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#payAdd',
        data: {

          payForm: {
            apply_date: '',
            apply_price: '',
            application: '',
            project_id: '',
            project_content: '',
            pay_detail: '',
            pictures: []
          },

          checkedMen: [],
          menList: [],

          throttle: {
            id_timer: null,
            name_timer: null,
            payee_timer: null
          },
          selectData: {
            id: ''
          },
          currentSupplier: {},
          invoiceType: [],
          payType: [],
          pay_type: '',
          payDetail: []
        },
        mounted() {
          this.payForm.apply_date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')

          const invoiceType = $('#invoiceType').text().trim()
          this.invoiceType = invoiceType === '' ? [] : JSON.parse(invoiceType)
          $('#payAdd').removeClass('invisible')

          _http.PaymentManager.searchFeePay()
            .then(res => {
              if (res.data.code === '200') {
                this.payType = res.data.data
              } else {
                this.$notify({
                  title: '错误',
                  message: res.data.msg,
                  type: 'error'
                })
              }
            })

            // console.log($('#addEdit').text())
          const addEdit = $('#addEdit').text().trim()
          // const addEdit = {
          //   apply_date: '2018-02-11',
          //   apply_price: 22222,
          //   application: 'zheshiyongtu',
          //   project_id: 1,
          //   project_number: 'XM1232132100123',
          //   project_content: 'name',
          //   pay_detail: 1,
          //   remark: 'beizhu',
          //   invoice_type: 1,
          //   type: 1,
          //   supplier_id: 1,
          //   payee: 'gongyingshang',
          //   pay_type: 1,

          //   // 记得加这个结构，把当前的 payee 顺便塞到这个对象
          //   currentSupplier: {
          //     id: 1,
          //     name: 'name',
          //     bank: 'bank',
          //     account: 'account'
          //   },

          //   pictures: [{
          //     id: 1,
          //     name: 'tupian',
          //     url: 'http://www.baidu.jpg'
          //   }]
          // }
          if (addEdit) {
              console.log(addEdit)
            this.payForm = addEdit === '' ? [] : JSON.parse(addEdit)
              // console.log(this.payForm.application)
            // this.payForm = addEdit
            this.currentSupplier = this.payForm.currentSupplier
            this.handlePayTypeChange(this.payForm.pay_type)
          }

        },
        methods: {

          handlePayTypeChange(id) {
            this.payForm.pay_type = id
            _http.PaymentManager.searchFeePayDetail({
                id
              })
              .then(res => {
                if (res.data.code === '200') {
                  this.payDetail = res.data.data
                } else {
                  this.$notify({
                    title: '错误',
                    message: res.data.msg,
                    type: 'error'
                  })
                }
              })
          },

          //项目搜索
          querySearchProjectId(queryString, cb) {
            clearTimeout(this.throttle.id_timer)
            this.throttle.id_timer = setTimeout(() => {
              const searchKey = {
                id: queryString,
                type: 'pay_add'
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
            this.payForm.project_id = item.id
            this.payForm.project_number = item.number
            this.payForm.project_content = item.name
          },

          querySearchProjectContent(queryString, cb) {
            console.log(queryString)
            clearTimeout(this.throttle.name_timer)
            this.throttle.name_timer = setTimeout(() => {
              const searchKey = {
                  name: queryString,
                  type:'pay_add'
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
            this.payForm.project_id = item.id
            this.payForm.project_number = item.number
            this.payForm.project_content = item.name
          },

          //收款人搜索
          querySearchPayee(queryString, cb) {
            clearTimeout(this.throttle.payee_timer)
            this.throttle.payee_timer = setTimeout(() => {
              const searchKey = {
                name: queryString,
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
          handleSelectPayee(item) {
            this.currentSupplier = item
            this.payForm.supplier_id = item.id
            this.payForm.payee = item.name
          },


          //上传图片
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
                    this.payForm.pictures.push({
                      id: resData.size,
                      name: resData.name,
                      url: resData.url
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
                  console.log(err)
                  this.$notify({
                    title: '错误',
                    message: '服务器出错',
                    type: 'error'
                  })
                })
            }

          },

          deleteItem(index) {
            this.payForm.pictures.splice(index, 1)
          },

          //提交
          submit() {
            _http.PaymentManager.createNewPayAdd(this.payForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
                  })
                  this.selectData.id = res.data.data.id
                  _http.UserManager.searchAuthUsers({
                      role: 'pay_pass'
                    })
                    .then(resp => {
                      if (resp.data.code === '200') {
                        this.menList = resp.data.data
                        $('.ui.dimmer').addClass('active')
                      } else {
                        this.$notify({
                          title: '错误',
                          message: res.data.msg,
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
          //选择审批人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审批人
          confirmRecheck() {
            this.selectData.users = this.checkedMen
            _http.PaymentManager.newSelectPay(this.selectData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '已选择了审批人',
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