"use strict";$(document).ready(function(){new Vue({el:"#navbar",data:{navActive:"dataTeam"},mounted:function(){$("#navbar").removeClass("invisible")}});var e=window.ELEMENT;$(".dataTeamDelete").on("click",function(){var n=this;e.MessageBox.confirm("此操作将删除该施工队, 是否继续?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then(function(){$(n).parents("tr").remove(),e.Notification.success({title:"成功",message:"删除成功!"})}).catch(function(){e.Message.info({message:"已取消"})})})});