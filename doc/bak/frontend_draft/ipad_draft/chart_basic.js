
function generate_chart_option( chart_type )
{
    var options = {
        global: { 
            useUTC: false 
        }, 
        chart: {
                   renderTo: 'temp_chart',
                   type: 'line',
                   //width: 620,
                   //height: 400,
                   borderWidth: 0,
                   borderColor: '#EBBA95'
               },
        title: {
                   text: ''
               },
        subtitle: {
                      text: ''
                  },
        xAxis: {
                   type: 'datetime',
                   tickPixelInterval: 30,
                   labels: {
                        rotation: 45,
                        x:0,
                        y:25
                   }
                      // tickInterval: 2 * 3600 * 1000,
                       //maxZoom: 24 * 3600 * 1000
               },
        yAxis: {
                   title: {
                              text: 'Temperature (°C)'
                          }
               },
        tooltip: {
                     formatter: function() {
                                    return '<b>'+ this.series.name +'</b><br/>'+
                                        //this.x +': '+ this.y +'°C';
                                        Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+': '+this.y+'°C';
                                }
                 },
        legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                    //x: 0,
                    //y: 0,
                    //borderWidth: 0
                },
        series: []
    };		


	var options_pie = {
		chart : {
			renderTo : 'temp_pie',
			type : 'pie',
			//width: 620,
			//height : 400,
			borderWidth : 0,
			borderColor : '#EBBA95'
		},
		title : {
			text : ''
		},
		subtitle : {
			text : ''
		},
		plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
	                        formatter: function() {
	                        return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';					
							}
						}
					}
		},
        tooltip: {
                formatter: function() {
						return '<b>'+ + this.series.name + '</b><br/>' +
						this.point.name +'</b>: '+ this.percentage +' %';	
                }
        },
		legend : {
			layout : 'horizontal',
			align : 'center',
			verticalAlign : 'bottom',
			x : 0,
			y : 0
		},
		series : []
	};

    options.series[0] = {name: 'Temp indoor', data:[]};
    options.series[1] = {name: 'Temp outdoor', data:[]};

    switch(chart_type){
        case "es_temprature":
            options.title.text = "基站能耗表";
            options.subtitle.text = "平均值 和标准站对比结果";
            options.chart.height = 300;
			options.chart.type = 'area';
            options.chart.renderTo = 'es_temprature';
            return options;
        case "es_temprature_test":
            options.title.text = "基站室内外温度表";
            options.subtitle.text = "平均值";
            options.chart.height = 200;
            options.chart.renderTo = 'es_temprature_test';
            return options;
        case "es_temprature_test_2":
            options_pie.title.text = "冷源，新风";
            options_pie.subtitle.text = "总开机时间对比";
			options_pie.chart.height = 200;
			options_pie.chart.type = 'pie';
			options_pie.series[0] = {name: 'Colds Status', data:[['无',20],['冷源',30],['新风',50]]};
			options_pie.chart.renderTo = 'es_temprature_test_2';
			return options_pie;
        case "es_power":
            options.chart.renderTo = 'es_power';
            return options;
            break;
    }
}



function get_data_and_refresh_chart(){
	
			
/*
			temp_str = '[{"num":"26","time":"Mon, 26 Mar 2012 12:10:00 +0800"},\
						 {"num":"10","time":"Mon, 26 Mar 2012 12:40:00 +0800"},\
						 {"num":"28","time":"Mon, 26 Mar 2012 13:10:00 +0800"},\
						 {"num":"7","time":"Mon, 26 Mar 2012 13:40:00 +0800"},\
						 {"num":"28","time":"Mon, 26 Mar 2012 14:10:00 +0800"},\
						 {"num":"12","time":"Mon, 26 Mar 2012 14:40:00 +0800"}\]';
            tempObj = jQuery.parseJSON(temp_str);
            var _getdata= new Array();
            $.each(tempObj, 
                function(i,field){
                    _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                });	

            window.es_temprature_chart.series[0].setData(_getdata);
            window.es_temprature_test_chart.series[0].setData(_getdata);
            
            temp_str = '[{"num":"22","time":"Mon, 26 Mar 2012 12:10:00 +0800"},\
						 {"num":"9","time":"Mon, 26 Mar 2012 12:40:00 +0800"},\
						 {"num":"24","time":"Mon, 26 Mar 2012 13:10:00 +0800"},\
						 {"num":"5","time":"Mon, 26 Mar 2012 13:40:00 +0800"},\
						 {"num":"22","time":"Mon, 26 Mar 2012 14:10:00 +0800"},\
						 {"num":"8","time":"Mon, 26 Mar 2012 14:40:00 +0800"}\]';
            tempObj = jQuery.parseJSON(temp_str);
            var _getdata= new Array();
            $.each(tempObj, 
                function(i,field){
                    _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                });	

            window.es_temprature_chart.series[1].setData(_getdata);
            window.es_temprature_test_chart.series[1].setData(_getdata);
*/
         

	$.get(window.base_webservice_url+"/webservice/getdatalist", {
	//$.get("/webservice/getdatalist", {
		station_id : window.global_options.station_id,
		param : "indoor_tmp",
		dur : window.global_options.dur,
		type : window.global_options.type,
		time : window.global_options.time
	}, function(temp_str) {
		tempObj = jQuery.parseJSON(temp_str);
		var _getdata = new Array();
		$.each(tempObj, function(i, field) {
			_getdata.push([Date.parse(field.time), parseFloat(field.num)]);
		});

		window.es_temprature_chart.series[0].setData(_getdata);
		window.es_temprature_test_chart.series[0].setData(_getdata);
	});

	$.get(window.base_webservice_url+"/webservice/getdatalist", {
	//$.get("/webservice/getdatalist", {
		station_id : window.global_options.station_id,
		param : "outdoor_tmp",
		dur : window.global_options.dur,
		type : window.global_options.type,
		time : window.global_options.time
	}, function(temp_str) {
		tempObj = jQuery.parseJSON(temp_str);

		var _getdata = new Array();
		$.each(tempObj, function(i, field) {
			_getdata.push([Date.parse(field.time), parseFloat(field.num)]);
		});

		window.es_temprature_chart.series[1].setData(_getdata);
		window.es_temprature_test_chart.series[1].setData(_getdata);
	});

}


function draw_emtpy_charts(){
    Highcharts.setOptions({ 
        global: { 
            useUTC: false 
        } 
    }); 
    
    window.es_temprature_chart = new Highcharts.Chart( generate_chart_option("es_temprature") );
    window.es_temprature_test_chart = new Highcharts.Chart( generate_chart_option("es_temprature_test") );
    window.es_temprature_test_2_chart = new Highcharts.Chart( generate_chart_option("es_temprature_test_2") );

}

function set_es_last(str){
    for(var i=0;i<6;i++)
    {
        if($("#es_last > button:eq("+i+")").attr("value") === str ){
            $("#es_last > button:eq("+i+")").attr({"class":"btn active"});
        }
    }
}
function get_es_last(){
    for(var i=0;i<6;i++)
    {
        if($("#es_last > button:eq("+i+")").attr("class") === "btn active"){
            return $("#es_last > button:eq("+i+")").attr("value");
        }
    }
}

function set_es_dur(str){
    for(var i=0;i<6;i++)
    {
        if($("#es_dur > button:eq("+i+")").attr("value") === str ){
            $("#es_dur > button:eq("+i+")").attr({"class":"btn active"});
        }
    }
}
function get_es_dur(){
    for(var i=0;i<6;i++)
    {
        if($("#es_dur > button:eq("+i+")").attr("class") === "btn active"){
            return $("#es_dur > button:eq("+i+")").attr("value");
        }
    }
}
function set_es_type(str){
    for(var i=0;i<3;i++)
    {
        if($("#es_type > button:eq("+i+")").attr("value") === str ){
            $("#es_type > button:eq("+i+")").attr({"class":"btn active"});
        }
    }
}
function get_es_type(){
    for(var i=0;i<3;i++)
    {
        if($("#es_type > button:eq("+i+")").attr("class") === "btn active"){
            return $("#es_type > button:eq("+i+")").attr("value");
        }
    }
}

function generate_time_str_for_button_from_display_options(){
    var option = window.display_options;
    var trans_array = new Object();
    trans_array["3_hours"] = "3小时";
    trans_array["1_day"] = "1天";
    trans_array["7_days"] = "1周";
    trans_array["1_month"] = "1个月";
    trans_array["3_months"] = "1季度";
    trans_array["1_year"] = "1年";
    trans_array["end"] = "止于";
    trans_array["around"] = "附近";
    trans_array["start"] = "始于";
    var str = "";
    if(option.type === "last")
    {
        return "最近"+trans_array[option.dur];
    }
    str += "<b>" + trans_array[option.dur] + "</b> ";
    str += trans_array[option.type] + " ";
    str += trans_datetime(option.es_date_picker + option.es_time_picker);
    return str;
}

function trans_datetime(str){
    var a = str.substr(0,4) + "年";
    a += str.substr(4,2) + "月";
    a += str.substr(6,2) + "日";
    a += str.substr(8,2) + "时";
    a += str.substr(10,2) + "分";
    return a;
}




            function set_display_options_from_global(){
                window.display_options.station_id = window.global_options.station_id;
                window.display_options.dur = window.global_options.dur;
                window.display_options.type = window.global_options.type;
                window.display_options.es_date_picker = window.global_options.time.substr(0,8);
                window.display_options.es_time_picker = window.global_options.time.substr(8,6);
            }
                
            function set_global_options_from_display(){
                window.global_options.station_id = window.display_options.station_id;
                window.global_options.dur = window.display_options.dur;
                window.global_options.type = window.display_options.type;
                window.global_options.time = window.display_options.es_date_picker + window.display_options.es_time_picker;
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

