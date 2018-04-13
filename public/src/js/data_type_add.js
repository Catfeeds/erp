! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataTypeAdd',
        data: {
          typeForm: {
            id: '',
            name: '',
            rate: '',
          }
        },
        mounted() {
          this.typeForm.id = $('#typeId').val() || ''
          this.typeForm.name = $('#typeName').val() || ''
          this.typeForm.rate = $('#typeRate').val() || ''
        },
        methods: {
          //提交
          submit() {
            _http.ProjectManager.createType(this.typeForm)
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