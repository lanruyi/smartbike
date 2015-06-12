<style>
    .title{text-align:center;float:left;}
    .title tr{text-align:center;font-size:15px;}
    .table{width:400px;}
</style>

<div class="base_center">
		<!--工单系统主页面-->
    <form id="filter" method="post" action="/maintain/work_order/close_work_order"> 
		<div class="title">
			<div style="margin:0px 0px 10px 0px">
                <font style="font-size:30px">关闭工单</font>
			</div>
            <div style="margin:20px 0px 0px 0px;">
                <table class="table">
                	<input type="hidden" name="work_order_id" value="<?= $id?>">
					<tr size="75px">
						<td width="100px">基站ID:</td>
						<td><input  readonly='readonly' type="text" name="station_id" value="<?= $station_id ?>" /></td>
					</tr>
					<tr>
						<td>基站名:</td>
						<td><input readonly="readonly" type="text" name="station_name_chn" value="<?= $station_name_chn ?>" /></td>
					</tr>
					<tr>
						<td>监控人:</td>
						<td><input readonly='readonly' type="text" name="creator_name_chn" value="<?= $creator_name_chn ?>" /></td>
					</tr>
					<tr>
						<td>维修人:</td>
						<td><input readonly='readonly' type="text" name="dispatcher_name_chn" value="<?= $dispatcher_name_chn ?>" /></td>
					</tr>
					<tr>
						<td>监控日志:</td>
						<td><textarea style="width:255px" name="creator_remark"><?=$creator_remark?></textarea></td>
					</tr>
					<tr>
						<td>维修日志:</td>
						<td><textarea style="width:255px" name="dispatcher_remark"><?=$dispatcher_remark?></textarea></td>
					</tr>
					<tr>
						<td>监控维修日志:</td>
						<td><textarea style="width:255px" name="creator_repair_remark"></textarea></td>
					</tr>
					<tr>
						<td colspan="1"><input  type="button" value="点击完成" id="sub" /></td>
						<td><input type="button" value="取消" onclick="window.location='maintain/work_order/fixed_orders'" /></td>
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
<div style="clear:both">
</div>
