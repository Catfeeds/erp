! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataAuthAdd',
        data: {
          authForm: {
            name: '',
            department: '',
            number: '',
            password: ''
          }
        },
        mounted() {
          this.authForm.name = $('#authName').val()
          this.authForm.department = $('#authDepartment').val()
          this.authForm.number = $('#authNumber').val()
          this.authForm.password = $('#authPassword').val() ? '******' : ''
        },
        methods: {
          //提交
          submit() {
            for (let it in this.authForm) {
              this.authForm[it] = ''
            }
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