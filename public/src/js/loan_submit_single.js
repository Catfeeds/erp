! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#submitSingleDialog',
        data: {
          checkedMen: [],
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
        mounted() {
          const self = this
          $('#submitSingleCheck').on('click', function () {
            self.$notify({
              title: '成功',
              message: '提交成功',
              type: 'success'
            })
            $('.ui.dimmer').addClass('active')
          })
        },
        methods: {

          //选择审批人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审批人
          confirmRecheck() {
            this.$notify({
              title: '成功',
              message: '已选择了审批人',
              type: 'success'
            })
            $('.ui.dimmer').removeClass('active')
          }
        }
      })
    })
}()