! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'stockOutList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        }
      })
    })
}()