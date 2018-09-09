! function () {
    $(document)
        .ready(() => {
        new Vue({
            el: '#navbar',
            data: {
                navActive: 'payList'
            },
            mounted() {
                $('#navbar').removeClass('invisible')
            },
            methods: {}
        })


        const $functionToggleOne = $('.function-toggle-one')

        $functionToggleOne.on('click', function () {
        $('.function-one').toggle(300)
    })
})
}()