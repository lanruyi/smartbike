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
    $attributes = array("class"=>"add_contract");

    if($mod){
        $hidden = array('id' => $contract['id']);
        echo form_open("/backend/contract/update_contract?backurl=".urlencode($this->input->get('backurl')),$attributes,$hidden); 
    }else{
        echo form_open("/backend/contract/insert_contract?backurl=".urlencode($this->input->get('backurl')),$attributes); 
    ?>
    <?}?>

        <div class="body">
            <?php if($mod){?>
                 <ul>ID: <input readonly='readonly' type="text" name="id" value="<?= $mod? $contract['id']:"" ?>" /> </ul>
            <?php }?>
        <ul>
            项目: 
            <?= h_make_select(h_array_2_select($projects),'project_id',($mod)?$contract['project_id']:0,"--请选择--","150px"); ?></ul> 
        </ul>
        <ul>
            合同号: 
            <input type="text" name="name_chn" value="<?= $mod? $contract['name_chn']:"" ?>" /> </ul>
        <ul>
            分期别名: 
            <input type="text" name="alias" value="<?= $mod? $contract['alias']:"" ?>" /> </ul>
        <ul>
            创建时间: 
            <input type="text" name="create_time" value="<?= $mod? $contract['create_time']:"" ?>" /> </ul>
        <ul>
            描述: 
            <textarea cols="60" rows="4" name="content"><?= $mod? $contract['content']:""?></textarea></ul>
         <ul><?php echo form_submit("","提交"); ?> </ul>
    
    <?php echo form_close(); ?>
    </div>
</div>
