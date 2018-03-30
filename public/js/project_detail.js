! function () {
  $(document)
    .ready(() => {
      
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'projectDetail'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {
        }
      })
    })
}()