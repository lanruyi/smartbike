
    <div class="base_center">
    <div>
    <font>后台 >> 边界列表</font>
    </div>

<div class=row-fluid>
	

<form id="filter" method="get" action="">
<div class='filter'>
</div>
<div class='operate'>
<a href="/backend/edge/new_entity?backurl=<?= $backurlstr?>" class="btn btn-primary"><i class=""></i>增加新边界</a>
</div>
</form>


<?= $pagination?>

<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th> <b>ID</b> </th>
      <th>名</th>
      <th>描述</th>
      <th style="width:50px">门限</th>
      <th style="width:120px">测试时间</th>
      <th style="width:80px">基站数</th>
      <th style="width:160px"><b>操作</b> </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($edges as $edge): ?>
    <tr>
      <td><?= $edge['id'] ?>     </td>
      <td><?= $edge['name_chn'] ?></a></td>
      <td><?= $edge['edge_desc'] ?></a></td>
      <td><?= $edge['threshold'] ?>  </td>
      <td><?= $edge['last_query_time'] ?></td>
      <td><?= $edge['station_nums'] ?> <a href="/backend/edge/stations/<?= $edge['id'] ?>">查看</a> </td>
      <td>
          <?php if(h_auth_check_role($this->user_role,ESC_AUTHORITY__BACKEND_ADMINISTRATOR)){?>
          <a href="/backend/edge/mod_entity/<?= $edge['id']?>?backurl=<?= $backurlstr?>">修改</a>
          <a href="/backend/edge/test/<?= $edge['id']?>?backurl=<?= $backurlstr?>">测试</a>
          <?php }?>
      </td>
    </tr>
    <tr>
      <td>     </td>
      <td colspan='5'><?= $edge['query'] ?></td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>
<?= $pagination?>

</div>
