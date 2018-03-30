! function () {
  $(document)
    .ready(() => {

      $('#buyNewProjectLink').on('click', function () {
        $('.ui.dimmer')
          .dimmer('show', 'set disabled')
      })
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'buyProjectList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })
    })
}()