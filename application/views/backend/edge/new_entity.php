<style>
    .title{margin-bottom:10px;padding:10px 10px 0px 10px;font-size:20px;}
    .body{padding:10px 20px 0px 0px;font-size:13px} 
    .table{font-size:10px;padding:10px 20px 20px 0px;}
</style>
<div class="base_center">
<div class="title">
<?php if($mod){?>
   修改边界 
  <?php }else{?> 新增边界 <?php }?>
</div>
<?php 

$attributes = array("method"=>"post");
if($mod){
    $hidden = array('id' => $edge['id']);
    echo form_open("/backend/edge/update_edge",$attributes,$hidden); 
}else{
    echo form_open("/backend/edge/insert_edge",$attributes); 
?>
<?}?>
<div class="body">

<?php if($mod){?>
    <ul>ID: <input readonly='readonly' type="text" name="id" value="<?= $mod? $edge['id']:"" ?>" /> </ul>
<?php }?>
    <ul>
      边界名称: 
        <input type="text" name="name_chn" value="<?= $mod? $edge['name_chn']:"" ?>" /> </ul>
    <ul>
        <table class=table>
            <tr>
                <td>边界描述:<input type="text" name="edge_desc" value="<?= $mod? $edge['edge_desc']:"" ?>" /> </td>
            <tr>
            </tr>
                <td>查询语句:<textarea name="query"><?= $mod? $edge['query']:"" ?></textarea></td>
            <tr>
            </tr>
                <td>边界门限:<input type="text" name="threshold" value="<?= $mod? $edge['threshold']:"" ?>" /> </td>
            </tr>
            </tr>
                <td>边界时间段:<input type="text" name="time_slot" value="<?= $mod? $edge['time_slot']:"" ?>" /> </td>
            <tr>
        </table>
    </ul>
    <ul><?php echo form_submit("","提交"); ?> </ul>
    
<?php echo form_close(); ?>
</div>
<div style="padding:0px 20px 0px 30px">
<a href="/backend/edge">返回</a>
</div>

</div>
