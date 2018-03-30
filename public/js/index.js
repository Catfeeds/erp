! function () {
  $(document)
    .ready(function () {

      new Vue({
        el: '#navbar',
        data: {
          navActive: 'index',
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {}
      })

      new Vue({
        el: '#indexPending',
        data: {
          //业务列表
          pendingList: [{
              id: 1,
              name: '采购立项',
              number: 'CG2131521323213',
              status: '未审核',
            },
            {
              id: 2,
              name: '采购立项',
              number: 'CG73452321523213',
              status: '未审批',
            }
          ]
        },
        mounted() {
          $('#indexPending').removeClass('invisible')
        },
      })
    })

}()