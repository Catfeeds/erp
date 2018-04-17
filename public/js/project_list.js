! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'projectList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })
    })
}()