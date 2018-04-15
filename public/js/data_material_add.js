! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#dataMaterialAdd',
        data: {
          materialForm: {
            name: '',
            param: '',
            model: '',
            factor: '',
            unit: ''
          }
        },
        mounted() {
          this.materialForm.id = $('#materialId').val() || ''
          this.materialForm.name = $('#materialName').val() || ''
          this.materialForm.param = $('#materialParam').val() || ''
          this.materialForm.model = $('#materialModel').val() || ''
          this.materialForm.factor = $('#materialFactor').val() || ''
          this.materialForm.unit = $('#materialUnit').val() || ''
        },
        methods: {
          //提交
          submit() {
            _http.MaterialManager.createMaterial(this.materialForm)
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