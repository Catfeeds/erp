"use strict";$(document).ready(function(){new Vue({el:"#payPay",data:{payForm:{manager:"",pay_date:"",cash:"",transfer:"",other:"",bank:"",account:"",remark:"",bankIndex:""},bankList:[]},mounted:function(){this.payForm.id=$("#payId").val()||"",this.payForm.manager=$("#manager").val()||"",this.payForm.people=$("#manager").val()||"",this.payForm.pay_date=_helper.timeFormat(new Date,"YYYY-MM-DD");var a=$("#bankList").text().trim();this.bankList=""===a?[]:JSON.parse(a),$("#payPay").removeClass("invisible")},methods:{selectBank:function(a){var t=this.bankList[a];this.payForm.bank=t.name,this.payForm.account=t.account},submit:function(){var a=this;_http.PaymentManager.createPayPay(this.payForm).then(function(t){"200"===t.data.code?(a.$notify.success({title:"成功",message:"提交成功！"}),$(".ui.dimmer").addClass("active")):a.$notify({title:"错误",message:t.data.msg,type:"error"})}).catch(function(t){a.$notify({title:"错误",message:"服务器出错",type:"error"})})}}})});