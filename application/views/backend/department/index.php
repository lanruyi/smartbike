<style type="text/css">
.department td{width:10%;}
</style>


<div class=base_center>


<a href ="/backend/department/add_department" class="btn btn-success"> <i class="icon-plus-sign icon-white"></i> 添加部门 </a>
<br>
<br>

<table class="table table-striped table-bordered table-condensed department">
<thead>
<tr>
	<th>#</th>
	<th>部门名称</th>
	<th>部门成员</th>
	<th colspan="3">操作</th>
</tr>
</thead>
<tbody>
<?php foreach($departments as $department){?> 
<tr> 
<td> <?= $department['id']?></td> 
<td> <?= $department['name_chn']?></td> 
<td style="width:55%;">
    <?php foreach ($users as $user ){
        if($user['department_id']==$department['id']){
             echo $user['name_chn'];?>
             &nbsp;&nbsp;
    <? }}?>  
</td>
<td> <a href="javascript:if(confirm('确实要删除'))location='/backend/department/del_department/<?= $department['id']?>';void(0)">删除</a></td>
<td> <a href="/backend/department/mod_department/<?= $department['id']?>">修改</a></td>
<td> <a href="/backend/department/authorize_department?id=<?= $department['id']?>">授权</a></td>
</tr> 
<?php }?>     
</tbody>
</table>
</div>
