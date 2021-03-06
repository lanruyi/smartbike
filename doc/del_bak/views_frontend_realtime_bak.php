﻿<style type="text/css">
            /* css for datepicker */
            #ui-datepicker-div, .ui-datepicker{ font-size: 90%; margin:0px;}

            /* css for timepicker */
            .ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
            .ui-timepicker-div dl { text-align: left; text-indent: 5px;}
            .ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
            .ui-timepicker-div dl dd { margin: 0 10px 10px 45px; }
            .ui-timepicker-div td { font-size: 90%; }
            .ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
            .chart {margin:10px 0;}

/* Subnav */
.subnav {
  width: 100%;
  height: 32px;
  margin:0 0 8px 0;
  padding:0;
  background-color: #eeeeee; /* Old browsers */
  background-repeat: repeat-x; /* Repeat the gradient */
  background-image: -moz-linear-gradient(top, #f5f5f5 0%, #eeeeee 100%); /* FF3.6+ */
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f5f5f5), color-stop(100%,#eeeeee)); /* Chrome,Safari4+ */
  background-image: -webkit-linear-gradient(top, #f5f5f5 0%,#eeeeee 100%); /* Chrome 10+,Safari 5.1+ */
  background-image: -ms-linear-gradient(top, #f5f5f5 0%,#eeeeee 100%); /* IE10+ */
  background-image: -o-linear-gradient(top, #f5f5f5 0%,#eeeeee 100%); /* Opera 11.10+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f5f5', endColorstr='#eeeeee',GradientType=0 ); /* IE6-9 */
  background-image: linear-gradient(top, #f5f5f5 0%,#eeeeee 100%); /* W3C */
  border: 1px solid #e5e5e5;
  -webkit-border-radius: 0 0 0 8px;
     -moz-border-radius: 0 0 0 8px;
          border-radius: 0 0 0 8px;
}
.subnav .nav {
  margin-bottom: 0;
}
.subnav .nav > li > a {
  margin: 0;
  padding-top:    8px;
  padding-bottom: 8px;
  -webkit-border-radius: 0;
     -moz-border-radius: 0;
          border-radius: 0;
}
.subnav .nav > .active > a,
.subnav .nav > .active > a:hover {
  padding-left: 13px;
  color: #777;
  background-color: #e9e9e9;
  border-right-color: #ddd;
  border-left: 0;
  -webkit-box-shadow: inset 0 3px 5px rgba(0,0,0,.05);
     -moz-box-shadow: inset 0 3px 5px rgba(0,0,0,.05);
          box-shadow: inset 0 3px 5px rgba(0,0,0,.05);
}
.subnav .nav > .active > a .caret,
.subnav .nav > .active > a:hover .caret {
  border-top-color: #777;
}
.subnav .nav > li:first-child > a,
.subnav .nav > li:first-child > a:hover {
  padding: 12px 12px 12px 32px;
  font-size:16px;
  background:#fc9 url('/static/site/img/light-green.png') no-repeat 14px 15px;
  -webkit-border-radius: 0 0 8px 8px; 
     -moz-border-radius: 0 0 8px 8px; 
          border-radius: 0 0 8px 8px;
}
.subnav .nav > li:last-child > a {
}
.subnav .nav > li > a >font {
    font-size:12px;
}
.subnav .dropdown-menu {
  -webkit-border-radius: 0 0 4px 4px;
     -moz-border-radius: 0 0 4px 4px;
          border-radius: 0 0 4px 4px;
}

.subnav .nav .divider-vertical{
  width:0px;
  height:32px;
  border-right: 1px solid #f5f5f5;
  border-left: 1px solid #e5e5e5;
}


</style>

<div class="subnav">
    <div class="container-fluid">
        <ul class="nav nav-pills">
          <li class="dropdown active"  id="es_station_sel">
            <a  data-toggle="dropdown" class="btn" href="#">
                &nbsp; <font>请选择站点</font> 
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
            <?php foreach ($stations as $station):?>
                <li><a station_id="<?= $station['id']?>" href="#"><?= $station['name_chn']?></a></li>
            <?php endforeach ?>
            </ul>
          </li>

          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="modal" href="#time_Modal" id="es_time_modal_button" style="background:url('/static/site/img/icon-clock.png') no-repeat 14px center;padding-left:26px">&nbsp;
                <font>请选择时间</font>
                <b class="caret"></b></a>
          </li>
          <li class="divider-vertical"></li>
          <li class="dropdown" id="es_rt_sel">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <font>实时(1分)</font> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#" rt="3600"> 实时(1小时) </a></li>
              <li><a href="#" rt="300"> 实时(5分钟) </a></li>
              <li><a href="#" rt="60"> 实时(1分钟) </a></li>
              <li><a href="#" rt="5"> 实时(5秒) </a></li>
              <li><a href="#" rt="0"> 非实时 </a></li>
            </ul>
          </li>
          <li class="divider-vertical"></li>
          <li class="dropdown" id="es_warn_sel">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <font>警报</font> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#" rt="5"> 警报 </a></li>
              <li><a href="#" rt="0"> 无警报 </a></li>
            </ul>
          </li>
          <li class="divider-vertical"></li>
          <li><a id="es_refresh" href="javascript:void(0)" ><font>刷新</font></a></li>
        </ul>
    </div>
</div>

<div class="container-fluid">



            
            <div id="time_Modal" class="modal hide" style="top: auto; left: auto; margin: 0 auto; width:685px">
                <div class="modal-header">
                  <a class="close" data-dismiss="modal">×</a>
                  <h3>显示时间选择</h3>
                </div>
                <div class="modal-body"  style="height:auto;">
                  <div id="es_time_title" style="color:white;background-color:#39f;width:652px;text-align:center;line-height:30px;"> 左边为简单时段选择(<b>实时</b>) 右边为自定义复杂时段选择(<b>非实时</b>)</div>
                  <div id="es_time_simple" style="float:left;background-color:#39f;width:100px;display:block;height:auto;text-align:center">
                      <div style="height:4px"></div>
                      <div style="width:100px;float:left" data-toggle="buttons-radio" id=es_last>
                        <button style="width:90px;margin-bottom:4px" class="btn active" value="3_hours">最近3小时</button>
                        <button style="width:90px;margin-bottom:4px" class="btn" value="1_day">最近1天</button>
                        <button style="width:90px;margin-bottom:4px" class="btn" value="7_days">最近1周</button>
                        <button style="width:90px;margin-bottom:4px" class="btn" value="1_month">最近1个月</button>
                        <button style="width:90px;margin-bottom:4px" class="btn" value="3_months">最近1季度</button>
                        <button style="width:90px;margin-bottom:4px" class="btn" value="1_year">最近1年</button>
                      </div>
                  </div>
                  <div id="es_time_complex" style="float:left;background-color:#fff;width:552px;display:block;height:auto;text-align:center">
                      <div style="height:4px"></div>
                      <div style="width:66px;float:left;" data-toggle="buttons-radio" id=es_dur>
                        <button style="width:60px;margin-bottom:4px" class="btn active" value="3_hours">3小时</button>
                        <button style="width:60px;margin-bottom:4px" class="btn" value="1_day">1天</button>
                        <button style="width:60px;margin-bottom:4px" class="btn" value="7_days">1周</button>
                        <button style="width:60px;margin-bottom:4px" class="btn" value="1_month">1个月</button>
                        <button style="width:60px;margin-bottom:4px" class="btn" value="3_months">1季度</button>
                        <button style="width:60px;margin-bottom:4px" class="btn" value="1_year">1年</button>
                      </div>
                      <div style="width:60px;float:left" data-toggle="buttons-radio" id=es_type>
                        <button style="width:50px;margin-bottom:4px" class="btn active" value="end">止于</button>
                        <button style="width:50px;margin-bottom:4px" class="btn" value="around">附近</button>
                        <button style="width:50px;margin-bottom:4px" class="btn" value="start">始于</button>
                      </div>
                      <div style="float:left; margin:0 3px 4px 0" id="es_date_picker"></div>
                      <div style="float:left;" id="es_time_picker"></div>
                   </div>
                </div>
                <div class="modal-footer">
                  <a href="#" data-dismiss="modal" class="btn btn-primary" id="es_refresh_chart">刷新图表</a>
                </div>
            </div><!--time_Modal-->





    <div class="row-fluid"> <!--chart row 1--> 
        <div class="span8"> 
            <div class="chart" id="es_temprature"></div>
            <div class="chart" id="es_humidity"></div>
            <div class="chart" id="es_colds_0_on"></div>       
            <div class="chart" id="es_fan_0_on"></div>
        </div>
    </div>

</div>


		<script type="text/javascript" src="/static/site/js/frontend_chart_basic.js?id=7"></script>
		<script type="text/javascript">
		// Json struct for different params. Initial: current_time, last 3_hours
			window.global_options = {
				"station_id": "1",
				"dur": "3_hours",
				"type": "last",
                "time": "",
                "rt":"60"
            }
			window.display_options = {
				"station_id": "1",
				"dur": "",
				"type": "",
                "es_date_picker": "",
                "es_time_picker": ""
            }
            


            $(document).ready(function(){

                function get_data_and_refresh_all_charts(){
                    get_data_and_refresh_chart("es_temprature");
                    get_data_and_refresh_chart("es_humidity");
                    get_data_and_refresh_chart("es_colds_0_on");
                    get_data_and_refresh_chart("es_fan_0_on");
                }

                //默认站点按钮为当前站点
                $('#es_station_sel a font').html(
                    $('#es_station_sel ul li').children("a[station_id='"+window.global_options.station_id+"']").html()
                );
                
                //默认实时按钮为当前实时设置
                $('#es_rt_sel a font').html(
                    $('#es_rt_sel ul li').children("a[rt='"+window.global_options.rt+"']").html()
                );

                //绑定站点选择
                $('#es_station_sel ul li').each(function(){
                    $(this).click(function(){
                        $('#es_station_sel a font').html($(this).children("a").html());
                        window.global_options.station_id = $(this).children("a").attr("station_id");
                        get_data_and_refresh_all_charts();
                    });
                });
                
                //绑定实时选择
                $('#es_rt_sel ul li').each(function(){
                    $(this).click(function(){
                        $('#es_rt_sel a font').html($(this).children("a").html());
                        window.global_options.rt = $(this).children("a").attr("rt");
                        get_data_and_refresh_all_charts();
                    });
                });

                $("#es_refresh").click(function(){get_data_and_refresh_all_charts()});

                $('#es_date_picker').datepicker({
                    dateFormat: "yymmdd",
                    inline: true,
                    timezone: '+8000',
                    onSelect: function(datetimeText, instance){
                        //window.display_options.es_date_picker = datetimeText;
                    }
                });
                $('#es_time_picker').timepicker({
                    showTime:false,
                    timeFormat: "hhmmss",
                    showButtonPanel: false,
                    inline: true,
                    timezone: '+8000',
                    hourGrid: 4,
                    minuteGrid: 10,
                    onSelect: function(datetimeText, instance){
                        //window.display_options.es_time_picker = datetimeText;
                    }
                });
                var _now = new Date();
                $('#es_date_picker').datepicker('setDate',_now);//
                $('#es_time_picker').timepicker('setTime',_now);//

                set_display_options_from_global();

                
                if(window.display_options.type === "last")
                {
                    set_es_last(window.display_options.dur);
                    $("#es_time_simple").css({"background-color":"#39f"});   
                    $("#es_time_complex").css({"background-color":"#fff"});   
                }else{
                    set_es_type(window.display_options.type);
                    set_es_dur(display_options.dur);
                    $('#es_date_picker').datepicker( "setDate" , display_options.es_date_picker );//.datepicker // 设定日期 = global_options.es_date_picker
                    $('#es_time_picker').timepicker( "setTime" , display_options.es_time_picker );//.timepicker // 设定时间 = global_options.es_time_picker
                    $("#es_time_complex").css({"background-color":"#39f"});   
                    $("#es_time_simple").css({"background-color":"#fff"});   
                }
                
                $("#es_time_modal_button font").html(generate_time_str_for_button_from_display_options());

                //todo: 点完 刷新图表 按钮 更新global_options
                $("#es_refresh_chart").click(function(){
                    if(window.display_options.type === "last")
                    {
                      display_options.dur = get_es_last();
                    }else{
                        window.display_options.es_date_picker = new Date($('#es_date_picker').datepicker( "getDate")).format("yyyyMMdd");
                        window.display_options.es_time_picker = new Date($('#es_time_picker').datepicker( "getDate")).format("hhmmss");
                      display_options.dur = get_es_dur();
                      display_options.type = get_es_type(); 
                    }
                    $("#es_time_modal_button font").html(generate_time_str_for_button_from_display_options());
                    set_global_options_from_display();

                    get_data_and_refresh_all_charts();
                })

                $("#es_time_simple").click(function(){
                  display_options.type = "last"; 
                  $("#es_time_simple").css({"background-color":"#39f"});   
                  $("#es_time_complex").css({"background-color":"#fff"});   
                })

                $("#es_time_complex").click(function(){
                  display_options.type = "end"; 
                  $("#es_time_complex").css({"background-color":"#39f"});   
                  $("#es_time_simple").css({"background-color":"#fff"});   
                })

                init_highcharts();

                draw_chart("es_temprature");
                draw_chart("es_humidity");
                draw_chart("es_colds_0_on");
                draw_chart("es_fan_0_on");
                
                get_data_and_refresh_all_charts();
                window.basic_cycle = 0; 

                setInterval(function(){
                    window.basic_cycle += 1;
                    if(window.global_options.rt > 0){ 
                        if(window.basic_cycle % (window.global_options.rt/5) == 0){
                            get_data_and_refresh_all_charts();
                        }
                    }
                    if (window.basic_cycle >= 7200){window.basic_cycle = 0}
                },1000*5);


			});


		</script>
        
<script src="/static/hicharts/highcharts.js"></script>
<script src="/static/hicharts/modules/exporting.js"></script>




