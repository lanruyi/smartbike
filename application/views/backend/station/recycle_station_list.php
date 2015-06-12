<div class=base_center>
<a href ="/backend/station/" class="btn btn-primary"> <i class="icon-circle-arrow-left icon-white"></i> 返回可用基站列表</a>

<br><br>
<?= $pagination?>
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th> <b>#</b> </th>

<th> <b>中文(英文)</b> </th>
<th> <b>操作</b> </th>

</tr>
</thead>
<tbody>
<?php foreach ($stations as $station): ?>
<tr>
    <td width="10%"> <?= $station['id']?>  </td>
    <td width="20%"> <?= $station['name_chn']?> (<?= $station['name_py']?>)  </td>
	<td><? if(h_auth_check_role($this->user_role,ESC_AUTHORITY__BACKEND_ADMINISTRATOR)){ ?>
         <a class="btn btn-primary" href="javascript:if(confirm('确定?'))location='/backend/station/recycle_station/<?= $station['id']?>';void(0)">还原</a>
        <?}?> </td> 
</tr>
<?php endforeach?>
</tbody>
</table>
<?= $pagination?>

</div>
