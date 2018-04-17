! function () {
  $(document)
    .ready(() => {
      new Vue({
        el: '#loanPayAdd',
        data: {

          loanForm: {
            people: '',
            people_id: '',
            date: '',
            bank: '',
            account: '',
            de_amount: '',
            cash_amount: '',
            bank_amount: ''
          },

          //报销人
          payMen: [{
              id: 1,
              name: '张朝阳'
            },
            {
              id: 2,
              name: '李白'
            }
          ],

          currentList: [],

          backList: {
            1: [{
                id: 'BXBH123123123',
                amount: 213122,
                checkMan: '陈骁驰',
                passMan: '罗致'
              },
              {
                id: 'BXBH123123123',
                amount: 123,
                checkMan: '周毅强',
                passMan: '何春'
              },
              {
                id: 'BXBH123123123',
                amount: 555,
                checkMan: '海子',
                passMan: '罗致'
              },
              {
                id: 'BXBH123123123',
                amount: 12352,
                checkMan: '赫布',
                passMan: '张起灵'
              }
            ],
            2: [{
                id: 'BXBH123123123',
                amount: 555555,
                checkMan: '东山',
                passMan: '黄致列'
              },
              {
                id: 'BXBH123123123',
                amount: 12352,
                checkMan: '赫布',
                passMan: '张起灵'
              }
            ]
          },

          submitConfirmDialog: false,

        },
        mounted() {
          $('#loanPayAdd').removeClass('invisible')
          this.loanForm.date = _helper.timeFormat(new Date(), 'YYYY-MM-DD')
        },

        computed: {
          currentCheckedList() {
            const list = this.currentList
            const result = []
            list.forEach((it, index) => {
              if (it.checked) {
                result.push({
                  index,
                  value: it
                })
              }
            })
            return result
          },
        },
        methods: {

          //报销人搜索
          querySearchMen(queryString, cb) {
            var payMen = this.payMen
            var results = queryString ? payMen.filter(this.createFilterMen(queryString)) : payMen;
            // 调用 callback 返回建议列表的数据
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
              cb(results);
            }, 1000 * Math.random());
          },
          createFilterMen(queryString) {
            return (item) => {
              return (item.name.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
            };
          },
          handleSelectMen(item) {
            this.loanForm.people_id = item.id
            this.loanForm.people = item.name
            this.currentList = this.backList[item.id]
          },

          //确定
          confirmList() {
            console.log(this.currentCheckedList)
            if (this.currentCheckedList.length) {
              this.submitConfirmDialog = true
            } else {
              this.$notify({
                title: '错误',
                message: '请选中付款内容',
                type: 'error'
              })
            }
          },

          //提交
          submit() {
            this.$notify({
              title: '成功',
              message: '提交成功',
              type: 'success'
            })
            $('.ui.dimmer').addClass('active')
          },

        }
      })
    })
}()