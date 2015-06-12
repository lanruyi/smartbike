<style>
    .station_form{margin:0;padding:20px;overflow:hidden;}
    .station_form ul{overflow:hidden;padding:2px;list-style:none}
    .station_form ul li{float:left;list-style:none}
</style>
<div class="base_center">

    <div style="margin:0;width:100%">
    <font>后台 >> 数据修改 </font>
    </div>

    <? if(isset($station) && $station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>

    <div style="padding:5px;"> <span style="color:red">数据修改后无法恢复 请谨慎修改 </span> >> 
    </div>
<?php echo form_open("/backend/station/update_post?backurl=".urlencode($this->input->get('backurl')),array("class"=>"station_form_form")); ?>
<div class="station_form">
    <ul>
        <li>id:<input type="text" name="id" value="<?= $station['id']?>" readonly="readonly" /> </li>
        <li>基站名: <input type="text" name="name_chn" value="<?= $station['name_chn']?>" /> </li>
        <li>基站拼音: <input type="text" name="name_py" value="<?= $station['name_py']?>" /> </li>
        <li>状态: <?= h_station_status_select($station['status'],"") ?> </li>
    </ul>
    <ul>
        <li>esg_id: <input readonly type="text" name="esg_id" value="<?= isset($esg['id'])? $esg['id']:"" ?>" /> </li>
        <li>SIM卡号: <input type="text" name="sim_num" value="<?= $station['sim_num']?>" /> </li>
    </ul>
    <ul>
		<li>项目: 
		<select name='project_id' disabled>
			<?foreach ($projects as $project){?>
				<option value=<?= $project['id']?> <?= ($station['project_id'] == $project['id'])?"selected":""?>> 
					<?= $project['name_chn']?> 
				</option>
			<?}?>
		</select>
		</li>
        <li>城市: <?= h_make_select(h_array_2_select($cities),'city_id',$station['city_id']? $station['city_id']:0,"") ?> </li>
        <li>区域: <?= h_make_select(h_array_2_select($districts),'district_id',$station['district_id']? $station['district_id']:0,'请选择区') ?> </li>
        <li>类型: <?= h_station_station_type_select($station['station_type'],"") ?> </li>
        <li>建筑: <?= h_station_building_select($station['building'],"") ?>  </li>
        <li>负载数: <input type="text" name="load_num" value="<?= $station['load_num']?>" 
            style="width:50px;border-color:<?= $station['load_num']?"":"#f00"?>"/> A </li>
    </ul>
    <ul>
        <li>n+1节能天数: <input style="width:40px" type="text" name="ns" value="<?= $station['ns']?>" /></li>
        <li>开始时间:    <input type="text" name="ns_start" value="<?= $station['ns_start'] ?>" style="width:140px"></li>
        <li>前端可见性： <?= h_make_select(h_station_frontend_visible_array(), 'frontend_visible', $station['frontend_visible'],$first=null) ?></li>
        <li>对比基准站: <?= h_make_select(h_array_2_select($std_stations), 'standard_station_id', $station['standard_station_id'],$first="任意") ?></li>
    </ul>
    <ul>
        <li>经度: <input type="text" name="lng" value="<?= $station['lng']?>" /> </li>
        <li>纬度: <input type="text" name="lat" value="<?= $station['lat']?>" /> </li>
        <li>地址: <input type="text" name="address_chn" value="<?= $station['address_chn']?>" style="width:800px;"/> </li>
    </ul>
    <ul>
        <!--<li>空调数: <input type="radio" name="colds_num" value="1" <?= $station['colds_num']==1?"checked":"" ?> /> 1台&nbsp;
                       <input type="radio" name="colds_num" value="2" <?= $station['colds_num']==2?"checked":"" ?> /> 2台 </li>-->
        <li>空调1启动：<?=h_make_select(h_station_colds_0_func_array(),'colds_0_func',$station['colds_0_func'],'')?>
                空调2启动：<?=h_make_select(h_station_colds_1_func_array(),'colds_1_func',$station['colds_1_func'],'')?></li>
        <li>空调1类型: <input type="text" name="colds_0_type" value="<?= $station['colds_0_type']?>" /> </li>
        <li>空调2类型: <input type="text" name="colds_1_type" value="<?= $station['colds_1_type']?>" /> </li>
    </ul>
    <ul>
        <!--<li>是否安装恒温柜：<?= h_have_box_select('have_box',$station['have_box']) ?></li>-->
        <li>恒温箱类型: <?= h_station_box_type_select($station['box_type'],"") ?> </li>
        <li>安装室外温感: <?= h_being_select('equip_with_outdoor_sensor',$station['equip_with_outdoor_sensor']) ?>  </li>
        <li>人为干预: <?= h_station_force_on_select($station['force_on'],"") ?></li>
    </ul>
    <ul>
        <li>新风类型: <?= h_station_fan_type_select($station['fan_type'],"")?> </li>
        <li>风机: <?= h_station_air_volume_select($station['air_volume'],"")?>  </li>
        <li>显示顺序: <input type="text" name="display_order" value="<?= $station['display_order']?>" /> </li>
        <li>工程分期: <?= h_make_select(h_array_2_select($batches),"batch_id",$station['batch_id'],$first="暂未分期分批",220) ?> </li>
        <li>无线模块：<?=h_3g_module_select(h_3g_module_array(),'3g_module',$station['3g_module'],$default=0,$first="",$width=50)?></li>
        <li>电价: <input type="text" name="price" value="<?= $station['price']?>" /> </li>
        <li>额外交流功率(w): <input type="text" name="extra_ac" value="<?= $station['extra_ac']?>" /> </li>
        <li>验收名:<input type="text" name="change_name_chn" value="<?=$station['change_name_chn']?>"/></li>
        <li>&nbsp;设置锁定: <?=h_make_select(h_station_yes_or_no_array(),'setting_lock',$station['setting_lock'],'')?>
        <li>&nbsp;高温远程重启: <?=h_make_select(h_station_yes_or_no_array(),'temp_high_reboot',$station['temp_high_reboot'],'')?>
        <li>分成比例: <input type="text" name="saving_percentage" value="<?= $station['saving_percentage']?>" /> </li>
    </ul>
    <ul>
        <li><?php echo form_submit("","提交"); ?> 
            <input type="button" value="取消" onclick="window.location='<?= urldecode($this->input->get('backurl'))?>'" />
        </li>
    </ul>
</div>
    
<?php echo form_close(); ?>
</div>
<script>
    $(function(){
        $("select[name='project_id']").change(function(){
            var obj = $(this);
            $.ajax({
                type: "GET",
                data: "project_id="+obj.val(), 
                url: "/backend/project/ajax_get_cities",
                dateType: "json",                  
                success: function(data){
                    var jsondata=eval("("+data+")");
                    var str="";
                    for(var i=0;i<jsondata.length;i++){
                        str+="<option value="+jsondata[i].id+">"+jsondata[i].name_chn+"</option>";
                    }
                    $("select[name='city_id']").html(str);
                },
                error:function(){
                }
            })
            $("select[name='district_id']").html("<option value='0'>请选择区</option>");
        })
        $("select[name='city_id']").change(function(){
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
                    $("select[name='district_id']").html(str);
                },
                error:function(){
                }
            })
        })
    })
</script>
