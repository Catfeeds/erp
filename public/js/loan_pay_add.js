! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#loanPayAdd',
        data: {

          loanForm: {
            name: '',
            date: '',
            bank: '',
            account: '',
            daduction: '',
            cash: '',
            transfer: '',
            bank_index: ''
          },

          currentList: [],
          bankList: [],

          submitConfirmDialog: false,

          throttle: {
            user_timer: null
          }

        },
        mounted() {
          $('#loanPayAdd').removeClass('invisible')
          this.loanForm.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
          const bankList = $('#banks').text().trim()
          this.bankList = bankList === '' ? [] : JSON.parse(bankList)
        },

        computed: {
          currentCheckedList() {
            const list = this.currentList
            const result = []
            list.forEach((it, index) => {
              if (it.checked) {
                result.push({
                  index,
                  value: it
                })
              }
            })
            return result
          },

          listAmount() {
            const list = this.currentList
            let sum = 0
            list.forEach((it, index) => {
              sum += parseFloat(it.price)
            })
            return sum
          },

          checkAmount() {
            const list = this.currentCheckedList
            let sum = 0
            list.forEach((it, index) => {
              sum += parseFloat(it.price)
            })
            return sum
          },

          deAmount() {
            return this.checkAmount - parseFloat(this.loanForm.daduction)
          }
        },
        methods: {

          bankChange(index) {
            try {
              this.loanForm.account = this.bankList[index].account
              this.loanForm.bank = this.bankList[index].id
            } catch (error) {
              console.log(error)
            }
          },

          //报销人搜索
          querySearchMen(queryString, cb) {
            if (this.throttle.user_timer) {
              clearTimeout(this.throttle.user_timer)
            }
            this.throttle.user_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.LoanManager.loanUser(searchKey)
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
          handleSelectMen(item) {
            this.loanForm.name = item.name
            this.searchList(item.name)
          },

          searchList(name) {
            _http.LoanManager.loanListCheck({
                name
              })
              .then(res => {
                if (res.data.code === '200') {
                  this.currentList = res.data.data
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
          },

          //确定
          confirmList() {
            console.log(this.currentCheckedList)
            if (this.currentCheckedList.length) {
              this.submitConfirmDialog = true
            } else {
              this.$notify({
                title: '错误',
                message: '请选中付款内容',
                type: 'error'
              })
            }
          },

          //提交
          submit() {
            let postData = this.loanForm
            postData.lists = this.currentCheckedList.reduce((arr, item) => {
              return arr.concat([item.id])
            }, [])
            _http.LoanManager.createPayAddPost(postData)
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
          },

        }
      })
    })
}()