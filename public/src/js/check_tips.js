! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'checkTips'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })

      new Vue({
        el: '#datePicker',
        data: {
          dateOption: _schemas.datePickerOption,
          date: ''
        }
      })
    })
}()