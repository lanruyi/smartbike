<style>
.a_menu{float:left;height:20px;line-height:20px;margin:5px;}
</style>
<div class=base_center>
  <div>
    <p style="min-height:25px;line-height:25px;">
      <?foreach($cities as $city){?>
        <a class="a_menu badge span_margin <?=$city['id']==$father_id?'badge-success':''?>"  href="/backend/area/one_city/<?=$city['id']?>"><?=$city['name_chn']?></a>
      <?}?>
    </p>
    <div style="height:2px;clear:both"></div>
    <p class="muted"><?=$title?>.</p>
    <table class="table table-striped table-bordered table-condensed">
      <thead>
        <tr>
          <th>#ID</th>
          <th>区县</th>
          <th>pinyin</th>
          <th>经度</th>
          <th>纬度</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?foreach($districts as $district){?>
          <tr>
            <td><?=$district['id']?></td>
            <td><?=$district['name_chn']?></td>
            <td><?=$district['name_py']?></td>
            <td><?=$district['lng']?></td>
            <td><?=$district['lat']?></td>
            <td>
                <a href="/backend/area/mod_district/<?= $district['id']?>?backurl=<?=$backurlstr?>">修改</a>
            </td>
          </tr>
        <?}?>
      </tbody>
    </table>
  </div>
</div>
<div style="height:2px;clear:both"></div>
