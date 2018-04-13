! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#checkDetail',
        data: {

          //存放修改对象索引
          current: {
            marginRecyle: -1,
            requirement: -1,
            invoice: -1,
            subCompany: -1,
            masterContract: -1,
            subContract: -1
          },

          //存放修改对象数据
          editForm: {
            marginRecyle: {},
            requirement: {},
            invoice: {},
            subCompany: {},
            masterContract: {},
            subContract: {}
          },

          //保函 / 付款
          marginPay: {
            count1: 123123,
            count2: 123123,
            count3: 213421252,
            data: [{
                id: 1,
                guarantee: {
                  company: '单位一',
                  amount: 12315412,
                  date: '2018-02-11',
                  cost: 5232,
                  others: '其他信息'
                },
                payment: {
                  date: '2018-02-04',
                  amount: 52321,
                  payee: '张先生',
                  bank: '广发银行',
                  account: 6009876787523154281,
                  recyle: '回收条件条件'
                }
              },
              {
                id: 2,
                guarantee: {
                  company: '单位二',
                  amount: 223542,
                  date: '2018-02-15',
                  cost: 6234,
                  others: '其他信息'
                },
                payment: {
                  date: '2018-02-04',
                  amount: 52321,
                  payee: '张先生',
                  bank: '广发银行',
                  account: 6009876787523154281,
                  recyle: '回收条件条件'
                }
              }
            ]
          },

          //履约保证金
          marginRecyle: {
            count: 1111111,
            leftCount: 2321,
            data: [{
                id: 1,
                preDate: '2018-01-02',
                preAmount: 12342213,
                prePeople: '张先生',
                preRemark: '这是备注',
                realDate: '2018-02-01',
                realBank: '中国银行',
                realAmount: 231523,
                realPeople: '张先生',
                realAccount: 60002321523215231234
              },
              {
                id: 2,
                preDate: '2018-03-02',
                preAmount: 5232124,
                prePeople: '成先生',
                preRemark: '这是备注',
                realDate: '2018-04-01',
                realBank: '广发银行',
                realAmount: 2342,
                realPeople: '成先生',
                realAccount: 60002321523215231234
              }
            ]
          },

          //预计请款
          requirement: {
            count: 123123,
            data: [{
                id: 1,
                date: '2018-10-22',
                amount: 123142,
                company: 'xxx单位',
                remark: '这是备注~'
              },
              {
                id: 2,
                date: '2017-12-22',
                amount: 123,
                company: 'xxx单位',
                remark: '这是备注这是备注~'
              }
            ]
          },

          //开票
          invoice: {
            count: 2312312,
            data: [{
                id: 1,
                date: '2018-01-02',
                amount: 2132,
                company: {
                  id: 1,
                  value: '单位一',
                },
                tax: {
                  id: 1,
                  value: 5
                }
              },
              {
                id: 2,
                date: '2018-01-02',
                amount: 2132,
                company: {
                  id: 1,
                  value: '单位一',
                },
                tax: {
                  id: 1,
                  value: 5
                }
              },
              {
                id: 3,
                date: '2018-01-02',
                amount: 2132,
                company: {
                  id: 2,
                  value: '单位二',
                },
                tax: {
                  id: 2,
                  value: 9
                }
              },
              {
                id: 4,
                date: '2018-01-02',
                amount: 2132,
                company: {
                  id: 3,
                  value: '单位三',
                },
                tax: {
                  id: 3,
                  value: 15
                }
              },
              {
                id: 5,
                date: '2018-01-02',
                amount: 2132,
                company: {
                  id: 3,
                  value: '单位三',
                },
                tax: {
                  id: 1,
                  value: 5
                }
              }
            ]
          },

          //开票公司
          invoiceCompany: [{
              id: 1,
              value: '单位一',
            },
            {
              id: 2,
              value: '单位二',
            },
            {
              id: 3,
              value: '单位三',
            }
          ],

          //key--value copy
          invoiceCompanyCopy: {
            1: '单位一',
            2: '单位二',
            3: '单位三',
          },

          //开票税率
          invoiceTax: [{
              id: 1,
              value: 5,
            },
            {
              id: 2,
              value: 9,
            },
            {
              id: 3,
              value: 15,
            }
          ],

          //发包公司收款情况
          subCompany: {
            count: 323123,
            data: [{
                id: 1,
                date: '2018-01-02',
                amount: 213123,
                remark: '这是备注啊~'
              },
              {
                id: 2,
                date: '2018-01-02',
                amount: 3212,
                remark: '这是备注啊~'
              },
              {
                id: 3,
                date: '2018-01-02',
                amount: 4274,
                remark: '这是备注啊~'
              }
            ]
          },

          //主合同收款
          masterContract: {
            count: 123123,
            data: [{
                id: 1,
                date: '2018-09-21',
                amount: 213123,
                bank: '中国银行',
                account: 6034232123523673112,
                remark: '这是备注~'
              },
              {
                id: 2,
                date: '2018-09-21',
                amount: 6423,
                bank: '中国银行',
                account: 603423212123473112,
                remark: '这是备注~'
              },
              {
                id: 3,
                date: '2018-09-21',
                amount: 6321,
                bank: '广发银行',
                account: 6034232123242673112,
                remark: '这是备注~'
              },
              {
                id: 4,
                date: '2018-09-21',
                amount: 32421,
                bank: '中国银行',
                account: 6034232123523673112,
                remark: '这是备注~'
              }
            ]
          },

          //分包合同收款
          subContract: {
            count: 123123,
            data: [{
                id: 1,
                date: '2018-09-21',
                amount: 213123,
                bank: '中国银行',
                account: 6034232123523673112,
                remark: '这是备注~'
              },
              {
                id: 2,
                date: '2018-09-21',
                amount: 6423,
                bank: '中国银行',
                account: 603423212123473112,
                remark: '这是备注~'
              },
              {
                id: 3,
                date: '2018-09-21',
                amount: 6321,
                bank: '广发银行',
                account: 6034232123242673112,
                remark: '这是备注~'
              },
              {
                id: 4,
                date: '2018-09-21',
                amount: 32421,
                bank: '中国银行',
                account: 6034232123523673112,
                remark: '这是备注~'
              }
            ]
          }
        },

        mounted() {
          $('#checkDetail').removeClass('invisible')
        },

        computed: {

          //实际履约保证金合计
          marginCount() {
            const data = this.marginRecyle.data
            let sum = 0
            data.forEach((item, index) => {
              sum += item.realAmount
            })
            return sum
          },

          //预计保证金
          preMarginCount() {
            const data = this.marginRecyle.data
            let sum = 0
            data.forEach((item, index) => {
              sum += item.preAmount
            })
            return sum
          },

          //剩余保证金

          leftMarginCount() {
            return this.preMarginCount - this.marginCount
          },

          //请款合计
          requirementCount() {
            const data = this.requirement.data
            let sum = 0
            data.forEach((item, index) => {
              sum += item.amount
            })
            return sum
          },

          //收票合计
          invoiceCount() {
            const data = this.invoice.data
            let sum = 0
            data.forEach((item, index) => {
              sum += item.amount
            })
            return sum
          },

          //收票统计
          invoiceTaxCount() {
            const vm = this
            const data = this.invoice.data
            let tmpObj = {}
            let result = new Array()
            data.forEach((item, index) => {
              const company = item.company.id
              const tax = item.tax.id
              if (tmpObj[company]) {
                if (tmpObj[company][tax]) {
                  tmpObj[company][tax] += item.amount
                } else {
                  tmpObj[company][tax] = item.amount
                }
              } else {
                tmpObj[company] = new Object({
                  [tax]: item.amount
                })
              }
            })
            for (let company in tmpObj) {
              let tmpResult = new Object()
              tmpResult.company = {
                id: company,
                name: vm.invoiceCompanyCopy[company]
              }
              tmpResult.result = tmpObj[company]
              tmpResult.count = 0
              for (let tax in tmpObj[company]) {
                tmpResult.count += tmpObj[company][tax]
              }
              result.push(tmpResult)
            }
            return result
          },


          //分包公司合计
          subCompanyCount() {
            const data = this.subCompany.data
            let sum = 0
            data.forEach((item, index) => {
              sum += item.amount
            })
            return sum
          },

          //主合同合计
          masterContractCount() {
            const data = this.masterContract.data
            let sum = 0
            data.forEach((item, index) => {
              sum += item.amount
            })
            return sum
          },

          //分包合同合计
          subContractCount() {
            const data = this.subContract.data
            let sum = 0
            data.forEach((item, index) => {
              sum += item.amount
            })
            return sum
          },
        },
        methods: {

          // 修改校验
          dataValidate(data) {
            for (let it in data) {
              if (data[it] === '') {
                this.$notify.error({
                  title: '错误',
                  message: '请确保已填写所有项！'
                })
                return false
              }
            }
            return true
          },

          //数据通用编辑  --- 编辑
          EditFnc(item, index, name) {
            this.editForm[name] = item
            this.current[name] = index
          },


          //履约保证金回收情况 --- 保存
          marginRecyleSave(item, index) {
            const data = this.editForm.marginRecyle
            if (this.dataValidate(data)) {
              this.$notify.success({
                title: '成功',
                message: '已修改'
              })
              this.current.marginRecyle = -1
            }
          },

          //请款 --- 保存
          requirementSave(item, index) {
            const data = this.editForm.requirement
            if (this.dataValidate(data)) {
              this.$notify.success({
                title: '成功',
                message: '已修改'
              })
              this.current.requirement = -1
            }
          },

          //开票 --- 保存
          invoiceSave(item, index) {
            const data = this.editForm.invoice
            if (this.dataValidate(data)) {
              this.$notify.success({
                title: '成功',
                message: '已修改'
              })
              this.current.invoice = -1
            }
          },

          //分包公司 --- 保存
          subCompanySave(item, index) {
            const data = this.editForm.subCompany
            if (this.dataValidate(data)) {
              this.$notify.success({
                title: '成功',
                message: '已修改'
              })
              this.current.subCompany = -1
            }
          },

          //主合同 --- 保存
          masterContractSave(item, index) {
            const data = this.editForm.masterContract
            if (this.dataValidate(data)) {
              this.$notify.success({
                title: '成功',
                message: '已修改'
              })
              this.current.masterContract = -1
            }
          },

          //分包合同 --- 保存
          subContractSave(item, index) {
            const data = this.editForm.subContract
            if (this.dataValidate(data)) {
              this.$notify.success({
                title: '成功',
                message: '已修改'
              })
              this.current.subContract = -1
            }
          }
        }
      })
    })
}()