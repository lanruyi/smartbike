<style>
.datalist{
    width:100%;
	border:1px solid #333;	/* 表格边框 */
	font-family:Arial;
	border-collapse:collapse;	/* 边框重叠 */
	background-color:#fff;	/* 表格背景色 */
	font-size:12px;
}
.datalist caption{
	padding-bottom:5px;
	font:bold 1.4em;
	text-align:left;
}
.datalist th{
	border:1px solid #333;	/* 行名称边框 */
	background-color:#999;	/* 行名称背景色 */
	color:#FFFFFF;				/* 行名称颜色 */
	font-weight:bold;
	padding-top:4px; padding-bottom:4px;
	padding-left:12px; padding-right:12px;
	text-align:center;
}
.datalist td{
	border:1px solid #0058a3;	/* 单元格边框 */
	text-align:left;
	padding-top:4px; padding-bottom:4px;
	padding-left:10px; padding-right:10px;
}

.datalist tr{ background: #fff;} 
.datalist tr:nth-child(2n){ background: #ddd; } 


.datalist td.name_alive{ background: #6f6 }
.datalist td.fan_on_0{  }
.datalist td.fan_on_1{ background: #0f0; }
.datalist td.colds_0_on_0{  }
.datalist td.colds_0_on_1{ background: #f93; }
.datalist td.colds_1_on_0{  }
.datalist td.colds_1_on_1{ background: #9dd; }

.datalist .leftline{ border-left: 3px solid #444; }
.datalist .rightline{ border-right: 3px solid #444; }
</style>

<div class="base_center">

<table class="table table-striped table-bordered table-condensed">
  <thead>
      <tr>
      <th> <b>ESG_ID</b> </th>
      <th>当前状态</th>
      <th>总上报次数</th>
      <th>老化开始时间</th>
      <th>老化结束时间</th>
      <th>最后更新时间</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?= h_online_mark($esg['alive'])."&nbsp;".$esg['id'] ?> </td>
      <td><b><?= h_aging_process_name_chn($esg['aging_status']) ?></b> </td>
      <td><?= $esg['count'] ?>    </td>
      <td><?= $esg['aging_start_time'] ?> </td>
      <td><?= $esg['aging_stop_time']  ?> </td>
      <td><?= $esg['last_update_time'] ?> </td>
    </tr>
    <tr>
        <td colspan=6> 
             <? if( ESC_ESG_AGING_ING == $esg['aging_status'] || ESC_ESG_AGING_FINISH == $esg['aging_status'] ){ ?>
                <a href="/aging/home/agingdata?esg_id=<?= $esg['id']?>?backurl=<?= $backurlstr?>" class='btn btn-mini btn-primary'>数据</a>
                <a href="/aging/aging_cmd?esg_id=<?= $esg['id']?>" class='btn btn-mini btn-primary'>命令</a>
                <a href="/aging/home/report_aging/<?= $esg['id']?>?backurl=<?= $backurlstr?>" class='btn btn-mini btn-primary' target="_blank">报告</a>  
             <? }?>
             
             &nbsp;
             <? if( ESC_ESG_AGING_NONE == $esg['aging_status'] ){ ?>
             <a href="#" onclick="confirm_jumping('开始<?= $esg['id']?>号ESG老化','/aging/home/start_aging/<?= $esg['id']?>?backurl=<?= $backurlstr?>')"  class='btn btn-mini btn-primary'>开始</a> 
             <? }else if( ESC_ESG_AGING_ING == $esg['aging_status'] ){ ?>
             <a href="#" onclick="confirm_jumping('结束<?= $esg['id']?>号ESG老化','/aging/home/stop_aging/<?= $esg['id']?>?backurl=<?= $backurlstr?>')"  class='btn btn-mini btn-inverse'>结束老化</a> 
             <? }else if( ESC_ESG_AGING_FINISH == $esg['aging_status'] ){ ?>
             <a href="#" onclick="confirm_jumping('重置<?= $esg['id']?>号ESG老化','/aging/home/reset_aging/<?= $esg['id']?>?backurl=<?= $backurlstr?>')"  class='btn btn-mini btn-danger'>重新老化</a> 
             <? }?>
             
        </td>
    </tr>
  </tbody>
</table>

<div style="border:1px solid #999;width:988px;padding:5px;">
    <div class="es_day" >按时间日期显示:&nbsp;&nbsp;&nbsp;&nbsp;<input name='time' type="text"  style="width:68px;height:16px">
        &nbsp;&nbsp;&nbsp;
        <a href="/aging/home/agingdata?esg_id=<?= $esg['id']?>&time=<?= h_dt_sub_day($datetime)?>&type=day" >
          往前一天
        </a> 
        &nbsp;&nbsp;&nbsp;
        <a href="/aging/home/agingdata?esg_id=<?= $esg['id']?>&time=<?= h_dt_add_day($datetime)?>&type=day" >
          往后一天
        </a> 
         &nbsp;&nbsp;&nbsp;
        <a href="/aging/home/agingdata?esg_id=<?= $esg['id']?>&type=recent" 
             class="<?= $type == "recent"?"a_active":""?>" >
         最新60条数据
        </a> 
        &nbsp;&nbsp;&nbsp;
        <a href="/aging/home/agingdata?esg_id=<?= $esg['id']?>&time=<?= h_dt_format("now")?>&type=day" 
             class="<?= $type == "day" && h_dt_start_time_of_day($datetime) == h_dt_start_time_of_day("now") ?"a_active":""?>" >
         当天全部数据
        </a>     
    </div>
</div>
    
<div style=""> 共有 <?= count($datas)?>个数据 (分布如下) </div>
<div class=row-fluid>
    <div class="span12">
        <table class="datalist" >
            <tr>
                <th> <b></b> </th>
                <th colspan=8 class="leftline"> <b>温度</b> </td>
                <th colspan=2 class="leftline"> <b>湿度</b> </td>
                <th colspan=4 class="leftline"> <b>开关</b> </td>
                <th colspan=2 class="leftline"> <b>电能</b> </td>
                <th colspan=2 class="leftline rightline"> <b>功率</b> </td>
                <th> <b></b> </td>
            </tr>
            <tr>
                <th> <b></b> </th>
                <th class="leftline"> <b>室内</b> </td>
                <th> <b>室外</b> </td>
                <th> <b>室外<br>(真实)</b> </td>
                <th> <b>空调1</b> </td>
                <th> <b>空调2</b> </td>
                <th> <b>恒温</b> </td>
                <th> <b>恒温1</b> </td>
                <th> <b>恒温2</b> </td>
                <th class="leftline"> <b>内</b> </td>
                <th > <b>外</b> </td>
                <th class="leftline"> <b>风</b> </td>
                <th> <b>空1</b> </td>
                <th> <b>空2</b> </td>
                <th> <b>恒</b> </td>
                <th class="leftline"> <b>总</b> </td>
                <th> <b>dc</b> </td>
                <th class="leftline"> <b>总</b> </td>
                <th> <b>dc</b> </td>
                <th class="leftline"> <b>采样时间</b> </td>
            </tr>
            
        <?php foreach ($datas as $data): ?>
        <tr>
            <td>#</td>
            <td > <?= $data['indoor_tmp']?>  </td>
            <td> <?= $data['outdoor_tmp']?>  </td>
            <td> <?= $data['true_out_tmp']?>  </td>
            <td> <?= $data['colds_0_tmp']?>  </td>
            <td> <?= $data['colds_1_tmp']?>  </td>
            <td> <?= $data['box_tmp']?>  </td>
            <td> <?= $data['box_tmp_1']?>  </td>
            <td> <?= $data['box_tmp_2']?>  </td>
            <td class="leftline"> <?= $data['indoor_hum']?>  </td>
            <td class="rightline"> <?= $data['outdoor_hum']?>  </td>
            <td class="fan_on_<?= $data['fan_0_on']?>"><?= $data['fan_0_on']?></td>
            <td class="colds_0_on_<?= $data['colds_0_on']?>"> <?= $data['colds_0_on']?> </td>
            <td class="colds_1_on_<?= $data['colds_1_on']?>"> <?= $data['colds_1_on']?> </td>
            <td > <?= $data['colds_box_on']?>  </td>
            <td class="leftline"> <?= $data['energy_main']?>  </td>
            <td> <?= $data['energy_dc']?>  </td>
            <td class="leftline"> <?= $data['power_main']?>  </td>
            <td class="rightline"> <?= $data['power_dc']?>  </td>
            <td class="<?= h_compare_dur($data['create_time'],"",10)?"name_alive":"" ?>" style="width:130px"> <?= $data['create_time']?>  </td>
        </tr>
        <?php endforeach?>
        </table>
    </div><!--span9 content-->
</div>

<script type="text/javascript">
    window.global_options = {
       "esg_id": "<?= $esg['id'] ?>",
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
                window.location.href="?esg_id="+window.global_options.esg_id+"&type=day&time="+window.global_options.time;
        }
    });
    $('.es_day input').attr("value",window.global_options.time);
});
</script>
