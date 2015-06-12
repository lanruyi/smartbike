function trans_datetime_zhn(str){
    var a = str.substr(0,4) + "年";
    a += str.substr(4,2) + "月";
    a += str.substr(6,2) + "日";
    a += str.substr(8,2) + "时";
    a += str.substr(10,2) + "分";
    return a;
}

Date.prototype.format = function(format) //author: meizz 
{ 
    var o = { 
        "M+" : this.getMonth()+1, //month 
        "d+" : this.getDate(),    //day 
        "h+" : this.getHours(),   //hour 
        "m+" : this.getMinutes(), //minute 
        "s+" : this.getSeconds(), //second 
        "q+" : Math.floor((this.getMonth()+3)/3),  //quarter 
        "S" : this.getMilliseconds() //millisecond 
    } 
    if(/(y+)/.test(format)) format=format.replace(RegExp.$1, 
            (this.getFullYear()+"").substr(4 - RegExp.$1.length)); 
    for(var k in o)if(new RegExp("("+ k +")").test(format)) 
        format = format.replace(RegExp.$1, 
                RegExp.$1.length==1 ? o[k] : 
                ("00"+ o[k]).substr((""+ o[k]).length)); 
    return format; 
} 

// confirm button jump back
function confirm_jumping(text,url){
	if(confirm("你确定"+text+"吗？")){
		top.location = url;
	}
}
