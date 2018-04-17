! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'stockList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })
    })
}()