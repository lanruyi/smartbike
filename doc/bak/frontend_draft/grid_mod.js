/**
 * Grid theme for Highcharts JS
 * @author Torstein Hønsi
 */

Highcharts.theme = {
	original
	colors: ['#50B432', '#058DC7', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
	orange
	colors: ['#fa7238', '#058DC7', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
	colors: ['#a7e1e1', '#fec47b', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
	colors: ['#d76618','#1d476f','#99dddd', '#ffbb66', 'ee3344', '#66dd88','#887766','007788','#006677'],//'e49762','66829d'],
	// light blue_0,yellow_1,red_2,green_3,coffee_4,blue_5, blue-green_6, orange_7, purple_8
   	title: {
		style: {
			color: '#000',
			font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
		}
	},
	xAxis: {
		gridLineWidth: 1
		plotBands: [{
			color:,
			dashStyle:,
			width:,
			value:,
			zIndex:
		}]
	},
	yAxis: {
		minorTickInterval: 'auto',
		minorGridLineWidth: 0.6,
		gridLineWidth: 1,
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'Trebuchet MS, Verdana, sans-serif'
			}
		}
	},
	legend: {
		itemStyle: {
			font: '9pt Trebuchet MS, Verdana, sans-serif'
		},
		itemHoverStyle: {
			//color: '#039'
		},
		itemHiddenStyle: {
			//color: 'gray'
		}
	}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
