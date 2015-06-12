<script>
$(function(){ 
        $("#download_xls").click(function(){
           
            document.getElementById('filter').action = "/backend/data/xls";
            document.getElementById('filter').submit();
        });

        $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'}); 
    });
</script>

<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;display:none}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px;display:none}
.tab{width:980px;}
.tab ul{list-style:none;float:left;margin:4px 3.7px;padding:0}
.a_active{ background-color:#369;color:#fff };
</style>

<div class=base_center>
<div style="border:1px solid #999;width:988px;padding:5px;margin-bottom:5px">
   数据显示工具： 
   <a href="/frontend/single/data?station_id=<?= $this->input->get('station_id')?>&type=recent" 
        class="<?= $type == "recent"?"a_active":""?>" >
    最新60条数据
   </a> 
   &nbsp;&nbsp;&nbsp;
   <a href="/frontend/single/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_format("now")?>&type=day" 
        class="<?= $type == "day" && h_dt_start_time_of_day($datetime) == h_dt_start_time_of_day("now") ?"a_active":""?>" >
    当天全部数据
   </a> 
   &nbsp;&nbsp;&nbsp;
   数据压缩:
   <a href="/frontend/single/data?<?= h_set_query_string_param($_SERVER['QUERY_STRING'],"compress",1) ?>"
        class="<?= $this->input->get("compress") == 1 ?"a_active":""?>" >
    不压缩
   </a> 
   <a href="/frontend/single/data?<?= h_set_query_string_param($_SERVER['QUERY_STRING'],"compress",5) ?>"
        class="<?= $this->input->get("compress") == 5 ?"a_active":""?>" >
    压缩5倍
   </a> 
   <a href="/frontend/single/data?<?= h_set_query_string_param($_SERVER['QUERY_STRING'],"compress",10) ?>"
        class="<?= $this->input->get("compress") == 10 ?"a_active":""?>" >
    压缩10倍
   </a> 
    
</div>

<div style="border:1px solid #999;width:988px;padding:5px;">
    <div class="es_day" >按时间日期显示:&nbsp;&nbsp;&nbsp;&nbsp;<input name='time' type="text"  style="width:68px;height:16px">
   &nbsp;&nbsp;&nbsp;
   <a href="/frontend/single/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_sub_day($datetime)?>&type=day" >
     往前一天
   </a> 
   &nbsp;&nbsp;&nbsp;
   <a href="/frontend/single/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_add_day($datetime)?>&type=day" >
     往后一天
   </a> 
</div>
    <div class="tab">
            <ul>
                <a class="<?= ($type=="day")?"a_active":""?>" 
                    href="/frontend/single/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_format($datetime)?>&type=day" >
                    全天
                </a>
            </ul>
            <? foreach (range(0,23) as $t){?>
            <? $t = sprintf('%02d',$t);?>
            <ul>    
                <a class="<?= (h_dt_format($this->input->get('time'),"H") == $t && $type=="hour")?"a_active":""?>" 
                    href="/frontend/single/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_format($datetime,"Ymd".$t."0000")?>&type=hour" >
                    <?= $t?>:00
                </a>
            </ul>
            <?}?>
    </div>
    <div style="clear:both"> </div>
</div>

<div style="height:10px;"> </div>


<style>
    .h_draw_lines { float:left; border:1px solid #ddd}
    .h_draw_lines>ul { float:left;padding:0;margin:0}
    .h_draw_lines>ul>li { float:left;width:4px;height:12px;overflow:hidden;background-color:#369}
    .h_draw_lines>ul>li.split { float:left;width:1px;height:12px;overflow:hidden;background-color:#000}
</style>

<div style=""> 共有 <?= count($datas)?>个数据 (分布如下) </div>
<div class='h_draw_lines'>
    <ul>
    <? foreach(range(0,239) as $y){ ?>
        <? if ($y%10 == 0){?>
            <li class='split'> &nbsp; </li>
        <? } ?>
        <li style='background-color:<?= isset($data_x_time[$y*6])?"":"#999"?>'> &nbsp; </li>
    <? } ?>
    </ul>
</div>
<div style="clear:both"> </div>

<div style="height:10px;"> </div>


<style>


.datalist{ border:1px solid #999; background-color:#fff; font-size:12px; width:100%; }
.datalist th{ border:1px solid #666;color:#fff;background-color:#999; font-weight:bold; padding:2px; text-align:center; }
.datalist td{ border:1px solid #666;padding:2px; text-align:center; }

.datalist tr{ background: #fff;} 
.datalist tr:nth-child(2n){ background: #ddd; } 


.datalist td.name_alive{ background: #6f6 }
.datalist td.fan_on_0{  }
.datalist td.fan_on_1{ background: #0f0; }
.datalist td.colds_0_on_0{  }
.datalist td.colds_0_on_1{ background: #f93; }
.datalist td.colds_1_on_0{  }
.datalist td.colds_1_on_1{ background: #9dd; }

.datalist .leftline{ border-left: 2px solid #444; }
.datalist .rightline{ border-right: 2px solid #444; }
</style>

<table class="datalist" >
<tr>
<th> <b></b> </td>
<th colspan=5 class="leftline"> <b>温度</b> </td>
<th colspan=2 class="leftline"> <b>湿度</b> </td>
<th colspan=4 class="leftline"> <b>开关</b> </td>
<th colspan=2 class="leftline"> <b>电能</b> </td>
<th colspan=2 class="leftline rightline"> <b>功率</b> </td>
<th> <b></b> </td>
</tr>
<tr>
<th > <b>基站</b> </td>
<th class="leftline"> <b>室内</b> </td>
<th> <b>室外</b> </td>

<th> <b>空调1</b> </td>
<th> <b>空调2</b> </td>
<th> <b>恒温</b> </td>

<th class="leftline"> <b>内</b> </td>
<th > <b>外</b> </td>
<th class="leftline"> <b>风</b> </td>
<th> <b>空1</b> </td>
<th> <b>空2</b> </td>
<th> <b>恒</b> </td>
<th class="leftline"> <b>总</b> </td>
<th> <b>DC</b> </td>
<th class="leftline"> <b>总</b> </td>
<th> <b>DC</b> </td>
<th class="leftline"> <b>采样时间</b> </td>
</tr>
<?php foreach ($datas as $data): ?>
<tr>

<td class="rightline"> <?= $station['name_chn']?>  </td>
<td> <?= $data['indoor_tmp']?>  </td>
<td> <?= $data['outdoor_tmp']?>  </td>

<td> <?= $data['colds_0_tmp']?>  </td>
<td> <?= $data['colds_1_tmp']?>  </td>
<td> <?= $data['box_tmp']?>  </td>

<td class="leftline"> <?= $data['indoor_hum']?>  </td>
<td class="rightline"> <?= $data['outdoor_hum']?>  </td>
<td class="fan_on_<?= $data['fan_0_on']?>">       <?= $data['fan_0_on']?>   </td>
<td class="colds_0_on_<?= $data['colds_0_on']?>"> <?= $data['colds_0_on']?> </td>
<td class="colds_1_on_<?= $data['colds_1_on']?>"> <?= $data['colds_1_on']?> </td>
<td > <?= $data['colds_box_on']?>  </td>
<td class="leftline"> <?= $data['energy_main']?>  </td>
<td> <?= $data['energy_dc']?>  </td>
<td class="leftline"> <?= $data['power_main']?>  </td>
<td> <?= $data['power_dc']?>  </td>

<td class="leftline <?= h_compare_dur($data['create_time'],"",10)?"name_alive":"" ?>" style="width:130px"> 
    <?= $data['create_time']?>  
</td>
</tr>
<?php endforeach?>
</table>

</div>
<script type="text/javascript" src="/static/site/js/frontend_basic.js?id=<?= hsid()?>"></script>
<script type="text/javascript" src="/static/site/js/frontend_day.js?id=<?= hsid()?>"></script>
<script type="text/javascript">
	window.global_options = {
        "station_id": "<?= $station['id'] ?>",
        "day_offset": "0",
        "time": "<?= h_dt_format($datetime,"Y-m-d")?>"
        }

	$(document).ready(function(){

    $('.es_day input').datepicker({
        showButtonPanel: true,
        dateFormat: "yy-mm-dd",
        inline: false,
        timezone: '+8000',
        defaultDate: '+7d', 
        onClose:function(datatimeText,instance){
        window.global_options.time = $('.es_day input').attr("value");
        window.location.href="?station_id="+window.global_options.station_id+"&type=day&time="+window.global_options.time;
        }
    });
    $('.es_day input').attr("value",window.global_options.time);

});
</script>
