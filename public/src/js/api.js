! function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? (module.exports = factory()) :
    typeof define === 'function' && define.amd ? define(factory) : (global._http = factory())
}(window, function () {

  const url = 'http://localhost/erp/public/'

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

    // getUser(id) {
    //   if (!id) {
    //     return Promise.reject(new Error(`getUser：id(${id})无效`))
    //   }
    //   return this._http.get(`/users/${id}`)
    // }

    // createUser(data = {}) {
    //   if (!data || !Object.keys(data).length) {
    //     return Promise.reject(new Error('createUser：提交的数据无效'))
    //   }
    //   return this._http.post('/users', data, this.dataMethodDefaults)
    // }
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

  const http = {
    ProjectManager: new ProjectManager(),
    SupplierManager: new SupplierManager(),
    MaterialManager: new MaterialManager(),
    WarehouseManager: new WarehouseManager(),
    BankManager: new BankManager(),
    InvoiceManager: new InvoiceManager(),
    TeamManager: new TeamManager(),
    UploadManager: new UploadManager(),
    BudgetManager: new BudgetManager()
  }

  return http

})