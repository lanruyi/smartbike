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
    <font>后台 >> 用户日志</font>
    </div>

<form  id="filter" method="get" action="">
<div class='filter'>
 搜索项目: <?= h_make_select(h_array_2_select($projects),'project_id',$this->input->get('project_id'))?>
 用户: <?= h_make_select(h_array_2_select($users),'user_id',$this->input->get('user_id')) ?>
 搜索数据: <input type="text" name="data" style="width:80px" value="<?= $this->input->get('data')?>">
 搜索url:  <input type="text" name="url" style="width:80px" value="<?= $this->input->get('url')?>">
 创建时间:<input type="text" name="create_start_time" style="width:100px" value="<?= $this->input->get('create_start_time')?>" />
 到:<input type="text" name="create_stop_time" style="width:100px" value="<?= $this->input->get('create_stop_time')?>" />
每页: <input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
</div>
<div class='operate'> 
<button type="submit" class="btn btn-primary"> 确定查询 </button>
<a href="/backend/userlog" class="btn btn-primary">清除查询</a> 
        <font style="display:inline-block;padding:4px 10px; font-size:13px; line-height:18px; vertical-align:middle;">
            <?= $filter_num_str?></font>
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
      <th><b>用户名</b></th>
      <th><b>项目</b></th>
      <th><b>url</b></th>
      <th><b>数据</b></th>
      <th><b>方法</b></th>
      <th><b>创建时间</b></th>
      </tr>
  </thead>
  <tbody>
    <?php foreach ($userlogs as $userlog): ?>
    <tr>
      <td><?=  $userlog['id'] ?>  </td>
      <td style="width:70px"><?=  $userlog['user_name_chn'] ?>   </td>
      <td style="width:100px"><?=  $userlog['project_name_chn'] ?>   </td>
      <td style="width:200px"><?=  $userlog['url'] ?>     </td>
      <td style="width:200px"><?=  $userlog['data'] ?>     </td>
      <td style="width:100px"><?=  $userlog['method'] ?>     </td>
      <td style="width:200px"><?=  $userlog['create_time'] ?>     </td>
       </tr>
    <?php endforeach?>
  </tbody>
</table>

<?= $pagination?>

</div>


