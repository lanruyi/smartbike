
<div class=base_center>

<a href ="/backend/rom/add_rom" class="btn btn-success"> + 添加固件</a>
<a href ="/backend/rom/recal_rom" class="btn btn-success">统计数量</a>

<br>
<br>
<div class="alert alert-info">
  请使用 tar -zcvf example.tar.gz file1 file2 file3 ... 命令压缩多文件后上传。
</div>
<table class="table2">
<tr>
<td></td>
<td colspan=7> <b>参数</b> </td>
<td colspan=2> <b>操作</b> </td>
<td colspan=4> <b></b> </td>
</tr>
<tr>
<td> <b>#</b> </td>

<td> <b>版本</b> </td>
<td> <b>文件名</b> </td>
<td> <b>大小</b> </td>
<td> <b>分割数</b> </td>
<td> <b>类型</b> </td>
<td> <b>基站数</b> </td>
<td> <b>上传时间</b> </td>
<td> <b>原文件名</b> </td>
<td> <b>备注</b> </td>

<td> <b>下载</b> </td>
<td> <b>分块测试</b> </td>
<td> <b>删除</b> </td>
<td> <b>修改</b> </td>
</tr>
<?php foreach ($roms as $rom): ?>
<tr style="background-color:<?= $rom['recycle']==ESC_DEL?"#f66":""?>">
<td> <?= $rom['id'] ?> </td>

<td> <?= $rom['version'] ?>  </td>
<td> <?= $rom['name'] ?>  </td>
<td> <?= $rom['size'] ?>Byte </td>
<td> <?= $this->rom->romPartNum($rom['size']) ?> </td>
<td> <?= $rom['type'] ?>  </td>
<td> <?= $rom['station_num'] ?>  </td>
<td> <?= $rom['created'] ?>  </td>
<td> <?= $rom['orig_name'] ?>  </td>
<td> <?= $rom['comment'] ?>  </td>

<td> <a href="/static/uploads/roms/<?= $rom['name']?>">下载</a></td>
<td> 
    <a href="/webservice/rom_parts/<?= $rom['id']."/0"?>">0</a>&nbsp;
    <a href="/webservice/rom_parts/<?= $rom['id']."/1"?>">1</a>&nbsp;
    <a href="/webservice/rom_parts/<?= $rom['id']."/2"?>">2</a>&nbsp;
</td>
<td> 
<? if($rom['recycle']==ESC_DEL){ ?>
    已删除
<?}else{?>
    <a href="javascript:if(confirm('确实要删除'))location='/backend/rom/del_rom/<?= $rom['id']?>';void(0)">删除</a>
<?}?>
</td>
<td> <a href="/backend/rom/mod_rom/<?= $rom['id']?>">修改</a></td>
</tr>
<?php endforeach?>
</table>

</div>
