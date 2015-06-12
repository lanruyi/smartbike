<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px ;}
</style>

<div class=base_center>
	<div style="margin:0;width:100%">
		<font>工单系统 >> 工单列表</font>
	</div>
	<form id="filter" method="get" action="">
		<div class='filter'>
			创建时间:<input type="text" id="create_start_time" name='create_start_time' style="width:80px;height:16px"> 
			到:<input type="text" id="create_stop_time" name='create_stop_time' style="width:80px;height:16px"> 
			每页:<input class="input-mini" name="per_page" type="text" />
		</div>
		<div class='operate'>
			<button type="submit" class="btn btn-primary">确定查询</button> 
			<a href="/maintain/home/work_order_list" class="btn btn-primary">清除查询</a>
		</div>
	</form>

	<?= $pagination?>
		<table class="table table-striped table-bordered table-condensed">
			<thead>
				<tr>
				<th></th>
				<th colspan=4> <b>参数</b> </th>
				</tr>
				<tr>
				<th width="8%"> <b>工单ID</b> </th>
				<th > <b>基站名</b> </th>
				<th width="15%"> <b>工单生成时间</b> </th>
				<th width="10%"> <b>维修人</b> </th>
				</tr>
			</thead>
				<tbody>
					<?php foreach ($work_orders as $work_order): ?>
					<tr>
					<td> <?= $work_order['id']?> </td>
					<td> <div style="width:40px;float:left"><?= h_station_type($work_order['station_type'])?></div><?= $work_order['station_name_chn']?> </td>
					<td> <?= $work_order['create_time']?>  </td><!--故障时间-->
					<td> </td><!--维修人-->
					</tr>
					<?php endforeach?>
				</tbody>
		</table>
	<?= $pagination?>
</div>
<script>
	 $(function(){
		 //日历插件
			$('#create_start_time').datepicker({
				showButtonPanel: true,
				dateFormat: "yymmdd",
				inline: false,
				timezone: '+8000',
				onClose:function(datatimeText,instance){
					 $('#create_start_time').attr("value")
					//window.global_options.time = $('#create_start_time').attr("value");
					//window.location.href="?time="+window.global_options.time;
				}
			});
			//$('#create_start_time').attr("value",window.global_options.time);
			

			$('#create_stop_time').datepicker({
				showButtonPanel: true,
				dateFormat: "yymmdd",
				inline: false,
				timezone: '+8000',
				onClose:function(datatimeText,instance){
					$('#create_stop_time').attr("value");
					//window.global_options.time = $('#create_stop_time').attr("value");
					//window.location.href="?time="+window.global_options.time;
				}
			});
			//$('#create_stop_time').attr("value",window.global_options.time);
    });
</script>

