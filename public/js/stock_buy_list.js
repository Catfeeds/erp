! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'stockBuyList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
          $('.ui.checkbox').checkbox()
        },
        methods: {}
      })
    })
}()