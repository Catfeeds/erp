! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildPayAdd',
        data: {
          addForm: {
            date: _helper.timeFormat(new Date(), 'YYY-MM-DD'),
            payment: '',
            bank: '',
            account: '',
            remark: ''
          },

        },
        mounted() {
          this.addForm.bank = $('#bankAccount').val() || ''
          $('.ui.dropdown').dropdown()
        },
        methods: {

          submit() {
            this.$notify({
              title: '成功',
              message: '提交成功',
              type: 'success'
            })
          },

        }
      })
    })
}()