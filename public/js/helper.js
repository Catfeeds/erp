! function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? (module.exports = factory()) :
    typeof define === 'function' && define.amd ? define(factory) : (global._helper = factory())
}(window, function () {

  const helper = {

    //全屏跳转
    fullWindow: function (url) {
      const params = [
        'height=' + screen.height,
        'width=' + screen.width,
        'fullscreen=yes',
        'location=no'
      ].join(',')

      let popup = window.open(url, '', params)
      popup.moveTo(0, 0)
    },

    //时间格式化
    timeFormat(date, format) {
      if (!date) {
        console.error('date is necessary!')
        return undefined
      } else if (!format) {
        return date
      }
      const timeType = {
        'Y+': date.getFullYear(),
        'M+': date.getMonth() + 1,
        'D+': date.getDate(),
        'h+': date.getHours(),
        'm+': date.getMinutes(),
        's+': date.getSeconds()
      }

      let result = format
      for (let key in timeType) {
        if (new RegExp(`(${key})`).test(result)) {
          if (key === 'Y+') {
            result = result.replace(RegExp.$1, timeType[key])
          } else {
            result = result.replace(RegExp.$1, timeType[key] > 10 ? timeType[key] : `0${timeType[key]}`)
          }
        }
      }
      return result
    },

    //项目表单重命名
    projectCreatFormat(data, ContentIDMap, TaxIDMap) {
      let result = {
        project: {},
        mainContracts: [],
        outContracts: [],
        situations: [],
        bails: [],
        receipts: [],
        pictures: []
      }
      if (!data) {
        return result
      }

      const project = data.project
      //project edit
      result.project.id = project.id ? project.id : ''
      result.project.name = project.name
      result.project.PartyA = project.partyA
      result.project.price = project.amount
      result.project.finishTime = project.completeDate
      result.project.pm = project.manager
      result.project.createTime = project.signDate
      result.project.condition = project.maintain


      // masterCompany edit
      const mainContracts = data.masterCompany

      mainContracts.forEach((it, index) => {
        if (it) {
          let tmp = {
            id: it.id ? it.id : '',
            unit: it.name,
            price: it.amount,
            remark: it.remark
          }
          result.mainContracts.push(tmp)
        }
      })

      //subCompany edit
      const outContracts = data.subCompany

      outContracts.forEach((it, index) => {
        if (it) {
          let tmp = {
            id: it.id ? it.id : '',
            unit: it.name,
            price: it.amount,
            remark: it.remark
          }
          result.outContracts.push(tmp)
        }
      })

      //master/sub Contracts edit
      const masterContract = data.masterContract
      const subContract = data.subContract

      masterContract.forEach((it, index) => {
        if (it) {
          let tmp = {
            price: it.amount,
            type: 1,
            is_main: index === 0 ? 1 : 0,
            lists: []
          }
          const details = it.details
          details.forEach((subIt, subIndex) => {
            let subTmp = {
              name: ContentIDMap[subIt.name],
              tax: TaxIDMap[subIt.name],
              price: subIt.amount,
              remark: subIt.remark,
            }
            tmp.lists.push(subTmp)
          })
          result.situations.push(tmp)
        }
      })

      subContract.forEach((it, index) => {
        if (it) {
          let tmp = {
            price: it.amount,
            type: 2,
            is_main: index === 0 ? 1 : 0,
            lists: []
          }
          const details = it.details
          details.forEach((subIt, subIndex) => {
            let subTmp = {
              name: ContentIDMap[subIt.name],
              tax: TaxIDMap[subIt.name],
              price: subIt.amount,
              remark: subIt.remark,
            }
            tmp.lists.push(subTmp)
          })
          result.situations.push(tmp)
        }
      })

      //margins edit
      const margins = data.margins

      margins.forEach((it, index) => {
        if (it) {
          let tmp = {
            unit: it.guarantee_company,
            price: it.guarantee_amount,
            term: it.guarantee_date,
            cost: it.guarantee_cost,
            other: it.guarantee_others,
            pay_date: it.payment_date,
            pay_price: it.payment_amount,
            payee: it.payment_payee,
            bank: it.payment_bank,
            bank_account: it.payment_account,
            condition: it.payment_recycle,
          }
          result.bails.push(tmp)
        }
      })


      //condition edit
      const paymentConditions = data.paymentConditions

      paymentConditions.forEach((it, index) => {
        if (it) {
          let tmp = {
            ratio: it.rate,
            price: it.expected,
            condition: it.condition,
          }
          result.receipts.push(tmp)
        }
      })

      // picture edit
      const pictures = data.contracts

      pictures.forEach((it, index) => {
        if (it) {
          let tmp = {
            id: it.id,
            url: it.url,
            name: it.name,
          }
          result.pictures.push(tmp)
        }
      })

      return result
    },

    //项目数据获取重命名
    projectGetFormat(data, ContentNameMap) {
      let result = {
        project: {},
        masterCompany: [],
        subCompany: [],
        masterContract: [],
        subContract: [],
        margins: [],
        paymentConditions: [],
        contracts: []
      }
      if (!data) {
        return result
      }

      const project = data.project
      //project edit
      result.project.id = project.id ? project.id : ''
      result.project.name = project.name
      result.project.partyA = project.PartyA
      result.project.amount = project.price
      result.project.completeDate = project.finishTime
      result.project.manager = project.pm
      result.project.signDate = project.createTime
      result.project.maintain = project.condition


      // masterCompany edit
      const masterCompany = data.mainContracts

      masterCompany.forEach((it, index) => {
        if (it) {
          let tmp = {
            id: it.id ? it.id : '',
            name: it.unit,
            amount: it.price,
            remark: it.remark
          }
          result.masterCompany.push(tmp)
        }
      })

      //subCompany edit
      const subCompany = data.outContracts

      subCompany.forEach((it, index) => {
        if (it) {
          let tmp = {
            id: it.id ? it.id : '',
            name: it.unit,
            amount: it.price,
            remark: it.remark
          }
          result.subCompany.push(tmp)
        }
      })

      //master/sub Contracts edit
      const situations = data.situations

      situations.forEach((it, index) => {
        if (it) {
          let tmp = {
            id: it.id,
            amount: it.price,
            details: []
          }
          const details = it.lists
          details.forEach((subIt, subIndex) => {
            let subTmp = {
              name: ContentNameMap[subIt.name],
              amount: subIt.price,
              remark: subIt.remark,
            }
            tmp.details.push(subTmp)
          })
          if (it.type == 1) {
            result.masterContract.push(tmp)
          } else if (it.type == 2) {
            result.subContract.push(tmp)
          }
        }
      })

      //margins edit
      const margins = data.bails

      margins.forEach((it, index) => {
        if (it) {
          let tmp = {
            id: it.id,
            guarantee_company: it.unit,
            guarantee_amount: it.price,
            guarantee_date: it.term,
            guarantee_cost: it.cost,
            guarantee_others: it.other,
            payment_date: it.pay_date,
            payment_amount: it.pay_price,
            payment_payee: it.payee,
            payment_bank: it.bank,
            payment_account: it.bank_account,
            payment_recycle: it.condition,
          }
          result.margins.push(tmp)
        }
      })


      //condition edit
      const paymentConditions = data.receipts

      paymentConditions.forEach((it, index) => {
        if (it) {
          let tmp = {
            rate: it.ratio,
            expected: it.price,
            condition: it.condition,
            id: it.id,
          }
          result.paymentConditions.push(tmp)
        }
      })

      // picture edit
      const pictures = data.pictures

      pictures.forEach((it, index) => {
        if (it) {
          let tmp = {
            id: it.id,
            url: it.url,
            name: it.name,
          }
          result.contracts.push(tmp)
        }
      })

      return result

    },

  }

  return helper

})