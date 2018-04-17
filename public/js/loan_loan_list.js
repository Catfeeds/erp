! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'loanLoanList'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        }
      })

      const ele = window.ELEMENT
      $('.loanLoanListCancel').on('click', function () {
        const self = this
        ele.MessageBox.confirm('此操作将撤销该借款, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          $(self).parents('tr').remove()
          ele.Notification.success({
            title: '成功',
            message: '撤销成功!'
          })
        }).catch(() => {
          ele.Message.info({
            message: '已取消撤销'
          })
        })
      })

      $('.loanLoanListCheck').on('click', function () {
        const self = this
        ele.MessageBox.confirm('确认审批, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          $(self).remove()
          ele.Notification.success({
            title: '成功',
            message: '已审批!'
          })
        }).catch(() => {
          ele.Message.info({
            message: '已取消'
          })
        })
      })
    })
}()