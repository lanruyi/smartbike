<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px ;}

</style>

<script>
$(function(){
    $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'});
});
</script>

<div class=base_center>

    <div style="margin:0;width:100%">
    <font> 故障列表</font>
    </div>

<form id="filter" method="get" action="">
<div class='filter'>
<input type='hidden' name='station_id' value="<?= $this->input->get('station_id')?>" />
类型:<?= h_frontend_bug_type_select($this->input->get('type'))?>
状态:<?= h_bug_status_select($this->input->get('status'))?>
故障时间:<input type="text" name="create_start_time" style="width:80px" value="<?= $this->input->get('create_start_time') ?>"> 
    到:<input type="text" name="create_stop_time" style="width:80px"  value="<?= $this->input->get('create_stop_time') ?>"> 
    每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
</div>
<div class='operate'>
    <button type="submit" class="btn btn-primary">确定查询</button>
    <? if(isset($station) && $station){ ?>
        <a href="/frontend/single/bug?station_id=<?= $station['id'] ?>" class="btn btn-primary">清除查询</a>
    <?}else{?>
        <a href="/frontend/single/bug" class="btn btn-primary">清除查询</a>
    <?}?>
</div>
</form>

<? if($station && $station['alive'] == ESC_OFFLINE){?>
<div style="width:984px;line-height:24px; padding:2px 8px;background-color:<?= $dis_bugs?"#eaa":"#aea"?>;display:none">
    <? if($dis_bugs){?>
        <font style="color:red">
            本站断线前有 <b><?= count($dis_bugs)?></b> 个其他故障
        </font>：
        <? foreach($dis_bugs as $dis_bug){?>
            <?= h_bug_type_name_chn($dis_bug['type']);?>
            &nbsp;&nbsp;&nbsp;&nbsp;
        <?}?>
    <?}else{?>
        <font style="color:green">本站断线前无其他故障</font>
    <?}?>
</div>
<?}?>


<?= $pagination?>
<table class="table2">
<thead>
<tr>
<td> <b>#</b> </td>
<td> <b>站点</b> </td>
<td> <b>故障类型</b> </td>
<td> <b>参数</b> </td>
<td> <b>故障开始时间</b> </td>
<td> <b>结束时间</b> </td>
<td> <b>故障状态</b> </td>
<td> <b>操作</b> </td>
</tr>
</thead>
<? foreach ($bugs as $bug){?>
<tr>
<td> <?= $bug['id']?> </td>
<td> 
    <a href="/frontend/single/bug?station_id=<?= $station['id']?>">
        <?= $station['name_chn'] ?> 
    </a>
</td>
<td> <?= h_bug_type_name_chn($bug['type'])?>  </td>
<td> <?= $bug['arg']?>  </td>
<td> <?= $bug['start_time']?>  </td>
<td> <?= $bug['stop_time']?>  </td>
<td> <?= h_bug_status_name_chn($bug['status'])?>  </td>
<td> 
    
    <!-- 注释原因：故障为啥要删除？
    <a href="javascript:if(confirm('确实要删除'))location='/backend/bug/del_bug/<?= $bug['id'] ?>/<?= $station['id'] ?>';void(0)">删除</a>
    -->
</td>
</tr>
<?}?>
</table>
<?= $pagination?>

</div>
