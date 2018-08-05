! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#stockBuyAdd',
        data: {
          commodities: [],
          stockBuyAdd: _schemas.stockBuyAdd,
          //物料
          materials: [],
          currentMaterial: '',
          throttle: {
            stock_timer: null
          }
        },
        mounted() {
          this.mountedFnc()
          $('#stockBuyAdd').removeClass('invisible')
        },
        methods: {
          mountedFnc() {
            this.stockBuyAdd.worker = $('#stockReceiver').val() || ''
            this.stockBuyAdd.purchase_id = $('#purchaseId').val() || ''
            this.stockBuyAdd.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
            const projectId = $('#projectId').val() || ''
            this.stockBuyAdd.projectId = projectId ? projectId : false

            const materials = $('#buyMaterials').text().trim()
            this.materials = materials === '' ? [] : JSON.parse(materials)
          },

          //仓库搜索          
          handleSelect(item) {
            this.stockBuyAdd.warehouse_id = item.id
            this.stockBuyAdd.warehouse_name = item.name
          },
          querySearch(queryString, cb) {

            if (this.throttle.stock_timer) {
              clearTimeout(this.throttle.stock_timer)
            }
            this.throttle.stock_timer = setTimeout(() => {
              const searchKey = {
                name: queryString
              }
              _http.StockManager.searchStock(searchKey)
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

          //新增项
          addItem() {
            if (this.currentMaterial === '') {
              this.$notify.error({
                title: '错误',
                message: '请选择一项'
              })
              return false
            }
            const list = this.stockBuyAdd.lists
            const currentMaterial = this.materials[this.currentMaterial]
            let data = {
              id: list.length > 0 ? list[list.length - 1].id ? list[list.length - 1].id + 1 : 1 : 1,
              material_id: currentMaterial.id,
              material: currentMaterial,
              number: 0
            }
            data.material.index = this.currentMaterial
            this.stockBuyAdd.lists.push(data)
          },

          //新增所有
          addAll() {
            const materials = this.materials

            const list = materials.map((item, index) => {
              return {
                id: index,
                material_id: item.id,
                material: item,
                number: item.need_number
              }
            })

            this.stockBuyAdd.lists = list
          },

          //删除
          deleteItem(name, item, index) {
            this.stockBuyAdd[name].splice(index, 1)
          },

          dataFormat(data) {
            let result = {
              date: data.date,
              warehouse_id: data.warehouse_id,
              worker: data.worker,
              lists: []
            }
            const list = data.lists
            list.forEach(item => {
              result.lists.push({
                id: item.material_id,
                number: item.number
              })
            })

            return result
          },

          //提交
          submit() {
            const postData = this.dataFormat(this.stockBuyAdd)
            console.log(postData)
            _http.StockManager.createBuyAdd(postData)
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