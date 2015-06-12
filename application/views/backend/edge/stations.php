    <div class="base_center">
    <div>
    <font>后台 >> 边界列表 >> 基站列表</font>
    </div>

<div class=row-fluid>
	



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
    <tr>
      <td><?= $edge['id'] ?>     </td>
      <td><?= $edge['name_chn'] ?></a></td>
      <td><?= $edge['edge_desc'] ?></a></td>
      <td><?= $edge['threshold'] ?>  </td>
      <td><?= $edge['last_query_time']  ?></td>
      <td><?= $edge['station_nums'] ?></td>
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
  </tbody>
</table>


<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th> <b>ID</b> </th>
      <th>基站</th>
      <th>项目</th>
      <th>城市</th>
      <th>类型</th>
      <th>问题数</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
   <? foreach ($stations as $station){ ?>
    <tr>
      <td></td>
      <td><?= $station['station_name'] ?></a></td>
      <td><?= $station['project_name'] ?></a></td>
      <td><?= $station['area_name'] ?></a></td>
      <td><?= h_station_station_type_name_chn($station['station_type']) ?></a></td>
      <td><?= $station['nums'] ?></a></td>
      <td></td>
      <td></td>
    </tr>
    <?}?>
  </tbody>
</table>



</div>
