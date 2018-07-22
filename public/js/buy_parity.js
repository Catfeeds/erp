! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'buyParity',
            materail:[]
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })

      new Vue({
        el: '#buyParityForm',
        data: {
          dateOption: _schemas.datePickerOption,
          date: '',
          commodities: [],
          currentMaterial: {},
          currentMaterialName: "",
          throttle: {
            material_timer: null
          },
          currentMaterialId: ''
        },
        mounted() {
          $('#buyParityForm').removeClass('invisible')
            let materail = $('#material').text().trim()
            this.materail = materail === '' ? [] : JSON.parse(materail)
            this.currentMaterial = this.materail
            this.currentMaterialName = this.materail.name
        },
        methods: {

          querySearch(queryString, cb) {
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
          handleSelect(item) {
            this.currentMaterial = item
            this.currentMaterialName = item.name
            this.currentMaterialId = item.id
          },

        }
      })
    })
}()