<style>
    .title{text-align:center;float:left;}
    .title ul{text-align:center;font-size:15px;}
    .table{width:400px;}
</style>

<div class="base_center">

    <form id="filter" method="post" action="/maintain/work_order/update_third_party"> 
		<div class="title">
			<div style="font-size:30px;width:400px;height:50px;">
                <?=$title?>
			</div>
            <div style="float:left;margin:0px 0px 10px 0px">
                <table class="table">
                    <tr>
						<td width="100px">ID:</td>
						<td><input readonly='readonly' type="text" name="id" value="<?=$id ?>" /></td>
                    </tr>
					<tr>
						<td>基站ID:</td>
						<td><input  readonly='readonly' type="text" name="station_id" value="<?= $station_id ?>" /> </td>
					</tr>
					<tr>
						<td>基站名:</td>
						<td><input readonly="readonly" type="text" name="station_name_chn" value="<?= $station_name_chn ?>" /> </td>
					</tr>
					<tr>
						<td>监控人:</td>
						<td><input readonly='readonly' type="text" name="creator_name_chn" value="<?= $creator_name_chn ?>" /> </td>
                     </tr>
					 <tr>
						<td>故障类型:</td> 
                     	<td>
                     		<? foreach($bug_types as $bug){
									echo h_bug_type_name_chn($bug['type']);
									echo "&nbsp;&nbsp;";
								}?>
						</td>
					<tr>
					<tr>
						<td>监控日志:</td>
						<td><textarea style="width:255px" name="creator_remark"><?= $creator_remark ?></textarea></td>
					</tr>
				 
					<tr>
						<td><input  type="button" value="修改" id="sub" /></td> 
						<td><input type="button" value="取消" onclick="window.location='/maintain/work_order/prepare_orders'" /></td>
					</tr>
					
                </table>
			</div>
		</div>
	</form>
</div>
<script>
	$(function(){
		$("#sub").click(function(){
			$("#filter").submit();
		})
	})
</script>
<div style="clear:both"></div>
