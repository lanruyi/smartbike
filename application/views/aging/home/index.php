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

<form id="filter" method="get" action="">
<div class='filter'>
    搜索ESG ID: <input type="text" name="search"  value="<?= $this->input->get('search') ?>" style="width:100px" >
    在线:<?= h_alive_select($this->input->get('alive'));?>
    老化状态:<?= h_aging_process_select($this->input->get('aging_status'));?>
    <br>
    老化开始时间:<input type="text" name="create_start_begin_time" class="form-control input-xs" placeholder="2014-07-01" style="width:100px" value="<?= $this->input->get('create_start_begin_time') ?>"> 
    到:<input type="text" name="create_start_end_time" class="form-control input-xs" placeholder="2014-07-03" style="width:100px"  value="<?= $this->input->get('create_start_end_time') ?>"> 
    老化结束时间:<input type="text" name="create_stop_begin_time" class="form-control input-xs" placeholder="2014-07-05" style="width:100px" value="<?= $this->input->get('create_stop_end_time') ?>"> 
    到:<input type="text" name="create_stop_end_time" class="form-control input-xs" placeholder="2014-07-07" style="width:100px"  value="<?= $this->input->get('create_stop_end_time') ?>"> 
	每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page')?>" type="text" />
</div>
<div class='operate'>
		<button type="submit" class="btn btn-primary">确定查询</button> 
        <a href="/aging/home/index" class="btn btn-primary">清除查询</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/aging/home/index?aging_status=2" class="btn  btn-success" >老化中</font></a>
        <a href="/aging/home/index?aging_status=1" class="btn  btn-danger" >未老化</font></a>
        <a href="/aging/home/index?aging_status=3" class = "btn  btn-primary" >老化完成</font></a>
</div>
</form>

<?= $pagination?>
    <?php foreach ($esgs as $k=>$esg): ?>
    <table class="table table-striped table-bordered table-condensed">
  <thead>
      <tr>
        <th>序号</th>
        <th>当前状态</th>
        <th> <b>ESG_ID</b> </th>
        <th>老化开始时间</th>
        <th>老化结束时间</th>
        <th>最后更新时间</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <td><?= $k?></td>
        <td><b><?=h_aging_status_clolor($esg['aging_status'])?></b> </td>
        <td><?= h_online_mark($esg['alive'])."&nbsp;".$esg['id'] ?> </td>
        <td><?= $esg['aging_start_time'] ?> </td>
        <td><?= $esg['aging_stop_time']  ?> </td>
        <td><?= $esg['last_update_time'] ?> </td>
    </tr>
    <tr>
        <td colspan=6> 
             <? if( ESC_ESG_AGING_ING == $esg['aging_status'] || ESC_ESG_AGING_FINISH == $esg['aging_status'] ){ ?>
                <a href="/aging/home/agingdata?esg_id=<?= $esg['id']?>?backurl=<?= $backurlstr?>" class='btn btn-mini btn-primary' target="_blank">数据</a>
                 <a href="/aging/aging_cmd?esg_id=<?= $esg['id']?>" class='btn btn-mini btn-primary' target="_blank">命令</a>
                <a href="/aging/home/report_aging/<?= $esg['id']?>?backurl=<?= $backurlstr?>" class='btn btn-mini btn-primary' target="_blank">报告</a>  
             <? }?>
             
            
             
             <? if( ESC_ESG_AGING_NONE == $esg['aging_status'] ){ ?>
                <a href="#" onclick="confirm_jumping('开始<?= $esg['id']?>号ESG老化','/aging/home/start_aging/<?= $esg['id']?>?backurl=<?= $backurlstr?>')"  class='btn btn-mini btn-primary'>开始</a> 
             <? }else if( ESC_ESG_AGING_ING == $esg['aging_status'] ){ ?>
                &nbsp;&nbsp;&nbsp;<a href="#" onclick="confirm_jumping('结束<?= $esg['id']?>号ESG老化','/aging/home/stop_aging/<?= $esg['id']?>?backurl=<?= $backurlstr?>')"  class='btn btn-mini btn-inverse'>结束老化</a> 
             <? }else if( ESC_ESG_AGING_FINISH == $esg['aging_status'] ){ ?>
                &nbsp;&nbsp;&nbsp;<a href="#" onclick="confirm_jumping('重置<?= $esg['id']?>号ESG老化','/aging/home/reset_aging/<?= $esg['id']?>?backurl=<?= $backurlstr?>')"  class='btn btn-mini btn-danger'>重新老化</a> 
             <? }?>
             
        </td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>
    <br><br>
<?= $pagination?>

</div>




