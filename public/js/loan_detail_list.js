! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'loanDetailList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })

      new Vue({
        el: '#loanDetailList',
        data: {
          dateOption: _schemas.datePickerOption,
          date: '',
          timeout: null,
          throttle: {
            user_timer: null
          },
          search: {
            name: ''
          }
        },
        mounted() {
          this.search.name = $('#originName').val()
          $('#loanDetailList').removeClass('invisible')
        },
        methods: {

          //报销人搜索
          querySearchMen(queryString, cb) {
            if (this.throttle.user_timer) {
              clearTimeout(this.throttle.user_timer)
            }
            this.throttle.user_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.LoanManager.searchLoanedUser(searchKey)
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
            $('#userName').val(item)
            this.search.name = item
          },
        }
      })
    })
}()