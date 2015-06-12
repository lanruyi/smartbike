/**
 * Grid theme for Highcharts JS
 * @author Torstein Hønsi
 */

Highcharts.theme = {
	colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
   	title: {
		style: {
			color: '#000',
			font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
		}
	},
	xAxis: {
		gridLineWidth: 1
		// plotBands: [{
			// color:,
			// dashStyle:,
			// width:,
			// value:,
			// zIndex:
		// }]
	},
	yAxis: {
		minorTickInterval: 'auto',
		minorGridLineWidth: 0.6,
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
