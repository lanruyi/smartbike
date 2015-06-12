<div class="base_center">
	
<div style="margin:0;width:100%">
<font>后台 >> 本站设置 </font>
</div>

<? if(isset($station) && $station){?>
    <? $this->load->view("backend/onestation",array('station'=>$station))?>
<?}?>

<?php 
    $now = new DateTime();
	$hidden = array('station_id'=>$station['id']);
    echo form_open("/backend/esgconf/station_esgconf_go?backurl=".urlencode("/backend/command?station_id=".$station['id']),null,$hidden); 
?>


<? if($gs_command){?>
    正在获取中,请稍候...
<?}else{?>
    <a class="btn" href="/backend/esgconf/station_esgconf_get/<?= $station['id'] ?>">获取本站设置</a>
<?}?>
<a class="btn" href="/backend/esgconf/set_setting/<?= $station['id'] ?>">刷新</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<? if($esgconf){?>

    上一次读取时间：<?= $esgconf['last_update_time'] ?><br><br>
<?}else{?>
    从未读取过站点设置
<?}?>


<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th colspan=3> <b>变量</b> </th>
<th colspan=1> <b></b> </th>
</tr>
<tr>
<th colspan=1> <b>变量名</b> </th>
<th colspan=1> <b>当前值</b> </th>
<th colspan=1> <b>设置参数</b> </th>
<th colspan=1> <b>描述</b> </th>
</tr>
</thead>
<tbody>


    <?php foreach (h_esgconf_array() as $_c => $_esgconf){?>
        <tr>
            <td><?= $_c?>.<?= $_esgconf['cn']?><br />(<?= $_esgconf['en'] ?>)</td> 
            <td><?= $esgconf[$_esgconf['en']] ?></td>
            <td>
                <input type="text" name="<?= $_esgconf['en']?>" 
                    value="<?= $this->input->post($_esgconf['en'])?>" 
                    <?= h_esgconf_is_dis($_c)?'disabled="disabled"':''?> /> 
            </td>
            <td><?= $_esgconf['desc'] ?></td>
        </tr>
    <?}?>

</tbody>
</table>

    <ul><?php echo form_submit("","提交"); ?> 
    	<input type="button" value="取消" onclick="window.location='/backend/station/slist'" />
    </ul>
    
<?php echo form_close(); ?>

</div>
