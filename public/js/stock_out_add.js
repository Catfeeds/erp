! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#stockOutAdd',
        data: {
          stockCheckDialog: false,
          loader: true,
          singleData: {
            record: [],
            purchaseList: [],
            project: {}
          },
          href: ''
        },
        mounted() {
          const vm = this
          $('.stockOutItem').on('click', function () {
            const id = $(this).data('id')
            vm.outAddCheck(id)
          })
          $('#stockOutAdd').removeClass('invisible')
        },
        methods: {
          outAddCheck(id) {
            this.loader = true
            this.stockCheckDialog = true
            this.href = `javascript:_helper.fullWindow('../stock/out_add_add?id=${id}')`
              // console.log(this.href)
            _http.StockManager.searchOutAdd({
                id
              })
              .then(res => {
                if (res.data.code === '200') {
                  this.singleData = res.data.data
                  this.loader = false
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