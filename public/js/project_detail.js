! function () {
  $(document)
    .ready(() => {
      
      new Vue({
        el: '#navbar',
        data: {
          navActive: 'projectDetail'
        },
        mounted() {
          $('#navbar').removeClass('invisible')
        },
        methods: {
        }
      })

      const $functionToggleOne = $('.function-toggle-one')
      const $functionToggleTwo = $('.function-toggle-two')
      const $functionToggleThree = $('.function-toggle-three')
      const $functionToggleFour = $('.function-toggle-four')

      $functionToggleOne.on('click', function(){
        $('.function-one').toggle(300)
      })
      $functionToggleTwo.on('click', function(){
        $('.function-two').toggle(300)
      })
      $functionToggleThree.on('click', function(){
        $('.function-three').toggle(300)
      })
      $functionToggleFour.on('click', function(){
        $('.function-four').toggle(300)
      })
    })
}()