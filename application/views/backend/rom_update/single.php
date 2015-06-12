<script>
$(function(){ 
        $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'}); 
    });
</script>


<div class=base_center>

<div style="margin:0;width:100%">
<font>后台 >> ROM 更新</font>
</div>

    <? if(isset($station) && $station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>



<?if(!$current_rom_update){?>

    <?php
        $hidden = array('station_id' => $station['id']);
        echo form_open("/backend/rom_update/start_update_rom",null,$hidden); 
    ?>
    当前固件：<?= $station['rom']?$station['rom']['version']:""?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    请选择rom: 
    <select id='rom_id_select' name="new_rom_id" style="width:350px">
        <? foreach ($roms as $rom):?>
            <option value="<?= $rom['id']?>"><?= $rom['version']?> PartNum: <?= $rom['part_num']?> Size:<?= $rom['size']?></option>
        <? endforeach ?>
    </select>
    <?= form_submit("","提交"); ?> 

<?}else{?>
    
    当前正在跟新固件
    <br>
    本次从：
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;老固件 <?= $station['rom']?$station['rom']['version']:""?>
    <br>
    更新到：
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;新固件 <?= $current_rom_update['new_rom']['version']?>
    &nbsp;&nbsp;(共有n个区块)
    <br>

<?}?>








<div style='clear:both'> </div>
<br>


<!-------------------------------------------------------------------->

<table class="table2">
<tr>
<td colspan=7 style="background-color:#ccc;font-size:14px;"> <b>本站过去 版本升级历史</b> </td>
</tr>
<tr>
<td> <b>老版本</b> </td>
<td> <b>新版本</b> </td>
<td> <b>开始时间</b> </td>
<td> <b>下载完时间</b> </td>
<td> <b>结束时间</b> </td>
<td> <b>结束时状态</b> </td>
<td> <b>结果</b> </td>
</tr>

<?php foreach ($rom_updates as $rom_update): ?>
<tr>
<td> <?= $rom_update['old_rom']?$rom_update['old_rom']['version']:""?> </td>
<td> <?= $rom_update['new_rom']['version'] ?> </td>
<td> <?= $rom_update['start_time'] ?> </td>
<td> <?= $rom_update['down_time'] ?> </td>
<td> <?= $rom_update['stop_time'] ?> </td>
<td> <?= $rom_update['status'] ?> </td>
<td>  
    <?= $rom_update['status']==ESC_UR_STATUS__COMFIRMED?
    "<font color=green>成功</font>": 
    "<font color=red>失败</font>" ?>
</td>
</tr>

<?php endforeach?>
</table>

</div>
<script type="text/javascript" src="/static/site/js/frontend_basic.js?id=<?= hsid()?>"></script>
<script type="text/javascript" src="/static/site/js/frontend_day.js?id=<?= hsid()?>"></script>
<script type="text/javascript">
	window.global_options = {
        "station_id": "<?= $station['id'] ?>"
        }

	$(document).ready(function(){
    });
</script>
