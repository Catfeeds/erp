! function () {
  $(document)
    .ready(() => {
      
      const $paymentCheck = $('.payment-check')

      const ele = window.ELEMENT
      $paymentCheck.on('click', function () {
        const self = this
        ele.MessageBox.confirm('复核操作, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _http.BuyManager.paymentCheck({
            id: $(self).data('id')
          }).then(res => {
            if(res.data.code === '200'){
              $(self).parents('td').html('已复核')
              ele.Notification.success({
                title: '成功',
                message: '撤销成功!'
              })
            }else {
              ele.Message.error({
                message: res.data.msg
              })
            }
          })
          .catch(() => {
            ele.Message.error({
              message: '服务器错误'
            })
          })
        }).catch(() => {
          ele.Message.info({
            message: '已取消撤销'
          })
        })
      })
    })
}()