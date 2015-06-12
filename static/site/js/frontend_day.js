/********************************
Fast JJump 
..\..\..\application\views\frontend\station\realtime.php

********************************/
function draw_chart_es_power(){
    var options = {
        chart: { renderTo: 'es_power', type: 'area', width:985, height: 200, marginRight: 0, marginLeft: 28 },
    	title: { text: '  ', align:'left', x: 0, margin: 20 },
    	xAxis: { type: 'datetime', tickPixelInterval: 80, gridLineWidth: 1 },
    	yAxis: { title: { text: '' },minorTickInterval:500, minorGridLineWidth: 0.6, gridLineWidth: 1, allowDecimals:false, tickInterval:4000 },    	 		
    	plotOptions: {
    		area: { fillOpacity: 0.8, lineWidth: 0.8, lineColor: '#999', shadow: false, cursor: 'pointer' },  
    		series: {
    			marker: { radius: 0.01, fillColor: '#fff', lineWidth: 0.5, lineColor: '#333'	}
    		}
    	},
    	tooltip: {
    		formatter: function(){
    			return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'W';
    		}
    	},
    	legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 70, x: 10 },
    	series: [{ name: '总功率', data: [], color: Highcharts.getOptions().colors[0] },
                 { name: 'DC功率', data: [], color: Highcharts.getOptions().colors[1] }]
    };       
    window.es_power_chart = new Highcharts.Chart( options );
}


function draw_chart( chart_type, outdoor_sensor, colds_num, box_type) {
    switch(chart_type){
    	// page: real-time monitoring 
    	 case "es_temprature":
    	 	var options = {
                chart: { renderTo: 'es_temprature', type: 'line', width:985, height: 200, marginRight: 0, marginLeft: 28 },
    	 		title: { text: ' ', align:'left', x: 0, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 80, gridLineWidth: 1 },
    	 		yAxis: { title: { text: '' }, minorTickInterval: 2, minorGridLineWidth: 0.6, gridLineWidth: 1, max:50, min:0, allowDecimals:false, tickInterval:10, 			
    	 			plotLines: [{ value:35, color:'green', dashStyle: 'Dash', width: 1.2, zIndex: 1,label:{text: 'base:35°C'} }]
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: { radius: 0.01, fillColor: '#fff', lineWidth: 0.5, lineColor: '#333'}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'°C';
    	 			}
    	 		},
    	 		legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 80, x: 10 },
        		series: [{ name: '站内温度', data: [], color: Highcharts.getOptions().colors[0] }]
    	 	};
            if(box_type != 2){
                options.yAxis.plotLines[0].value = 37;
                options.yAxis.plotLines[0].label.text = 'highest:37°C';
            }else{
                options.yAxis.plotLines[0].value = 29;
                options.yAxis.plotLines[0].label.text = 'highest:29°C';
            }
            window.es_temprature_chart = new Highcharts.Chart( options );
            if(outdoor_sensor == 1){ window.es_temprature_chart.addSeries({ name: '站外温度', data: [], color: Highcharts.getOptions().colors[1] }); }
            break;

         case "es_colds_tmp":
             var options = {
                 chart: { renderTo: 'es_colds_tmp', type: 'line', width:985, height: 190, marginRight: 0, marginLeft: 28 },
                 title: { text: ' ', align:'left', x: 0, margin: 20 },
                 xAxis: { type: 'datetime', tickPixelInterval: 80, gridLineWidth: 1 },
                 yAxis: {
                     title: { text: '' }, minorTickInterval: 'auto', minorGridLineWidth: 0.6,
                    gridLineWidth: 1, gridLineWidth: 1, max:50, min:0, allowDecimals:false, tickInterval:10
                 },
                 plotOptions: {
                     line: { cursor: 'pointer' },
                     series: {
                         marker: {radius: 0.01,fillColor: '#fff',lineWidth: 0.5,lineColor: '#333'	
                         }
                     }
                 },
                 tooltip: {
                     formatter: function(){
                         return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'°C';
                     }
                 },
                 legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 90, x: 10 },
                series: [{ name: '空调1温度', data: [], color: Highcharts.getOptions().colors[0] }]
             };
            window.es_colds_tmp_chart = new Highcharts.Chart( options );
            if(colds_num == 2){ window.es_colds_tmp_chart.addSeries({ name: '空调2温度', data: [], color: Highcharts.getOptions().colors[1] }); }
            break;



    	 case "es_box_temprature":
    	 	var options = {
                chart: { renderTo: 'es_box_temprature', type: 'line', width:985, height: 135, marginRight: 0, marginLeft: 28 },
    	 		title: { text: '  ', align:'left', x: 0, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 80, gridLineWidth: 1 },
    	 		yAxis: {
                    max:30, min:20, allowDecimals:false,
    	 			title: { text: '' },
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,  max:40, min:10, allowDecimals:false, tickInterval:10,  	 			
    	 			plotLines: [{value:28,color:'green',dashStyle:'Dash',width: 1.2, zIndex:1, label:{text:'base: 28°C'}
    	 			}]
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: { radius: 0.01, fillColor: '#fff', lineWidth: 0.5, lineColor: '#333'}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'°C';
    	 			}
    	 		},
    	 		legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 90, x: 10 },
        		series: [{ name: '恒温柜温度', data: [], color: Highcharts.getOptions().colors[0] }]
    	 	};
            window.es_box_temprature_chart = new Highcharts.Chart( options );
            break;



        case "es_humidity":
    	 	var options = {
                chart: { renderTo: 'es_humidity', type: 'line',width:985, height: 160, marginRight: 0, marginLeft: 28 },
    	 		title: { text: '基站室内外湿度表(%)', align:'left', x: 0, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 80, gridLineWidth: 1 },
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			},   	 			
    	 			minorTickInterval: 3600 * 1000,
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,max:100, min:0, allowDecimals:false, tickInterval:20,
    	 			plotLines: [{ value:60,color:'green', dashStyle:'Dash', width:1.2, zIndex:1, label:{text:'base: 60%' }
    	 			}]
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: { radius: 0.01, fillColor: '#fff', lineWidth: 0.5, lineColor: '#333'	}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'%';
    	 			}
    	 		},
    	 		legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 80, x: 10 },
        		series: [{ name: '站内湿度', data: [], color: Highcharts.getOptions().colors[0] }]
    	 	};       
            window.es_humidity_chart = new Highcharts.Chart( options );
            if(outdoor_sensor == 1){ window.es_humidity_chart.addSeries({ name: '站外湿度', data: [], color: Highcharts.getOptions().colors[1] }); }
            break;


    	 case "es_fan_press":
    	 	var options = {
    	 		chart: { renderTo: 'es_fan_press', type: 'line', zoomType: 'x', height: 160, marginRight: 0, marginLeft: 40 },
    	 		title: { text: '新风风口负压(kpa)', align:'left', x: 0, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 100, gridLineWidth: 1 },
    	 		yAxis: {
    	 			title: { text: '' },
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1    	 			
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: { radius: 0.01, fillColor: '#fff', lineWidth: 0.5, lineColor: '#333'}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'kpa';
    	 			}
    	 		},
    	 		legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 90, x: 10 },
        		series: [{ name: '进口负压', data: [], color: Highcharts.getOptions().colors[0] },
                        { name: '出口负压', data: [], color: Highcharts.getOptions().colors[2] }]
    	 	};
            window.es_fan_press_chart = new Highcharts.Chart( options );
            break;

    }
}

function draw_chart_es_packets_num(){
	var options = {
		chart: { renderTo:'es_packets_num', type:'column', zoomType:'x', height:150, marginRight:0, marginLeft:28},
	 	title: { text: '小时丢包个数', align:'left', x: 0, margin: 20 },
	 	xAxis: { type: 'datetime', tickPixelInterval: 100 },
	 	yAxis: { title: { text: '' }, max:60, min:0, allowDecimals:false, tickInterval:60}, 	
	 	plotOptions: { column: { cursor: 'pointer', pointPadding: 0.3} },
	 	tooltip: {
	 		formatter: function(){
	 			return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%m月%e日%H点', this.x)+'<br> '+this.y+'个';
	 		}
	 	},	
        legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 92, x: 10 },
    	series: [{ name: '小时丢包数', data: [], color: Highcharts.getOptions().colors[0], dataLabels:{enabled:true}}]	 	 		
	};
	window.es_packets_num_chart = new Highcharts.Chart( options );
}


function draw_chart_es_colds_fan_on_pie(){
    var options = {
        chart: { renderTo: 'es_colds_fan_on_pie', type: 'pie', height: 150 },
        title: { text: '设备使用率', align:'right' },
        plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: false }, size: '100%' } },
        tooltip: {
                     formatter: function(){
                                    return '<b>'+ this.point.name +'</b>: '+ this.y + '%';
                                }
                 },
        legend: {
                    align: 'right',
                    layout: 'vertical',
                    width: 80,
                    verticalAlign: 'middle',
                    borderWidth: 0,
                    itemStyle: { font: '11px Trebuchet MS, Verdana, sans-serif' }
                },
        series: [{
                    data: [{ name: '设备全关', color: Highcharts.getOptions().colors[3] },
                    { name: '只开新风', color: Highcharts.getOptions().colors[0] },
                    { name: '开1台空调', color: Highcharts.getOptions().colors[1]},
                    { name: '开2台空调', color: Highcharts.getOptions().colors[2]}],
                          showInLegend: true
                }]
    };                  		
    window.es_colds_fan_on_pie = new Highcharts.Chart( options );
}

function draw_chart_es_ac_dc_energy_pie(){
    var options = {
        chart: { renderTo: 'es_ac_dc_energy_pie', type: 'pie', height: 150 },
        title: { text: '日AC/DC能耗比', align:'right' },
        plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: false }, size: '100%' } },
        tooltip: {
                     formatter: function(){
                                    return '<b>'+ this.point.name +'</b>: '+ this.y + '%';
                                }
                 },
        legend: {
                    align: 'right',
                    layout: 'vertical',
                    verticalAlign: 'middle',
                    width: 80,
                    borderWidth: 0,
                    itemStyle: { font: '11px Trebuchet MS, Verdana, sans-serif' }
                },
        series: [{
                    data: [{ name: 'AC', color: Highcharts.getOptions().colors[0] },
                    { name: 'DC', color: Highcharts.getOptions().colors[1]}],
                          showInLegend: true
                }]
    };                  		
    window.es_ac_dc_energy_pie_chart = new Highcharts.Chart( options );
}


function draw_chart_es_day_saving_pie(){
    var options = {
        chart: { renderTo: 'es_day_saving_pie', type: 'pie', height: 150 },
        title: { text: '日AC节能率', align:'right' },
        plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: false }, size: '100%' } },
        tooltip: {
                     formatter: function(){
                                    return '<b>'+ this.point.name +'</b>: '+ this.y + '%';
                                }
                 },
        legend: {
                    align: 'right',
                    layout: 'vertical',
                    width: 80,
                    verticalAlign: 'middle',
                    borderWidth: 0,
                    itemStyle: { font: '11px Trebuchet MS, Verdana, sans-serif' }
                },
        series: [{
                    data: [{ name: 'AC耗能', color: Highcharts.getOptions().colors[0] },
                    { name: '节约', color: Highcharts.getOptions().colors[1]}],
                          showInLegend: true
                }]
    };                  		
    window.es_day_saving_pie_chart = new Highcharts.Chart( options );
}




function trans_onoff(data,offset){
    var _data = new Array();
    $.each(data, 
        function(i,field){
            _data.push([field[0], (field[1] == 0 || field[1]==null )? null:offset]);
        }); 
    return _data;
}

function trans_misspkts(data){
    var _data = new Array();
    $.each(data, 
        function(i,field){
            _data.push([field[0], (field[1] == 60)? null:(60-field[1])]);
        }); 
    return _data;
}


