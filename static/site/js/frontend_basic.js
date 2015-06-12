function init_highcharts(){
    Highcharts.setOptions({ 
        global: { 
                    useUTC: false 
                } ,
        colors: ['#d76618','#1d476f','#99dddd', '#ffbb66', 'ee3344', '#66dd88','#887766','#007788','#006677','#118811'],
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
    	 	}
    	}
    }); 
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

