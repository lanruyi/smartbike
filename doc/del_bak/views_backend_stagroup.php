<div class=row-fluid>
<div class="span12">

<a href ="/backend/stagroup/add_stagroup" class="btn btn-success"> <i class="icon-plus-sign icon-white"></i> 添加基站组</a>
<br>
<br>

<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
    <td > # </td>
    <td >name:</td>
    <td>count:</td>
    <td>type: </td>
    <th colspan="2"> <b>删除</b> </th>
    <th> <b>修改</b> </th>
</tr>
</thead>
<tbody>
<?php foreach ($stagroups as $stagroup): ?>
<tr>
    <td> <?= $stagroup->getId()?>  </td>
    <td> <?= $stagroup->getNamechn()?> </td>
    <td> <?= $stagroup->getCount()?></td>
    <td> <?= $stagroup->getType()?></td>
    <td colspan="2"><a href="javascript:if(confirm('确实要删除'))location='/backend/stagroup/del_stagroup/<?= $stagroup->getId()?>';void(0)">删除</a></td>
      <td><a href="/backend/stagroup/mod_stagroup/<?= $stagroup->getId()?>">修改</a></td>
</tr>

<tr>
    <td  colspan='6'> 
    包括站点：
    <?php foreach ($stagroup->getStations() as $station): ?> 
        (<?= $station->getId()?>)<?= $station->getNameChn()?> &nbsp;&nbsp;
    <?php endforeach?>
    </td>
</tr>


<?php endforeach?>
</tbody>
</table>

</div><!--span9 content-->
