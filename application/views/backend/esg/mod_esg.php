<style type="text/css">
	.active{color:red;}
	.useful{color:green;}
    .title{margin-bottom:10px;padding:10px 10px 0px 10px;font-size:20px;}
    .body{padding:10px 20px 20px 0px;font-size:10px} 
</style>

<div class="base_center">

<div class="title">

修改ESG控制板
</div>
<div class="body">
<?

    $hidden = array('id' => $esg['id']);
    echo form_open("/backend/esg/update_esg?backurl=".urlencode($this->input->get('backurl')),null,$hidden); 
?>

    <ul>ID: <input readonly='readonly' type="text" name="id" value="<?= $esg['id']?>" /> </ul>
    <ul> ESG板子名称: <input type="text" name="string" value="<?= $esg['string']?>" /> </ul>
    <ul> ESG板子KEY: <input type="text" readonly='readonly' name="key" value="<?=  $esg['string']?>" /> </ul>
    <ul> Station_id: <input type="text" id="station_id" name="station_id" value="<?= $esg['station_id']?>" /> </ul>
    
    <ul><?php echo form_submit("","提交"); ?> 
    <input type="button" value="取消" onclick="window.location='<?= urldecode($this->input->get('backurl'))?>'" />
    </ul>
    
<?php echo form_close(); ?>
</div>
</div>
</div>

<script type="text/javascript">
window.opts = {
	"station_id": "<?= $esg['station_id']?$esg['station_id']:0 ?>"
}

$(document).ready(function(){
	$('.station_name').click(function(){
		$('#'+window.opts.station_id).next().attr('class','');
		window.opts.station_id = $(this).attr('value');
		$('#station_id').attr('value',$(this).attr('value'));
		$('#'+window.opts.station_id).next().attr('class','active');
	});
	
	$('#station_id').change(function(){
		
		$('#'+window.opts.station_id).attr('checked','');
		$('#'+window.opts.station_id).next().attr('class','');
		
		window.opts.station_id = $(this).attr('value');
		$('#'+window.opts.station_id).attr('checked','checked');
		$('#'+window.opts.station_id).next().attr('class','active');
	})
});
</script>
