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
        const id = $(self).parents('tr').data('id')
        ele.MessageBox.confirm('此操作将撤销该借款, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _http.LoanManager.cancelLoan({id})
            .then(res => {
              if (res.data.code === '200') {
                $(self).parents('tr').remove()
                ele.Notification.success({
                  title: '成功',
                  message: '撤销成功!'
                })
              } else {
                ele.$notify({
                  title: '错误',
                  message: res.data.msg,
                  type: 'error'
                })
              }
            })
            .catch(err => {
              ele.$notify({
                title: '错误',
                message: '服务器出错',
                type: 'error'
              })
            })
        }).catch(() => {
          ele.Message.info({
            message: '已取消撤销'
          })
        })
      })

      $('.loanLoanListCheck').on('click', function () {
        const self = this
        const id = $(self).parents('tr').data('id')
        ele.MessageBox.confirm('确认审批, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _http.LoanManager.confirmLoan({id})
            .then(res => {
              if (res.data.code === '200') {
                $(self).remove()
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