<div class=base_center>

<a href ="/backend/contract/add_contract" class="btn btn-success"> <i class="icon-plus-sign icon-white"></i> 添加合同 </a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href ="/backend/contract/generate_phase_num" class="btn btn-success"> <i class="icon-plus-sign icon-white"></i> 计算期数 </a>
<br>
<br>

<table class="table table-striped table-bordered table-condensed" style="width:100%">
  <thead>
    <tr>
      <th></th>
      <th colspan="4"> 参数 </th>
      <th> 操作 </th>
    </tr>
    <tr>
      <th>#ID </th>
      <th>项目</th>
      <th>分期 </th>
      <th>分期别名 </th>
      <th>合同号 </th>
      <th>描述 </th>
      <th>创建时间</th>
      <th>删除 </th>
      <th>修改 </th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($contracts as $contract): ?>
    <tr>
      <td><?= $contract['id'] ?>     </td>
      <td><?= $contract['project_name_chn'] ?>    </td>
      <td><?= h_contract_phase_name_chn($contract['phase_num']) ?>    </td>
      <td><?= $contract['alias'] ?>    </td>
      <td><?= $contract['name_chn'] ?>     </td>
      <td><?= $contract['content'] ?>     </td>
      <td><?= $contract['create_time'] ?>     </td>
      <td><a href="javascript:if(confirm('确实要删除'))location='/backend/contract/del_contract/<?= $contract['id']?>?backurl=<?=$backurlstr?>';void(0)">删除</a></td>
      <td><a href="/backend/contract/mod_contract/<?= $contract['id']?>">修改</a></td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>

</div>
