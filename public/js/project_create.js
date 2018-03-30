"use strict";$(document).ready(function(){var t=""===$("#contractContent").text().trim()?[]:JSON.parse($("#contractContent").text().trim()),e=""===$("#contractTax").text().trim()?[]:JSON.parse($("#contractTax").text().trim()),a=""!==$("#projectData").text().trim()&&JSON.parse($("#projectData").text().trim());function r(t){var e={},a=!0,r=!1,n=void 0;try{for(var o,i=t[Symbol.iterator]();!(a=(o=i.next()).done);a=!0){var s=o.value;e[s.id]=s.name}}catch(t){r=!0,n=t}finally{try{!a&&i.return&&i.return()}finally{if(r)throw n}}return e}var n=r(e),o=r(t);new Vue({el:"#projectCreate",data:{project:_schemas.projects,contractContent:t,contractTax:e,TaxIDMap:n,ContentIDMap:o},mounted:function(){a&&(this.project=_helper.projectGetFormat(a)),$("#projectCreate").removeClass("invisible")},computed:{sumAmount:function(){var t=this.project.masterContract,e=this.project.subContract,a=0,r=[];function n(t,e){if(e.length<1)return!1;e.forEach(function(e,n){var o=e.amount?parseFloat(e.amount):0;a+=o,r.push({head:0===n,id:t+e.id,amount:o.toLocaleString("en-US"),type:t})})}return n("m",t),n("s",e),{sum:a.toLocaleString("en-US"),result:r}},sumContent:function(){var t=this.project.masterContract,e=this.project.subContract,a=0,r={},n=[];if(t&&e){u(t),u(e);for(var o in r){var i=o.split(""),s=this.ContentIDMap[i[0]],c=this.TaxIDMap[i[1]];n.push({name:s,tax:c,amount:r[o]})}return{sum:a,result:n}}function u(t){t.forEach(function(t,e){var n=t.details;if(!n||n.length<1)return!1;n.forEach(function(t,e){var n=t.amount?parseFloat(t.amount):0;if(a+=n,void 0!==t.name){var o=t.name+""+t.tax;r[o]=r[o]?r[o]+n:n}})})}},sumMargins:function(){var t=this.project.margins,e={sumGuaranteeAmount:0,sumGuaranteeCost:0,sumPaymentCost:0};return t.length<1?e:(t.forEach(function(t,a){e.sumGuaranteeAmount+=t.guarantee_amount?parseFloat(t.guarantee_amount):0,e.sumGuaranteeCost+=t.guarantee_cost?parseFloat(t.guarantee_cost):0,e.sumPaymentCost+=t.payment_amount?parseFloat(t.payment_amount):0}),e)},sumPaymentConditions:function(){var t=this.project.paymentConditions,e=0;return t.length<1?e:(t.forEach(function(t,a){e+=t.expected?parseFloat(t.expected):0}),e)}},methods:{addFirstItem:function(t){var e=this.project[t],a=e.length,r=void 0;r=a>0?e[a-1].id+1:1,"masterContract"===t||"subContract"===t?this.project[t].push({id:r,details:new Array}):this.project[t].push({id:r})},deleteFirstItem:function(t,e,a){this.project[t].splice(a,1)},addSecondItem:function(t,e){var a=this.project[t][e].details||[],r=a.length,n=void 0;n=r>0?a[r-1].id+1:1,this.project[t][e].details.push({id:n})},deleteSecondItem:function(t,e,a,r){this.project[t][e].details.splice(a,1)},fileUpload:function(t){var e=this,a=t.target.files,r=!0,n=!1,o=void 0;try{for(var i,s=a[Symbol.iterator]();!(r=(i=s.next()).done);r=!0){var c=i.value,u=new FormData;u.append("image",c),_http.UploadManager.createUpload(u).then(function(t){if("200"===t.data.code){var a=t.data.data;e.project.contracts.push({id:a.size,name:a.name,url:a.url}),e.$notify({title:"成功",message:a.name+" 提交成功",type:"success"})}else e.$notify({title:"错误",message:t.data.msg,type:"error"})}).catch(function(t){e.$notify({title:"错误",message:"服务器出错",type:"error"})})}}catch(t){n=!0,o=t}finally{try{!r&&s.return&&s.return()}finally{if(n)throw o}}},submit:function(){var t=this,e=_helper.projectCreatFormat(this.project);_http.ProjectManager.createProject(e).then(function(e){"200"===e.data.code?t.$notify({title:"成功",message:"提交成功",type:"success"}):t.$notify({title:"错误",message:e.data.msg,type:"error"})}).catch(function(e){t.$notify({title:"错误",message:"服务器出错",type:"error"})})}}})});