! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'buyPayList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
          $('.ui.checkbox').checkbox()
        },
        methods: {}
      })
    })
}()