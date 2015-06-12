<?// view/backend/cmail/index.php
?>

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
    <font>后台 >> 邮件列表</font>
    </div>

<div>
<form id="filter" method="get" action="">
<div class='filter'>
   搜索主题: <input type="text" name="subject" value="<?= $this->input->get('subject') ?>" style="width:100px"/>
   搜索内容: <input type="text" name="content" value="<?= $this->input->get('content') ?>" style="width:100px"/>
   发送状态: <?= h_cmail_status_select($this->input->get('status')); ?>
   创建时间: <input type="text" name="create_start_time" style="width:100px" value="<?= $this->input->get('create_start_time') ?>"> 
    到: <input type="text" name="create_stop_time" style="width:100px"  value="<?= $this->input->get('create_stop_time') ?>"> 
    每页: <input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
</div>
<div class='operate'>
		<button type="submit" class="btn btn-primary">确定查询</button> 
        <a href="/backend/cmail/index" class="btn btn-primary">清除查询</a>
        <font style="display:inline-block;padding:4px 10px; font-size:13px; line-height:18px; vertical-align:middle;">
            <?= $filter_num_str?></font>
        <a href='/backend/cmail/verify_cmailstatus' class="btn btn-primary" style="float:right;"> 取消所有未发送的邮件 </a>

</div>
</form>



<?= $pagination?>
<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th></th>
      <th colspan="10"> <b>参数</b> </th>
    </tr>
    <tr>
      <th> <b>#</b> </th>
      <th><b>收件人</b></th>
      <th><b>发件人</b></th>
      <th><b>主题</b></th>
      <th><b>内容</b></th>
      <th><b>类型</b></th>
      <th><b>状态</b></th>
      <th><b>优先级</b></th>
      <th><b>创建时间</b></th>
      <th><b>发送时间</b></th>
      <th><b>真实发送时间</b></th>   
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cmails as $cmail): ?>
    <tr>
      <td><?=  $cmail['id'] ?>      </td>
      <td ><div style="width:120px;height:60px;overflow:scroll"><?=  $cmail['to_add'] ?></div></td>
      <td><?=  $cmail['from_add'] ?>     </td>
      <td><?=  $cmail['subject'] ?>     </td>
      <td><?=  $cmail['content'] ?>     </td>
      <td><?=  $cmail['type'] ?>     </td>
      <td><?=  h_cmail_status_name_chn($cmail['status']) ?>     </td>
      <td><?=  $cmail['priority'] ?>     </td>
      <td><?=  $cmail['create_time'] ?>     </td>
      <td><?=  $cmail['send_time'] ?>     </td>
      <td><?=  $cmail['real_send_time'] ?>     </td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>

<?= $pagination?>

</div>
