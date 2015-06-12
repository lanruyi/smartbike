<style>
    .title{margin-bottom:10px;padding:10px 10px 0px 10px;font-size:20px;}
</style>

<div class="base_center">


<div class="title">
<?php if($mod){?>
   更新日志
  <?php }else{?> 新增日志 <?php }?>
</div>
  
 <br />

  
<?php 
$attributes = array("class"=>"add_blog");

if($mod){
	$hidden = array('id' => $blog['id'],'author_id'=>$user['id']);
	echo form_open("/backend/blog/update_blog?backurl=".urlencode($this->input->get('backurl')),$attributes,$hidden); 
}else{
	$hidden = array('author_id'=>$user['id']);
    echo form_open("/backend/blog/insert_blog",$attributes,$hidden); 
?>
<?}?>

<?php if($mod){?>
	<ul style="list-style:none;">
		<li>日志ID: <input type="text" name="blog_id" value="<?= $mod? $blog['id']:"" ?>" disabled="disabled"/></li>
		<li>基站名称: <input type="text" name="station_name" value="<?= $mod? $station['name_chn']:"" ?>" disabled="disabled"/></li>
		<li>最近更新时间: <?= $mod? $blog['create_time']:"" ?></li>
	</ul>
<?php }else{?>
	<ul>基站名称：<?= form_dropdown('station_id', $station_ids, '');?></ul>
<?php }?>
    <ul><textarea style="width:800px; height:500px;" name="content"><?= $content?$content:null;?></textarea></ul>
    <ul><?php echo form_submit("","提交"); ?> 
    	<input type="button" value="取消" onclick="window.location='<?= urldecode($this->input->get('backurl'))?>'" />
    </ul>
    
<?php echo form_close(); ?>

</div>
