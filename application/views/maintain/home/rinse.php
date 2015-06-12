
<div class=base_center>

<style>
.detail_f{margin:0;padding:0}
.detail_f ul{float:left;margin:2px 0;padding:0;}
.detail_f ul.head{width:90px;text-align:left;font-weight:bold;padding:4px 0 0 0;}
.detail_f ul.body{width:965px;}
.detail_f ul.line{width:1000px;border-bottom:1px dashed #ccc;height:2px;}
.detail_f ul li{float:left;margin:2px;padding:1px 6px;background-color:#ddd;}
.detail_f ul li a{color:#000;}
.detail_f ul li.head{width:35px;text-align:left;font-weight:bold}
.detail_f ul li.active{background-color:#69c;color:#fff}
.detail_f ul li.active a{background-color:#69c;color:#fff}

</style>

<div class='detail_f'>
    <ul class=head> 数据错误 </ul>
    <ul class=line> </ul>
        <table class="table table-striped table-bordered table-condensed">
      <thead>
        <tr>
          <th></th>
          <th colspan="5"> <b>参数</b> </th>
          <th> <b>操作</b> </th>
        </tr>
        <tr>
          <th width="6%"> <b>基站id</b> </th>
          <th width="15%">地区名称</th>
          <th width="8%">城市</th>
          <th width="8%">经度</th>
          <th width="8%">纬度</th>
          <th>地址</th>
          <th width="8%">sim卡号</th>
          <th width="8%">建站人</th>
          <th width="10%"> <b>修改</b> </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($dataError as $data): ?>
        <tr>
          <td><?=  $data['id'] ?>     </td>
          <td><?=  $data['name_chn'] ?>      </td>
          <td><?=  $data['city_chn'] ?>     </td>
          <td><?=  $data['lng'] ?>      </td>
          <td><?=  $data['lat'] ?>     </td>
          <td><?=  $data['address_chn'] ?>     </td>
          <td><?=  $data['sim_num'] ?>     </td>
          <td><?=  $data['user_name_chn'] ?>     </td>
          <td><a href="/backend/station/mod_station/<?= $data['id']?>?backurl=<?= $backurlstr ?>">修改</a></td>
        </tr>
        <?php endforeach?>
      </tbody>
    </table>
</div>


<div style='clear:both;border-bottom:2px solid #933;width:1000px;height:20px'>
</div>

</div><!--span9 content-->

  
</body>
