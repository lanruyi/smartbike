<div class=base_center>


<h3> 修改项目 </h3> 

<?
$attributes = array("class"=>"add_project");

$hidden = array('id' => $project['id']);
echo form_open("/backend/project/update_project",$attributes,$hidden); 
?>

    <ul>ID: <input readonly='readonly' type="text" name="id" value="<?= $project['id'] ?>" /> </ul>
    <ul>
      项目名称:<input type="text" name="name_chn" value="<?= $project['name_chn'] ?>" /> </ul>
    <ul>
    </ul>

     <ul>
         类型:<?= h_project_type_select($project['type'],"")?>
     </ul>
    
     <ul>
         项目运营类型:<?= h_project_ope_type_select($project['ope_type'],"")?>
     </ul>

     <ul>
        城市:
        <? foreach ($areas as $area){?>
        <input type="checkbox" name="areas[]" value=<?= $area['id']?> 
            <?= in_array($area['id'], explode(',',$project['city_list']))?"checked":""?> />
            <span style="<?= in_array($area['id'],explode(',',$project['city_list']))?"color:red":""?> "><?= $area['name_chn']?></span>
        <? }?>
     </ul>

     <ul>
        用户:
       
        <?php foreach($departments as $department){?>
            <hr/>
            <?= $department['id']?>、
            <?= $department['name_chn']?>:
            <? foreach($users as $user) {
                if($user['department_id']==$department['id']){?>
                <input type="checkbox" name="users[]" value=<?= $user['id']?> 
                <?= isset($user_projects[$user['id']])?"checked":""?> />
                <span style="<?= isset($user_projects[$user['id']])?"color:red":""?> "><?= $user['name_chn']?></span>         
            <? }}?>  
        <?php }?>        
     </ul>
    <hr/>
    
    <ul><?php echo form_submit("","submit"); ?> </ul>
    
<?php echo form_close(); ?>

</div>
