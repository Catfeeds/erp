! function () {
  $(document)
    .ready(() => {
      const payId = $('#payId').val() || ''
      const ele = window.ELEMENT
      $('#paySingleCancel').on('click', function () {
        ele.MessageBox.confirm('此操作将撤销付款申请, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _http.PaymentManager.calcelPay({
              id: payId
            })
            .then(res => {
              if (res.data.code === '200') {
                $('#paySingleBtn').html(`
                <h3 class="ui center aligned header grey">
                  该申请已撤销
                </h3>`)
                ele.Notification.success({
                  title: '成功',
                  message: '撤销成功!'
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
        }).catch(() => {
          ele.Message.info({
            message: '已取消'
          })
        })
      })


      $('#paySingleCheck').on('click', function () {
        ele.MessageBox.confirm('此操作将确认审批, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _http.PaymentManager.confirmPay({
              id: payId
            })
            .then(res => {
              if (res.data.code === '200') {
                ele.Notification.success({
                  title: '成功',
                  message: '已审批!'
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
        }).catch(() => {
          ele.Message.info({
            message: '已取消'
          })
        })
      })
    })
}()