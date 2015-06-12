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

    <div style="margin:0;width:100%;display:none">
    <font> 命令列表 </font>
    </div>


    <table class="table table-striped table-bordered table-condensed">
  <thead>
      <tr>
      <th> <b>ESG_ID</b> </th>
      <th>当前状态</th>
      <th>总上报次数</th>
      <th>老化开始时间</th>
      <th>老化结束时间</th>
      <th>最后更新时间</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?= h_online_mark($esg['alive'])."&nbsp;".$esg['id'] ?> </td>
      <td><b><?= h_aging_process_name_chn($esg['aging_status']) ?></b> </td>
      <td><?= $esg['count'] ?>    </td>
      <td><?= $esg['aging_start_time'] ?> </td>
      <td><?= $esg['aging_stop_time']  ?> </td>
      <td><?= $esg['last_update_time'] ?> </td>
    </tr>
    <tr>
        <td colspan=6> 
             <? if( ESC_ESG_AGING_ING == $esg['aging_status'] || ESC_ESG_AGING_FINISH == $esg['aging_status'] ){ ?>
                <a href="/aging/home/agingdata?esg_id=<?= $esg['id']?>?backurl=<?= $backurlstr?>" class='btn btn-mini btn-primary'>数据</a>
                 <a href="/aging/aging_cmd?esg_id=<?= $esg['id']?>" class='btn btn-mini btn-primary'>命令</a>
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
  </tbody>
</table>
    
    <form id="filter" method="get" action="">
        <div class='filter'>
          <input type='hidden' name='esg_id' value="<?= $this->input->get('esg_id')?>" />
          命令类型:<?= h_command_type_select($this->input->get('command')) ?>
          状态:<?= h_command_status_select($this->input->get('status')) ?>
          操作人员:<input type="text" name="user_name_chn" value="<?= $this->input->get('user_name_chn') ?>" style="width:100px">
          创建时间:<input type="text" name="create_start_time" style="width:100px" value="<?= $this->input->get('create_start_time') ?>"> 
          到:<input type="text" name="create_stop_time" style="width:100px"  value="<?= $this->input->get('create_stop_time') ?>"> 
          每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
        </div>

        <div class='operate'>
          <button type="submit" class="btn btn-primary">确定查询</button> 
          <? if($esg){ ?>
            <a href="/aging/aging_cmd?esg_id=<?= $esg['id'] ?>" class="btn btn-primary">清除查询</a>
          <?}else{?>
            <a href="/aging/aging_cmd" class="btn btn-primary">清除查询</a>
          <?}?>
        </div>
    </form>
    
    <?= $pagination?>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th> <b>#</b> </th>
                <th> <b>ESG</b> </th>
                <th> <b>命令</b> </th>
                <th> <b>参数</b> </th>   
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
                <td> <a href="#"><?= $esg['id'] ?></a></td>
                <td> <?= h_command_type_name_chn($command['command']) ?>  </td>
                <td> <?= $command['arg'] ?>  </td>
                <td> <?= h_command_status_color_name_chn($command['status']) ?>  </td>
                <td> <?= $command['user_id'] ?></td>
                <td> <?= $command['create_time']?></td>
                         <td><a class="btn btn-primary btn-mini" href="#" 
                          onclick="confirm_jumping('确定删除','/aging/aging_cmd/del_command/<?= $command['id'] ?>?backurl=<?= $backurlstr?>')">删除</a>
                </td>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
    <?= $pagination?>
</div>




