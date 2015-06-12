<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px ;}

</style>

<script>
$(function(){
    $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'});
})
</script>

<div class=base_center>

    <div style="margin:0;width:100%">
    <font>后台 >> 警告列表</font>
    </div>

    <? if(isset($station) && $station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>

<form id="filter" method="get" action="">
<div class='filter'>
<input type='hidden' name='station_id' value="<?= $this->input->get('station_id')?>" />
报警类型:<?= h_warning_type_select($this->input->get('type'))?>
报警状态:<?= h_warning_status_select($this->input->get('status'))?>
创建时间:<input type="text" name="create_start_time" style="width:80px" value="<?= $this->input->get('create_start_time') ?>"> 
    到:<input type="text" name="create_stop_time" style="width:80px"  value="<?= $this->input->get('create_stop_time') ?>"> 
    每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
</div>
<div class='operate'>
    <button type="submit" class="btn btn-primary">确定查询</button> 
    <? if($station){ ?>
        <a href="/backend/warning?station_id=<?= $station['id'] ?>" class="btn btn-primary">清除查询</a>
    <?}else{?>
        <a href="/backend/warning" class="btn btn-primary">清除查询</a>
    <?}?>
</div>
</form>


<?= $pagination?>
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th></th>
<th colspan=3> <b>参数</b> </th>
<th colspan=2> <b>操作</b> </th>
</tr>
<tr>
<th> <b>#</b> </th>
<th> <b>报警站点</b> </th>
<th> <b>报警类型</b> </th>
<th> <b>报警时间</b> </th>
<th> <b>报警状态</b> </th>
<th> <b>删除</b> </th>
<th> <b>修改</b> </th>
</tr>
</thead>
<tbody>
<?php foreach ($warnings as $warning): ?>
<tr>
<td> <?= $warning['id']?> </td>
<td> <?= $warning['station_name_chn']?$warning['station_name_chn']:"no sta"?> </td>
<td> <?= h_warning_type_name_chn($warning['type'])?>  </td>
<td> <?= $warning['start_time']?>  </td>
<td> <?= h_warning_status_name_chn($warning['status'])?>  </td>
<td> <a href="javascript:if(confirm('确实要删除'))location='/backend/warning/del_warning/<?= $warning['id'] ?>/<?= $station['id'] ?>';void(0)">删除</a></td>
<td> <a href="/backend/warning/mod_warning/<?= $warning['id']?>">修改</a></td>
</tr>
<?php endforeach?>
</tbody>
</table>
<?= $pagination?>

</div><!--span9 content-->
