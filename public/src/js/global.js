(function () {
  $(document)
    .ready(function () {

      //激活 dropdown
      $('.ui.dropdown')
        .dropdown();

      //激活 accordion
      $('.ui.accordion')
        .accordion();

      // 激活 sidebar
      const $sidebarBtn = $('#sidebarBtn')
      $sidebarBtn.on('click', function () {
        if ($(this).find('i').css('display') === 'none') {
          return false
        }
        $('.index-aside').toggleClass('active')
      })
    })
})()