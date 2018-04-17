! function () {
  $(document)
    .ready(() => {
      
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'buyList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
          $('.ui.checkbox').checkbox()
        },
        methods: {
        }
      })
    })
}()