"use strict";$(document).ready(function(){new Vue({el:"#budgetCreate",data:{budgetType:_schemas.budget_type,newBudget:_schemas.budget,budgetForm:new Array},mounted:function(){$("#budgetCreate").removeClass("invisible")},methods:{addNewBudget:function(){var e=Object.assign({},this.newBudget);for(var t in e)if(""===e[t]||void 0===e[t])return this.$notify.error({title:"错误",message:"请确保已填写所有项！"}),!1;this.budgetForm.push(e);for(var i in this.newBudget)"id"!==i?this.newBudget[i]="":"id"===i&&this.newBudget.id++;this.$notify.success({title:"成功",message:"已添加"})},deleteBudget:function(e,t){this.budgetForm.splice(t,1)}}})});