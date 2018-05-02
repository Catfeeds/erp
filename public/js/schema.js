! function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? (module.exports = factory()) :
    typeof define === 'function' && define.amd ? define(factory) : (global._schemas = factory())
}(window, function () {

  //立项项目
  const projects = {
    project: {
      signDate: '', //立项日期
      name: '', //项目名
      partyA: '', //甲方
      amount: '', //项目总额
      completeDate: '', //完工日期
      manager: '', //项目经理
      maintain: '', //维护条件
    },
    masterCompany: [{ //主合同中标情况 { name, amount, remark }
      id: 1,
      name: '本单位'
    }],
    subCompany: [{ //分包情况  { name, amount, remark }
      id: 1
    }],
    masterContract: [{ //主合同情况 { amount, details }，可追加
      id: 1,
      amount: '',
      details: [{ //{ name, tax, amount, remark }
        id: 1
      }]
    }],
    subContract: [{ //分包合同情况 { amount, details }, 可追加
      id: 1,
      amount: '',
      details: [{ // { name, tax, amount, remark }
        id: 1
      }]
    }],
    margins: [{ //保证金情况 --- 保函 / 付款  { guarantee_company, guarantee_amount, guarantee_date, guarantee_cost, guarantee_others, payment_date, payment_amount, payment_payee, payment_bank, payment_account, payment_recycle}
      id: 1
    }],
    paymentConditions: [{ //收款条件 { rate, condition, expected }
      id: 1
    }],
    contracts: [] //合同上传 { name, url }
  }

  //项目预算
  const budget = {
    id: 1, //id
    name: '', //物料名称
    param: '', //参数
    model: '', //型号
    factory: '', //生产厂家
    unit: '', //单位
    price: '', //单价
    number: '', //数量
    cost: '', //金额
    type: '', //物料  / 工程 / 其他
  }

  const budget_type = [{
      id: 1,
      name: '物料',
    },
    {
      id: 2,
      name: '工程',
    },
    {
      id: 3,
      name: '其他',
    }
  ]

  const budget_type_reverse = {
    1: '物料',
    2: '工程',
    3: '其他'
  }

  //element-ui 日期选择格式
  const datePickerOption = {
    shortcuts: [{
      text: '最近一周',
      onClick(picker) {
        const end = new Date();
        const start = new Date();
        start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
        picker.$emit('pick', [start, end]);
      }
    }, {
      text: '最近一个月',
      onClick(picker) {
        const end = new Date();
        const start = new Date();
        start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
        picker.$emit('pick', [start, end]);
      }
    }, {
      text: '最近三个月',
      onClick(picker) {
        const end = new Date();
        const start = new Date();
        start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
        picker.$emit('pick', [start, end]);
      }
    }]
  }

  //收款提示
  const checkTips = {
    margins: [{ //pay_date, price, payee, remark
      id: 1,
    }],
    requirepayment: [{ //pay_date, price, payee, remark
      id: 1,
    }]
  }

  //开票
  const checkInvoice = {
    project_id: '', //项目 id
    company: '', //付款单位
    payee: '', //付款单位
    date: '', //开票日期
    rate: '', //税率
    price: '', //开票金额
    lists: [ //  number, with_tax, tax, without_tax, remark
      {
        id: 1,
      }
    ]
  }

  //验收收款
  const checkCollect = {
    margins: {
      payee: '',
      pay_date: '',
      price: '',
      bank_id: '',
      account: ''
    },
    masterContract: {
      payee: '',
      pay_date: '',
      price: '',
      bank_id: '',
      account: ''
    },
    subContract: {
      payee: '',
      pay_date: '',
      price: '',
      bank_id: '',
      account: ''
    },
    subCompany: {
      pay_date: '',
      price: '',
    }
  }

  //预算内采购
  const budgetary_buy = {
    lists: [], //采购物料清单列表： 物料 { 名称，性能， 型号， 生产厂家， 单位，单价， 数量}, 已采购数量， 剩余未采购数量， 新信息 { 本次数量，本次单价，本次金额，截至日期，保修时间 }
    contracts: [], //采购合同：名称

    project_id: '', //项目 id
    info: {
      supplier_id: '', //供应商 id
      date: '', //日期
      condition: '',  //条件
      content: '', //
      type: 1  //立项内标志
    },
    amount: 0
  }


  //预算外采购 第一步
  const extrabudgetary = {
    
    lists: [], //采购物料清单列表： 物料 { 名称，性能， 型号， 生产厂家， 单位，单价， 数量}, 已采购数量， 剩余未采购数量， 新信息 { 本次数量，本次单价，本次金额，截至日期，保修时间 }
    contracts: [], //采购合同：名称

    project_id: '', //项目 id
    info: {
      supplier_id: '', //供应商 id
      date: '', //日期
      condition: '',  //条件
      content: '', //
      type: 2  //立项外标志
    }
  }

  const invoiceCreate = {
    date: '', //收票日期
    pay_id: '',
    lists: [{ // date, type, number, amount_without_tax, tax, amount
      id: 1
    }]
  }

  const stockBuyAdd = {
    purchase_id: '',
    date: '', //收货日期
    warehouse_name: '', //仓库名字
    warehouse_id: '', //仓库 id
    worker: '',  //收货人
    lists: [], //采购列表
  }

  const stockReturnAdd = {
    project_id: '', //项目id
    project_content: '', //项目content
    returnee: '',  //退料人
    worker: '', //收货人
    warehouse_id: '', //入库仓库 id
    warehouse_name: '', //仓库名称
    lists: [], //退料清单
  }

  const stockGetAdd = {
    project_id: '', //项目id
    project_content: '', //项目内容
    project_manger: '', //项目经理
    worker: '', //领料人
    warehouse_id: '', //出货仓库, id
    warehouse_name: '', //出货仓库
    lists: [], //领料清单,
    type: ''
  }

  const buildDealAdd = {
    date: '', //日期
    team: '', //施工队,id
    build_name: '', //施工队, name
    manager: '', //施工队, manager
    project_id: '', //项目id
    project_content: '', //项目内容
    project_manger: '', //项目经理
    lists: [], //合同清单
    list: []
  }

  const buildFinishAdd = {
    date: '', //日期
    price: '', //金额
    team: '', //施工队,id
    build_name: '', //施工队, name
    build_manager: '', //施工队, manager
    project_id: '', //项目id
    project_content: '', //项目内容
    project_manger: '', //项目经理
    lists: [] //合同清单
  }

  // schemas
  const schemas = {
    projects,
    budget,
    budget_type,
    datePickerOption,
    checkTips,
    checkInvoice,
    checkCollect,
    budget_type_reverse,
    budgetary_buy,
    extrabudgetary,
    invoiceCreate,
    stockBuyAdd,
    stockReturnAdd,
    stockGetAdd,
    buildDealAdd,
    buildFinishAdd
  }

  return schemas
})