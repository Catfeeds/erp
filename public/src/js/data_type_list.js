"use strict";$(document).ready(function(){new Vue({el:"#navbar",data:{navActive:"dataType"},mounted:function(){$("#navbar").removeClass("invisible")},methods:{}});var e=window.ELEMENT;$(".dataTypeDelete").on("click",function(){var t=this;e.MessageBox.confirm("此操作将删除该项目类别, 是否继续?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(function(){$(t).parents("tr").remove(),e.Notification.success({title:"成功",message:"删除成功!"})}).catch(function(){e.Message.info({message:"已取消"})})})});