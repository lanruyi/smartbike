
<div class='base_center'>

    <div style="margin:0;width:100%">
    <font>后台 >> 电表同步</font>
    </div>

    <? if(isset($station) && $station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>


<table class='table2'>
    <tr style="background-color:#ccc">
    <td><b>时间</b></td>
    <td><b>博欧电表值</b</td>
    <td><b>客户电表值</b</td>
    <td></td>
    <td><b>base</b></td>
    <td><b>correct_base</b</td>
    <td><b>slope</b</td>
    <td></td>
    </tr>

    <? foreach($corrects as $correct){?>
    <tr>
    <td><?= $correct['time']?> </td>
    <td><?= $correct['org_num']?> </td>
    <td><?= $correct['correct_num']?> </td>
    <td></td>
    <td><?= $correct['base'] ? $correct['base']:""?> </td>
    <td><?= $correct['correct_base'] ? $correct['correct_base']:"" ?> </td>
    <td><?= $correct['slope'] ? $correct['slope']:"" ?> </td>
    <td> 
        <a href="javascript:
            if(confirm('确实要删除'))
                location='/backend/correct/del_correct/<?= 
                $station['id']?>/<?= $correct['id']?>?backurl=<?= $backurlstr?>';void(0)">
            删除
        </a>
    </td>
    </tr>
    <? }?>
</table>

<div style="clear:both"> </div>

<br />
<br />
<?= form_open("/backend/correct/add_correct/".$station['id']."?backurl=".$backurlstr); ?>
输入当前电表值<input name="correct_num" />
<?php echo form_submit("","输入"); ?> 
<?php echo form_close(); ?>


</div>

