<style>
    .install_step{ width:100%; float:left; background-color:#f00;margin-bottom:10px;color:#fff}
    .install_step h3{float:left;width:100%; text-align:center;background-color:#333;padding:5px 0;margin-bottom:8px; color:#fff}
    .install_step select{ width:100px }
    .install_step ul{list-style:none;float:left;width:100% }
    .install_step ul li{list-style:none; float:left; width:48%  }
    .install_step ul.install_op{ padding:10px 0; }
    .install_step ul.install_op a { width:50px; }
</style>



<div class=row-fluid>
    <div class="span12">
        <div style="width:100%; background-color:#eee;margin-bottom:10px;">
            <iframe id=data_frame frameborder=0 border=0 style='width:100%;height:250px;border:0' src='/backend/data/em_single_station_data/0'></iframe>
        </div>
    </div>
</div>

<div class=row-fluid>
    <div class="span6">

        <div id="station_div" class="install_step">
        <h3>第一步：配置基站</h3>
            <ul>
                基站:<input id="station_name"  type="text" class="input-large" /><br>
            </ul>
            <ul>
                城市:<?= $this->area->area_select('city_id',0,"请选择")?>
                类型:<?= h_station_station_type_select(0,"请选择") ?>
            </ul>
            <ul>
                建筑:<?= h_station_building_select(0,"请选择") ?>
                负载:<?= h_station_total_load_select(0,"请选择") ?>             
            </ul>    
			<ul>
               	备注:<textarea style="width:220px;" id="comment"></textarea>
            </ul>  
            <ul>
               	当前:<span style="color:#000;"><?= $project->getNameChn()?></span> [请确认当前所处项目 依需切换]
            </ul>                  
            <ul id="station_error">
                            
            </ul>
            <ul class="install_op">
                <a href="javascript:void(0)" id="station_confirm" class='btn btn-large btn-inverse'>确定</a>
            </ul>
        </div>

        <div id="esg_div" class="install_step">
        <h3>第二步：配置ESG</h3>
            <ul> ESG_ID:<input id="esg_id" type="text" class="input-large" /> </ul>
            <ul id="esg_error">
            </ul>
            <ul class="install_op">
                <a href="javascript:void(0)" id="esg_confirm" class='btn btn-large btn-inverse'>安装</a> &nbsp;
                <a href="javascript:void(0)" id="esg_del" class='btn btn-large btn-inverse'>拆除</a>
            </ul>
        </div>

        <div id="correct_1_div" class="install_step">
        <h3>第三步：初始电表校准</h3>
            <ul>
                基站总电表读数:<input id="correct_1_correct_num"  type="text" class="input-large"  /><br>
            </ul>
            <ul class="install_op">
                <a href="javascript:void(0)" id="correct_1_confirm" class='btn btn-large btn-inverse'>确定</a>
            </ul>
        </div>

        <div id="correct_2_div" class="install_step" style='display:none'>
        <h3>第五步：第二次电表校准</h3>
            <ul>
                时间:<font id="correct_2_time"> </font><br />
                ESG电表:<font id="correct_2_org_num"> </font>
            </ul>
            <ul>
                读数:<input id="correct_2_correct_num"  type="text" class="input-large" />
            </ul>
            <ul>
                斜率:<font id="show_correct_slope"></font><br>
            </ul>
            <ul class="install_op">
                <a href="javascript:void(0)" id="correct_2_confirm" class='btn btn-large btn-inverse'>确定</a>
            </ul>
        </div>

    </div>
    <div class="span6">

        <div style="width:100%;border:1px solid #999; background-color:#eee; color:#000">
            <h3 style="text-align:center">最终检查表</h3>
            <ol>
                <h4> 数据确认 </h4>
                <li> <input type="checkbox"> 室内温度 室外温度正常（10～40） </li>
                <li> <input type="checkbox"> 两个空调出风口温度 正常（10～40） </li>
                <li> <input type="checkbox"> 湿度 正常（20%～80%） </li>
                <li> <input type="checkbox"> 电能正常 （递增 总电能>DC电能） </li>
                <li> <input type="checkbox"> 功率正常 （总功率3000～12000） </li>
            </ol>
            <ol>
                <h4> 现场确认 </h4>
                <li> <input type="checkbox"> 恒温柜 制冷点设置到25度 </li>
                <li> <input type="checkbox"> 自检按钮按下 看到开关量变化 </li>
            </ol>
        </div>

        <br>

        <div style="width:100%;border:1px solid #ccc; color:#999;">
            <h3 style="text-align:center">操作说明</h3>
            <br>
            <ol>
                <h4>主要原则</h4>
                <li> 每个模块设置正确后会自动变成绿色 </li>
                <li> 每个模块只有等前面的所有模块变绿后才可以开始操作</li>
                <li> 模块没有完全变绿之前不建议离开此页面</li>
            </ol>
            <ol>
                <h4>第一步</h4>
                <li> 在基站名称中填入当前基站的中文名 </li>
                <li> 选择基站对应的属性 </li>
                <li> 确认后无特殊情况该模块变绿</li>
                <li> 若要修改可直接修改 再点确定</li>
            </ol>
            <ol>
                <h4>第二步</h4>
                <li> 在EGS_ID中填入刚安装好的机器的ID(11001xxxxx)</li>
                <li> 如果有错误：一般是ID填错，请校对ID</li>
                <li> 如果ID对 却报<b>此ESG暂时不在线</b>，说明ESG没能正确送上数据</li>
            </ol>
            <ol>
                <h4>第四步</h4>
                <li> 读出当前的电表值并填入</li>
            </ol>
        </div>

    </div>

</div>

<script type="text/javascript">
// Json struct for different params. Initial: time, last 3_hours
window.global_options = {
    "esg_obj":"",
    "station_obj":"",
    "correct_1_obj":"",
    "correct_2_obj":"",
    "esg_error":"",
    "state":new Array()
}
function alert_if_uploading() {
    if(isGreen('esg') && !isGreen('correct_1')){
        return '基站正在创建过程中！ 你确定要离开或重来？';
    }
}
window.onbeforeunload = alert_if_uploading;

function new_correct_2(){
    if(!isGreen('esg')){alert('上面的模块没有变绿!');return}
    if(!isGreen('station')){alert('上面的模块没有变绿!');return}
    if(!isGreen('data')){alert('上面的模块没有变绿!');return}
    setState('correct_2','gray');
    var correct_num = $('#correct_2_correct_num').attr("value");
    if(!correct_num){alert('没有填写电表值！');return;}
    var station_id = window.global_options.station_obj.id;
    var correct_id = window.global_options.correct_2_obj?window.global_options.correct_2_obj.id:0;
    $.get("/backend/tool/ajax_set_correct/"+station_id+"/"+correct_id,{"correct_num":correct_num}, 
        function(temp_str){
            tempObj = jQuery.parseJSON(temp_str);
            window.global_options.correct_2_obj = tempObj;
            $("#correct_2_time").html(window.global_options.correct_2_obj.time);
            $("#correct_2_org_num").html(window.global_options.correct_2_obj.org_num);
            if(tempObj.id){
                $.get("/backend/tool/ajax_make_correct/"+station_id,{},function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    //(tempObj.id)? setState('correct_2','green'):setState('correct_2','red');
                    $('#show_correct_slope').html(tempObj.slope);
                    setState('correct_2','green')
                });
            }
    });
}


function new_correct_1(){
    if(!isGreen('data')){alert('上面的模块没有变绿!');return}
    setState('correct_1','gray');
    var correct_num = $('#correct_1_correct_num').attr("value");
    if(!correct_num){alert('没有填写电表值！');return;}
    var station_id = window.global_options.station_obj.id;
    var correct_id = window.global_options.correct_1_obj?window.global_options.correct_1_obj.id:0;
    $.get("/backend/tool/ajax_set_correct/"+station_id+"/"+correct_id,{"correct_num":correct_num}, 
        function(temp_str){
            tempObj = jQuery.parseJSON(temp_str);
            //(tempObj.id)? setState('correct_1','green'):setState('correct_1','red');
            window.global_options.correct_1_obj = tempObj;
            $("#correct_1_time").html(window.global_options.correct_1_obj.time);
            $("#correct_1_org_num").html(window.global_options.correct_1_obj.org_num);
            if(tempObj.id){
                $.get("/backend/tool/ajax_make_correct/"+station_id,{},function(temp_str){
                    tempObj = jQuery.parseJSON(temp_str);
                    setState('correct_1','green')
                });
            }
    });
}

function set_data_frame_station(station_id){
    $('#data_frame').attr("src","/backend/data/em_single_station_data/"+station_id);
}

function new_station(){
    var station_name = $('#station_name').attr("value");
    var city_id = $('#city_id').attr("value");
    var station_type = $('#station_type').attr("value");
    var building = $('#building').attr("value");
    var total_load = $('#total_load').attr("value");
    var comment = $('#comment').attr("value");
    // setState('station','gray');
    if(!station_name){ alert("不能没有基站名字！"); return; }
	if(city_id==0||station_type==0||building==0||total_load==0){ alert("选择不完整 请补全！"); return; }
    station_id = window.global_options.station_obj? window.global_options.station_obj.id : 0; 
    $('#station_div').css("background-color","#ccc");
    $.get("/backend/tool/ajax_get_station/"+station_id,{"name_chn":station_name,
    "city_id":city_id,"station_type":station_type,"building":building,"total_load":total_load,"comment":comment}, 
        function(temp_str){
            tempObj = jQuery.parseJSON(temp_str);
            if(tempObj){
                setState('station','green');
                set_data_frame_station(tempObj.id);
            }else{
                setState('station','red');
            }
            window.global_options.station_obj = tempObj;
    });
}

function get_esg(){
    if(!isGreen('station')){alert('上面的模块没有变绿!');return;}
    if(isGreen('esg')){return;}
    var esg_id = $('#esg_id').attr("value");
    var station_id = window.global_options.station_obj.id;
    if(!esg_id){alert('没有填写ESG_ID');return;}
    if(!esg_id)return;
    setState('esg','gray');
    $.get("/backend/tool/ajax_get_esg/"+station_id+"/"+esg_id,{}, 
        function(temp_str){
            tempObj = jQuery.parseJSON(temp_str);
            window.global_options.esg_obj = tempObj;
            if(check_esg(tempObj)){
                setState('esg','green')
                $("#esg_id").attr("disabled",true);
            }else{
                setState('esg','red');
            }
            $('#esg_error').html(window.global_options.esg_error);
    });
}

function del_esg(){
    if(!isGreen('esg')){alert('没啥好拆的!');return}
    var esg_id = $('#esg_id').attr("value");
    var station_id = window.global_options.station_obj.id;
    setState('esg','gray');
    $.get("/backend/tool/ajax_del_esg/"+station_id+"/"+esg_id,{}, 
        function(temp_str){
                $("#esg_id").attr("disabled",false);
                setState('esg','red');
                setState('data','red');
                setState('correct_1','red');
    });
}

function check_esg(obj){
    var $res = true;
    window.global_options.esg_error = "";
    if("noEsg" === obj.error){
        window.global_options.esg_error = "没有这个ESG 请确认";
        $res = false;
    }else if("noSingle" === obj.error){
        window.global_options.esg_error = "此ESG属于 <b>"+obj.station_name+"</b> 请确认";
        $res = false;
    }else if("offline" === obj.error){
        window.global_options.esg_error = "此ESG暂时不在线 请确认";
        $res = false;
    }
    return $res;
}

// green red gray
function setState(part,state){
    $('#'+part+'_div').css("background-color",state);
    window.global_options.state[part] = state;
}

function isGreen(part){
    return window.global_options.state[part] === 'green';
}

function getState(part){
    return window.global_options.state[part];
}

$(document).ready(function(){
    $('#esg_confirm').click(function(){get_esg()});
    $('#esg_del').click(function(){del_esg()});
    $('#station_confirm').click(function(){new_station()});
    $('#correct_1_confirm').click(function(){new_correct_1()});
    $('#correct_2_confirm').click(function(){new_correct_2()});

});


</script>
