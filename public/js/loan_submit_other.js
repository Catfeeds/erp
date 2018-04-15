! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#loanSubmitOther',
        data: {

          submitOtherForm: {
            loan_user: '',
            date: '',
            price: '',
            lists: []
          },

          //费用类型
          paymentData: {
            currentTypeIndex: '',
            currentType: {},
            typeList: [],
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
          this.submitOtherForm.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
          _http.LoanManager.searchCategory()
            .then(res => {
              if (res.data.code === '200') {
                this.paymentData.typeList = res.data.data
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
          $('#loanSubmitOther').removeClass('invisible')
        },
        computed: {

          sumAmount() {
            const list = this.submitOtherForm.lists
            if (!list.length) {
              return 0
            }
            let sum = 0
            list.forEach((it, index) => {
              const price = it.price
              if (price) {
                sum += price * 1
              }
            })
            return sum
          }
        },
        methods: {

          //新增项
          addItem() {
            const category_id = this.paymentData.currentType.id
            const kind_id = this.paymentData.currentDetailType.id
            if (category_id !== '') {
              const list = this.submitOtherForm.lists
              let data = {
                id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
                kind_id: kind_id,
                category_id: category_id,
                type: this.paymentData.currentType.title,
                detailType: this.paymentData.currentDetailType.title,
              }
              this.submitOtherForm.lists.push(data)
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

            const currentType = this.paymentData.typeList[typeIndex]
            this.paymentData.currentType = currentType
            this.paymentData.currentDetailTypeIndex = ''
            this.paymentData.detailTypeList = currentType.kinds.length ? currentType.kinds : []
          },

          detailTypeChange(detailTypeIndex) {
            const currentDetailType = this.paymentData.detailTypeList[detailTypeIndex]
            this.paymentData.currentDetailType = currentDetailType
          },

          formatData(data) {
            let result = {
              loan_user: data.loan_user,
              date: data.date,
              price: data.price,
              lists: []
            }
            const list = data.lists
            for(let i = 0; i < list.length; i++){
              let tmp = {
                category_id: list[i].category_id,
                kind_id: list[i].kind_id,
                remark: list[i].remark,
                number: list[i].number,
                price: list[i].price,
              }
              result.lists.push(tmp)
            }
            return result
          },

          //提交
          submit() {
            const postData = this.formatData(this.submitOtherForm)
            console.log(postData)
            _http.LoanManager.createSubmit(postData)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
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