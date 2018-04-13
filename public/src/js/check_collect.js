! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#checkCollect',
        data: {
          collectForm: _schemas.checkCollect,
          companies: [{
              id: 1,
              name: '单位A'
            },
            {
              id: 2,
              name: '单位B'
            },
            {
              id: 2,
              name: '单位C'
            }
          ],

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
          ]
        },
        mounted() {
          $('.tabular.menu .item').tab()
          $('#checkCollect').removeClass('invisible')
        },
        methods: {
          //单位搜索
          querySearchCompany(queryString, cb) {
            var companies = this.companies
            var results = queryString ? companies.filter(this.createFilterCompany(queryString)) : companies;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilterCompany(queryString) {
            return (item) => {
              return (item.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelectCompanyA(item) {
            this.collectForm.margins.payee_id = item.id
            this.collectForm.margins.payee = item.name
          },
          handleSelectCompanyB(item) {
            this.collectForm.masterContract.payee_id = item.id
            this.collectForm.masterContract.payee = item.name
          },
          handleSelectCompanyC(item) {
            this.collectForm.subContract.payee_id = item.id
            this.collectForm.subContract.payee = item.name
          },

          //银行搜索
          querySearchBank(queryString, cb) {
            var banks = this.banks
            var results = queryString ? banks.filter(this.createFilterBank(queryString)) : banks;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilterBank(queryString) {
            return (item) => {
              return (item.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
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

            for (let it in data) {
              if (typeof data[it] === 'undefined' || data[it] === '') {

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
            this.clearData(name)
            vm.$notify.success({
              title: '成功',
              message: '提交成功！'
            })
          },

          //主合同提交
          marginsSubmit(name) {
            const vm = this
            this.clearData(name)
            vm.$notify.success({
              title: '成功',
              message: '提交成功！'
            })
          },

          //分包合同提交
          marginsSubmit(name) {
            const vm = this
            this.clearData(name)
            vm.$notify.success({
              title: '成功',
              message: '提交成功！'
            })
          },

          //发包公司提交
          marginsSubmit(name) {
            const vm = this
            this.clearData(name)
            vm.$notify.success({
              title: '成功',
              message: '提交成功！'
            })
          }
        }
      })
    })
}()