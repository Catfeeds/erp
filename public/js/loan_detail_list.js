! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'loanDetailList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })

      new Vue({
        el: '#loanDetailList',
        data: {
          dateOption: _schemas.datePickerOption,
          date: '',
          timeout: null
        },
        mounted() {
          $('#loanDetailList').removeClass('invisible')
        },
        methods: {}
      })
    })
}()