function init_highcharts(){
    Highcharts.setOptions({ 
        global: { 
                    useUTC: false 
                } ,
        colors: ['#d76618','#1d476f','#99dddd', '#ffbb66', 'ee3344', '#66dd88','#887766','007788','#006677'],
       	title: {
			style: {
				color: '#000',
				font: 'bold 12px Trebuchet MS, Verdana, sans-serif'
			}
		},
		legend: {
			itemStyle: {
				font: '12px Trebuchet MS, Verdana, sans-serif'
			}
		},
        exporting:{
            printButton:{
                enabled: false
            }
        },
        lang: {
        	loading: ''
        },
        loading:{
    	 	style: {
    	 		background: 'url(/static/site/img/loading.gif) center no-repeat'
    	 		// background: 'url(http://58.215.20.110:8988/static/site/img/light-green.png) center no-repeat'
    	 	}
    	}
    }); 
}

function draw_chart( chart_type ) {
    switch(chart_type){
    	// page: real-time monitoring 
    	 case "es_temprature":
    	 	var options = {
    	 		chart: {
    	 			renderTo: 'es_temprature',
    	 			type: 'line',
    	 			zoomType: 'x',
    	 			height: 220,
    	 			marginRight: 0
    	 		},
    	 		title: {
                	text: '基站内外温度(°C)',
                	align:'left',
                	x: 0,
                	margin: 20
    	 		},
    	 		xAxis: {
    	 			type: 'datetime',
    	 			tickPixelInterval: 100,
    	 			gridLineWidth: 1
    	 		},
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			},
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,    	 			
    	 			plotLines: [{
    	 				value: 35,
    	 				color: 'green',
						dashStyle: 'Dash',
						width: 1.2,
						zIndex: 1,
						label: {
							text: 'base: 35°C'
						}
    	 			}]
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: {
    	 					radius: 0.01,
		        			fillColor: '#fff',
		        			lineWidth: 0.5,
		        			lineColor: '#333'	
    	 				}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'°C';
    	 			}
    	 		},
    	 		legend: {
    	 			align: 'right',
    	 			verticalAlign: 'top',
    	 			borderWidth: 0,
    	 			itemWidth: 80,
    	 			x: 10
    	 		},
    	 		// loading:{
    	 			// style: {
    	 				// // backgroundImage: 'url(http://58.215.20.110:8988/static/site/img/light-green.png)'
    	 				// background: 'url(http://58.215.20.110:8988/static/site/img/light-green.png) center no-repeat'
    	 			// }
    	 		// },
        		series: [{
        			name: '站内温度',
        			data: [],
        			color: Highcharts.getOptions().colors[0]
        		},{
        			name: '站外温度',
        			data: [],
        			color: Highcharts.getOptions().colors[1]
        		}]
    	 	};
            window.es_temprature_chart = new Highcharts.Chart( options );
            window.es_temprature_chart.showLoading();
            break;s


    	 case "es_colds_tmp":
    	 	var options = {
    	 		chart: {
    	 			renderTo: 'es_colds_tmp',
    	 			type: 'line',
    	 			zoomType: 'x',
    	 			height: 180,
    	 			marginRight: 0
    	 		},
    	 		title: {
                	text: '空调出风口温度(°C)',
                	align:'left',
                	x: 0,
                	margin: 20
    	 		},
    	 		xAxis: {
    	 			type: 'datetime',
    	 			tickPixelInterval: 100,
    	 			gridLineWidth: 1
    	 		},
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			},
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1    	 			
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: {
    	 					radius: 0.01,
		        			fillColor: '#fff',
		        			lineWidth: 0.5,
		        			lineColor: '#333'	
    	 				}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'°C';
    	 			}
    	 		},
    	 		legend: {
    	 			align: 'right',
    	 			verticalAlign: 'top',
    	 			borderWidth: 0,
    	 			itemWidth: 90,
    	 			x: 10
    	 		},
        		series: [{
        			name: '空调0温度',
        			data: [],
        			color: Highcharts.getOptions().colors[0]
        		},{
        			name: '空调1温度',
        			data: [],
        			color: Highcharts.getOptions().colors[1]
        		},{
        			name: '空调2温度',
        			data: [],
        			color: Highcharts.getOptions().colors[2]
        		}]
    	 	};
            window.es_colds_tmp_chart = new Highcharts.Chart( options );
            break;


    	 case "es_fan_press":
    	 	var options = {
    	 		chart: {
    	 			renderTo: 'es_fan_press',
    	 			type: 'line',
    	 			zoomType: 'x',
    	 			height: 180,
    	 			marginRight: 0
    	 		},
    	 		title: {
                	text: '新风风口负压(kpa)',
                	align:'left',
                	x: 0,
                	margin: 20
    	 		},
    	 		xAxis: {
    	 			type: 'datetime',
    	 			tickPixelInterval: 100,
    	 			gridLineWidth: 1
    	 		},
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			},
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1    	 			
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: {
    	 					radius: 0.01,
		        			fillColor: '#fff',
		        			lineWidth: 0.5,
		        			lineColor: '#333'	
    	 				}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'kpa';
    	 			}
    	 		},
    	 		legend: {
    	 			align: 'right',
    	 			verticalAlign: 'top',
    	 			borderWidth: 0,
    	 			itemWidth: 90,
    	 			x: 10
    	 		},
        		series: [{
        			name: '进口负压',
        			data: [],
        			color: Highcharts.getOptions().colors[0]
        		},{
        			name: '出口负压',
        			data: [],
        			color: Highcharts.getOptions().colors[2]
        		}]
    	 	};
            window.es_fan_press_chart = new Highcharts.Chart( options );
            break;


    	 case "es_box_temprature":
    	 	var options = {
    	 		chart: {
    	 			renderTo: 'es_box_temprature',
    	 			type: 'line',
    	 			zoomType: 'x',
    	 			height: 180,
    	 			marginRight: 0
    	 		},
    	 		title: {
                	text: '恒温柜温度(°C)',
                	align:'left',
                	x: 0,
                	margin: 20
    	 		},
    	 		xAxis: {
    	 			type: 'datetime',
    	 			tickPixelInterval: 100,
    	 			gridLineWidth: 1
    	 		},
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			},
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,    	 			
    	 			plotLines: [{
    	 				value: 22,
    	 				color: 'green',
						dashStyle: 'Dash',
						width: 1.2,
						zIndex: 1,
						label: {
							text: 'base: 22°C'
						}
    	 			}]
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: {
    	 					radius: 0.01,
		        			fillColor: '#fff',
		        			lineWidth: 0.5,
		        			lineColor: '#333'	
    	 				}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'°C';
    	 			}
    	 		},
    	 		legend: {
    	 			align: 'right',
    	 			verticalAlign: 'top',
    	 			borderWidth: 0,
    	 			itemWidth: 90,
    	 			x: 10
    	 		},
        		series: [{
        			name: '恒温柜温度',
        			data: [],
        			color: Highcharts.getOptions().colors[0]
        		}]
    	 	};
            window.es_box_temprature_chart = new Highcharts.Chart( options );
            break;



        case "es_humidity":
    	 	var options = {
    	 		chart: {
    	 			renderTo: 'es_humidity',
    	 			type: 'line',
    	 			zoomType: 'x',
    	 			height: 180,
    	 			marginRight: 0
    	 		},
    	 		title: {
                	text: '基站室内湿度表(%)',
                	align:'left',
                	x: 0,
                	margin: 20
    	 		},
    	 		xAxis: {
    	 			type: 'datetime',
    	 			tickPixelInterval: 100,
    	 			gridLineWidth: 1
    	 		},
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			},   	 			
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,
    	 			plotLines: [{
    	 				value: 60,
    	 				color: 'green',
						dashStyle: 'Dash',
						width: 1.2,
						zIndex: 1,
						label: {
							text: 'base: 60%'
						}
    	 			}]
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: {
    	 					radius: 0.01,
		        			fillColor: '#fff',
		        			lineWidth: 0.5,
		        			lineColor: '#333'	
    	 				}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'%';
    	 			}
    	 		},
    	 		legend: {
    	 			align: 'right',
    	 			verticalAlign: 'top',
    	 			borderWidth: 0,
    	 			itemWidth: 80,
    	 			x: 10
    	 		},
        		series: [{
        			name: '站内湿度',
        			data: [],
        			color: Highcharts.getOptions().colors[0]
        		},{
        			name: '站外湿度',
        			data: [],
        			color: Highcharts.getOptions().colors[1]
        		}]
    	 	};       
            window.es_humidity_chart = new Highcharts.Chart( options );
            break;
            
        case "es_colds_fan_on":
    	 	var options = {
    	 		chart: {
    	 			renderTo: 'es_colds_fan_on',
    	 			type: 'line',
    	 			zoomType: 'x',
    	 			height: 220,
    	 			marginRight: 0
    	 		},
    	 		title: {
                	text: '基站交流设备开关状态表',
                	align:'left',
                	x: 0,
                	margin: 20
    	 		},
    	 		xAxis: {
    	 			type: 'datetime',
    	 			tickPixelInterval: 100,
    	 			gridLineWidth: 1
    	 		},
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			},    	 			
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,
					labels: {
						formatter: function(){
							if(this.value==0||this.value==1){
								return this.value;								
							}
						}
					}
    	 		},
    	 		plotOptions: {
    	 			line: {
    	 				cursor: 'pointer'
    	 			},
    	 			series: {
    	 				marker: {
    	 					radius: 0.01,
		        			fillColor: '#fff',
		        			lineWidth: 0.5,
		        			lineColor: '#333'	
    	 				}
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
            			return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y;;
    	 			}
    	 		},
    	 		legend: {
    	 			align: 'right',
    	 			verticalAlign: 'top',
    	 			borderWidth: 0,
    	 			itemWidth: 80,
    	 			x: 5
    	 		},
        		series: [{
        			name: '新风0开关',
        			data: [],
        			color: Highcharts.getOptions().colors[0]
        		},{
        			name: '新风1开关',
        			data: [],
        			color: Highcharts.getOptions().colors[1]
        		},{
        			name: '空调0开关',
        			data: [],
        			color: Highcharts.getOptions().colors[2]
        		},{
        			name: '空调1开关',
        			data: [],
        			color: Highcharts.getOptions().colors[3]
        		},{
        			name: '空调2开关',
        			data: [],
        			color: Highcharts.getOptions().colors[4]
        		}]
    	 	};           
            window.es_colds_fan_on_chart = new Highcharts.Chart( options );
            break;
            
       // page: Energy consumption analysis 
       case "es_power":
    	 	var options = {
    	 		chart: {
    	 			renderTo: 'es_power',
    	 			type: 'area',
    	 			zoomType: 'x',
    	 			height: 250,
    	 			marginRight: 0
    	 		},
    	 		title: {
                	text: '基站能耗实时表(kW)',
                	align:'left',
                	x: 0,
                	margin: 20
    	 		},
    	 		xAxis: {
    	 			type: 'datetime',
    	 			tickPixelInterval: 100
    	 		},
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			}
    	 		},    	 		
    	 		plotOptions: {
    	 			area: {
    	 				fillOpacity: 0.9,
		        		lineWidth: 0.8,
		        		lineColor: '#999',
		        		shadow: false,
		        		cursor: 'pointer'
    	 			},  
    	 			series: {
    	 				marker: {
    	 					radius: 0.01,
		        			fillColor: '#fff',
		        			lineWidth: 0.5,
		        			lineColor: '#333'	
    	 				}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'kW';
    	 			}
    	 		},
    	 		legend: {
    	 			align: 'right',
    	 			verticalAlign: 'top',
    	 			borderWidth: 0,
    	 			itemWidth: 100,
    	 			x: 10
    	 		},
        		series: [{
        			name: '标准站能耗',
        			data: [],
        			color: Highcharts.getOptions().colors[0]
        		},{
        			name: '测试站能耗',
        			data: [],
        			color: Highcharts.getOptions().colors[1]
        		}]
    	 	};       
            window.es_temprature_chart = new Highcharts.Chart( options );
            break; 
            
       case "es_power_column":
    	 	var options = {
    	 		chart: {
    	 			renderTo: 'es_power_column',
    	 			type: 'column',
    	 			zoomType: 'x',
    	 			height: 300,
    	 			marginRight: 0
    	 		},
    	 		title: {
                	text: '基站能耗对比图(kWh)',
                	align:'left',
                	x: 0,
                	margin: 20
    	 		},
    	 		xAxis: {
    	 			type: 'datetime',
    	 			tickPixelInterval: 100
    	 		},
    	 		yAxis: {
    	 			title: {
    	 				text: ''
    	 			}
    	 		},     	 		
    	 		plotOptions: {
    	 			column: {
    	 				cursor: 'pointer',
    	 				pointPadding: 0.1,
        				groupPadding: 0.3
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'kWh';
    	 			}
    	 		},
    	 		legend: {
    	 			align: 'right',
    	 			verticalAlign: 'top',
    	 			borderWidth: 0,
    	 			itemWidth: 100,
    	 			x: 10
    	 		},
        		series: [{
        			name: '标准站能耗',
        			data: [],
        			color: Highcharts.getOptions().colors[0]
        		},{
        			name: '测试站能耗',
        			data: [],
        			color: Highcharts.getOptions().colors[1]
        		}]
    	 	};        
            window.es_power_chart = new Highcharts.Chart( options );
            break; 
       

       
    }
}


function get_data_and_refresh_chart(chart_type){

    switch(chart_type){
    	case "es_power_column":
    		pwr_str1 = '[{"num":"10","time":"Mon, 23 Apr 2012 00:00:00 +0800"},'+
    				   '{"num":"18","time":"Tue, 24 Apr 2012 00:00:00 +0800"},'+
    				   '{"num":"16","time":"Wed, 25 Apr 2012 00:00:00 +0800"},'+
    				   '{"num":"19","time":"Thu, 26 Apr 2012 00:00:00 +0800"},'+
    				   '{"num":"18","time":"Fri, 27 Apr 2012 00:00:00 +0800"}]';
    				   
    		pwr_str2 = '[{"num":"6","time":"Mon, 23 Apr 2012 00:00:00 +0800"},'+
    				   '{"num":"12","time":"Tue, 24 Apr 2012 00:00:00 +0800"},'+
    				   '{"num":"12","time":"Wed, 25 Apr 2012 00:00:00 +0800"},'+
    				   '{"num":"16","time":"Thu, 26 Apr 2012 00:00:00 +0800"},'+
    				   '{"num":"10","time":"Fri, 27 Apr 2012 00:00:00 +0800"}]';

    		pwrObj = jQuery.parseJSON(pwr_str1);
    		var _getdata = new Array();
    		$.each(pwrObj, 
                    function(i,field){
                        _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                    });	
                    window.es_power_chart.series[0].setData(_getdata);
            pwrObj2 = jQuery.parseJSON(pwr_str2);
            var _getdata2 = new Array();
            $.each(pwrObj2, 
                    function(i,field){
                        _getdata2.push([Date.parse(field.time), parseFloat(field.num)]);
                    });	
                    window.es_power_chart.series[1].setData(_getdata2);
            
    		break;

        case "es_station_info":
            $.get("/webservice/get_station_info",  {station_id:window.global_options.station_id,
            rnd:Math.round(new Date().getTime()/10000)}, 
            function(temp_str){
                tempObj = jQuery.parseJSON(temp_str);
                window.global_options.name_chn = tempObj['name_chn'];
                window.global_options.alive = tempObj['alive'];
                window.global_options.lng = tempObj['lng'];
                window.global_options.lat = tempObj['lat'];
                window.global_options.pic_url = tempObj['pic_url'];
                window.global_options.last_connect_time = tempObj['last_connect_time'];
                finish_get_fn();// hahahahaha thats great!
            });

            break;
    		
        case "es_box_temprature":
            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id,
                param:"box_tmp",
            dur:window.global_options.dur,
            type:window.global_options.type,
            time:window.global_options.time,
            rnd:Math.round(new Date().getTime()/10000)}, 
            function(temp_str){
                tempObj = jQuery.parseJSON(temp_str);
                var _getdata = new Array();
                var _storedata = new Array();
                $.each(tempObj, 
                    function(i,field){
                        _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                         if(parseFloat(field.num) > 22){
                        	 //console.log(parseFloat(field.num));
                        	 _storedata.push(Date.parse(field.time));
                        }
                });                     
				
                window.es_box_temprature_chart.series[0].setData(_getdata);
 				
	                $.each(_storedata, function(i,n){
			    		window.es_box_temprature_chart.xAxis[0].addPlotLine({
			                value: n,
			                color: '#fe9',
			                width: 20
			            });
	                });   	
            });

            break;

    	case "es_power":
            break;

        case "es_colds_tmp":

            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id, param:"colds_0_tmp",
                dur:window.global_options.dur, type:window.global_options.type, time:window.global_options.time, 
                rnd:Math.round(new Date().getTime()/10000)}, 
            function(temp_str){
                tempObj = jQuery.parseJSON(temp_str);
                var _getdata = new Array();
                $.each(tempObj, 
                    function(i,field){
                        _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                });                     
				
                window.es_colds_tmp_chart.series[0].setData(_getdata);
 				
	        });   	
            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id, param:"colds_1_tmp",
                dur:window.global_options.dur, type:window.global_options.type, time:window.global_options.time, 
                rnd:Math.round(new Date().getTime()/10000)}, 
            function(temp_str){
                tempObj = jQuery.parseJSON(temp_str);
                var _getdata = new Array();
                $.each(tempObj, 
                    function(i,field){
                        _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                });                     
				
                window.es_colds_tmp_chart.series[1].setData(_getdata);
 				
	        });   	
            break;


        case "es_temprature":
			
            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id,
                param:"indoor_tmp", dur:window.global_options.dur, type:window.global_options.type, time:window.global_options.time,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    finish_get_fn();// hahahahaha thats great!
                    tempObj = jQuery.parseJSON(temp_str);

                    window.global_options.last_indoor_tmp = (tempObj.length)? tempObj[tempObj.length-1]['num']:"";
                    
                    var _getdata = new Array();
                    var _storedata = new Array();
                    $.each(tempObj, 
                        function(i,field){
                            _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                             if(parseFloat(field.num) > 35){
                                 _storedata.push(Date.parse(field.time));
                            }
                    });                     
                    window.es_temprature_chart.hideLoading();
                    window.es_temprature_chart.series[0].setData(_getdata);
 					
	                $.each(_storedata, function(i,n){
			    		window.es_temprature_chart.xAxis[0].addPlotLine({ value: n, color: '#fe9', width: 20 });
	                });   	

                var table_html = "";
                table_html += " <table class='table'><thead> <tr> <th>时间</th> <th>室内</th> <th>todo</th> </tr> </thead> <tbody>";
                _table_body_html = "";
                _time = window.es_temprature_chart.series[0].xData;
                _datain = window.es_temprature_chart.series[0].yData;
                    $.each(_time, 
                        function(i,field){
                            var _t = new Date(field);
                            _tsa = _t.toLocaleString().split(" ");
                            timestr = _tsa[1]+" "+_tsa[2]+" "+_tsa[4];
                            _table_body_html = "<tr><td>"+timestr+"</td><td>"+_datain[i]+"</td><td>todo</td></tr>" + _table_body_html;
                        });	
                table_html += _table_body_html;
                table_html += " </tbody></table>";
                $("#es_temprature_table").html(table_html);

            });

            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id,
                param:"outdoor_tmp", dur:window.global_options.dur, type:window.global_options.type, time:window.global_options.time,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    finish_get_fn();// hahahahaha thats great!
                    tempObj = jQuery.parseJSON(temp_str);
                    window.global_options.last_outdoor_tmp = (tempObj.length)? tempObj[tempObj.length-1]['num']:"";
                    var _getdata= new Array();
                    $.each(tempObj, 
                        function(i,field){
                            _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                        });	

                    window.es_temprature_chart.series[1].setData(_getdata);
                });

            break;

        case "es_humidity":
            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id,
                param:"indoor_hum",
                dur:window.global_options.dur,
                type:window.global_options.type,
                time:window.global_options.time,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    var _getdata= new Array();
                    $.each(tempObj, 
                        function(i,field){
                            _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                        });	

                    window.es_humidity_chart.series[0].setData(_getdata);
                });
            break;
            
        case "es_colds_fan_on":

            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id, param:"fan_0_on",
                dur:window.global_options.dur,
                type:window.global_options.type,
                time:window.global_options.time,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    finish_get_fn();// hahahahaha thats great!
                    tempObj = jQuery.parseJSON(temp_str);
                    window.global_options.last_fan_0_on = (tempObj.length)? tempObj[tempObj.length-1]['num']:"";
                    var _getdata= new Array();
                    $.each(tempObj, 
                        function(i,field){
                            _getdata.push([Date.parse(field.time), parseFloat(field.num)+4]);
                        });	
                    window.es_colds_fan_on_chart.series[0].setData(_getdata);
                });

            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id, param:"fan_1_on",
                dur:window.global_options.dur,
                type:window.global_options.type,
                time:window.global_options.time,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    finish_get_fn();// hahahahaha thats great!
                    tempObj = jQuery.parseJSON(temp_str);
                    window.global_options.last_fan_1_on = (tempObj.length)? tempObj[tempObj.length-1]['num']:"";
                    var _getdata= new Array();
                    $.each(tempObj, 
                        function(i,field){
                            _getdata.push([Date.parse(field.time), parseFloat(field.num)+2]);
                        });	
                    window.es_colds_fan_on_chart.series[1].setData(_getdata);
                });

            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id, param:"colds_0_on",
                dur:window.global_options.dur,
                type:window.global_options.type,
                time:window.global_options.time,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    finish_get_fn();// hahahahaha thats great!
                    tempObj = jQuery.parseJSON(temp_str);
                    window.global_options.last_colds_0_on = (tempObj.length)? tempObj[tempObj.length-1]['num']:"";
                    var _getdata= new Array();
                    $.each(tempObj, 
                        function(i,field){
                            _getdata.push([Date.parse(field.time), parseFloat(field.num)]);
                        });	
                    window.es_colds_fan_on_chart.series[2].setData(_getdata);
                });
                
            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id, param:"colds_1_on",
                dur:window.global_options.dur,
                type:window.global_options.type,
                time:window.global_options.time,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    finish_get_fn();// hahahahaha thats great!
                    tempObj = jQuery.parseJSON(temp_str);
                    window.global_options.last_colds_1_on = (tempObj.length)? tempObj[tempObj.length-1]['num']:"";
                    var _getdata= new Array();
                    $.each(tempObj, 
                        function(i,field){
                            _getdata.push([Date.parse(field.time), parseFloat(field.num)-2]);
                        });	
                    window.es_colds_fan_on_chart.series[3].setData(_getdata);
                });


            $.get("/webservice/getdatalist",  {station_id:window.global_options.station_id, param:"colds_2_on",
                dur:window.global_options.dur,
                type:window.global_options.type,
                time:window.global_options.time,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    finish_get_fn();// hahahahaha thats great!
                    tempObj = jQuery.parseJSON(temp_str);
                    window.global_options.last_colds_2_on = (tempObj.length)? tempObj[tempObj.length-1]['num']:"";
                    var _getdata= new Array();
                    $.each(tempObj, 
                        function(i,field){
                            _getdata.push([Date.parse(field.time), parseFloat(field.num)-4]);
                        });	
                    window.es_colds_fan_on_chart.series[4].setData(_getdata);
                });

            break;

    }
}

function finish_get_fn(){
    window.finish_get++;
    if(window.finish_get >= 8){
        draw_station_info();
    }
}

function draw_station_info(){
    var str = '';
    str += ' <div class="hero-unit" style="padding:10px">';
    str += '               <h2>'+window.global_options.name_chn+'</h2>';
    if(window.global_options.alive === 1){
        str += '               当前状态: <span class="label label-success">在线！</span><br>';
    }else{
        str += '               当前状态：<span class="label label-important">不在线</span><br>';
    }
    str += '             最后连接时间: '+window.global_options.last_connect_time;
    str += '             </div>';
    str += '             <div class="hero-unit" style="padding:10px">';
    str += '               <small>室内温度&emsp;室外温度&emsp;恒温柜温度</small><br>';
    str += '               <h2>'+window.global_options.last_indoor_tmp+'° '+window.global_options.last_outdoor_tmp+'°</h1>';
    str += '             </div>';
    str += '             <div class="hero-unit" style="padding:10px">';
    str += '               <small>新风&emsp;空调1&emsp;空调2</small><br>';
    if(window.global_options.last_fan_0_on === "1"){
        str += '                <img src=/static/site/img/fan_on.gif width=64>';
    }else{
        str += '                <img src=/static/site/img/fan_off.gif width=64>';
    }
    if(window.global_options.last_colds_0_on === "1"){
        str += '                <img src=/static/site/img/colds_on.gif width=64>';
    }else{
        str += '                <img src=/static/site/img/colds_off.gif width=64>';
    }
    if(window.global_options.last_colds_1_on === "1"){
        str += '                <img src=/static/site/img/colds_on.gif width=64>';
    }else{
        str += '                <img src=/static/site/img/colds_off.gif width=64>';
    }
    str += '             </div>';
    str += '             <div class="hero-unit" style="padding:10px">';
    if(window.global_options.pic_url){
        str += '               <img src="'+window.global_options.pic_url+'" style="width:100%" />';
    }
    str += '             </div>';
    $("#es_station_info").html(str);
}

function get_data_and_refresh_all_charts(){
    window.finish_get = 0;
    get_data_and_refresh_chart("es_temprature");
    get_data_and_refresh_chart("es_humidity");
    get_data_and_refresh_chart("es_box_temprature");
    get_data_and_refresh_chart("es_colds_fan_on");
    get_data_and_refresh_chart("es_colds_tmp");
    get_data_and_refresh_chart("es_station_info");
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
    str += '<b>' + trans_array[option.dur] + "</b> ";
    str += trans_array[option.type] + " ";
    str += trans_datetime_zhn(option.es_date_picker + option.es_time_picker);
        return str;
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

