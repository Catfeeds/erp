! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#extrabudgetaryCheck',
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
          const vm = this
          $('#extraBudgetaryCheckRecheck').on('click', function () {
            vm.$confirm('确定复核, 是否继续?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              vm.$message({
                type: 'success',
                message: '已复核!'
              })
              $('.ui.dimmer').addClass('active')
            }).catch(() => {
              vm.$message({
                type: 'info',
                message: '已取消'
              })
            })
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