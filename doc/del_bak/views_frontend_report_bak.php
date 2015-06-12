<style type="text/css">
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
  padding: 10px 10px 10px 32px;
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

        <div class="span2">
            <div class="nav_model" id="nav_model">
            	<div class="well" style="padding: 8px 0;">
		        	<ul class="nav nav-list">
		          		<li class="active"><a href="/datam"><i class="icon-white icon-home"></i> HOME </a></li>
		         		<li class="nav-header">站点能耗 </li>
		           		<li><a href="#"><i class="icon-book"></i> >80A </a></li>
		         	 	<li><a href="#"><i class="icon-pencil"></i> 40-60A </a></li>
		         	 	<li><a href="#"><i class="icon-pencil"></i> 20-30A </a></li>

		        	  	<li class="divider"></li>
		        	  	<li><a href="#"><i class="icon-cog"></i> 设置 </a></li>
		         	 	<li><a href="#"><i class="icon-flag"></i> 帮助 </a></li>
					</ul>
      			</div>
            </div>
        </div>
        <div class="span10">
            	<div class="nav_content" id="nav_content">
            	<div class="tabbable tabs-top">
            		<ul class="nav nav-tabs">
            			<li class="active"><a href="#A" data-toggle="tab">section A</a></li>
            			<li><a href="#B" data-toggle="tab">section B</a></li>
            			<li><a href="#C" data-toggle="tab">section C</a></li>
            		</ul>
            		<div class="tab-content">
            			<div class="tab-pane active" id="A">
							<table class="table table-bordered">
							  <thead>
							    <tr>
							      <th rowspan="2">#站点id</th>
							      <th colspan="4">新风</th>
							      <th colspan="4">空调</th>
							    </tr>
							    <tr>
							      <th>No.</th>
							      <th>工作时间</th>	
							      <th>曲线</th>
							      <th>饼图</th>
							      <th>No.</th>
							      <th>工作时间</th>
							      <th>曲线</th>
							      <th>饼图</th>				    	
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <td rowspan="2">1</td>
							      <td>1</td>
							      <td>5</td>
							      <td id="xf_line">
									<!-- <span class="xf_sparkline1" sparkType="bar" sparkBarColor="green"> 1,3,4,2 </span> -->
									<!-- <span class="xf_sparkline1" values="1,3,4,2"></span> -->
									<span class="xf_sparkline1"></span>
							      </td>
							      <td id="xf_pie">
									<span class="xf_sparkline2"></span>
							      </td>
							      <td>1</td>
							      <td>2</td>
							      <td id="kt_line">
									<span class="kt_sparkline1"></span>
								  </td>
							      <td id="kt_pie">
							      	<span class="kt_sparkline2"></span>
							      </td>		
							      		      
							    </tr>
							     <tr>
							      <td>1</td>
							      <td>5</td>
							      <td id="xf_line">
									<!-- <span class="xf_sparkline1" sparkType="bar" sparkBarColor="green"> 1,3,4,2 </span> -->
									<!-- <span class="xf_sparkline1" values="1,3,4,2"></span> -->
									<span class="xf_sparkline1"></span>
							      </td>
							      <td id="xf_pie">
									<span class="xf_sparkline2"></span>
							      </td>
							      <td>1</td>
							      <td>2</td>
							      <td id="kt_line">
									<span class="kt_sparkline1"></span>
								  </td>
							      <td id="kt_pie">
							      	<span class="kt_sparkline2"></span>
							      </td>		
							      		      
							    </tr>
							  </tbody>
							</table>
						</div><!--tab-pane A-->
			          	<div class="tab-pane" id="B">
			          		<p>I'm in Section B.</p>
			         	</div>
			         	<div class="tab-pane" id="C">
			          		<p>this is Section C.</p>
			          	</div>
            		</div><!--tab-content-->
            	</div><!--tabbable-->
            </div><!--nav_content-->
        </div><!--span10-->

    </div><!--main row-->


</div>

    <script type="text/javascript" src="/static/jquery/jquery.sparkline.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			// $('.xf_sparkline1').sparkline('html', { enableTagOptions: true });
			// $('.xf_sparkline1').sparkline('html', {type:'bar', barColor: 'green'});
			//$.fn.sparkline.defaults.bar.barcolor = 'green';
			
			bullet_values=[14,7,16];
			pie_values=[4,4,2];
			$('.xf_sparkline1').sparkline(bullet_values,{type:'bullet'});
			$('.xf_sparkline2').sparkline(pie_values,{type:'pie'});
			$('.kt_sparkline1').sparkline(bullet_values,{type:'bullet'});
			$('.kt_sparkline2').sparkline(pie_values,{type:'pie'});
		});
    </script>
