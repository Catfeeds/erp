"use strict";var _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};!function(t,e){"object"===("undefined"==typeof exports?"undefined":_typeof(exports))&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):t._helper=e()}(window,function(){return{fullWindow:function(t){var e=["height="+screen.height,"width="+screen.width,"fullscreen=yes","location=no"].join(",");window.open(t,"",e).moveTo(0,0)},timeFormat:function(t,e){if(t){if(!e)return t;var a={"Y+":t.getFullYear(),"M+":t.getMonth()+1,"D+":t.getDate(),"h+":t.getHours(),"m+":t.getMinutes(),"s+":t.getSeconds()},n=e;for(var r in a)new RegExp("("+r+")").test(n)&&(n="Y+"===r?n.replace(RegExp.$1,a[r]):n.replace(RegExp.$1,a[r]>10?a[r]:"0"+a[r]));return n}console.error("date is necessary!")},projectCreatFormat:function(t){var e={project:{},mainContracts:[],outContracts:[],situations:[],bails:[],receipts:[],pictures:[]};if(!t)return e;var a=t.project;e.project.id=a.id?a.id:"",e.project.name=a.name,e.project.PartyA=a.partyA,e.project.price=a.amount,e.project.finishTime=a.completeDate,e.project.pm=a.manager,e.project.createTime=a.signDate,e.project.condition=a.maintain,t.masterCompany.forEach(function(t,a){if(t){var n={id:t.id?t.id:"",unit:t.name,price:t.amount,remark:t.remark};e.mainContracts.push(n)}}),t.subCompany.forEach(function(t,a){if(t){var n={id:t.id?t.id:"",unit:t.name,price:t.amount,remark:t.remark};e.outContracts.push(n)}});var n=t.masterContract,r=t.subContract;return n.forEach(function(t,a){if(t){var n={price:t.amount,type:1,is_main:0===a?1:0,lists:[]};t.details.forEach(function(t,e){var a={name:t.name,tax:t.tax,price:t.amount,remark:t.remark};n.lists.push(a)}),e.situations.push(n)}}),r.forEach(function(t,a){if(t){var n={price:t.amount,type:2,is_main:0===a?1:0,lists:[]};t.details.forEach(function(t,e){var a={name:t.name,tax:t.tax,price:t.amount,remark:t.remark};n.lists.push(a)}),e.situations.push(n)}}),t.margins.forEach(function(t,a){if(t){var n={unit:t.guarantee_company,price:t.guarantee_amount,term:t.guarantee_date,cost:t.guarantee_cost,other:t.guarantee_others,pay_date:t.payment_date,pay_price:t.payment_amount,payee:t.payment_payee,bank:t.payment_bank,bank_account:t.payment_account,condition:t.payment_recycle};e.bails.push(n)}}),t.paymentConditions.forEach(function(t,a){if(t){var n={radio:t.rate,price:t.expected,condition:t.condition};e.receipts.push(n)}}),t.contracts.forEach(function(t,a){if(t){var n={id:t.id,url:t.url,name:t.name};e.pictures.push(n)}}),e},projectGetFormat:function(t){var e={project:{},masterCompany:[],subCompany:[],masterContract:[],subContract:[],margins:[],paymentConditions:[],contracts:[]};if(!t)return e;var a=t.project;return e.project.id=a.id?a.id:"",e.project.name=a.name,e.project.partyA=a.PartyA,e.project.amount=a.price,e.project.completeDate=a.finishTime,e.project.manager=a.pm,e.project.signDate=a.createTime,e.project.maintain=a.condition,t.mainContracts.forEach(function(t,a){if(t){var n={id:t.id?t.id:"",name:t.unit,amount:t.price,remark:t.remark};e.masterCompany.push(n)}}),t.outContracts.forEach(function(t,a){if(t){var n={id:t.id?t.id:"",name:t.unit,amount:t.price,remark:t.remark};e.subCompany.push(n)}}),t.situations.forEach(function(t,a){if(t){var n={id:t.id,amount:t.price,details:[]};t.lists.forEach(function(t,e){var a={name:t.name,tax:t.tax,amount:t.price,remark:t.remark};n.details.push(a)}),1==t.type?e.masterContract.push(n):2==t.type&&e.subContract.push(n)}}),t.bails.forEach(function(t,a){if(t){var n={id:t.id,guarantee_company:t.unit,guarantee_amount:t.price,guarantee_date:t.term,guarantee_cost:t.cost,guarantee_others:t.other,payment_date:t.pay_date,payment_amount:t.pay_price,payment_payee:t.payee,payment_bank:t.bank,payment_account:t.bank_account,payment_recycle:t.condition};e.margins.push(n)}}),t.receipts.forEach(function(t,a){if(t){var n={rate:t.radio,expected:t.price,condition:t.condition};e.paymentConditions.push(n)}}),t.pictures.forEach(function(t,a){if(t){var n={id:t.id,url:t.url,name:t.name};e.contracts.push(n)}}),e}}});