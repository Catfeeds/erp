! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#buildFinishSingle',
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
          $('#navbar').removeClass('invisible')
        },
        methods: {
          recheckFnc() {
            this.$notify({
              title: '成功',
              message: '复核成功',
              type: 'success'
            })
            $('.ui.dimmer').addClass('active')
          },
          //选择审核人
          handleCheckManChange(value) {
            console.log(this.checkedMen)
          },

          //提交审核人
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