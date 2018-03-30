! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataTeamAdd',
        data: {
          teamForm: {
            id: '',
            name: '',
            manager: '',
          }
        },
        mounted() {
          this.teamForm.id = $('#teamId').val() || ''
          this.teamForm.name = $('#teamName').val() || ''
          this.teamForm.manager = $('#teamManager').val() || ''
        },
        methods: {
          //提交
          submit() {
            _http.InvoiceManager.createInvoice(this.teamForm)
              .then(res => {
                if (res.data.code === '200') {
                  this.$notify({
                    title: '成功',
                    message: '提交成功',
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