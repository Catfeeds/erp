! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#checkCreateTips',
        data: {
          tipsForm: _schemas.checkTips
        },
        mounted() {
          $('#checkCreateTips').removeClass('invisible')
        },
        methods: {

          //删除第一层数据
          deleteItem(name, item, index) {
            this.tipsForm[name].splice(index, 1)
          },

          //新增第一层数据
          addItem(name) {
            const tipsForm = this.tipsForm[name]
            const length = tipsForm.length
            let id
            if (length > 0) {
              id = tipsForm[length - 1].id + 1
            } else {
              id = 1
            }
            this.tipsForm[name].push({
              id
            })
          },


          formatData() {
            let results = []
            const margins = this.tipsForm.margins
            const requirepayment = this.tipsForm.requirepayment

            margins.forEach((it, index) => {
              if (it) {
                let tmp = it
                tmp.type = 1
                results.push(tmp)
              }
            })

            requirepayment.forEach((it, index) => {
              if (it) {
                let tmp = it
                tmp.type = 2
                results.push(tmp)
              }
            })

            return results
          },

          submit() {
            const postData = this.formatData()
            if (postData.length <= 0) {
              this.$notify({
                title: '错误',
                message: '请填写数据！',
                type: 'error'
              })
              return false
            }

            _http.CheckManager.createTips(postData)
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