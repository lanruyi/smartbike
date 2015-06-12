<script>

window.colds_0_on = 0;
window.colds_1_on = 0;
window.fan_0_on = 1;
window.ti = 22;
window.to = 14;
window.hi = 60;
window.ho = 79;
window.r = 0;
window.energy_main1 = 10;
window.energy_main2 = 10;
window.energy_dc1 = 1;
window.energy_dc2 = 1;
window.energy_main4 = 10;
window.energy_main6 = 10;
window.energy_dc4 = 1;
window.energy_dc6 = 1;

function geten1(){
	window.energy_main1 += 1;
	window.energy_dc1 = 0.5;
}
function geten2(){
	window.energy_main2 += 2;
	window.energy_dc2 = 1;
}
function geten4(){
	window.energy_main4 += 4;
	window.energy_dc4 = 2;
}
function geten6(){
	window.energy_main6 += 6;
	window.energy_dc6 = 3;
}

function gettmp(){
    window.r = window.r+1;
    if(window.r > 6*30){
        window.r = 0;
    }
    if(window.r%3 != 0){
        return;
    }
    window.ti = window.ti+Math.floor(Math.random()*4-2)
    window.to = window.to+Math.floor(Math.random()*4-2)
    window.hi = window.hi+Math.floor(Math.random()*4-2)
    window.ho = window.ho+Math.floor(Math.random()*4-2)

    if(window.r === 6*12){
        window.ti = window.ti+Math.floor(Math.random()*8-4)
        window.hi = window.hi+Math.floor(Math.random()*12-6)
    }
    if(window.r === 6*24){
        window.to = window.to+Math.floor(Math.random()*8-4)
        window.ho = window.ho+Math.floor(Math.random()*12-6)
    }

    if(window.ti>30) window.ti=28;
    if(window.to>24) window.to=22;

    if(window.ti<14) window.ti=16;
    if(window.to<8) window.to=10;




    if(window.hi>80) window.hi=78;
    if(window.ho>90) window.ho=88;

    if(window.hi<30) window.hi=32;
    if(window.ho<40) window.ho=42;


    // window.energy_main1 = window.energy_main1+Math.floor(Math.random()*4)
    // window.energy_main2 = window.energy_main2+Math.floor(Math.random()*8)
// 
    // window.energy_dc1 = window.energy_main1+Math.floor(Math.random()*3)
    // window.energy_dc2 = window.energy_main2+Math.floor(Math.random()*3)

	if(Math.floor(Math.random()*2) === 1){
		if(window.colds_0_on === 0){
			window.colds_0_on = 1;
				if(Math.floor(Math.random()*2) === 1){
					window.colds_1_on = 1;
				}
			}else{
			window.colds_0_on = 0;
			window.colds_1_on = 0;
		}
	}

		if(window.colds_0_on === 0){
			window.fan_0_on = 1;
			}else{
			window.fan_0_on = 0;
		}
}



function abc(){
					geten1();
                    gettmp();
                    senddata('/s','s=1&d={"'+ new Date().format("yyyy-MM-dd hh:mm:ss")+'":['+window.ti+','+window.to+','+window.hi+','+window.ho+',20,'+window.colds_0_on+','+window.colds_1_on+',"",'+window.fan_0_on+',"",11,12,"","","","",50,'+window.energy_main1+',"7","'+(window.energy_dc1)+'","","","","","","","",""]}');
                    geten2();
                    gettmp();
                    senddata('/s','s=2&d={"'+ new Date().format("yyyy-MM-dd hh:mm:ss")+'":['+window.ti+','+window.to+','+window.hi+','+window.ho+',20,'+window.colds_0_on+','+window.colds_1_on+',"",'+window.fan_0_on+',"",11,12,"","","","",100,'+window.energy_main2+',"8","'+(window.energy_dc2)+'","","","","","","","",""]}&w={"'+ new Date().format("yyyy-MM-dd hh:mm:ss")+'":[1,2]}');
					geten4();
                    gettmp();
                    senddata('/s','s=4&d={"'+ new Date().format("yyyy-MM-dd hh:mm:ss")+'":['+window.ti+','+window.to+','+window.hi+','+window.ho+',20,'+window.colds_0_on+','+window.colds_1_on+',"",'+window.fan_0_on+',"",11,12,"","","","",50,'+window.energy_main4+',"7","'+(window.energy_dc4)+'","","","","","","","",""]}');
                    geten6();
                    gettmp();
                    senddata('/s','s=6&d={"'+ new Date().format("yyyy-MM-dd hh:mm:ss")+'":['+window.ti+','+window.to+','+window.hi+','+window.ho+',20,'+window.colds_0_on+','+window.colds_1_on+',"",'+window.fan_0_on+',"",11,12,"","","","",100,'+window.energy_main6+',"8","'+(window.energy_dc6)+'","","","","","","","",""]}&w={"'+ new Date().format("yyyy-MM-dd hh:mm:ss")+'":[1,2]}');
}

window.interval = 60;
function efg(){
	// var time = (new Date().getTime()/1000)%(3600*24);
	var time = (new Date().getTime()/1000)%(60);
	if(time<window.interval){
		senddata('/s','s=1&m='+new Date().format("yyyy-MM-dd hh:mm:ss"));
	}
}
                setTimeout(function(){abc();},1000);
                setInterval(function(){ abc();},1000*window.interval);
                // setTimeout(function(){efg();},1000);
                // setInterval(function(){ efg();},1000*window.interval);
                
</script>

<script language="JavaScript">
function senddata(url,postdata)
{
    document.write(postdata+'<br>');
    if (window.XMLHttpRequest)
    {
        var http = new XMLHttpRequest();
        http.open("post", url , true);
        http.setRequestHeader("Content-length", postdata.length);
        http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        http.send(postdata);

        http.onreadystatechange = function()
        {
            if(http.readyState == 4)
            {
                if(http.status==200)
                {
                    document.write(http.responseText+"<br>");
                }
                else
                {
                    document.write("Error "+http.status);
                }
            }
        }
    }
    return false;
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
</script>
