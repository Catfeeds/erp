! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'buyParity'
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
          currentMaterial: {
            name: '',
            parameter: '暂无数据',
            model: '暂无数据',
            unit: '暂无数据',
            address: '暂无数据'
          },
          currentMaterialName: "",
          throttle: {
            material_timer: null
          },
          currentMaterialId: ''
        },
        mounted() {
          $('#buyParityForm').removeClass('invisible')
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