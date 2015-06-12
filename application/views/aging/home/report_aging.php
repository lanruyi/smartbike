<div class="base_center">

	<a href="<?= urldecode($this->input->get('backurl'))?>" class="btn">返回</a>
	<div id="es_temperature"></div><!--realtime temperatures-->
	<br />
	<a href=<?= "/aging/home/report_aging/".$esg['id']."/1?backurl=".urlencode($this->input->get('backurl')) ?> class="btn">刷新统计数据</a>&nbsp;&nbsp;
	<span><?= h_start_stop_time($esg)?></span>
	<div id="es_packets"></div><!--per hour packets-->
	<br />

</div>



<script type="text/javascript" src="/static/site/js/frontend_basic.js?id=<?= hsid()?>"></script>
<script src="/static/hicharts/highcharts.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		init_highcharts();
		draw_temperature();
		draw_packets();
		
		window.es_temperature_chart.series[0].setData(<?= $indoor_tmp?>);
		window.es_temperature_chart.series[1].setData(<?= $outdoor_tmp?>);
		window.es_temperature_chart.series[2].setData(<?= $indoor_hum?>);
		window.es_temperature_chart.series[3].setData(<?= $outdoor_hum?>);
		window.es_temperature_chart.series[4].setData(<?= $colds_0_tmp?>);
		window.es_temperature_chart.series[5].setData(<?= $colds_1_tmp?>);
		
	});
	
	function draw_temperature(){
    	 	var options = {
    	 		chart: { renderTo: 'es_temperature', type: 'line', zoomType: 'x', height: 400, marginRight: 0, marginLeft: 30 },
    	 		title: { text: '室内温度(°C)', align:'left', x: -10, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 100, gridLineWidth: 1 },
    	 		yAxis: {
    	 			title: { text: '' },
    	 			minorTickInterval: 'auto',
					minorGridLineWidth: 0.6,
					gridLineWidth: 1,    
					allowDecimals: false,	 			
    	 			plotLines: [{ value:35, color:'#ee3344', dashStyle: 'Dash', width: 1.2, zIndex: 1,label:{text: 'indoor base:35°C'} }]
    	 		},
    	 		plotOptions: {
    	 			line: { cursor: 'pointer'},
    	 			series: { marker: { radius: 0.01, fillColor: '#fff', lineWidth: 0.5, lineColor: '#333'} }
    	 		},
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%Y-%m-%e %H:%M:%S', this.x)+' '+this.y+'°C';
    	 			}
    	 		},
    	 		legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 80, x: 5 },
        		series: [{ name: '室内温度', data: [], color: Highcharts.getOptions().colors[0] },
        				{ name: '室外温度', data: [], color: Highcharts.getOptions().colors[3] },
        				{ name: '室内湿度', data: [], color: Highcharts.getOptions().colors[9] },
        				{ name: '室外湿度', data: [], color: Highcharts.getOptions().colors[5] },
        				{ name: '空调0温度', data: [], color: Highcharts.getOptions().colors[1] },
        				{ name: '空调1温度', data: [], color: Highcharts.getOptions().colors[2] },]
    	 	};
            window.es_temperature_chart = new Highcharts.Chart( options );		
	}
	
	function draw_packets(){
    	 	var options = {
    	 		chart: { renderTo: 'es_packets', type: 'column', zoomType: 'x', height: 200, marginRight: 0, marginLeft: 30 },
    	 		title: { text: '每小时丢包个数统计', align:'left', x: -10, margin: 20 },
    	 		xAxis: { type: 'datetime', tickPixelInterval: 200 },
    	 		yAxis: { title: { text: '' }, max: 60, min: 0, allowDecimals: false, tickInterval: 60 },
    	 		plotOptions: { column: { cursor: 'pointer', pointWidth: 4 } },
    	 		tooltip: {
    	 			formatter: function(){
    	 				return '<b>'+ this.series.name +' '+this.y+'个' + '</b><br/>' + Highcharts.dateFormat('%m月%e日%H点', this.x);
    	 			}
    	 		},
    	 		legend: { align: 'right', verticalAlign: 'top', borderWidth: 0, itemWidth: 80, x: 0 },
        		series: [{ name: '小时丢包数', data: [], color: Highcharts.getOptions().colors[0], dataLabels:{enabled:true} }]
    	 	};
            window.es_packets_chart = new Highcharts.Chart( options );		
	}
</script>
