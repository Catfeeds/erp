! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#checkAcceptance',
        data: {
          acceptanceForm: {
            acceptance_date: '',
            remark: '',
            deadline: '',
            finish: false
          }
        },
        mounted(){
          $('#checkAcceptance').removeClass('invisible')
        },
        methods: {}
      })
    })
}()