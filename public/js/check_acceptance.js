! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#checkAcceptance',
        data: {
          acceptanceForm: {
            project_id: '',
            acceptance_date: '',
            remark: '',
            deadline: '',
            to_warranty: false
          }
        },
        mounted() {
          $('#checkAcceptance').removeClass('invisible')
          this.acceptanceForm.project_id = $('#getProjectId').val() || ''
        },
        methods: {
          submit(){
            _http.CheckManager.createProjectCheck(this.acceptanceForm)
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
          }
        }
      })
    })
}()