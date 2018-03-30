! function () {
  $(document)
    .ready(() => {

      new Vue({
        el: '#stockOutAdd',
        data: {
          stockCheckDialog: false,
          loader: true,

          singleData: {
            buy_id: 'CG213123213',
            buy_date: '2018-02-03',
            buy_shop: 'xxx采购商',
            buy_amount: 123523123,
            project_id: 'XM16312412321',
            project_content: '这是内容xxx',
            project_manager: '陈先生',
            total_amount: 123123123,
            list: [{
                id: 1,
                name: '线缆',
                parameter: '这是性能参数',
                model: 'ak232',
                manufacturer: 'xxx厂家',
                unit: '个',
                price: 124,
                count: 23123,
                amount: 56231212,
                stock_id: 'SHRK20171103001',
                stock_date: '2018-02-11',
                stock_manager: '陈一发',
                stock_name: 'xxx仓库',
                stock_number: 200,
                stock_amount: 5000,
                left_number: 300,
                left_amount: 6000
              },
              {
                id: 2,
                name: '线缆',
                parameter: '这是性能参数',
                model: 'ak232',
                manufacturer: 'xxx厂家',
                unit: '条',
                price: 22,
                count: 12,
                amount: 5231,
                stock_id: 'SHRK20171103001',
                stock_date: '2018-02-11',
                stock_manager: '陈一发',
                stock_name: 'xxx仓库',
                stock_number: 200,
                stock_amount: 5000,
                left_number: 300,
                left_amount: 6000
              },
              {
                id: 3,
                name: '线缆',
                parameter: '这是性能参数',
                model: 'ak232',
                manufacturer: 'xxx厂家',
                unit: '件',
                price: 51,
                count: 523,
                amount: 61233,
                stock_id: 'SHRK20171103001',
                stock_date: '2018-02-11',
                stock_manager: '陈一发',
                stock_name: 'xxx仓库',
                stock_number: 200,
                stock_amount: 5000,
                left_number: 300,
                left_amount: 6000
              },
              {
                id: 4,
                name: '线缆',
                parameter: '这是性能参数',
                model: 'ak232',
                manufacturer: 'xxx厂家',
                unit: '套',
                price: 11,
                count: 32,
                amount: 5232,
                stock_id: 'SHRK20171103001',
                stock_date: '2018-02-11',
                stock_manager: '陈一发',
                stock_name: 'xxx仓库',
                stock_number: 200,
                stock_amount: 5000,
                left_number: 300,
                left_amount: 6000
              }
            ]
          }
        },
        mounted() {
          const vm = this
          $('.stockOutItem').on('click', function () {
            const id = $(this).data('id')
            vm.outAddCheck(id)
          })
          $('#stockOutAdd').removeClass('invisible')
        },
        methods: {
          outAddCheck(id) {
            this.loader = true
            this.stockCheckDialog = true
            setTimeout(() => {
              this.loader = false
            }, 1000)
          }
        }
      })
    })
}()