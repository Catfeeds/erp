! function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? (module.exports = factory()) :
    typeof define === 'function' && define.amd ? define(factory) : (global._http = factory())
}(window, function () {

    // const url = 'http://119.23.202.220:8080'
    // const url = 'http://192.168.1.78/erp/public'
    // const url = 'http://localhost/erp/public/'
     const url = 'http://'+window.location.host

  class ProjectManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }


    //新建项目
    createProject(data = {}) {
      return this._http.post('/project/create', data, this.dataMethodDefaults)
    }

    //创建项目类别
    createType(data = {}) {
      return this._http.post('/project/type/create', data, this.dataMethodDefaults)
    }

    //项目查询
    searchProject(search = {}) {
      return this._http.get(`/projects`, {
        params: search
      })
    }

    //项目单位查询
    searchProjectUnit(search = {}) {
      return this._http.get(`/project/unit`, {
        params: search
      })
    }

    //项目用户权限删除
    deleteProjectAuth(data = {}) {
      return this._http.get(`/del/project/role`, {
        params: data
      })
    }

    //删除项目类型
    deletProject(data = {}) {
      return this._http.get(`/del/project/type`, {
        params: data
      })
    }

    //项目复核
    checkProject(data = {}) {
      return this._http.get(`/check/project`, {
        params: data
      })
    }

    //项目审批
    passProject(data = {}) {
      return this._http.get(`/pass/project`, {
        params: data
      })
    }

    //选择复核人
    selectProjectCheck(data = {}) {
      return this._http.post('/select/project/checker', data, this.dataMethodDefaults)
    }

    //选择审批人
    selectProjectPass(data = {}) {
      return this._http.post('/select/project/passer', data, this.dataMethodDefaults)
    }

    //确认项目
    confirmProject(data = {}) {
      return this._http.get(`/confirm/project`, {
        params: data
      })
    }


    //删除项目
    deleteProject(data = {}) {
      return this._http.get(`/delete/project`, {
        params: data
      })
    }
  }

  class SupplierManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }

    //创建供应商
    createSupplier(data = {}) {
      return this._http.post('/supplier/create', data, this.dataMethodDefaults)
    }

    //搜索供应商
    searchSuppliers(search = {}) {
      return this._http.get(`/suppliers`, {
        params: search
      })
    }

    //删除供应商
    deleteSupplier(data = {}) {
      return this._http.get(`/del/supplier`, {
        params: data
      })
    }
  }

  class MaterialManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }

    //创建材料
    createMaterial(data = {}) {
      return this._http.post('/material/create', data, this.dataMethodDefaults)
    }

    //搜索项目采购材料
    searchProjectMaterial(search = {}) {
      return this._http.get(`/project/material`, {
        params: search
      })
    }

    //搜索采购项目材料
    searchBuyMaterial(search = {}) {
      return this._http.get(`/search/purchase/material`, {
        params: search
      })
    }

    //预算内采购项目材料
    searchBudgetMaterial(id, search = {}) {
      return this._http.get(`/search/budget?project=${id}`, {
        params: search
      })
    }

    searchPurchase(id) {
      return this._http.get(`/search/purchase?budget=${id}`)
    }

    searchMaterial(search = {}) {
      return this._http.get(`/search/material`, {
        params: search
      })
    }

    deleteMaterial(data = {}) {
      return this._http.get(`/del/material`, {
        params: data
      })
    }

    searchPurchaseProject(search = {}) {
      return this._http.get(`/search/purchase/project`, {
        params: search
      })
    }

    uploadMaterialBuy(data = {}) {
      return this._http.post('/import/purchase', data)
    }
  }

  class WarehouseManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //创建仓库
    createWarehouse(data = {}) {
      return this._http.post('/warehouse/create', data, this.dataMethodDefaults)
    }

    deleteWarehouse(data = {}) {
      return this._http.get(`/del/warehouse`, {
        params: data
      })
    }
  }

  class BankManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //创建银行
    createBank(data = {}) {
      return this._http.post('/bank/create', data, this.dataMethodDefaults)
    }

    //银行搜索
    searchBank(search = {}) {
      return this._http.get(`/banks`, {
        params: search
      })
    }

    //删除银行
    deleteBank(data = {}) {
      return this._http.get(`/del/bank`, {
        params: data
      })
    }
  }

  class InvoiceManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //创建发票
    createInvoice(data = {}) {
      return this._http.post('/invoice/create', data, this.dataMethodDefaults)
    }

    //删除发票
    deleteInvoice(data = {}) {
      return this._http.get(`/del/invoice`, {
        params: data
      })
    }
  }

  class TeamManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //创建团队
    createTeam(data = {}) {
      return this._http.post('/team/create', data, this.dataMethodDefaults)
    }

    //录入合同
    createContract(data = {}) {
      return this._http.post('/create/contract', data, this.dataMethodDefaults)
    }

    //搜索施工队
    searchTeam(search = {}) {
      return this._http.get(`/teams`, {
        params: search
      })
    }

    //施工   新增请款
    createFinish(data = {}) {
      return this._http.post('/finish/add', data, this.dataMethodDefaults)
    }

    // 施工   付款申请录入
    createPayApply(data = {}) {
      return this._http.post('/build/pay/apply', data, this.dataMethodDefaults)
    }


    // 施工   付款申请  付款
    createPayAdd(data = {}) {
      return this._http.post('/build/pay/add', data, this.dataMethodDefaults)
    }

    //施工   收票
    createGetAdd(data = {}) {
      return this._http.post('/build/get/add', data, this.dataMethodDefaults)
    }

    //施工请款复核人选择
    selectFinishCheck(data = {}) {
      return this._http.post('/build/finish/select/checker', data, this.dataMethodDefaults)
    }

    //复核操作
    checkFinish(data = {}) {
      return this._http.get(`/build/finish/check`, {
        params: data
      })
    }

    //提交审批人
    selectFinishPass(data = {}) {
      return this._http.post('/build/finish/select/passer', data, this.dataMethodDefaults)
    }

    //审批
    passFinish(data = {}) {
      return this._http.get(`/build/finish/pass`, {
        params: data
      })
    }

    //复核付款
    checkPay(data = {}) {
      return this._http.get(`/build/pay/check`, {
        params: data
      })
    }

    //选择付款审批人
    selectPayPasser(data = {}) {
      return this._http.post('/build/pay/select/passer', data, this.dataMethodDefaults)
    }

    //选择付款审核人
    selectPayCheck(data = {}) {
      return this._http.post('/build/pay/select/checker', data, this.dataMethodDefaults)
    }

    //审批付款
    passPay(data = {}) {
      return this._http.get(`/build/pay/pass`, {
        params: data
      })
    }

    //删除施工队
    deleteTeam(data = {}) {
      return this._http.get(`/del/team`, {
        params: data
      })
    }


    //删除请款
    deleteFinish(data = {}) {
      return this._http.get(`build/finish/delete`, {
        params: data
      })
    }
  }

  //上传
  class UploadManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
    }
    //上传
    createUpload(data = {}) {
      return this._http.post('/upload', data)
    }

    //excel 导入
    createExcel(data = {}) {
      return this._http.post('/import/payment', data)
    }
  }

  class BudgetManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //录入物料
    createBudget(project_id = '', data = {}) {
      return this._http.post(`/create/budget?project_id=${project_id}`, data, this.dataMethodDefaults)
    }
  }

  class UserManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //录入员工
    createUser(data = {}) {
      return this._http.post(`/create/user`, data, this.dataMethodDefaults)
    }

    //搜索成员
    searchUsers(search = {}) {
      return this._http.get(`/search/users`, {
        params: search
      })
    }

    //搜索用户  包含role 和 project
    searchAuthUsers(search = {}) {
      return this._http.get(`/users`, {
        params: search
      })
    }

    //删除员工
    deleteUser(data = {}) {
      return this._http.get(`/del/user`, {
        params: data
      })
    }
  }

  //费用付款管理
  class PaymentManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //录入报销费用类型
    createPayment(data = {}) {
      return this._http.post(`/category/create`, data, this.dataMethodDefaults)
    }

    //申请付款
    createPayAdd(data = {}) {
      return this._http.post(`/pay/add`, data, this.dataMethodDefaults)
    }

    //申请付款
    createNewPayAdd(data = {}) {
      return this._http.post(`/new/pay/add`, data, this.dataMethodDefaults)
    }

    //撤销申请
    calcelPay(data) {
      return this._http.get(`/pay/cancel`, {
        params: data
      })
    }
      newCancelPay(data) {
          return this._http.get(`new/pay/cancel`, {
              params: data
          })
      }

    //审批
    confirmPay(data) {
      return this._http.get(`/pay/confirm`, {
        params: data
      })
    }
      newConfirmPay(data) {
          return this._http.get(`new/pay/confirm`, {
              params: data
          })
      }

    // 付款
    createPayPay(data = {}) {
      return this._http.post(`/pay/pay`, data, this.dataMethodDefaults)
    }

    
    // 付款
    createNewPayPay(data = {}) {
      return this._http.post(`/new/pay/pay`, data, this.dataMethodDefaults)
    }

    //选择审批人
    selectPay(data = {}) {
      return this._http.post(`/pay/select`, data, this.dataMethodDefaults)
    }
    //
    newSelectPay(data = {}) {
      return this._http.post(`new/pay/select`, data, this.dataMethodDefaults)
    }
    //删除付费类型
    deleteCategory(data = {}) {
      return this._http.get(`/del/category`, {
        params: data
      })
    }

    //删除费用付款
    deleteFeePay(data = {}) {
      return this._http.get(`/del/pay/type`, {
        params: data
      })
    }

    createFeePay(data = {}) {
      return this._http.post(`/add/pay/type`, data, this.dataMethodDefaults)
    }

    searchFeePay(data = {}){
      return this._http.get(`/pay/types`, {
        params: data
      })
    }

    searchFeePayDetail(data = {}){
      return this._http.get(`/pay/types/detail`, {
        params: data
      })
    }

  }

  // 验收
  class CheckManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //项目验收
    createProjectCheck(data = {}) {
      return this._http.post(`/project/acceptance`, data, this.dataMethodDefaults)
    }

    //收款提示
    createTips(data = {}) {
      return this._http.post(`/create/tips`, data, this.dataMethodDefaults)
    }

    //项目开票
    createProjectInvoice(data = {}) {
      return this._http.post(`/project/invoice`, data, this.dataMethodDefaults)
    }

    // 项目收款
    createProjectCollect(data = {}) {
      return this._http.post(`/project/collect`, data, this.dataMethodDefaults)
    }

    //collect 修改
    editCollect(data = {}) {
      return this._http.post(`/collect`, data, this.dataMethodDefaults)
    }

    //collect get
    getCollect(data = {}) {
      return this._http.get(`/collect`, {
        params: data
      })
    }

    //tip 修改
    editTip(data = {}) {
      return this._http.post(`/tip`, data, this.dataMethodDefaults)
    }

    //tip get
    getTip(data = {}) {
      return this._http.get(`/tip`, {
        params: data
      })
    }
  }

  // 采购
  class BuyManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //采购立项
    createPurchase(data = {}) {
      return this._http.post(`/purchase/create`, data, this.dataMethodDefaults)
    }

    //采购付款申请
    createPayApply(data = {}) {
      return this._http.post(`/purchase/ask/pay`, data, this.dataMethodDefaults)
    }

    //采购实际付款
    createPay(data = {}) {
      return this._http.post(`/purchase/pay`, data, this.dataMethodDefaults)
    }

    //采购收票
    createInvoice(data = {}) {
      return this._http.post(`/purchase/invoice/create`, data, this.dataMethodDefaults)
    }
      createCostInvoice(data = {}) {
          return this._http.post(`/pay/invoice`, data, this.dataMethodDefaults)
      }

    //修改收票
    editInvoice(data = {}) {
      return this._http.post(`/purchase/edit/invoice`, data, this.dataMethodDefaults)
    }

    //采购复核
    createCheck(data = {}) {
      return this._http.get(`/purchase/check`, {
        params: data
      })
    }


    //采购复核人选择
    selectCheck(data = {}) {
      return this._http.post(`/purchase/select/check`, data, this.dataMethodDefaults)
    }

    //采购审批
    createPass(data = {}) {
      return this._http.get(`/purchase/pass`, {
        params: data
      })
    }

    //采购审批人选择
    selectPass(data = {}) {
      return this._http.post(`/purchase/select/pass`, data, this.dataMethodDefaults)
    }

    //采购付款申请
    createPayment(data = {}) {
      return this._http.post(`/purchase/payment/create`, data, this.dataMethodDefaults)
    }

    //采购付款复核
    paymentCheck(data = {}) {
      return this._http.get(`/purchase/payment/check`, {
        params: data
      })
    }

    // 选择复核人员
    selectPaymentCheck(data = {}) {
      return this._http.post(`/purchase/payment/select/check`, data, this.dataMethodDefaults)
    }

    // 付款录入
    createPaymentAdd(data = {}) {
      return this._http.post(`/purchase/payment/finish`, data, this.dataMethodDefaults)
    }

    //搜索物价比
    searchPurchase(search = {}) {
      return this._http.get(`/search/purchase`, {
        params: search
      })
    }

    deleteBuy(data = {}) {
      return this._http.get(`/del/purchase`, {
        params: data
      })
    }

    createPaySingle(data = {}) {
      return this._http.post(`/purchase/cheque`, data, this.dataMethodDefaults)
    }
  }


  class StockManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //采购收货入库
    createBuyAdd(data = {}) {
      return this._http.post(`/stock/buy/add`, data, this.dataMethodDefaults)
    }

    //退料入库
    createReturnAdd(data = {}) {
      return this._http.post(`/stock/return/add`, data, this.dataMethodDefaults)
    }

    searchStockMaterial(search = {}) {
      return this._http.get(`/search/stock/get`, {
        params: search
      })
    }

    searchStockMaterialSpecial(search = {}) {
      return this._http.get(`/search/stock/material`, {
        params: search
      })
    }

    // 领料出库
    createGetAdd(data = {}) {
      return this._http.post(`/stock/get/add`, data, this.dataMethodDefaults)
    }


    // 领料出库
    createOutAdd(data = {}) {
      return this._http.post(`/stock/out/add`, data, this.dataMethodDefaults)
    }

    //仓库查询
    searchStock(search = {}) {
      return this._http.get(`/search/warehouse`, {
        params: search
      })
    }

    //新仓库搜索
    searchOutStock(search = {}) {
      return this._http.get(`/search/purchase/warehouse`, {
        params: search
      })
    }

    //出货查询
    searchOutAdd(data = {}) {
      return this._http.get(`/stock/purchase`, {
        params: data
      })
    }
  }

  // 报销借款
  class LoanManager {
    constructor() {
      this._http = axios.create({
        baseURL: url,
        withCredentials: true
      })
      this.dataMethodDefaults = {
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        transformRequest: [function (data) {
          return Qs.stringify(data)
        }]
      }
    }
    //借款申请
    createLoanAdd(data = {}) {
      return this._http.post(`/loan/add`, data, this.dataMethodDefaults)
    }

    //期间费用报销
    createSubmit(data = {}) {
      return this._http.post(`/loan/submit/other`, data, this.dataMethodDefaults)
    }

    //项目成本报销
    createSubmitProject(data = {}) {
      return this._http.post(`/loan/submit/project`, data, this.dataMethodDefaults)
    }

    //报销种类检索
    searchCategory(search = {}) {
      return this._http.get(`/search/category`, {
        params: search
      })
    }

    //撤销借款
    cancelLoan(data = {}) {
      return this._http.get(`/loan/cancel`, {
        params: data
      })
    }


    //审批借款
    confirmLoan(data = {}) {
      return this._http.get(`/loan/confirm`, {
        params: data
      })
    }

    //选择审批人
    selectLoan(data = {}) {
      return this._http.get(`/loan/select`, {
        params: data
      })
    }

    //录入修改
    payLoan(data = {}) {
      return this._http.post(`/loan/pay/finish`, data, this.dataMethodDefaults)
    }

    //报销复核
    checkSubmit(data = {}) {
      return this._http.get(`/check/submit`, {
        params: data
      })
    }

    //选择报销复核人
    selectCheckSubmit(data = {}) {
      return this._http.post(`/select/check/submit`, data, this.dataMethodDefaults)
    }

    //选择报销审核人
    selectPassSubmit(data = {}) {
      return this._http.post(`/select/pass/submit`, data, this.dataMethodDefaults)
    }

    //报销审批
    passSubmit(data = {}) {
      return this._http.get(`/pass/submit`, {
        params: data
      })
    }


    //删除
    deleteSubmit(data = {}) {
      return this._http.get(`/delete/submit`, {
        params: data
      })
    }

    //报销付款人查询
    loanUser(data = {}) {
      return this._http.get(`/search/loan/user`, {
        params: data
      })
    }

    //查询报销人未支付报销单
    loanListCheck(data = {}) {
      return this._http.get(`/search/loan/submit`, {
        params: data
      })
    }

    //报销
    createPayAddPost(data = {}) {
      return this._http.post(`/loan/pay/add`, data, this.dataMethodDefaults)
    }

    searchLoanedUser(data = {}) {
      return this._http.get(`/search/loaned/user`, {
        params: data
      })
    }

  }


  const http = {
    BankManager: new BankManager(),
    BudgetManager: new BudgetManager(),
    InvoiceManager: new InvoiceManager(),
    MaterialManager: new MaterialManager(),
    PaymentManager: new PaymentManager(),
    ProjectManager: new ProjectManager(),
    SupplierManager: new SupplierManager(),
    TeamManager: new TeamManager(),
    UploadManager: new UploadManager(),
    UserManager: new UserManager(),
    WarehouseManager: new WarehouseManager(),
    CheckManager: new CheckManager(),
    BuyManager: new BuyManager(),
    StockManager: new StockManager(),
    LoanManager: new LoanManager()
  }

  return http

})
