<style>
    .title{margin-bottom:10px;padding:10px 10px 0px 23px;font-size:20px;}
    .body{padding:10px 20px 20px 0px;font-size:10px} 
    .mod{padding:0px 0px 20px 20px;}
</style>
<div class=row-fluid>
<div class="span12">

<div class="base_center">

<div class="title">
<?php if($mod){?> 修改固件信息 <?php }else{?> 新增固件 <?php }?>
</div>

<div class="body">
<?php 
$attributes = array("class"=>"add_rom");

if($mod){
    $hidden = array('id' => $rom['id']);
    echo form_open("/backend/rom/update_rom",$attributes,$hidden); 
}else{
    echo form_open_multipart("/backend/rom/insert_rom",$attributes); 
?>
    <ul>固件文件: <input type="file" name="userfile" size="20" /></ul>
<?}?>

<?php if($mod){?>
    <ul>name: <input readonly='readonly' type="text" name="name" value="<?= $mod? $rom['id']:"" ?>" /> </ul>
<?php }?>
    <ul>version: <input type="text" name="version" value="<?= $mod? $rom['version']:"" ?>" /> </ul>
    <ul>type: <input type="text" name="type" value="<?= $mod? $rom['type']:"" ?>" /> </ul>
    <ul>comment: <input type="text" name="comment" value="<?= $mod? $rom['comment']:"" ?>" /> </ul>


    <ul><?php echo form_submit("","提交"); ?> </ul>
    
<?php echo form_close(); ?>
<div class="mod">
<?php if($mod){?>
<a href="#">修改</a>
<?php }else{?>
<a href="#">添加</a>
<?php }?>
<a href="/backend/rom">返回</a>
</div>
</div>
</div>
