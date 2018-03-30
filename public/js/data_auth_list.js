! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'dataAuth'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        }
      })

      const ele = window.ELEMENT
      $('.authDelete').on('click', function () {
        ele.MessageBox.confirm('此操作将删除该操作人员, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          $(this).parents('tr').remove()
          ele.Notification.success({
            title: '成功',
            message: '删除成功!'
          })
        }).catch(() => {
          ele.Message.info({
            message: '已取消'
          })
        })
      })
    })
}()