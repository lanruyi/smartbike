/********************************
Fast JJump 
..\..\..\application\views\frontend\station\month.php

********************************/

function draw_chart( chart_type ) {
    switch(chart_type){
    	 case "es_temprature":
    	 	var options = {
    	 		chart: { renderTo: 'es_temprature', type: 'line', zoomType: 'x', height: 190, marginRight: 0, marginLeft: 25 },
    	 		title: { text: '天气预报(°C)', align:'left', x: 0, margin: 20 },
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
    	 				marker: { radius: 0.01, fillColor: '#fff', lineWidth: 0.5, lineColor: '#333'	}
    	 			}
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e', this.x)+' '+this.y+'°C';
    	 			}
    	 		},
    	 		legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 100, x: 10 },
        		series: [{ name: '预报最高温度', data: [], color: Highcharts.getOptions().colors[0] },
                        { name: '预报最低温度', data: [], color: Highcharts.getOptions().colors[1] }]
    	 	};
            window.es_temprature_chart = new Highcharts.Chart( options );
            break;

    }
}


function draw_chart_es_switchon_num_chart(){
	 	var options = {
            chart: { renderTo:'es_switchon_num', type:'column', zoomType:'x', height:200, marginRight:0, marginLeft:40},
	 		title: { text: '各设备开关次数(/天)', align:'left', x: 0, margin: 20 },
	 		xAxis: { type: 'datetime', tickPixelInterval: 100 },
	 		yAxis: { title: { text: '' } },     	 		
	 		plotOptions: { column: { cursor: 'pointer', pointPadding: 0.1, groupPadding: 0.1 } },
	 		tooltip: {
	 			formatter: function(){
	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%m月%e日', this.x)+'<br> '+this.y+'次';
	 			}
	 		},
            legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 120, x: 10 },
    		series: [{ name: '新风开关次数', data: [], color: Highcharts.getOptions().colors[0]},
                { name: '空调1开关次数', data: [], color: Highcharts.getOptions().colors[1]},
                { name: '空调2开关次数', data: [], color: Highcharts.getOptions().colors[2]}]
	 	};        
        window.es_switchon_num_chart = new Highcharts.Chart( options );
}


function draw_chart_es_switchon_time_chart(){
	 	var options = {
            chart: { renderTo:'es_switchon_time', type:'column', zoomType:'x', height:200, marginRight:0, marginLeft:40},
	 		title: { text: '各设备开机时间(/天)', align:'left', x: 0, margin: 20 },
	 		xAxis: { type: 'datetime', tickPixelInterval: 100 },
	 		yAxis: { title: { text: '' } },     	 		
	 		plotOptions: { column: { cursor: 'pointer', pointPadding: 0.1, groupPadding: 0.1 } },
	 		tooltip: {
	 			formatter: function(){
	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%m月%e日', this.x)+'<br> '+h_num_to_str(this.y);
	 			}
	 		},
            legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 120, x: 10 },
    		series: [{ name: '新风开机时间', data: [], color: Highcharts.getOptions().colors[0]},
                { name: '空调1开机时间', data: [], color: Highcharts.getOptions().colors[1]},
                { name: '空调2开机时间', data: [], color: Highcharts.getOptions().colors[2]}]
	 	};        
        window.es_switchon_time_chart = new Highcharts.Chart( options );
}

function draw_chart_es_energy_column_chart(){
	 	var options = {
            chart: { renderTo:'es_energy_column', type:'column', zoomType:'x', height:200, marginRight:0, marginLeft:40},
	 		title: { text: '能耗图(kWh)', align:'left', x: 0, margin: 20 },
	 		xAxis: { type: 'datetime', tickPixelInterval: 100 },
	 		yAxis: { title: { text: '' } },     	 		
	 		plotOptions: { column: { cursor: 'pointer', pointPadding: 0.1, groupPadding: 0.1 } },
	 		tooltip: {
	 			formatter: function(){
	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%m月%e日%H点', this.x)+'<br> '+this.y+'kWh';
	 			}
	 		},
            legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 95, x: 10 },
    		series: [{ name: '每天总能耗', data: [], color: Highcharts.getOptions().colors[0]},
                { name: '每天DC能耗', data: [], color: Highcharts.getOptions().colors[1]},
                { name: '每天AC能耗', data: [], color: Highcharts.getOptions().colors[2]}]
	 	};        
        window.es_energy_column_chart = new Highcharts.Chart( options );
}

function draw_chart_es_energy_saving_column_chart(station_type){
	 	var options = {
            chart: { renderTo:'es_energy_saving_column', type:'column', zoomType:'x', height:200, marginRight:0, marginLeft:25},
	 		title: { text: ' ', align:'left', x: 0, margin: 20 },
	 		xAxis: { type: 'datetime', tickPixelInterval: 100 },
	 		yAxis: { title: { text: '' } },     	 		
	 		plotOptions: { column: { cursor: 'pointer', pointPadding: 0.1, groupPadding: 0.1 } },
	 		tooltip: {
	 			formatter: function(){
	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%m月%e日%H点', this.x)+'<br> '+this.y+'kWh';
	 			}
	 		},
            legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 120, x: 10 },
    		series: [{ name: '标准站每天AC', data: [], color: Highcharts.getOptions().colors[0]},
                { name: '节能站每天AC', data: [], color: Highcharts.getOptions().colors[1]}]
	 	};      
        if(station_type == 3){
            options.series[0].name = '基准日每天AC';
            options.series[1].name = '节能日每天AC';
        }
        window.es_energy_saving_column_chart = new Highcharts.Chart( options );
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
                    verticalAlign: 'middle',
                    width: 80,
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
        title: { text: '月AC/DC能耗比', align:'right' },
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


function draw_chart_es_saving_pie(){
    var options = {
        chart: { renderTo: 'es_saving_pie', type: 'pie', height: 150 },
        title: { text: '月AC节能率', align:'right' },
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
                    data: [{ name: 'AC耗能', color: Highcharts.getOptions().colors[0] },
                    { name: '节约', color: Highcharts.getOptions().colors[1]}],
                          showInLegend: true
                }]
    };                  		
    window.es_saving_pie_chart = new Highcharts.Chart( options );
}


function h_num_to_str(minutes){
	var hours = parseInt(minutes/60);
	var mins = minutes%60;
	var str = "";
	if(hours){ str += hours+"小时"; }
	if(mins){ str+= mins+"分"; }
	return str;
}


