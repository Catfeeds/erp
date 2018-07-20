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
            factory: '',
            unit: ''
          },
            throttle:{
                material_timer:''
            }
        },
        mounted() {
          this.materialForm.id = $('#materialId').val() || ''
          this.materialForm.name = $('#materialName').val() || ''
          this.materialForm.param = $('#materialParam').val() || ''
          this.materialForm.model = $('#materialModel').val() || ''
          this.materialForm.factory = $('#materialFactor').val() || ''
          this.materialForm.unit = $('#materialUnit').val() || ''
        },
        methods: {


          //物料
          querySearchMaterial(queryString, cb) {
            if (this.throttle.material_timer) {
              clearTimeout(this.throttle.material_timer)
            }
            this.throttle.material_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.MaterialManager.searchMaterial(searchKey)
                .then(res => {
                  if (res.data.code === '200') {
                    cb(res.data.data)
                  } else {
                    this.$notify({
                      title: '错误',
                      message: res.data.msg || '未知错误',
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
            }, 500)
          },
          handleSelectMaterial(item) {
            return false
          },


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