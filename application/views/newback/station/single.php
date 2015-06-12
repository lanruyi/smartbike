<?if(0){?> <!-- vim:set filetype=phtml: --> <?}?>
<?if(0){?> <!-- vimjumper ../back_header.php --> <?}?>
<?= $this->load->view('newback/back_header'); ?>

<style>
.line_hidden{display:none}
</style>


<!-- BEGIN station detail -->
<div class="row">
    <div class="col-xs-12 ">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet tabbable">
            <div class="portlet-title" style="height:8px;">
            </div>
            <div class="portlet-body" style="padding:8px 0">
                <div class="row" >
                    <div class="col-xs-1"> <div class="pull-right"><b>项目</b></div> </div>
                    <div class="col-xs-2">
                        <?= $station['project']['name_chn']?>
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>城市</b></div> </div>
                    <div class="col-xs-2">
                        <?= $station['city']['name_chn']?>
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>档位</b></div> </div>
                    <div class="col-xs-2">
                        <?= h_station_total_load_name_chn($station['total_load'])?>
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>建筑</b></div> </div>
                    <div class="col-xs-2">
                        <?= h_station_building_name_chn($station['building']);?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-1"> <div class="pull-right"><b>负载</b></div> </div>
                    <div class="col-xs-2">
                        <?= $station['load_num'] ?>A
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>ESG</b></div> </div>
                    <div class="col-xs-2">
                        <?= $station['esg']['id'] ?>
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>电话</b></div> </div>
                    <div class="col-xs-2">
                        <?= $station['sim_num']?>
                    </div>
                    <div class="col-xs-1">
                        <div class="pull-right"><b>恒温柜</b></div>
                    </div>
                    <div class="col-xs-2">
                        <?= h_station_box_type_name_chn($station['box_type'])?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-1">
                        <div class="pull-right"><b>空调</b></div>
                    </div>
                    <div class="col-xs-2">
                        <?= $station['colds_num'] ?>台
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b>外温感</b></div>
                    </div>
                    <div class="col-xs-2">
                        <?= $station['equip_with_outdoor_sensor']==ESC_BEINGLESS?
                        "<font color=red><b>无</b></font>":"有"?>     
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b>风量</b></div>
                    </div>
                    <div class="col-xs-2">
                        <?= h_station_air_volume_name_chn($station['air_volume'])?>
                    </div>
                    <div class="col-xs-1">
                        <div class="pull-right"><b>督导</b></div>
                    </div>
                    <div class="col-xs-2">
                        <?= $station['creator'] ?$station['creator']['name_chn'] :"无记录"?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-1">
                        <div class="pull-right"><b>建站</b></div>
                    </div>
                    <div class="col-xs-2">
                        <?= h_dt_format($station['create_time'],"Y-m-d")?>
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b>电价</b></div>
                    </div>
                    <div class="col-xs-2">
                        <?= $station['price'] ?>
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b>分期</b></div>
                    </div>
                    <div class="col-xs-3">
                        <?= $station['batch']?$station['batch']['name_chn']:"无"?>
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b></b></div>
                    </div>
                    <div class="col-xs-1">

                    </div>
                </div>
            </div>
        </div>
        <!-- END Portlet PORTLET-->
    </div>
</div>
<!-- END station detail -->

<!-- BEGIN page body -->
<div class="row">
    <div class="col-xs-12">
        <div class="tabbable tabbable-custom boxless">
            <ul class="nav nav-tabs" id="func_tabs">
                <li class="active"><a href="#tab_info" data-toggle="tab">基本信息修改</a></li>
                <li class=""><a href="#tab_data" data-toggle="tab">数据列表</a></li>
                <li class=""><a href="#tab_save" data-toggle="tab">节能信息</a></li>
                <li class=""><a href="#tab_chart" data-toggle="tab">数据图表</a></li>
            </ul>
            <div class="tab-content">
                <!-- START TAB_INFO -->
                <div class="tab-pane active" id="tab_info">
                    <div class="row" >
                    </div>
                </div>
                <!-- END TAB_INFO -->

                <!-- START TAB_SAVE -->
                <div class="tab-pane" id="tab_save">
                    save
                    save
                </div>
                <!-- END TAB_SAVE -->

                <!-- START TAB_DATA -->
                <div class="tab-pane" id="tab_data" style="min-height:600px">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default" id="date-picker-display"> </button>
                                <button type="button" class="btn btn-info date"  id="date-picker" data-date="today">
                                    <i class="icon-calendar"></i>
                                </button>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default" id="hour-selector-display">  </button>
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><i class="icon-clock"></i>小时
                                </button>
                                <ul class="dropdown-menu" role="menu" id="hour-selector">
                                    <li><a href="javascript:void(0);" alt="all">00:00 - 23:59</a></li>
                                    <li class="divider"></li>
                                    <? foreach (range(0,23) as $t){?>
                                    <li><a href="javascript:void(0);" alt="<?= $t?>"> <?= sprintf('%02d',$t)?>:00 - <?= sprintf('%02d',$t)?>:59</a></li>
                                    <?}?>
                                </ul>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-primary" id="ajax_refresh"> 载入数据 </button>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="pull-right" >
                                <div class="btn-group btn-group-sm" data-toggle="buttons" id="show_type">
                                    <label class="btn btn-default active">
                                        <input type="radio" class="toggle" value="less"> 精简
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" class="toggle" value="more"> 完整
                                    </label>
                                </div>
                                <div class="btn-group btn-group-sm" data-toggle="buttons" id="compress">
                                    <label class="btn btn-default">
                                        <input type="radio" class="toggle" value=1> 不压缩
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" class="toggle" value=3> 压缩3
                                    </label>
                                    <label class="btn btn-default active">
                                        <input type="radio" class="toggle" value=9> 压缩9
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" class="toggle" value=15> 压缩15
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" class="toggle" value=31> 压缩31
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:12px">
                        <div class="col-xs-12">
                            <table class="table table-bordered table-striped table-condensed flip-content" style="font-size:13px" id="data_table"> 
                                <thead>
                                    <tr>
                                        <th>室温</th> 
                                        <th>外温</th>
                                        <th class="show_type_hidden">真实</th>
                                        <th>空调1</th> <th>空调2</th>
                                        <th>恒温柜</th> 
                                        <th class="show_type_hidden">恒温2</th> 
                                        <th class="show_type_hidden">恒温3</th> 
                                        <th class="show_type_hidden">内湿</th>
                                        <th class="show_type_hidden">外湿</th>
                                        <th>风</th>    
                                        <th>空1</th> 
                                        <th>空2</th>  
                                        <th class="show_type_hidden">恒</th>
                                        <th>总能耗</th> 
                                        <th>dc能耗</th>
                                        <th>总功率</th> 
                                        <th>dc功率</th> 
                                        <th style="width:140px">采样时间</th>
                                    </tr>
                                </thead>
                                <tbody id="data_table_contect">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="data_table_error">
                            </div>
                            <div id="data_table_loading">
                                <img src="/static/assets/img/loading.gif" alt="loading"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END TAB_DATA -->

                <!-- START TAB_CHART -->
                <div class="tab-pane" id="tab_chart">
                    chart
                    chart
                    chart
                    chart
                </div>
                <!-- END TAB_CHART -->
            </div>
        </div>
    </div>
</div>
<!-- END page body -->



<!-- vimjumper ../back_footer.php -->
<?= $this->load->view('newback/back_footer'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/static/assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<script src="/static/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/static/assets/scripts/app.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->  

<script>

var datas     = "";
var datetime  = new Date("<?= h_dt_format(h_dt_now(),"Y-m-d")?>");
var hour      = "all";
var compress  = 5;
var show_type = "less";
jQuery(document).ready(function() {    
    App.init();                // initlayout and core plugins

    $("#ajax_refresh").click(function(){ajax_load_data(true)});

    //小时数
    $('#hour-selector-display ').text($('#hour-selector a[alt='+hour+']').text());
    $('#hour-selector > li').on("click",function(){
        hour = $(this).children().attr("alt");
        var hour_disp = $(this).children().html();
        $('#hour-selector-display').html(hour_disp);
    });
    //日期 
    $('#date-picker-display').text(datetime.Format("yyyy-MM-dd")); 
    $('#date-picker').datepicker({ todayBtn:true}).on('changeDate',function(ev){
        datetime = new Date(ev.date);
        $('#date-picker-display').text(datetime.Format("yyyy-MM-dd"));
        $('#date-picker').datepicker('hide');
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    //压缩倍数
    $("#compress label").on('click',"",function(){
        compress = $(this.children).val();
        $.cookie('compress',compress,{expires: 7,path:'/newback/station/single'});
        $("tbody tr").addClass("line_hidden");
        $("tbody tr:nth-child("+compress+"n+1)").removeClass("line_hidden");
    });
    compress = ($.cookie('compress'))?($.cookie('compress')):"5";
    $("#compress input[value='"+compress+"']").click();
    //精简 or 完整
    $("#show_type label").on('click',"",function(){
        show_type = $(this.children).val();
        $.cookie('show_type',show_type,{expires: 7,path:'/newback/station/single'});
        show_type == "less" ? $(".show_type_hidden").hide():$(".show_type_hidden").show();
    });
    show_type = ($.cookie('show_type'))?($.cookie('show_type')):"less";
    $("#show_type input[value='"+show_type+"']").click();

    //当子页面模块被点击时
    $("#func_tabs").on('click',"a[href='#tab_data']",function(e){
        ajax_load_data();
    });
    $("#func_tabs a[href='"+$.cookie('func_tabs')+"']").click();
    $("#func_tabs").on('click',"a",function(e){
        $.cookie('func_tabs',$(this).attr("href"),{expires: 7,path:'/newback/station/single'});
    });



    //准备加载前 清空老内容 打开加载条
    function before_draw_data_table(){
        $("#data_table tbody").html(" ");
        $("#data_table_loading").show();
    }

    function draw_data_table_error(){
        $("#data_table tbody").html();
        $("#data_table tbody").html("Connection error");
        $("#data_table_loading").hide();
    }
    //加载
    function draw_data_table(){
        table_str="";
        var obj = jQuery.parseJSON(datas);

        function ds(a){return (a===undefined || a===null)?"":a;}
        $.each(obj,function(i,val){
            table_str+='<tr>';
            table_str+='<td>'+ds(val['indoor_tmp'])     +'</td>';
            table_str+='<td>'+ds(val['outdoor_tmp'])    +'</td>';
            table_str+='<td class="show_type_hidden">'+ds(val['true_tmp'])       +'</td>';
            table_str+='<td>'+ds(val['colds_0_tmp'])    +'</td>';
            table_str+='<td>'+ds(val['colds_1_tmp'])    +'</td>';
            table_str+='<td>'+ds(val['box_tmp'])        +'</td>';
            table_str+='<td class="show_type_hidden">'+ds(val['box_tmp_1'])      +'</td>';
            table_str+='<td class="show_type_hidden">'+ds(val['box_tmp_2'])      +'</td>';
            table_str+='<td class="show_type_hidden">'+ds(val['indoor_hum'])     +'</td>';
            table_str+='<td class="show_type_hidden">'+ds(val['outdoor_hum'])    +'</td>';
            table_str+='<td>'+ds(val['fan_0_on'])       +'</td>';
            table_str+='<td>'+ds(val['colds_0_on'])     +'</td>';
            table_str+='<td>'+ds(val['colds_1_on'])     +'</td>';
            table_str+='<td class="show_type_hidden">'+ds(val['colds_box_on'])   +'</td>';
            table_str+='<td>'+ds(val['energy_main'])    +'</td>';
            table_str+='<td>'+ds(val['energy_dc'])      +'</td>';
            table_str+='<td>'+ds(val['power_main'])     +'</td>';
            table_str+='<td>'+ds(val['power_dc'])       +'</td>';
            table_str+='<td>'+ds(val['create_time'])    +'</td>';
            table_str+='</tr>';
        })
        $("#data_table tbody").html();
        $("#data_table tbody").html(table_str);
        $("#data_table_loading").hide();
        show_type == "less" ? $(".show_type_hidden").hide():$(".show_type_hidden").show();
        $("tbody tr").addClass("line_hidden");
        $("tbody tr:nth-child("+compress+"n+1)").removeClass("line_hidden");
    }
    function ajax_load_data(){
        var is_refresh = arguments[0] ? arguments[0] : false;
        if(datas != "" && !is_refresh){ return; }
        before_draw_data_table();
        pageContentBody = $("#data_table");
        $.ajax({
            type: "GET",
            cache: true,
            url: "/ajax/data/single_json/<?= $station['id']?>/"+datetime.Format("yyyyMMdd")+"/"+hour,
            dataType: "html",
            success: function (res) {
                App.fixContentHeight(); // fix content height
                App.initAjax(); // initialize core stuff
                datas = res;
                draw_data_table();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                       datas = null;
                       draw_data_table_error();
                   },
            async: true 
        });
    }


});

</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>



