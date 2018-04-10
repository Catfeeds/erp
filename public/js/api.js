! function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? (module.exports = factory()) :
    typeof define === 'function' && define.amd ? define(factory) : (global._http = factory())
}(window, function () {

  const url = 'http://119.23.202.220:8080'

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
    //创建银行
    createInvoice(data = {}) {
      return this._http.post('/invoice/create', data, this.dataMethodDefaults)
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
  }

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
      return this._http.post(`/purchase/invoice`, data, this.dataMethodDefaults)
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
    BuyManager: new BuyManager()
  }

  return http

})