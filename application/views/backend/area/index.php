<div class=base_center>

<a href ="/backend/area/add_city" class="btn btn-success"> <i class="icon-plus-sign icon-white"></i> 添加城市</a>
<br>
<br>

<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th></th>
      <th colspan="5"> <b>参数</b> </th>
      <th> <b>操作</b> </th>
    </tr>
    <tr>
      <th> <b>#</b> </th>
      <th>地区名称</th>
      <th>地区拼音</th>
      <th>区县（总）</th>
      <th>经度</th>
      <th>纬度</th>
      <th>weather_code</th>
      <th> <b>添加</b> </th>
      <th> <b>修改</b> </th>
      <th> <b>查看</b> </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($areas as $area): ?>
    <tr>
      <td><?=  $area['id'] ?>     </td>
      <td><?= $area['name_chn'] ?>    </td>
      <td><?= $area['name_py'] ?>     </td>
      <td><?= $area['sum'] ?>     </td>
      <td><?= $area['lng'] ?>      </td>
      <td><?= $area['lat'] ?>     </td>
      <td><?=  $area['weather_code'] ?>     </td>
      <td><a href="/backend/area/add_district/<?= $area['id']?>">添加区县</a></td>
      <td><a href="/backend/area/mod_city/<?= $area['id']?>">修改</a></td>
      <td><a href="/backend/area/one_city/<?= $area['id']?>">查看区县</a></td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>

</div>
<!--span9 content-->
