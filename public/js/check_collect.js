! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#checkCollect',
        data: {
          collectForm: _schemas.checkCollect,

          banks: [{
              id: 1,
              name: '中国银行',
              account: 62343134314134313
            },
            {
              id: 2,
              name: '平安银行',
              account: 63534234232234234
            },
            {
              id: 3,
              name: '广发银行',
              account: 63432234234233432
            },
            {
              id: 4,
              name: '中央银行',
              account: 62343134314134313
            }
          ],

          throttle: {
            unit_timer: null,
            bank_timer: null
          }
        },
        mounted() {
          $('.tabular.menu .item').tab()
          this.project_id = $('#projectId').val()
          $('#checkCollect').removeClass('invisible')
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
                project_id: this.project_id || ''
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
          handleSelectCompanyA(item) {
            this.collectForm.margins.payee = item
          },
          handleSelectCompanyB(item) {
            this.collectForm.masterContract.payee = item
          },
          handleSelectCompanyC(item) {
            this.collectForm.subContract.payee = item
          },

          //银行搜索
          querySearchBank(queryString, cb) {
            
            if (this.throttle.bank_timer) {
              clearTimeout(this.throttle.bank_timer)
            }
            this.throttle.bank_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.BankManager.searchBank(searchKey)
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
          handleSelectBankA(item) {
            this.collectForm.margins.bank_id = item.id
            this.collectForm.margins.bank = item.name
            this.collectForm.margins.account = item.account
          },
          handleSelectBankB(item) {
            this.collectForm.masterContract.bank_id = item.id
            this.collectForm.masterContract.bank = item.name
            this.collectForm.masterContract.account = item.account
          },
          handleSelectBankC(item) {
            this.collectForm.subContract.bank_id = item.id
            this.collectForm.subContract.bank = item.name
            this.collectForm.subContract.account = item.account
          },

          //数据校验
          checkSubmit(name) {
            const vm = this
            const data = vm.collectForm[name]
            console.log(data)
            for (let it in data) {
              if (typeof data[it] === 'undefined' || data[it] === '') {
                console.log(it)
                vm.$notify.error({
                  title: '错误',
                  message: '请确保已填写所有内容！'
                })
                return false
              }
            }

            switch (name) {
              case 'margins':
                vm.marginsSubmit(name)
                break
              case 'masterContract':
                vm.masterContractSubmit(name)
                break
              case 'subContract':
                vm.subContractSubmit(name)
                break
              case 'subCompany':
                vm.subCompanySubmit(name)
                break
              default:
                return false
            }
          },

          //清空数据
          clearData(name) {
            for (let it in this.collectForm[name]) {
              this.collectForm[name][it] = ''
            }
          },

          //保证金提交
          marginsSubmit(name) {
            const vm = this
            let data = this.collectForm[name]
            data.project_id = this.project_id
            data.type = 1
            _http.CheckManager.createProjectCollect(data)
              .then(res => {
                if (res.data.code === '200') {
                  this.clearData(name)
                  vm.$notify.success({
                    title: '成功',
                    message: '提交成功！'
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

          //主合同提交
          masterContractSubmit(name) {
            const vm = this
            let data = this.collectForm[name]
            data.project_id = this.project_id
            data.type = 2
            _http.CheckManager.createProjectCollect(data)
              .then(res => {
                if (res.data.code === '200') {
                  this.clearData(name)
                  vm.$notify.success({
                    title: '成功',
                    message: '提交成功！'
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

          //分包合同提交
          subContractSubmit(name) {
            const vm = this
            let data = this.collectForm[name]
            data.project_id = this.project_id
            data.type = 3
            _http.CheckManager.createProjectCollect(data)
              .then(res => {
                if (res.data.code === '200') {
                  this.clearData(name)
                  vm.$notify.success({
                    title: '成功',
                    message: '提交成功！'
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

          //发包公司提交
          subCompanySubmit(name) {
            const vm = this
            let data = this.collectForm[name]
            data.project_id = this.project_id
            data.type = 4
            _http.CheckManager.createProjectCollect(data)
              .then(res => {
                if (res.data.code === '200') {
                  this.clearData(name)
                  vm.$notify.success({
                    title: '成功',
                    message: '提交成功！'
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