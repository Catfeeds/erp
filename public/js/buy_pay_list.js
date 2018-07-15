! function () {
    $(document)
        .ready(() => {
        new Vue({
            el: '#navbar',
            data: {
                navActive: 'buyPayList'
            },
            mounted() {
                $('#navbar').removeClass('invisible')
                $('.ui.checkbox').checkbox()

                const self = this
                $('.pay-operation').on('click', function (e) {
                    const dataId = $(this).data('id')
                    self.$prompt('请输入支票', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                    }).then(({
                        value
                    }) => {
                        self.$message({
                        type: 'success',
                        message: '提交成功'
                    });
                    if (value === '' || typeof value === 'undefined') {
                        return
                    }
                    _http.BuyManager.createPaySingle({
                        content: value,
                        id: dataId
                    })
                        .then(res => {
                        if (res.data.code === '200') {
                        self.$notify({
                            title: '成功',
                            message: `提交成功`,
                            type: 'success'
                        })
                        window.location.reload()
                    } else {
                        self.$notify({
                            title: '错误',
                            message: res.data.msg || '未知错误',
                            type: 'error'
                        })
                    }
                })
                .catch(err => {
                        this.$notify({
                        title: '错误',
                        message: '服务器出错',
                        type: 'error'
                    })
                })
                }).catch(() => {
                        self.$message({
                        type: 'info',
                        message: '取消输入'
                    });
                });
                })
            },
            methods: {}
        })
    })
}()