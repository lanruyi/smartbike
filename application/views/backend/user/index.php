<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px ;}

</style>

<script>
$(function(){
    $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'});
})
</script>
<div class=base_center>

    <div style="margin:0;width:100%">
    <font>后台 >> 用户列表</font>
    </div>
    
<div class=row-fluid>
<div class="span12">

<form id="filter" method="get" action="">
<div class='filter'>
    搜索用户(中文名): 
    <input type="text" name="search" value="<?= $this->input->get('search') ?>" style="width:100px" >
    部门:
    <?= h_make_select(h_array_2_select($departments),'department_id',$this->input->get('department_id'));?>
    用户角色:
    <?= h_make_select(h_array_2_select($roles),'role_id',$this->input->get('role_id'));?>
    当前项目:
    <?= h_make_select(h_array_2_select($projects),'current_project_id',$this->input->get('current_project_id'));?>
    每页:
    <input class="input-mini" name="per_page" value="<?= $this->input->get('per_page')?>" type="text" />
</div>
<div class='operate'>
		<button type="submit" class="btn btn-primary">确定查询</button> 
        <a href="/backend/user/index" class="btn btn-primary">清除查询</a>
        <a href ="/backend/user/verify_projects?backurl=<?= $backurlstr?>" class="btn btn-primary" style="float:right;"> 确认项目 默认城市合理 </a>
        <a href ="/backend/user/add_user?backurl=<?= $backurlstr?>" class="btn btn-primary" style="float:right;margin-right:5px;"><i class="icon-plus-sign icon-white"></i> 添加用户</a>
</div>
</form>

<?= $pagination?>
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th></th>
<th colspan=10> <b>参数</b> </th>
<th colspan=2> <b>操作</b> </th>
</tr>
<tr>
<th> <b>#ID</b> </th>

<th> <b>用户名</b> </th>
<th> <b>中文名</b> </th>
<th> <b>角色</b> </th>
<th> <b>部门</b> </th>
<th> <b>当前项目</b> </th>
<th> <b>默认城市</b> </th>
<th> <b>项目数</b> </th>
<th> <b>邮件</b> </th>
<th> <b>联系电话</b> </th>
<th> <b>备注</b> </th>
<th> <b>最后登录</b> </th>
<th> <b>创建时间</b> </th>



<th> <b>操作</b> </th>
</tr>
</thead>

<tbody>
<?php foreach($users as $user){?>
	<tr>
	<td> <?= $user['id'] ?> </td>
	<td> <?= $user['username'] ?>  </td>
	<td> <?= $user['name_chn'] ?>  </td>
	<td> <?= $user['role'] ?>  </td>
	<td> <?= $user['department'] ?>  </td>
	<td> <?= $user['current_project'] ?>  </td>
	<td> <?= $user['default_city'] ?>  </td>        
	<td> <?= $user['projects_count'] ?>  </td>
	<td> <?= $user['email'] ?> </td>
        <td> <?= $user['telephone'] ?> </td>
	<td> <?= $user['remark'] ?> </td>
	<td> <?= $user['last_login'] ?>  </td>
	<td> <?= $user['created'] ?>  </td>   

    <td> <a class="btn btn-primary btn-mini" href="#" 
        onclick="confirm_jumping('删除用户 <?= $user['name_chn']?> ',
		'/backend/user/del_user/<?= $user['id']?>?backurl=<?= $backurlstr?>')">删除</a>
	<a  class="btn btn-primary btn-mini" href="/backend/user/mod_user/<?= $user['id']?>?backurl=<?= $backurlstr?>">修改</a></td>		
	</tr>
<?php }?>
</tbody>

</table>
<?= $pagination?>

</div>

