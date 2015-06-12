<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px ;}
#stations_div{position:absolute;z-index:1;display: none;width:400px;background-color: #eee;border:1px solid #666;}
#stations_div ul,#stations_div ul li{float:left;list-style: none;margin:0;padding:0}
#stations_div ul li{margin:3px;}
</style>

<script>
$(function(){
    $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'});
});
</script>


<div class=base_center>

<div style="margin:0;width:100%">
<font>后台 >> 自检列表</font>
</div>

    <? if($station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>

<form id="filter" method="get" action="">
    <div class='filter'>
      <input type='hidden' name='station_id' value="<?= $this->input->get('station_id')?>" />
      每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
    </div>
    <div class='operate'>
      <button type="submit" class="btn btn-primary">确定查询</button> 
      <? if($station){ ?>
        <a href="/backend/autocheck?station_id=<?= $station['id'] ?>" class="btn btn-primary">清除查询</a>
      <?}else{?>
        <a href="/backend/autocheck" class="btn btn-primary">清除查询</a>
      <?}?>
      
    <? if($station){?>
    <span style="float:right">
    <a href="/backend/autocheck/add_autocheck?station_id=<?=  $this->input->get('station_id')?>&backurl=<?=$backurlstr?>" class="btn btn-primary">添加命令</a>
    </span>
    <?}?>
    </div>
</form>


<?= $pagination?>
<table class="table2">
<tr>
<td> <b>#</b> </td>
<td> <b>基站</b> </td>
<td> <b>时间</b> </td>
<td> <b>报告</b> </td>
<td>  </td>
<td>  </td>
</tr>
<?php foreach ($autochecks as $autocheck){?>
<tr>
<td> <?= $autocheck['id'] ?> </td>
<td> 
    <?= $this->station->getNameChn($autocheck['station_id'])?> 
</td>
<td> <?= $autocheck['datetime'] ?> </td>
<td> <?= h_autocheck_report_trans($autocheck['report'])?></td>
<td> 
    <a href="/backend/data?station_id=<?= $autocheck['station_id']?>&time=<?= h_dt_format($autocheck['datetime'])?>&type=hour">
        点击查看数据
    </a>
</td>
<td> <a href="/backend/autocheck/re_check?auto_check_id=<?= $autocheck['id']?>&backurl=<?= $backurlstr?>">重算</a></td>
</tr>
<?}?>
</table>
<?= $pagination?>

</div>


