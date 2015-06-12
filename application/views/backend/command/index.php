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
<font>后台 >> 命令列表</font>
</div>

    <? if($station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>

<form id="filter" method="get" action="">
    <div class='filter'>
      <input type='hidden' name='station_id' value="<?= $this->input->get('station_id')?>" />
      命令类型:<?= h_command_type_select($this->input->get('command')) ?>
      状态:<?= h_command_status_select($this->input->get('status')) ?>
      操作人员:<input type="text" name="user_name_chn" value="<?= $this->input->get('user_name_chn') ?>" style="width:100px">
      创建时间:<input type="text" name="create_start_time" style="width:100px" value="<?= $this->input->get('create_start_time') ?>"> 
      到:<input type="text" name="create_stop_time" style="width:100px"  value="<?= $this->input->get('create_stop_time') ?>"> 
      每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
    </div>
    <div class='operate'>
      <button type="submit" class="btn btn-primary">确定查询</button> 
      <? if($station){ ?>
        <a href="/backend/command?station_id=<?= $station['id'] ?>" class="btn btn-primary">清除查询</a>
      <?}else{?>
        <a href="/backend/command" class="btn btn-primary">清除查询</a>
      <?}?>
      
    <? if($station){?>
    <span style="float:right">
    <a href="/backend/command/add_command?station_id=<?=  $this->input->get('station_id')?>&backurl=<?=$backurlstr?>" class="btn btn-primary">添加命令</a>
    </span>
    <?}?>
    </div>
</form>


<?= $pagination?>
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th> <b>#</b> </th>
<th> <b>站点</b> </th>
<th> <b>命令</b> </th>
<th> <b>参数</b> </th>
<th> <b>优先级</b> </th>
<th> <b>状态</b> </th>
<th> <b>人员</b> </th>
<th> <b>时间</b> </th>
<th> <b>操作</b> </th>
</tr>
</thead>
<tbody>
<?php foreach ($commands as $command): ?>
<tr>
<td> <?= $command['id'] ?> </td>
<td> 
    <a href="/backend/command?station_id=<?= $command['station_id']?>" target="_blank">
        <?= $command['station_name_chn'] ?> 
    </a>
</td>
<td> <?= h_command_type_name_chn($command['command']) ?>  </td>
<td> <?= $command['arg'] ?>  </td>
<td> <?= $command['priority'] ?>  </td>
<td> <?= h_command_status_color_name_chn($command['status']) ?>  </td>
<td> <?= $command['user_name_chn']?></td>
<td> <?= $command['create_time']?></td>
         <td><a class="btn btn-primary btn-mini" href="#" 
          onclick="confirm_jumping('确定删除','/backend/command/del_command/<?= $command['id'] ?>?backurl=<?= $backurlstr?>')">删除</a>
</td>
</tr>
<?php endforeach?>
</tbody>
</table>
<?= $pagination?>

</div>


