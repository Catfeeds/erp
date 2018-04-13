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
          }
        }
      })
    })
}()