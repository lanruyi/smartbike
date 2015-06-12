<div class=base_center>

<a href ="/backend/batch/add_batch" class="btn btn-success"> <i class="icon-plus-sign icon-white"></i> 添加批次</a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href ="/backend/batch/generate_batch_num" class="btn btn-success"> <i class="icon-plus-sign icon-white"></i> 生成批次 </a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href ="/backend/batch/generate_batch_name_chn" class="btn btn-success"> <i class="icon-plus-sign icon-white"></i> 生成全名 </a>
<br>
<br>

<table class="table2" style="width:100%">
  <thead>
    <tr style="background-color:#ddd">
      <td>全名 </td>
      <td>合同号</td>
      <td>城市 </td>
      <td>批次 </td>
      <td>运营时间 </td>
      <td>总时间（月） </td>
      <td>已收/应收款（月） </td>
      <td>上次收款时间 </td>
      <td>操作 </td>
    </tr>
  </thead>
  <tbody>
    <? foreach ($batches as $batch): ?>
    <tr>
      <td><?= $batch['name_chn'] ?>     </td>
      <td><?= $batch['contract_name_chn'] ?>    </td>
      <td><?= $batch['city_name_chn'] ?>     </td>
      <td><?= h_batch_batch_name_chn($batch['batch_num']) ?>     </td>
      <td><?= $batch['start_time'] ?>     </td>
      <td><?= $batch['total_month'] ?>     </td>
      <td>
          <?= h_batch_interval($batch['start_time'],$batch['current_time']) ?> 
          /<?= h_batch_interval($batch['start_time'],'now') ?>     
      </td>
      <td><?= $batch['current_time'] ?>     </td>
      <td><a href="/backend/batch/mod_batch/<?= $batch['id']?>">修改</a></td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>

</div>
