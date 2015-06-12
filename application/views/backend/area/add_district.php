<style>
    .title{margin-bottom:20px;padding:20px 20px 0px 20px;font-size:20px;}
    .body{padding:10px 30px 30px 0px}
    .mod{margin-bottom:10px;padding:0px 0px 0px 20px}
</style>

<div class="base_center">

    <div class="title">
    <?=$title?>
    </div>
    <?php 
    $attributes = array("class"=>"add_area");

    if($mod){
        $hidden = array('id' => $area['id']);
        echo form_open("/backend/area/update_district?backurl=".urlencode($this->input->get('backurl')),$attributes,$hidden); 
    }else{
        $hidden = array('father_id' => $father_id);
        echo form_open("/backend/area/insert_district?backurl=".urlencode($this->input->get('backurl')),$attributes,$hidden); 
    ?>
    <?}?>

        <div class="body">
            <?php if($mod){?>
                 <ul>ID: <input readonly='readonly' type="text" name="id" value="<?= $mod? $area['id']:"" ?>" /> </ul>
            <?php }?>
         <ul>
             区县名称: 
        <input type="text" name="name_chn" value="<?= $mod? $area['name_chn']:"" ?>" /> </ul>
     <ul>
        区县拼音: 
         <input type="text" name="name_py" value="<?= $mod? $area['name_py']:"" ?>" /> </ul>
     <ul>
         经度: 
        <input type="text" name="lng" value="<?= $mod? $area['lng']:"" ?>" /> </ul>
     <ul>
         纬度: 
        <input type="text" name="lat" value="<?= $mod? $area['lat']:"" ?>" /> </ul>
         <ul><?php echo form_submit("","提交"); ?> </ul>
    
    <?php echo form_close(); ?>
        <div class="mod">
            <?php if($mod){?>
            <a href="#">修改</a>
            <?php }else{?>
            <a href="#">添加</a>
             <?php }?>
             <a href="/backend/area">返回</a>
         </div>
    </div>
</div>
