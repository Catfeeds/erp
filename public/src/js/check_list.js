! function () {
  $(document)
    .ready(() => {
      
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'checkCheck'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {
        }
      })
    })
}()