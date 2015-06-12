<style>
    .title{color:#507AAA;font-size:25px;padding:30px 25px;height:30px;}
</style>
<div class=base_center>

<span class="title">
<?php if($mod){?> 修改用户信息 <?php }else{?> 新增用户 <?php }?>
</span>
<?php 
$attributes = array("class"=>"add_user");

if($mod){
    $hidden = array('id' => $user['id']);
    echo form_open("/backend/user/update_user?backurl=".urlencode($this->input->get('backurl')),$attributes,$hidden); 
}else{
    echo form_open("/backend/user/insert_user?backurl=".urlencode($this->input->get('backurl')),$attributes); 
?>
<?}?>

<?php if($mod){?>
    <ul>ID: <input readonly='readonly' type="text" name="id" value="<?= $mod? $user['id']:"" ?>" /> </ul>
<?php }?>
<div style="padding:30px 40px 20px 10px"> 
    <ul>用户登录名: <input type="text" name="username" value="<?= $mod? $user['username']:"" ?>" /> </ul>
    <ul>中文名(必填): <input type="text" name="name_chn" value="<?= $mod? $user['name_chn']:"" ?>" /> </ul>
    <ul>密码: <input type="text" name="password" value="" /> </ul>
    <ul>Email: <input type="text" name="email" value="<?= $mod? $user['email']:"" ?>" /> </ul>
    <ul>Tel: <input type="text" name="telephone" value="<?= $mod? $user['telephone']:"" ?>" /> </ul>
	<ul>备注:<textarea  name="remark"><?= $mod? $user['remark']:"" ?></textarea> </ul>
	
	
	
    <ul>角色: 
   	<?= h_make_select(h_array_2_select($roles),'role_id',($mod)?$user['role_id']:0,""); ?> 
    </ul>
     
    <ul>部门: 
   	<?= h_make_select(h_array_2_select($departments),'department_id',($mod)?$user['department_id']:0,""); ?> 
    </ul>
      
<?
    $project_group = array();
	if($mod){
	    foreach ($userProjects as $project){
	        array_push($project_group,$project['project_id']);
	    }		
	}
?>
    <ul>项目组: 
    <? foreach ($projects as $project){?>
    <input type="checkbox" name="project_ids[]" value=<?= $project['id']?> 
       <?= in_array($project['id'],$project_group)?"checked":""?> />
       <span style=<?= in_array($project['id'],$project_group)?"color:red":""?>><?= $project['name_chn']?></span>
    <? }?>
    </ul>

    <ul>当前项目: 
    <?= h_make_select(h_array_2_select($projects),'current_project_id',($mod)?$user['current_project_id']:0,"无"); ?>
    </ul>

    <ul>默认城市: 
    <?= h_make_select(h_array_2_select($cities),'default_city_id',($mod)?$user['default_city_id']:0,"无"); ?>
    </ul>
    
    <ul><?php echo form_submit("","提交"); ?> 
    	<input type="button" value="取消" onclick="window.location='/backend/user'" />
    </ul>
    
<?php echo form_close(); ?>
</div>
</div>
