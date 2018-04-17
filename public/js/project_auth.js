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


      let currentType = ''
      const $authAdd = $('.auth-add')
      $authAdd.on('click', function () {
        const type = $(this).data('type')
        currentType = type
        $('.ui.dimmer').dimmer('show')
      })

      new Vue({
        el: '#memberChoose',
        data: {

          checkedMen: '',
          menList: [{
              id: 1,
              name: '张先生'
            },
            {
              id: 2,
              name: '陈一发'
            },
            {
              id: 3,
              name: '刘芳芳'
            },
            {
              id: 4,
              name: '乌达奇'
            },
            {
              id: 5,
              name: '何求'
            }
          ],
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
            const url = `../project/auth_edit.html?type=${currentType}&user_id=${this.checkedMen}`
            _helper.fullWindow(url)
            $('.ui.dimmer').dimmer('hide')
          }
        }
      })
    })
}()