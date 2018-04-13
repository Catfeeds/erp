! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#loanSubmitOther',
        data: {

          submitOtherForm: {
            people: '',
            date: '',
            amount: '',
            list: []
          },

          //费用类型
          paymentData: {
            currentTypeIndex: '',
            currentType: {},
            typeList: [{
                id: 1,
                name: '交通运输费',
              },
              {
                id: 2,
                name: '业务招待费',
              },
              {
                id: 3,
                name: '差旅费',
              }
            ],
            currentDetailTypeIndex: '',
            currentDetailType: {},
            detailTypeList: []
          },

          checkedMen: [],
          menList: [{
              id: 1,
              name: '张先生'
            },
            {
              id: 2,
              name: '陈一发'
            },
            {
              id: 3,
              name: '刘芳芳'
            },
            {
              id: 4,
              name: '乌达奇'
            },
            {
              id: 5,
              name: '何求'
            }
          ],
        },
        mounted() {
          $('#loanSubmitOther').removeClass('invisible')
          this.submitOtherForm.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },
        computed: {

          sumAmount() {
            const list = this.submitOtherForm.list
            if (!list.length) {
              return 0
            }
            let sum = 0
            list.forEach((it, index) => {
              const amount = it.amount
              if (amount) {
                sum += amount * 1
              }
            })
            return sum
          }
        },
        methods: {

          //新增项
          addItem() {
            if (this.paymentData.currentDetailTypeIndex !== '') {
              const list = this.submitOtherForm.list
              let data = {
                id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
                type: this.paymentData.currentType.name,
                detailType: this.paymentData.currentDetailType.name,
              }
              this.submitOtherForm.list.push(data)
            } else {
              this.$notify({
                title: '错误',
                message: '请先选择具体事项',
                type: 'error'
              })
            }
          },

          //删除
          deleteItem(name, item, index) {
            this.submitOtherForm[name].splice(index, 1)
          },

          //选择器
          typeChange(typeIndex) {
            let data = {
              1: [{
                  id: 1,
                  name: '油费',
                },
                {
                  id: 2,
                  name: '路桥费',
                },
                {
                  id: 3,
                  name: '汽车维修费',
                },
                {
                  id: 4,
                  name: '车辆保修',
                }
              ],
              2: [{
                  id: 1,
                  name: '餐费'
                },
                {
                  id: 2,
                  name: '其他'
                }
              ],
              3: [{
                  id: 1,
                  name: '打车费'
                },
                {
                  id: 2,
                  name: '餐补'
                },
                {
                  id: 3,
                  name: '其他'
                }
              ]
            }

            const currentType = this.paymentData.typeList[typeIndex]
            this.paymentData.currentType = currentType
            const tmp = data[currentType.id]
            this.paymentData.currentDetailTypeIndex = ''
            this.paymentData.detailTypeList = tmp.length ? tmp : []
          },

          detailTypeChange(detailTypeIndex) {
            const currentDetailType = this.paymentData.detailTypeList[detailTypeIndex]
            this.paymentData.currentDetailType = currentDetailType
          },

          //提交
          submit() {
            this.$notify({
              title: '成功',
              message: '提交成功',
              type: 'success'
            })
            $('.ui.dimmer').addClass('active')
          },
          //选择审批人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交复核人
          confirmRecheck() {
            this.$notify({
              title: '成功',
              message: '已选择了复核人',
              type: 'success'
            })
            $('.ui.dimmer').removeClass('active')
          }
        }
      })
    })
}()