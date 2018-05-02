! function () {
  $(document)
    .ready(() => {
      const $authDelete = $('.auth-delete')

      const ele = window.ELEMENT
      $authDelete.on('click', function () {
        const self = this
        ele.MessageBox.confirm('此操作将撤销该人员得权限, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _http.ProjectManager.deleteProjectAuth({
            user_id: $(self).data('id'),
            project_id:projectId
          }).then(res => {
            if(res.data.code === '200'){
              $(self).parents('tr').remove()
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


      let currentType = ''
      const $authAdd = $('.auth-add')
      $authAdd.on('click', function () {
        const type = $(this).data('type')
        currentType = type
        $('.ui.dimmer').dimmer('show')
      })

      const projectId = $('#projectId').val()
      new Vue({
        el: '#memberChoose',
        data: {

          checkedMen: '',
          menList: [],
        },

        created() {
          const persons = $('#person').text().trim()
          this.menList = persons === '' ? [] : JSON.parse(persons)
        },
        methods: {
          //选择审核人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          cancelClick() {
            $('.ui.dimmer').dimmer('hide')
          },

          //提交审核人
          confirmRecheck() {
            const url = `../project/auth_edit?project_id=${projectId}&type=${currentType}&user_id=${this.checkedMen}`
            _helper.fullWindow(url)
            $('.ui.dimmer').dimmer('hide')
          }
        }
      })
    })
}()