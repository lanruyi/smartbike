/********************************
Fast JJump 
..\..\..\application\views\frontend\stations\station_mstatistic.php

********************************/


function draw_project_statistic(){
	 	var options = {
            chart: { renderTo: 'es_project_statistic', type: 'column', zoomType: 'x', height: 200, marginRight: 0, marginLeft: 40},
	 		title: { text: '项目所有基站 月AC节能图(kWh)', align: 'left', x: 0, margin: 20 },
	 		xAxis: { type: 'datetime', tickPixelInterval: 100 },
	 		yAxis: { title: { text: '' } },     	 		
	 		plotOptions: { column: { cursor: 'pointer', pointPadding: 0.25} },
	 		tooltip: {
	 			formatter: function(){
	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%m月%e日%H点', this.x)+'<br> '+this.y+'kWh';
	 			}
	 		},
            legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 100, x: 0 },
    		series: [{ name: '日AC节能量', data: [], color: Highcharts.getOptions().colors[0] }]
	 	};  	
	 	window.es_project_statistic = new Highcharts.Chart( options );
}

function draw_load_building(){
	 	var options = {
            chart: { renderTo: 'es_load_building', type: 'column', zoomType: 'x', height: 200, marginRight: 0, marginLeft: 40},
	 		title: { text: '各类型基站 月AC平均节能对比图(kWh)', align: 'left', x: 0, margin: 20 },
	 		xAxis: { categories: ['20-30A','30-40A','40-50A','50-60A','60-70A','70A+'] },
	 		yAxis: { title: { text: '' } },     	 		
	 		plotOptions: { column: { cursor: 'pointer', groupPadding: 0.35, pointPadding:0.2 } },
	 		tooltip: {
	 			formatter: function(){
	 				return '<b>'+ this.x + ' ' + this.series.name +'</b><br/>'+ '月AC平均节能' + this.y+'kWh';
	 			}
	 		},
            legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 70, x: 0 },
    		series: [{ name: '砖墙', data: [], color: Highcharts.getOptions().colors[1] },
    				 { name: '彩钢板', data: [], color: Highcharts.getOptions().colors[2] }]
	 	};  	
	 	window.es_load_building = new Highcharts.Chart( options );
}





