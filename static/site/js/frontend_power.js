/********************************
Fast JJump 
..\..\..\application\views\frontend\station\power.php

********************************/

function draw_chart_es_ac_dc_energy_day_pie(){
    var options = {
        chart: { renderTo: 'es_ac_dc_energy_day_pie', type: 'pie', height: 130 },
        title: { text: '日AC/DC能耗比', align:'right' },
        plotOptions: {
                         pie: {
                                  allowPointSelect: true,
                                  cursor: 'pointer',
                                  dataLabels: { enabled: false },
                                  size: '100%'
                              }
                     },
        tooltip: {
                     formatter: function(){
                                    return '<b>'+ this.point.name +'</b>: '+ this.y + '%';
                                }
                 },
        legend: {
                    align: 'right',
                    layout: 'vertical',
                    verticalAlign: 'middle',
                    borderWidth: 0,
                    itemStyle: { font: '11px Trebuchet MS, Verdana, sans-serif' }
                },
        series: [{
                    data: [{ name: 'AC', color: Highcharts.getOptions().colors[0] },
                    { name: 'DC', color: Highcharts.getOptions().colors[1]}],
                          showInLegend: true
                }]
    };                  		
    window.es_ac_dc_energy_day_pie_chart = new Highcharts.Chart( options );
}

function draw_chart_es_ac_dc_energy_month_pie(){
    var options = {
        chart: { renderTo: 'es_ac_dc_energy_month_pie', type: 'pie', height: 130 },
        title: { text: '月AC/DC能耗比', align:'right' },
        plotOptions: {
                         pie: {
                                  allowPointSelect: true,
                                  cursor: 'pointer',
                                  dataLabels: { enabled: false },
                                  size: '100%'
                              }
                     },
        tooltip: {
                     formatter: function(){
                                    return '<b>'+ this.point.name +'</b>: '+ this.y + '%';
                                }
                 },
        legend: {
                    align: 'right',
                    layout: 'vertical',
                    verticalAlign: 'middle',
                    borderWidth: 0,
                    itemStyle: { font: '11px Trebuchet MS, Verdana, sans-serif' }
                },
        series: [{
                    data: [{ name: 'AC', color: Highcharts.getOptions().colors[0] },
                    { name: 'DC', color: Highcharts.getOptions().colors[1]}],
                          showInLegend: true
                }]
    };                  		
    window.es_ac_dc_energy_month_pie_chart = new Highcharts.Chart( options );
}

function draw_chart_es_day_saving_pie(){
    var options = {
        chart: { renderTo: 'es_day_saving_pie', type: 'pie', height: 190 },
        title: { text: '日AC节能率', align:'right' },
        plotOptions: {
                         pie: {
                                  allowPointSelect: true,
                                  cursor: 'pointer',
                                  dataLabels: { enabled: false },
                                  size: '100%'
                              }
                     },
        tooltip: {
                     formatter: function(){
                                    return '<b>'+ this.point.name +'</b>: '+ this.y + '%';
                                }
                 },
        legend: {
                    align: 'right',
                    layout: 'vertical',
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

function draw_chart_es_month_saving_pie(){
    var options = {
        chart: { renderTo: 'es_month_saving_pie', type: 'pie', height: 190 },
        title: { text: '月AC节能率', align:'right' },
        plotOptions: {
                         pie: {
                                  allowPointSelect: true,
                                  cursor: 'pointer',
                                  dataLabels: { enabled: false },
                                  size: '100%'
                              }
                     },
        tooltip: {
                     formatter: function(){
                                    return '<b>'+ this.point.name +'</b>: '+ this.y + '%';
                                }
                 },
        legend: {
                    align: 'right',
                    layout: 'vertical',
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
    window.es_month_saving_pie_chart = new Highcharts.Chart( options );
}

function draw_chart( chart_type ) {
    switch(chart_type){
       case "es_energy_hour_column":
    	 	var options = {
    	 		chart: { renderTo:'es_energy_hour_column', type:'column', zoomType:'x', height:200, marginRight:0},
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
        		series: [{ name: '基准站小时AC', data: [], color: Highcharts.getOptions().colors[0]},
                    { name: '测试站小时AC', data: [], color: Highcharts.getOptions().colors[1]}]
    	 	};        
            window.es_energy_hour_column_chart = new Highcharts.Chart( options );
            break; 
       case "es_energy_day_column":
    	 	var options = {
    	 		chart: { renderTo:'es_energy_day_column', type:'column', zoomType:'x', height:200, marginRight:0},
    	 		title: { text: '日AC能耗图(kWh)', align:'left', x: 0, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 100 },
    	 		yAxis: { title: { text: '' } },     	 		
    	 		plotOptions: { column: { cursor: 'pointer', pointPadding: 0.1, groupPadding: 0.1 } },
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e', this.x)+' '+this.y+'kWh';
    	 			}
    	 		},
    	 		legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 110, x: 10 },
        		series: [{ name: '基准站日AC', data: [], color: Highcharts.getOptions().colors[0]},
                    { name: '测试站日AC', data: [], color: Highcharts.getOptions().colors[1]}]
    	 	};        
            window.es_energy_day_column_chart = new Highcharts.Chart( options );
            break; 

       case "es_energy_month_column":
    	 	var options = {
    	 		chart: { renderTo:'es_energy_month_column', type:'column', zoomType:'x', height:200, marginRight:0},
    	 		title: { text: '每月能耗图(kWh)', align:'left', x: 0, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 100 },
    	 		yAxis: { title: { text: '' } },     	 		
    	 		plotOptions: { column: { cursor: 'pointer', pointPadding: 0.1, groupPadding: 0.1 } },
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e', this.x)+' '+this.y+'kWh';
    	 			}
    	 		},
    	 		legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 110, x: 10 },
        		series: [{ name: '基准站月能耗', data: [], color: Highcharts.getOptions().colors[0]},
                    { name: '测试站月能耗', data: [], color: Highcharts.getOptions().colors[1]}]
    	 	};        
            window.es_energy_month_column_chart = new Highcharts.Chart( options );
            break; 

    }
}


function get_energy_column_refresh_chart(chart_type){
    switch(chart_type){

    	case "day":
            $.get("/webservice/getdatalistv2",  {station_id:window.global_options.standard_station_id,
                param:"energy_ac_column", 
                time:window.global_options.es_time_two_stations,
                type:"day",
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    window.es_energy_hour_column_chart.series[0].setData(tempObj);
                });
            $.get("/webservice/getdatalistv2",  {station_id:window.global_options.station_id,
                param:"energy_ac_column", 
                time:window.global_options.es_time_two_stations,
                type:"day",
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    window.es_energy_hour_column_chart.series[1].setData(tempObj);
                });
            break;

    	case "month":
            $.get("/webservice/getdatalistv2",  {station_id:window.global_options.standard_station_id,
                param:"energy_ac_column", 
                time:window.global_options.es_time_two_stations,
                type:"month",
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    window.es_energy_day_column_chart.series[0].setData(tempObj);
                });
            $.get("/webservice/getdatalistv2",  {station_id:window.global_options.station_id,
                param:"energy_ac_column", 
                time:window.global_options.es_time_two_stations,
                type:"month",
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    window.es_energy_day_column_chart.series[1].setData(tempObj);
                });
            break;

        case "es_day_saving_pie":
            $.get("/webservice/getdatalistv2",  {station_id:window.global_options.station_id, 
                ex_station_id:window.global_options.standard_station_id,
                param:"saving_pie",
                type:"day",
                time:window.global_options.es_time_two_stations,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    var _getdata= new Array();
                    $.each(tempObj,
                        function(i,field){
                            _getdata.push({name: window.es_day_saving_pie_chart.series[0].data[i].name, y: parseFloat(field),
                            	color: window.es_day_saving_pie_chart.series[0].data[i].color});
                        });
                    if(_getdata.length){
                        window.es_day_saving_pie_chart.series[0].setData(_getdata,false);
                        window.es_day_saving_pie_chart.series[0].showInLegend = true;
                        window.es_day_saving_pie_chart.series[0].data[0].sliced = true;
                        window.es_day_saving_pie_chart.redraw();
                    }
                });
            break;
        case "es_month_saving_pie":
            $.get("/webservice/getdatalistv2",  {station_id:window.global_options.station_id, 
                ex_station_id:window.global_options.standard_station_id,
                param:"saving_pie",
                type:"month",
                time:window.global_options.es_time_two_stations,
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    var _getdata= new Array();
                    $.each(tempObj,
                        function(i,field){
                            _getdata.push({name: window.es_month_saving_pie_chart.series[0].data[i].name, y: parseFloat(field),
                            	color: window.es_month_saving_pie_chart.series[0].data[i].color});
                        });
                    if(_getdata.length){
                        window.es_month_saving_pie_chart.series[0].setData(_getdata,false);
                        window.es_month_saving_pie_chart.series[0].showInLegend = true;
                        window.es_month_saving_pie_chart.series[0].data[0].sliced = true;
                        window.es_month_saving_pie_chart.redraw();
                    }
                });
            break;

        case "es_ac_dc_energy_day_pie":
            $.get("/webservice/getdatalistv2",  {station_id:window.global_options.station_id, 
                param:"ac_dc_energy_percentage",
                time:window.global_options.es_time_ac_dc,
                type:"day",
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    var _getdata= new Array();
                    $.each(tempObj,
                        function(i,field){
                            _getdata.push({name: window.es_ac_dc_energy_day_pie_chart.series[0].data[i].name, y: parseFloat(field),
                            	color: window.es_ac_dc_energy_day_pie_chart.series[0].data[i].color});
                        });
                    if(_getdata.length){
                        window.es_ac_dc_energy_day_pie_chart.series[0].setData(_getdata,false);
                        window.es_ac_dc_energy_day_pie_chart.series[0].showInLegend = true;
                        window.es_ac_dc_energy_day_pie_chart.series[0].data[0].sliced = true;
                        window.es_ac_dc_energy_day_pie_chart.redraw();
                    }
                });
            break;
        case "es_ac_dc_energy_month_pie":
            $.get("/webservice/getdatalistv2",  {station_id:window.global_options.station_id, 
                param:"ac_dc_energy_percentage",
                time:window.global_options.es_time_ac_dc,
                type:"month",
                rnd:Math.round(new Date().getTime()/10000)}, 
                function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    var _getdata= new Array();
                    $.each(tempObj,
                        function(i,field){
                            _getdata.push({name: window.es_ac_dc_energy_month_pie_chart.series[0].data[i].name, y: parseFloat(field),
                            	color: window.es_ac_dc_energy_month_pie_chart.series[0].data[i].color});
                        });
                    if(_getdata.length){
                        window.es_ac_dc_energy_month_pie_chart.series[0].setData(_getdata,false);
                        window.es_ac_dc_energy_month_pie_chart.series[0].showInLegend = true;
                        window.es_ac_dc_energy_month_pie_chart.series[0].data[0].sliced = true;
                        window.es_ac_dc_energy_month_pie_chart.redraw();
                    }
                });
            break;
    }
}



function draw_all_charts(isStandardStation){
    draw_chart_es_ac_dc_energy_day_pie();
    draw_chart_es_ac_dc_energy_month_pie();
    if(!isStandardStation){
        draw_chart("es_energy_hour_column");
        draw_chart("es_energy_day_column");
        draw_chart_es_day_saving_pie();
        draw_chart_es_month_saving_pie();
    }
}

function get_data_and_refresh_ac_dc_charts(){
    get_energy_column_refresh_chart("es_ac_dc_energy_day_pie");
    get_energy_column_refresh_chart("es_ac_dc_energy_month_pie");
}
function get_data_and_refresh_two_stations_charts(){
    get_energy_column_refresh_chart("day");
    get_energy_column_refresh_chart("month");
    get_energy_column_refresh_chart("es_day_saving_pie");
    get_energy_column_refresh_chart("es_month_saving_pie");
}
function get_data_and_refresh_all_charts(isStandardStation){
    get_data_and_refresh_ac_dc_charts();
    if(!isStandardStation){
        get_data_and_refresh_two_stations_charts();
    }
}
