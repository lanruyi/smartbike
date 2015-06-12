<script>

document.onkeydown = function(e){
	if(!e) e=window.event;
	if(e.keyCode==13 || e.which==13){
		document.getElementById("confirm_s").click();
	}
}
$(function(){ $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'}); })
</script>


<div class = "base_center">

    <div style="margin:0;width:100%">
    <font>后台 >> 基站列表</font>
    </div>

<div style="border:1px solid #797;background-color:#beb;padding:5px;margin:10px;display:none">
<li><b>通知</b>(<b>7月01日</b>)：</li>
<li>
    服务器更新日志搬迁到小工具一栏的“更新日志”中，最近一次更新为7月01日
</li>
</div>

<form id="filter" method="get" action="">
<div class='filter'>
    搜索站名: <input type="text" name="search" value="<?= $this->input->get('search') ?>" style="width:160px" >
    基站ID: <input type="text" name="station_ids" value="<?= $this->input->get('station_ids') ?>" style="width:160px" >
    创建时间:<input type="text" name="create_start_time" style="width:110px" id="create_start_time" value="<?= $this->input->get('create_start_time') ?>"> 
    到:<input type="text" name="create_stop_time" style="width:110px"  id="create_stop_time" value="<?= $this->input->get('create_stop_time') ?>"> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
    <br>
    项目:<?= h_make_select(h_array_2_select($projects),'stations#project_id',$this->input->get('stations#project_id')); ?>
    城市:<?= h_make_select(h_array_2_select($cities),'stations#city_id',$this->input->get('stations#city_id')); ?>
    区县:<?= h_make_select(h_array_2_select($districts),'stations#district_id',$this->input->get('stations#district_id')); ?>
    负载:<?= h_make_select(h_station_total_load_array(),'stations#total_load',$this->input->get('stations#total_load')); ?>
    建筑:<?= h_make_select(h_station_building_array(),'stations#building',$this->input->get('stations#building')); ?>
    基站类型:<?= h_make_select(h_station_station_type_array(),'stations#station_type',$this->input->get('stations#station_type'));?>
    空调：<?= h_make_select(array("1"=>"1台","2"=>"2台"),"stations#colds_num",$this->input->get('stations#colds_num')); ?>
    <br>
    基站状态:<?= h_make_select(h_station_status_array(),'stations#status',$this->input->get('stations#status')); ?>
    在线:<?= h_make_select(h_alive_array(),'stations#alive',$this->input->get('stations#alive'),"全部",58);?>
    隐藏：<?= h_make_select(h_station_frontend_visible_array(), 'stations#frontend_visible',$this->input->get('stations#frontend_visible'),"全部",58) ?>
    Rom:<?= h_make_select(h_array_2_select($roms,"version"),'stations#rom_id',$this->input->get('stations#rom_id')); ?>
    恒温柜安装: <?= h_make_select(h_station_have_box_array(), 'stations#have_box',$this->input->get('stations#have_box'),"全部",58) ?>
    恒温柜类型: <?= h_make_select(h_station_box_filter_array(), 'stations#box_type',$this->input->get('stations#box_type'),"全部",58) ?>
    分期：<?= h_make_select(h_array_2_select($batches),"stations#batch_id",$this->input->get('stations#batch_id'),"全部",180); ?><br>
    督导:<?= h_make_select(h_array_2_select($creators),'stations#creator_id',$this->input->get('stations#creator_id'),"全部",72); ?>
    无线模块：<?= h_3g_module_select(h_3g_module_array(),'stations#3g_module',$this->input->get('stations#3g_module'),"全部",$width=100)?>
    有额外交流：<?= h_make_select(h_station_extra_ac_func_array(),'stations#extra_ac',$this->input->get('stations#extra_ac'),"全部",58);?>
    风机：<?=  h_make_select(h_station_air_volume_array(),'stations#air_volume', $this->input->get('stations#air_volume'),"全部",72)?>
    验收名：<input type="text" name="change_name_chn" value="<?=$this->input->get('change_name_chn')?>" style="width: 100px">
    设置锁定：<?= h_make_select(h_station_yes_or_no_array(),'stations#setting_lock',$this->input->get('stations#setting_lock'),"全部",58);?>
    高温远程重启：<?= h_make_select(h_station_yes_or_no_array(),'stations#temp_high_reboot',$this->input->get('stations#temp_high_reboot'),"全部",58);?>
    <br>
    基站设置过滤:
    s17.系统模式: <input type="text" name="esgconfs#sys_mode" value="<?= $this->input->get('esgconfs#sys_mode') ?>" style="width:40px" >
    s18.简单控制: <input type="text" name="esgconfs#simple_control" value="<?= $this->input->get('esgconfs#simple_control') ?>" style="width:40px" >
    <br>
    数据清洗过滤: <input name="no_batch" type="checkbox" <?= $this->input->get('no_batch')?"checked":""?>/>&nbsp;无分期站点&nbsp;&nbsp;&nbsp;&nbsp;
                  <input name="has_batch" type="checkbox" <?= $this->input->get('has_batch')?"checked":""?>/>&nbsp;有分期站点&nbsp;&nbsp;&nbsp;&nbsp;
    <br>
</div>
<div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
        <a href="/backend/station/slist" class="btn btn-primary">清除查询</a>
        <font style="display:inline-block;padding:4px 10px; font-size:13px; line-height:18px; vertical-align:middle;">
            <?= $filter_num_str?></font>
        
        <p style="float:right">
            <a href="/backend/station/clearStationStatus" class="btn btn-primary" title="有分期的->运营站点 无分期的->新建站点">更新基站状态</a>
            <a href="javascript:void(0)" id="save_csv" class="btn btn-primary">导出xls</a>
            <a href="javascript:void(0)" id="save_bug_csv" class="btn btn-primary">导出站点故障</a>
            <a href="/backend/station/display_abnormal_station" class="btn btn-primary">显示不正常基站</a>
            <a href="/backend/station/recycle_station_list" class="btn btn-inverse"> <i class="icon-trash icon-white"></i> 回收基站列表 </a>
        </p>
</div>
</form>

</div>



<div class = "base_center">
<form method="post" action="" id="batch_oper_form">  
    <div style="float:right;cursor: pointer;">
        <a onclick="select_all((this),'station_ids[]')" style="margin-right:5px;"> 全选 </a>
        <a onclick="select_none((this),'station_ids[]')" style="margin-right:5px;"> 全不选 </a>
        <a onclick="invert((this),'station_ids[]')" style="margin-right:5px;"> 反选 </a> 
        <input type="submit" onclick="batch_setting()" value="批量设置" />
        <input type="submit" onclick="batch_update_rom()" value="批量更新固件" />
    </div>
<div style="clear:right;"><?= $pagination ?></div>
<?php foreach ($stations as $key=>$station): ?>
    <?$this->load->view("backend/onestation",array('station'=>$station,));?>
<?php endforeach?>
</form>
<div style="clear:left;"><?= $pagination ?></div>

</div>

<script type="text/javascript">
    function batch_setting(){
        document.getElementById('batch_oper_form').action = "/backend/esgconf/batch_setting";
        document.getElementById('batch_oper_form').submit();
    }
    function batch_update_rom(){
        document.getElementById('batch_oper_form').action = 
            "/backend/rom_update/batch_update_rom?backurlstr=<?= $backurlstr?>";
        document.getElementById('batch_oper_form').submit();
    }
    
    function invert(obj,name){
        var checkboxs = document.getElementsByName(name);
        for(var i=0;i<checkboxs.length;i++){
            if(checkboxs[i].checked == true){
                checkboxs[i].checked = false;
            }else{
                checkboxs[i].checked = true;
            }
        }
    }
    function select_all(obj,name){
        var checkboxs = document.getElementsByName(name);
        for(var i=0;i<checkboxs.length;i++){
                checkboxs[i].checked = true;
        }        
    }
    function select_none(obj,name){
        var checkboxs = document.getElementsByName(name);
        for(var i=0;i<checkboxs.length;i++){
                checkboxs[i].checked = false;
        }        
    }  
</script>

<script>
    $(function(){
        $("#save_csv").click(function(){
            document.getElementById('filter').action = "/backend/station/save_csv";
            document.getElementById('filter').submit();
        });
        $("#save_bug_csv").click(function(){
            document.getElementById('filter').action = "/backend/station/save_csv/bug";
            document.getElementById('filter').submit();
        });
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/backend/station/slist";
            document.getElementById('filter').submit();
        });


        //ajax更新城市->区域
        $("#city_id").change(function(){
            var obj = $(this);
            $.ajax({
                type: "GET",
                data: "city_id="+obj.val(), 
                url: "/backend/area/ajax_get_districts",
                dateType: "json",                  
                success: function(data){
                    var jsondata=eval("("+data+")");
                    var str="";
                    for(var i=0;i<jsondata.length;i++){
                        str+="<option value="+jsondata[i].id+">"+jsondata[i].name_chn+"</option>";
                    }
                    $("#district_id").html(str);
                },
                error:function(){
                }
            })
        })
    });
</script>
