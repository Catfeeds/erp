! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataAuthAdd',
        data: {
          authForm: {
            username: '',
            department: '',
            phone: '',
            password: '',
            id: ''
          }
        },
        mounted() {
          this.authForm.id = $('currentId').val() || ''
          this.authForm.username = $('#authName').val()
          this.authForm.department = $('#authDepartment').val()
          this.authForm.phone = $('#authNumber').val()
          this.authForm.password = $('#authPassword').val() ? '******' : ''
        },
        methods: {
          //提交
          submit() {
            _http.UserManager.createUser(this.authForm)
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