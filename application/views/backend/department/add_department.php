<style>
    .title{margin-bottom:10px;padding:10px 10px 0px 23px;font-size:20px;}
    .body{padding:10px 20px 20px 0px;font-size:15px} 
</style>

<div class="base_center">

<div class="title">
<?php if($mod){?>
   修改部门
  <?php }else{?> 新增部门 <?php }?>
</div>
<?php 
$attributes = array("class"=>"add_department");

if($mod){
    $hidden = array('id' => $department['id']);
    echo form_open("/backend/department/update_department",$attributes,$hidden); 
}else{
    echo form_open("/backend/department/insert_department",$attributes); 
?>
<?}?>
    
<div class="body">
<?php if($mod){?>
    <ul>ID: <input readonly='readonly' type="text" name="id" value="<?= $mod? $department['id']:"" ?>" /> </ul>
<?php }?>
    <ul>
     	 部门名称: 
        <input type="text" name="name_chn" value="<?= $mod? $department['name_chn']:"" ?>" />
    </ul>
          
    <ul>部门成员:
        <?php if($mod){?>
		<? foreach ($users as $user){?>
        <input type="checkbox" name="user_ids[]" value=<?= $user['id']?>
                    <?= ($user['department_id']==$department['id'])?"checked":""?> />
        <span style=<?= ($user['department_id']==$department['id'])?"color:red":"" ?>><?= $user['name_chn']?></span>
                <? }?>
        <?php }else{?>
            <? foreach ($users as $user){?>
        <input type="checkbox" name="user_ids[]" value=<?= $user['id']?> />
        <span><?= $user['name_chn']?></span>
                <? }}?>       
    </ul>
    
    <ul><?php echo form_submit("","提交"); ?> 
    	<input type="button" value="取消" onclick="window.location='/backend/department'" />
    </ul>
    
<?php echo form_close(); ?>
    
</div>
</div>
