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
    <font>后台 >> ESG列表</font>
    </div>


<form id="filter" method="get" action="">
<div class='filter'>
	搜索esg ID: <input type="text" name="search" value="<?= $this->input->get('search') ?>" style="width:100px" >
	在线情况:<?= h_alive_select($this->input->get('alive'));?>
	老化情况:<?= h_aging_process_select($this->input->get('aging_status'));?>
	创建时间:<input type="text" name="create_start_time" style="width:80px" id="create_start_time" value="<?= $this->input->get('create_start_time')?>"> 
        到:<input type="text" name="create_stop_time" style="width:80px"  id="create_stop_time" value="<?= $this->input->get('create_stop_time')?>"> 
	每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page')?>" type="text" />
</div>
<div class='operate'>
		<button type="submit" class="btn btn-primary">确定查询</button> 
        <a href="/backend/esg/index" class="btn btn-primary">清除查询</a>
        <a href="/backend/esg/verify_agingstatus" class="btn btn-primary" style="float:right;">确认ESG老化合理</a>
</div>
</form>

<?= $pagination?>
<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th></th>
      <th colspan=9> <b>参数</b> </th>
      <th> <b>操作</b> </th>
    </tr>
    <tr>
      <th> <b>ESG_ID</b> </th>
      <th>KEY</th>
      <th>基站</th>
      <th>老化</th>
      <th>老化开始时间</th>
      <th>老化结束时间</th>
      <th>上报次数</th>
      <th>最后更新时间</th>
      <th>创建时间</th>
      <th>板子状态</th>
      <th> <b>修改</b> </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($esgs as $esg): ?>
    <tr>
      <td><?= h_online_mark($esg['alive'])."&nbsp;".$esg['id'] ?>     </td>
      <td><a href="#" title='<?= $esg['esg_key'] ?>'><?= strlen($esg['esg_key']) ?></a></td>
      <td><?= $esg['station']?$esg['station']['name_chn']:"" ?></td>
      <td><?= h_aging_process_name_chn($esg['aging_status']) ?></td>
      <td><?= $esg['aging_start_time'] ?></td>
      <td><?= $esg['aging_stop_time'] ?></td>
      <td><?= $esg['count'] ?>    </td>
      <td><?= $esg['last_update_time'] ?>     </td>
      <td><?= $esg['create_time']  ?> </td>
      <td><?= $esg['status'] ?>  </td>
      <td>
      <?php if(h_auth_check_role($this->user_role,ESC_AUTHORITY__BACKEND_ADMINISTRATOR)){?>
      <a href="/backend/esg/mod_esg/<?= $esg['id']?>?backurl=<?= $backurlstr?>">修改</a>
      <?php }?></td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>
<?= $pagination?>
</div>
