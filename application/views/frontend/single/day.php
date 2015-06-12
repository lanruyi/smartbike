<?
/********************************
Fast JJump 
../../../../static/site/js/frontend_month.js

********************************/
?>
<script>
    function changeURLPar(destiny, par, par_value)
    {
        var pattern = par+'=([^&]*)';
        var replaceText = par+'='+par_value;
        if (destiny.match(pattern))
        {
            var tmp = '/\\'+par+'=[^&]*/';
            tmp = destiny.replace(eval(tmp), replaceText);
            return (tmp);
        }
        else
        {
            if (destiny.match('[\?]'))
            {
                return destiny+'&'+ replaceText;
            }
            else
            {
                return destiny+'?'+replaceText;
            }
        }
        return destiny+'\n'+par+'\n'+par_value;
    }

    function jump_dis_str(a,b){
        var jslevel=new Array(<?= implode(',',$level)?>);
        jslevel[a] = b;
        var str = window.location.href;
        var newstr=changeURLPar(str,"levels",jslevel[0]+'-'+jslevel[1]+'-'
            +jslevel[2]+'-'+jslevel[3]+'-'+jslevel[4]+'-'+jslevel[5]);
        window.location = newstr;
    }
</script>

<style>
.realtime_box{ margin-top:8px; float:left;width:100%; border-top:3px solid #333; border-bottom:3px solid #333;}
.realtime_box ul{ margin:0;padding:0; float:left; width:100%; list-style:none}
.realtime_box ul li{height:48px; margin:2px; font-size:9px; line-height:18px;float:left; text-align:center;list-style:none; border-right:1px solid #666}
.realtime_box ul li font{ font-size:20px;}
.realtime_box ul li div{ font-size:20px;}
</style>

<div class="base_center">
        <div class="realtime_box" >
            <ul>
                <li style="width:11%">
                    <?=$this->lang->line("Indoor temperature")?>  <br/>
                    <font><?= $station_info['last_indoor_tmp']?>℃</font>
                </li>
                <li style="width:11%">
                    <?=$this->lang->line("Outdoor temperature")?>  <br/>
                    <font><?= $station_info['last_outdoor_tmp']?>℃</font>
                </li>
                <li style="width:11%">
                    <?=$this->lang->line("TLKS-BCT temperature")?> <br/>
                    <font><?= $station_info['last_box_tmp']?>℃</font>
                </li>
                <li style="width:8%">
                    <?=$this->lang->line("New wind")?>  <br/>
                    <?= h_realtime_box_on_off($station_info['last_fan_0_on']) ?>
                </li>
                <li style="width:8%">
                    <?=$this->lang->line("Air-condition")?>1 
                    <br/><?= h_realtime_box_on_off($station_info['last_colds_0_on']) ?>
                </li>
                <li style="width:8%">
                    <?=$this->lang->line("Air-condition")?>2 <br/>
                    <?= h_realtime_box_on_off($station_info['last_colds_1_on']) ?>
                </li>
                <li style="width:15%;">
                    智能<?=$this->lang->line("Ammeter")?> <br/>
                    <font><?= $station_info['last_energy_main']?></font> 
                </li>
                <li style="width:15%">
                    基站<?=$this->lang->line("Ammeter")?> <br/>
                    <font><?= $station_info['last_energy_main_correct']?
                        $station_info['last_energy_main_correct']:"---" ?></font> 
                </li>
                <li style="width:8%">
                    <?=$this->lang->line("Create_time")?> <br/>
                    <?= ($station_info['last_create_time']) ?>
                </li>
            </ul>
          </div>
</div>
<!------------------------------------------------------------------------------------------------------------->

<div class="base_center" >
    <div style="clear:both;height:1px;overflow:hidden"></div>
    <div class="es_time_bar" style="margin:10px 0 5px 0;">
        <ul >
            <li style="width:660px;text-align:left;"> 
                <font style="font-size:22px;font-weight:bold"><?= $time_disp ?></font> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </li>
            <?if ($this->current_project['id'] == 112) {?>
                <li class="<?= $time_disp == h_dt_date_str_no_time("now")?"active":""?>">
                    <a href="?time=<?= h_dt_date_str_no_time("now")?>"> <?=$this->lang->line("Today")?> </a>
                </li>
                <li class="divider-vertical"></li>
                <li>
                    <a href="?time=<?= h_dt_sub_day($time_disp)?>"> 
                        前一天
                    </a>
                </li>
                <li class="divider-vertical"></li>
                <li>
                    <a href="?time=<?= h_dt_add_day($time_disp)?>"> 
                        后一天
                    </a>
                </li>
            <?} else {?>
                <li class="<?= $time_disp == h_dt_date_str_no_time("now")?"active":""?>">
                    <a href="?time=<?= h_dt_date_str_no_time("now")?>"> <?=$this->lang->line("Today")?> </a>
                </li>
                <li class="divider-vertical"></li>
                <li class="<?= $time_disp == h_dt_date_str_no_time("-1 day")?"active":""?>">
                    <a href="?time=<?= h_dt_date_str_no_time("-1 day")?>"> 
                        <?=$this->lang->line("Yesterday")?> 
                    </a>
                </li>
                <li class="divider-vertical"></li>
                <li class="<?= $time_disp == h_dt_date_str_no_time("-2 day")?"active":""?>">
                    <a href="?time=<?= h_dt_date_str_no_time("-2 day")?>"> 
                        <?=$this->lang->line("The day before yesterday")?> 
                    </a>
                </li>
            <?}?>
            <li class="divider-vertical"></li>
            <li  id="es_day">  
                <input type="text"  style="width:68px;height:16px">
            </li>
            <li class="divider-vertical"></li>
        </ul>                
    </div>
    <div style="clear:both;height:1px;overflow:hidden"></div>
    <div class='chart_title'>
        <ul>本日能耗</ul>
    </div>
    <div style="clear:both;height:1px;overflow:hidden"></div>
        <? if ($level[5]){?>
            <? h_draw_chart_ac_column($energy_dc,$energy_main)?>
        <?}?>
    <div style="clear:both;height:1px;overflow:hidden"></div>
    <div style="margin-top:5px;">
    </div>
    <div style="clear:both;height:1px;overflow:hidden"></div>

    <div class='chart_title'>
        <ul><?=$this->lang->line("The total power of the base station and DC power")?></ul>
        <ul style="float:right" class=<?= $level[0] == 3?"active":"normal" ?>>
            <a href="javascript:jump_dis_str(0,3)"><?=$this->lang->line("Details")?></a>
        </ul>
        <ul style="float:right" class=<?= $level[0] == 2?"active":"normal" ?>>
            <a href="javascript:jump_dis_str(0,2)"><?=$this->lang->line("Normal")?></a>
        </ul>
        <ul style="float:right" class=<?= $level[0] == 1?"active":"normal" ?>>
            <a href="javascript:jump_dis_str(0,1)"><?=$this->lang->line("Simple")?></a>
        </ul>
        <ul style="float:right" class=<?= $level[0] == 0?"active":"normal" ?>>
            <a href="javascript:jump_dis_str(0,0)"><?=$this->lang->line("Hide")?></a>
        </ul>
    </div>
    <div style="clear:both;height:1px;overflow:hidden"></div>
        <? if ($level[0]){?>
            <div id="es_power"></div>       
        <?}?>
    <div style="clear:both;height:1px;overflow:hidden"></div>
        <div class='chart_title'>
            <ul><?=$this->lang->line("The station of AC device switching state")?></ul>
        </div>
    <div style="clear:both;height:1px;overflow:hidden"></div>

    <div style="margin:5px 0 0 0px ">
        <?= h_draw_chart_switchon($fan_0_on,$colds_0_on,$colds_1_on) ?>
    </div>
    <div style="clear:both;height:1px;overflow:hidden"></div>
        <div class='chart_title'>
            <ul><?=$this->lang->line("Indoor and outdoor temperature")?></ul>
            <ul style="float:right" class=<?= $level[1] == 3?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(1,3)"><?=$this->lang->line("Details")?></a>
            </ul>
            <ul style="float:right" class=<?= $level[1] == 2?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(1,2)"><?=$this->lang->line("Normal")?></a>
            </ul>
            <ul style="float:right" class=<?= $level[1] == 1?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(1,1)"><?=$this->lang->line("Simple")?></a>
            </ul>
            <ul style="float:right" class=<?= $level[1] == 0?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(1,0)"><?=$this->lang->line("Hide")?></a>
            </ul>
        </div>
        <div style="clear:both;height:1px;overflow:hidden"></div>
          <? if ($level[1]){?>
            <div id="es_temprature"></div>
          <?}?>
        <div style="clear:both;height:1px;overflow:hidden"></div>
        <div class='chart_title'>
            <ul><?=$this->lang->line("Air-conditioning temperature")?></ul>
            <ul style="float:right" class=<?= $level[2] == 3?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(2,3)"><?=$this->lang->line("Details")?></a>
            </ul>
            <ul style="float:right" class=<?= $level[2] == 2?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(2,2)"><?=$this->lang->line("Normal")?></a>
            </ul>
            <ul style="float:right" class=<?= $level[2] == 1?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(2,1)"><?=$this->lang->line("Simple")?></a>
            </ul>
            <ul style="float:right" class=<?= $level[2] == 0?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(2,0)"><?=$this->lang->line("Hide")?></a>
            </ul>
        </div>
        <? if ($level[2]){?>
            <div id="es_colds_tmp"></div>
        <?}?>

        <? if (ESC_STATION_TYPE_STANDARD != $station['station_type']){?>
        <div style="clear:both;height:1px;overflow:hidden"></div>
            <div class='chart_title'>
                <ul><?=$this->lang->line("TLKS-BCT temperature")?></ul>
                <ul style="float:right" class=<?= $level[3] == 3?"active":"normal" ?>>
                    <a href="javascript:jump_dis_str(3,3)"><?=$this->lang->line("Details")?></a>
                </ul>
                <ul style="float:right" class=<?= $level[3] == 2?"active":"normal" ?>>
                    <a href="javascript:jump_dis_str(3,2)"><?=$this->lang->line("Normal")?></a>
                </ul>
                <ul style="float:right" class=<?= $level[3] == 1?"active":"normal" ?>>
                    <a href="javascript:jump_dis_str(3,1)"><?=$this->lang->line("Simple")?></a>
                </ul>
                <ul style="float:right" class=<?= $level[3] == 0?"active":"normal" ?>>
                    <a href="javascript:jump_dis_str(3,0)"><?=$this->lang->line("Hide")?></a>
                </ul>
            </div>
            <? if ($level[3] && ESC_STATION_TYPE_STANDARD != $station['station_type']){?>
                <div id="es_box_temprature"></div>
            <?}?>
        <?}?>
        <div class='chart_title'>
            <ul><?=$this->lang->line("Indoor and outdoor humidity")?></ul>
            <ul style="float:right" class=<?= $level[4] == 3?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(4,3)"><?=$this->lang->line("Details")?></a>
            </ul>
            <ul style="float:right" class=<?= $level[4] == 2?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(4,2)"><?=$this->lang->line("Normal")?></a>
            </ul>
            <ul style="float:right" class=<?= $level[4] == 1?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(4,1)"><?=$this->lang->line("Simple")?></a>
            </ul>
            <ul style="float:right" class=<?= $level[4] == 0?"active":"normal" ?>>
                <a href="javascript:jump_dis_str(4,0)"><?=$this->lang->line("Hide")?></a>
            </ul>
        </div>
        <? if ($level[4]){?>
            <div id="es_humidity"></div>
        <?}?>
        <div id="es_packets_num"></div>
        <div id="es_fan_press"></div>
</div>

<?
    $this->benchmark->mark('f'); 
    if($this->input->get('speed')){
        echo $this->benchmark->elapsed_time('a', 'b')."<br>";
        echo $this->benchmark->elapsed_time('b', 'c')."<br>";
        echo $this->benchmark->elapsed_time('c', 'd')."<br>";
        echo $this->benchmark->elapsed_time('d', 'e')."<br>";
        echo $this->benchmark->elapsed_time('e', 'f')."<br>";
        echo $this->benchmark->elapsed_time('a', 'f')."<br>";
    }
?>

<script type="text/javascript" src="/static/site/js/frontend_basic.js<?= hsid()?>"></script>
<script type="text/javascript" src="/static/site/js/frontend_day.js<?= hsid()?>"></script>
<script type="text/javascript">
    // Json struct for different params. Initial: time, last 3_hours
    window.global_options = {
        "station_id": "<?= $station['id'] ?>",
        "day_offset": "0",
        "time": "<?= $time_disp?>"
    }

    $(document).ready(function(){


        $("#es_refresh").click(function(){ window.location.reload();});

        $('#es_day input').datepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            inline: false,
            timezone: '+8000',
            defaultDate: '+7d', 
            onClose:function(datatimeText,instance){
                window.global_options.time = $('#es_day input').attr("value");
                window.location.href="?time="+window.global_options.time;
            }
        });
        $('#es_day input').attr("value",window.global_options.time);

        init_highcharts();

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        

        <? if ($level[0]){?>
            draw_chart_es_power();
            window.es_power_chart.series[0].setData(<?= $power_main?>);
            window.es_power_chart.series[1].setData(<?= $power_dc?>);
        <? }?>
        
        <? if ($level[1]){?>
            draw_chart("es_temprature",<?= $station['equip_with_outdoor_sensor']?>,"",<?= $station['box_type']?>);
            window.es_temprature_chart.series[0].setData(<?= $indoor_tmp?>);
            <? if($station['equip_with_outdoor_sensor'] == ESC_BEING){ ?> 
                window.es_temprature_chart.series[1].setData(<?= $outdoor_tmp?>);
            <? }?>
        <? }?>

        <? if ($level[2]){?>
            draw_chart("es_colds_tmp","",<?= $station['colds_num']?>);
            window.es_colds_tmp_chart.series[0].setData(<?= $colds_0_tmp?>);
            <? if($station['colds_num'] == 2){ ?>
                window.es_colds_tmp_chart.series[1].setData(<?= $colds_1_tmp?>);
            <? }?>
        <? }?>

        <? if ($level[3] && ESC_STATION_TYPE_STANDARD != $station['station_type'] ){?>
                draw_chart("es_box_temprature");
                window.es_box_temprature_chart.series[0].setData(<?= ($station['id'] == 3355)?h_fake_JsBoxTmp($box_tmp):$box_tmp?>);
        <? }?>

        <? if ($level[4]){?>
            draw_chart("es_humidity",<?= $station['equip_with_outdoor_sensor']?>);
            window.es_humidity_chart.series[0].setData(<?= $indoor_hum?>);
            <? if($station['equip_with_outdoor_sensor'] == ESC_BEING){ ?> 
            window.es_humidity_chart.series[1].setData(<?= $outdoor_hum?>);
            <? }?>
        <? }?>
        
        

        //window.es_packets_num_chart.series[0].setData();	

    });


</script>
        



