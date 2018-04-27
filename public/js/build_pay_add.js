! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildPayAdd',
        data: {
          addForm: {
            date: _helper.timeFormat(new Date(), 'YYY-MM-DD'),
            worker: '',
            bank_id: '',
            payee_account: '',
            remark: '',
            apply_id: '',
          },
          banks: []

        },
        mounted() {
          this.addForm.bank_id = $('#bankAccount').val() || ''
          this.addForm.apply_id = $('#applyId').val() || ''
          $('.ui.dropdown').dropdown()

          _http.BankManager.searchBank()
            .then(res => {
              if (res.data.code === '200') {
                this.banks = res.data.data
              } else {
                this.$notify({
                  title: '错误',
                  message: res.data.msg,
                  type: 'error'
                })
              }
            })
            .catch(err => {
              this.$notify({
                title: '错误',
                message: '服务器出错',
                type: 'error'
              })
            })
        },
        methods: {

          submit() {
            _http.TeamManager.createPayAdd(this.addForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: `提交成功`,
                    type: 'success'
                  })
                } else {
                  this.$notify({
                    title: '错误',
                    message: res.data.msg,
                    type: 'error'
                  })
                }
              })
              .catch(err => {
                this.$notify({
                  title: '错误',
                  message: '服务器出错',
                  type: 'error'
                })
              })
          },

        }
      })
    })
}()