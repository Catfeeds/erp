! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'buyChargeList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
          $('.ui.checkbox').checkbox()
          $('.ui.dropdown').dropdown()
        },
        methods: {}
      })
    })
}()