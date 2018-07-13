! function () {
    $(document)
        .ready(() => {
        new Vue({
            el: '#checkCollect',
            data: {
                collectForm: _schemas.checkCollect,

                banks: [{
                    id: 1,
                    name: '中国银行',
                    account: 62343134314134313
                },
                    {
                        id: 2,
                        name: '平安银行',
                        account: 63534234232234234
                    },
                    {
                        id: 3,
                        name: '广发银行',
                        account: 63432234234233432
                    },
                    {
                        id: 4,
                        name: '中央银行',
                        account: 62343134314134313
                    }
                ],

                throttle: {
                    unit_timer: null,
                    bank_timer: null
                }
            },
            mounted() {
                $('.tabular.menu .item').tab()
                this.project_id = $('#projectId').val()
                $('#checkCollect').removeClass('invisible')
                this.collectForm.masterContract.account = $('#account').val()
                this.collectForm.masterContract.bank = $('#bank').val()
            },
            methods: {

                //银行搜索
                querySearchBank(queryString, cb) {

                    if (this.throttle.bank_timer) {
                        clearTimeout(this.throttle.bank_timer)
                    }
                    this.throttle.bank_timer = setTimeout(() => {
                        const searchKey = {
                            name: queryString
                        }
                        _http.BankManager.searchBank(searchKey)
                        .then(res => {
                        if (res.data.code === '200') {
                        cb(res.data.data)
                    } else {
                        this.$notify({
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
                }, 500)
                },
                handleSelectBankA(item) {
                    this.collectForm.margins.bank_id = item.id
                    this.collectForm.margins.bank = item.name
                    this.collectForm.margins.account = item.account
                    $('#bank').val(item.name)
                    $('#account').val(item.account)
                },
                handleSelectBankB(item) {
                    this.collectForm.masterContract.bank_id = item.id
                    this.collectForm.masterContract.bank = item.name
                    this.collectForm.masterContract.account = item.account

                    $('#bank').val(item.name)
                    $('#account').val(item.account)
                },
                handleSelectBankC(item) {
                    this.collectForm.subContract.bank_id = item.id
                    this.collectForm.subContract.bank = item.name
                    this.collectForm.subContract.account = item.account

                    $('#bank').val(item.name)
                    $('#account').val(item.account)
                },

                //数据校验
                checkSubmit(name) {
                    const vm = this
                    const data = vm.collectForm[name]
                    console.log(data)
                    for (let it in data) {
                        if (typeof data[it] === 'undefined' || data[it] === '') {
                            console.log(it)
                            vm.$notify.error({
                                title: '错误',
                                message: '请确保已填写所有内容！'
                            })
                            return false
                        }
                    }

                    switch (name) {
                        case 'margins':
                            vm.marginsSubmit(name)
                            break
                        case 'masterContract':
                            vm.masterContractSubmit(name)
                            break
                        case 'subContract':
                            vm.subContractSubmit(name)
                            break
                        case 'subCompany':
                            vm.subCompanySubmit(name)
                            break
                        default:
                            return false
                    }
                },

                //清空数据
                clearData(name) {
                    for (let it in this.collectForm[name]) {
                        this.collectForm[name][it] = ''
                    }
                },


            }
        })
    })
}()