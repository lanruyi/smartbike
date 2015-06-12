/********************************
Fast JJump 
..\..\..\application\views\frontend\station\realtime.php

********************************/

function draw_chart( chart_type, outdoor_sensor, colds_num ) {
    switch(chart_type){
    	// page: real-time monitoring 
    	 case "es_temprature":
    	 	var options = {
    	 		chart: { renderTo: 'es_temprature', type: 'line', zoomType: 'x', height: 190, marginRight: 0, marginLeft: 40 },
    	 		title: { text: '基站内外温度(°C)', align:'left', x: 0, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 100, gridLineWidth: 1 },
    	 		yAxis: {
    	 			title: { text: '' },
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,    	 			
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
            window.es_temprature_chart = new Highcharts.Chart( options );
            if(outdoor_sensor == 1){ window.es_temprature_chart.addSeries({ name: '站外温度', data: [], color: Highcharts.getOptions().colors[1] }); }
            break;

         case "es_colds_tmp":
             var options = {
                 chart: { renderTo: 'es_colds_tmp', type: 'line', zoomType: 'x', height: 160, marginRight: 0, marginLeft: 40 },
                 title: { text: '空调出风口温度(°C)', align:'left', x: 0, margin: 20 },
                 xAxis: { type: 'datetime', tickPixelInterval: 100, gridLineWidth: 1 },
                 yAxis: {
                     title: { text: '' },
                     minorTickInterval: 'auto',
                    minorGridLineWidth: 0.6,
                    gridLineWidth: 1    	 			
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


    	 case "es_box_temprature":
    	 	var options = {
    	 		chart: { renderTo: 'es_box_temprature', type: 'line', zoomType: 'x', height: 135, marginRight: 0, marginLeft: 40 },
    	 		title: { text: '恒温柜温度(°C)', align:'left', x: 0, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 100, gridLineWidth: 1 },
    	 		yAxis: {
                    max:30, min:20, allowDecimals:false,
    	 			title: { text: '' },
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,    	 			
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
    	 		chart: { renderTo: 'es_humidity', type: 'line', zoomType: 'x', height: 160, marginRight: 0, marginLeft: 40 },
    	 		title: { text: '基站室内外湿度表(%)', align:'left', x: 0, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 100, gridLineWidth: 1 },
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			},   	 			
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,
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
    }
}

function draw_chart_es_energy_hour_column_chart(station_type,weekday){
	 	var options = {
            chart: { renderTo:'es_energy_hour_column', type:'column', zoomType:'x', height:200, marginRight:0, marginLeft:40},
	 		title: { text: '小时AC能耗图(kWh)', align:'left', x: 0, margin: 20 },
	 		xAxis: { type: 'datetime', tickPixelInterval: 100 },
	 		yAxis: { title: { text: '' } },     	 		
	 		plotOptions: { column: { cursor: 'pointer', pointPadding: 0.1, groupPadding: 0.1 } },
	 		tooltip: {
	 			formatter: function(){
	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%m月%e日%H点', this.x)+'<br> '+this.y+'kWh';
	 			}
	 		},
            legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 120, x: 10 },
    		series: [{ name: '标准站小时AC', data: [], color: Highcharts.getOptions().colors[0]},
                { name: '节能站小时AC', data: [], color: Highcharts.getOptions().colors[1]}]
	 	};     
        if(station_type == 3){
            if(weekday){
                options.series[0].name = '基准日小时AC';
                options.series[1].name = '节能日小时AC';               
            }else{
                options.plotOptions.column.pointPadding = 0.3;
                options.series = [{'name':'今日小时AC ',data:[],color: Highcharts.getOptions().colors[1]}];               
            }
        }
        if(station_type == 2){
            options.plotOptions.column.pointPadding = 0.3;
            options.series = [{'name':'本站小时AC ',data:[],color: Highcharts.getOptions().colors[1]}];
        }
        window.es_energy_hour_column_chart = new Highcharts.Chart( options );
}

function draw_chart_es_packets_num(){
	var options = {
		chart: { renderTo:'es_packets_num', type:'column', zoomType:'x', height:150, marginRight:0, marginLeft:40},
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

function draw_chart_es_power(){
    var options = {
    	chart: { renderTo: 'es_power', type: 'area', zoomType: 'x', height: 190, marginRight: 0, marginLeft: 40 },
    	title: { text: '基站功率实时表(W)', align:'left', x: 0, margin: 20 },
    	xAxis: { type: 'datetime', tickPixelInterval: 100, gridLineWidth: 1 },
    	yAxis: {
    		title: { text: '' },
    		minorTickInterval: 'auto',
			minorGridLineWidth: 0.6,
			gridLineWidth: 1 
    	},    	 		
    	plotOptions: {
    		area: { fillOpacity: 0.9, lineWidth: 0.8, lineColor: '#999', shadow: false, cursor: 'pointer' },  
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
                 { name: 'dc功率', data: [], color: Highcharts.getOptions().colors[1] }]
    };       
    window.es_power_chart = new Highcharts.Chart( options );
}

function draw_chart_es_colds_fan_on(){
    var options = {
        chart: { renderTo:'es_colds_fan_on', type:'line', zoomType:'x', height:140, marginRight:0, marginLeft: 40},
        title: { text:'基站交流设备开关状态表', align:'left', x:0, margin:20 },
        xAxis: { type:'datetime', tickPixelInterval:100, gridLineWidth:1 },
        yAxis: {
            title: { text:'' },    	 			
            minorTickInterval: 'auto',
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            labels: {
                formatter: function(){
                               if(this.value==0||this.value==1){return this.value;}
                           }
            },
    	 	plotLines: [{ value: 3.6, color: '#333', width: 2, zIndex: 0  },
    	 	            { value: 2.1, color: '#333', width: 2, zIndex: 0  },
    	 	            { value: 0.6, color: '#333', width: 2, zIndex: 0  }]
        },
        plotOptions: {
                         line: { cursor: 'pointer',lineWidth:14 },
                         series: {
                             marker: { radius: 0.01, fillColor: '#fff', lineWidth: 0.5, lineColor: '#333'}
                         }
                     },
        tooltip: {
                     formatter: function(){
                                    switch(this.y){
                                        case -2:
                                        case -1:
                                            this.y += 2;
                                            break;
                                        default:
                                            break;
                                    };
                                    return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y;
                                }
                 },
        legend: { align:'right', verticalAlign:'top', borderWidth:0, itemWidth:70, x:5 },
        series: [{ name: '新风0开', data: [], color: '#0f0'},
                //{ name: '新风1开关', data: [], color: Highcharts.getOptions().colors[1]},
                { name: '空调1开', data: [], color:'#f93'},
                { name: '空调2开', data: [], color:'#9dd'}
                //{ name: '空调2开关', data: [], color: Highcharts.getOptions().colors[3]}
                ]
    };           
    window.es_colds_fan_on_chart = new Highcharts.Chart( options );
}



function trans_misspkts(data){
    var _data = new Array();
    $.each(data, 
        function(i,field){
            _data.push([field[0], (field[1] == 60)? null:(60-field[1])]);
        }); 
    return _data;
}



function draw_all_charts(isStandardStation,equipOutdoorSensor,coldsNum,stationType,weekday){
    draw_chart("es_temprature",equipOutdoorSensor);
    draw_chart_es_power();
    draw_chart("es_colds_tmp","",coldsNum);
    draw_chart("es_humidity",equipOutdoorSensor);
        draw_chart_es_colds_fan_on();
        draw_chart_es_energy_hour_column_chart(stationType,weekday);
    if(!isStandardStation){
        draw_chart("es_box_temprature");
    }
    // draw_chart_es_packets_num();

}


