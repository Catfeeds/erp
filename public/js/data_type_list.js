! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'dataType'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })

      const ele = window.ELEMENT
      $('.dataTypeDelete').on('click', function () {
        const $this = $(this)
        ele.MessageBox.confirm('此操作将删除该项目类别, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _http.ProjectManager.deletProject({
              id: $this.data('id')
            })
            .then(res => {
              if (res.data.code === '200') {
                $this.parents('tr').remove()
                ele.Notification.success({
                  title: '成功',
                  message: '删除成功!'
                })
              } else {
                ele.Notification.error({
                  title: '错误',
                  message: res.data.msg
                })
              }
            })
            .catch(() => {
              ele.Notification.error({
                title: '错误',
                message: '服务器错误'
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