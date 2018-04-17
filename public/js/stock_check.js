! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#stockCheck',
        data: {
          dateOption: _schemas.datePickerOption,
          date: ''
        },
        mounted() {
          $('#stockCheck').removeClass('invisible')
          // $($('.el-range-input')[0]).val('2018-01-02')
          // $($('.el-range-input')[1]).val('2018-01-06')
        },
        methods: {
        }
      })
    })
}()