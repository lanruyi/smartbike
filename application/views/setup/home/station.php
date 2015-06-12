<style>
    .install_step{ width:100%; float:left; background-color:#f00;margin-bottom:10px;color:#fff}
    .install_step ul{list-style:none;float:left;width:100%;padding:0;margin:0;}
    .install_step ul li{list-style:none; float:left;padding:0;margin:0;padding-left:5px; }
    .install_step ul li.title{float:left;width:100%; text-align:center;background-color:#333;padding:5px 0;margin-bottom:8px; color:#fff}
    .install_step select{ width:100px }
    .install_step ul.install_op{ padding:10px 0; }
    .install_step ul.install_op a { width:50px; }
</style>

<div class='base_center'>

    <div style="width:100%; float:left; margin-bottom:10px;">
        <a href="/setup/home/station" class="btn btn-primary">创建新基站</a>  
        <a href="/setup/home/nearestUnderConstructNewStation" class="btn btn-primary">继续刚才的那个基站的创建</a>  
    </div>

    <div id="station_div" class="install_step" style="<?= $station ? "background-color:green" : "" ?>">
        <ul>
            <li class="title">第一步：配置基站 &nbsp;&nbsp;&nbsp;&nbsp;
            </li>
            <li>
                基站:<input id="station_name" 
                    value="<?= $station?$station['name_chn']:"" ?>" 
                    type="text" style="width:140px" />
            </li>
            <li>
                项目:<?= h_make_select(h_array_2_select($projects),'project_id',
                        $station?$station['project_id']:0,"请选择",150) ?>
                城市:<span id="city_select">
                        <?= ($station) ? $station['city']['name_chn'] : 
                        h_make_select(array(), 'city_id', 0, "请选择") ?>
                     </span>
                区域:<span id="district_select">
                        <?= ($station['district']) ? $station['district']['name_chn'] : 
                        h_make_select(array(), 'district_id', 0, "请选择") ?>
                     </span>
                类型:<?= h_station_station_type_select($station ? $station['station_type'] : 0, "请选择") ?>
                负载:<input id="load_num" value="<?= $station ? 
                      $station['load_num'] : "" ?>" type="text" style="width:50px;" /> A
            </li>
            <li>空调1启动：<?=h_make_select(h_station_colds_0_func_array(),'colds_0_func',$station?$station['colds_0_func']:0,"请选择")?>
                空调2启动：<?=h_make_select(h_station_colds_1_func_array(),'colds_1_func',$station?$station['colds_1_func']:ESC_STATION_COLDS_FUNC_NONE,'')?>
                恒温柜类型:<?= h_station_box_type_select($station ? $station['box_type']: 1,"请选择") ?> 
                配有室外传感器:<?= h_being_select('equip_with_outdoor_sensor', 
                                $station?$station['equip_with_outdoor_sensor'] : 0, "请选择") ?>
                风机:<?= h_station_air_volume_select($station ? $station['air_volume']:0, "请选择") ?>
            </li>
            <li>
                建筑:<?= h_station_building_select($station ? $station['building'] : 0, "请选择") ?>
                风机类型:<?= h_station_fan_type_select($station ? $station['fan_type']: ESC_FAN_TYPE_BOOU,"请选择") ?>    
                无线模块：<?=h_3g_module_select(h_3g_module_array(),'3g_module',$station?$station['3g_module']:3,$default=0,$first="",$width=50)?>
                经度:<input id="lng" value="<?= $station?$station['lng']:"" ?>" type="text" style="width:70px;" />
                纬度:<input id="lat" value="<?= $station?$station['lat']:"" ?>" type="text" style="width:70px;" />
            </li> 
            <li>
                sim卡电话:<input id="sim_num" value="<?= $station ? 
                          $station['sim_num']: "" ?>" type="text" style="width:100px;" />
            </li>  
            <li>
                地址:<input id="address_chn" value="<?= $station ? 
                        $station['address_chn']:"" ?>" type="text" style="width:800px;" />
            </li>  
            <li id="station_error">
            </li>
            <li>
                &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" id="station_confirm" class='btn btn-inverse'>确定</a>
            </li>
        </ul>
    </div>

    <div id="esg_div" class="install_step" style="<?= $station && $station['esg'] ? "background-color:green" : "" ?>">
        <ul>
            <li class="title">第二步：配置ESG</li>
            <li> ESG_ID:<input id="esg_id" type="text" class="input-large" 
                        value="<?= $station && $station['esg'] ? $station['esg']['id'] : "" ?>" 
                        <?= $station && $station['esg'] ? "disabled" : "" ?> /> 
            </li>
            <li class="install_op" style="padding-left:12px">
                <a href="javascript:void(0)" id="esg_confirm" class='btn btn-inverse'>安装</a> &nbsp;
                <a href="javascript:void(0)" id="esg_del" class='btn btn-inverse'>拆除</a>
            </li>
        </ul>
    </div>

    <div style="width:100%; background-color:#eee;margin-bottom:10px;">
        <iframe id=data_frame frameborder=0 border=0 style='width:100%;height:215px;border:0' 
            src='/setup/home/em_single_station_data/<?= $station?$station['id']:0 ?>'>
        </iframe>
    </div>

    <div id="correct_1_div" class="install_step" 
        style="<?= count($corrects)>0?"background-color:green":"" ?>">
        <ul>
            <li class="title">第三步：初始化同步电表</li>
        </ul>
        <ul>
            <li>
                <? foreach ($corrects as $key=>$correct) { ?>
                    历史电表同步: 
                    <b>时间</b>:<?= $correct['time'] ?> 
                    <b>真实读数</b>:<?= $correct['correct_num'] ?> 
                    <b>博欧读数</b>:<?= $correct['org_num'] ?>
                    &nbsp;&nbsp;
                    <a href='javascript:if(confirm("确定要删除吗？")){
                        location.href="/backend/correct/del_correct/<?= 
                            $station['id'] ?>/<?= $correct['id'] ?>?backurl=<?= $backurlstr?>"}'>
                        删除
                    </a>
                    &nbsp;&nbsp;
                    <? if(0 == $key){?>
                        <b>base</b>:<?= $correct['base'] ?>
                        <b>correct_base</b>:<?= $correct['correct_base'] ?>
                        <b>slope</b>:<?= $correct['slope'] ?>
                    <? } ?>
                    <br>
                <? } ?>
            </li>
            <li style="padding:10px">
                <?= form_open("/backend/correct/add_correct/".$station['id']."?backurl=".$backurlstr); ?>
                基站当前电表读数<input name="correct_num" />
                <?php echo form_submit("","添加一次电表同步数据"); ?> 
                <?php echo form_close(); ?>
            </li>
        </ul>
    </div>

    <div id="blog_div" class="install_step" style="<?= $blog ? "background-color:green" : "" ?>">
        <ul>
            <li class="title">第四步: 记录安装日志&nbsp;&nbsp;&nbsp;&nbsp;[安装基站时 请务必填写安装日志] </li>
        </ul>
        <ul>
            <li>日志内容:<textarea id="blog_content" style="width:700px;" <?= $blog ? "readonly" : "" ?>><?= $blog ? $blog['content'] : "" ?></textarea></li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;
                <a id="create_blog" href="javascript:void(0)" class="btn btn-inverse" style="<?= $blog ? "display:none;" : "" ?>">添加安装日志</a></li>
        </ul> 
    </div>

</div>


<script>
    function checkInteger(str){
        var num = /^\d+(\.\d+)?$/;
        return num.test(str);
    }

    function new_station(){
        var station_name = $('#station_name').attr("value");
        var project_id = $('#project_id').attr("value");
        var city_id = $('#city_id').attr("value");
        var district_id = $('#district_id').attr("value");
        var station_type = $('#station_type').attr("value");
        var building = $('#building').attr("value");
        var load_num = $('#load_num').attr("value");
        var colds_0_func = $("#colds_0_func").attr("value");
        var colds_1_func = $("#colds_1_func").attr("value");
        var box_type = $('#box_type').val();
        var fan_type = $('#fan_type').val();
        var wireless_module = $('#3g_module').attr("value");
        var equip_with_outdoor_sensor = $('#equip_with_outdoor_sensor').attr("value");
        var lng = $('#lng').attr("value");
        var lat = $('#lat').attr("value");
        var address_chn = $('#address_chn').attr("value");
        var sim_num = $('#sim_num').attr("value");
        var air_volume = $('#air_volume').attr("value");
        if(!station_name){ alert("不能没有基站名字！"); return; }
        if(<?= $station ? "true" : "false" ?>){ alert("对不起！修改功能已禁用，若想修改请在'基站'中进行修改！"); return; }
        if(city_id==0||station_type==0||building==0||colds_0_func==0||box_type==0||equip_with_outdoor_sensor==0){ alert("选择不完整 请补全！"); return; }
        if(!load_num){ alert("请填写负载数！"); return; }
        if(!checkInteger(load_num)){
            alert('请填写正确的负载值, 最多精确到小数点后1位');
            return ;
        }
        if(!address_chn){ alert("请填写基站地址！"); return; }
        if(!sim_num){ alert("请填写sim卡的电话号码！"); return; }
        if( air_volume == 0){ alert("请填写风量！"); return; }
        location.href="/setup/home/ajax_new_station_sql/<?= $station ? $station['id'] : 0 ?>?name_chn="+station_name
            +"&project_id="+project_id+"&city_id="+city_id +"&station_type="+station_type+"&building="+building+"&load_num="+load_num
            +"&sim_num="+sim_num+"&colds_0_func="+colds_0_func+"&colds_1_func="+colds_1_func+"&box_type="+box_type+"&fan_type="+fan_type
            +"&3g_module="+wireless_module+"&district_id="+district_id
            +"&equip_with_outdoor_sensor="+equip_with_outdoor_sensor+"&lng="+lng+"&lat="+lat+"&address_chn="+address_chn+"&air_volume="+air_volume;
    }

    function get_esg(){
        if(<?= $station ? "false" : "true" ?>){alert('基站还没设定好!');return;}
        if(<?= $station && $station['esg'] ? "true" : "false" ?>){alert('已经装好esg!');return}
        var esg_id = $('#esg_id').attr("value");
        if(!esg_id){alert('没有填写ESG_ID');return;}
        location.href="/setup/home/save_esg/<?= $station ? $station['id'] : 0 ?>?esg_id="+esg_id;
    }

    function del_esg(){
        if(<?= $station && $station['esg'] ? "false" : "true" ?>){alert('没啥好拆的!');return}
        location.href="/setup/home/del_esg/<?= $station ? $station['id'] : 0 ?>?esg_id="+esg_id;
    }

    function new_correct(){
        var correct_num = $('#correct_1_correct_num').attr("value");
        if(<?= $station ? "false" : "true" ?>){alert('当前无基站 无法同步电表!');return}
        location.href="/setup/home/add_correct/<?= $station ? $station['id'] : 0 ?>?correct_num="+correct_num;
    }

    function create_blog(){
        if(<?= $station ? "false" : "true" ?>){alert('基站还没设定好!');return;}
        var content = $('#blog_content').val();
        if(!content){ alert('请填写基站日志!');return; }
        location.href="/setup/home/station_create_blog/<?= $station ? $station['id'] : 0 ?>?content="+content;
    }

    window.options = {
        "prj_cities":'<?= $prj_cities ?>',
        "city_id":'<?= $station ? $station['city_id']: 0 ?>'
    }

    function project_cities(prj_id){
        //    var cities = jQuery.parseJSON(window.options.prj_cities);
        var cities = eval('('+window.options.prj_cities+')');
        str =  "<select id='city_id' name='city_id' value='"+window.options.city_id+"' style='width:100px;'>";
        str += "<option value='0'"+(window.options.city_id==0?"selected":"")+">请选择</option>";
        $.each(cities[prj_id],function(i,n){
            str += "<option value='"+i+"'"+(window.options.city_id==i?"selected":"")+">"+n+"</option>";
        });      
        str += "</select>";
        $('#city_select').html(str);
    }
    
    window.city_options = {
        "city_districts":'<?= $city_districts ?>',
        "district_id":'<?= $station['district_id'] ? $station['district_id']: 0 ?>'
    }

    function city_districts(city_id){
        //    var cities = jQuery.parseJSON(window.options.prj_cities);
        var districts = eval('('+window.city_options.city_districts+')');
        str =  "<select id='district_id' name='district_id' value='"+window.city_options.district_id+"' style='width:100px;'>";
        str += "<option value='0'"+(window.city_options.city_districts==0?"selected":"")+">请选择</option>";
        $.each(districts[city_id],function(i,n){
            str += "<option value='"+i+"'"+(window.city_options.district_id==i?"selected":"")+">"+n+"</option>";
        });      
        str += "</select>";
        $('#district_select').html(str);
    }

    $(document).ready(function(){
        $('#esg_confirm').click(function(){get_esg()});
        $('#esg_del').click(function(){del_esg()});
        $('#station_confirm').click(function(){new_station()});
        $('#create_blog').click(function(){create_blog()});
        $('#project_id').change(function(){
            project_cities($(this).attr("value"));
        });
        $('#city_select').change(function(){
            city_districts($('#city_id').attr("value"));
        });
    });


</script>
