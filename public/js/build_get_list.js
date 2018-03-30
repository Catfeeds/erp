! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'buildGetList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })
    })
}()