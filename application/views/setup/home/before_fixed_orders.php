<style>
    .title{text-align:center;float:left;}
    .title tr{text-align:center;font-size:15px;}
    .table{width:300px;}
</style>

<div class="base_center">
		<!--工单系统主页面-->
    <form id="filter" method="post" action="/setup/home/fixed_order"> 
		<div class="title">
			<div style="margin:0px 0px 10px 0px">
                <font style="font-size:30px">完成工单</font>
			</div>
            <div style="margin:20px 0px 0px 0px;">
                <table class="table">
                	<input type="hidden" name="work_order_id" value="<?= $id?>">
					<tr size="75px">
						<td>基站ID:</td>
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
						<td>维修日志:</td>
						<td><textarea style="width:255px" name="dispatcher_remark"></textarea></td>
					</tr>
					<tr>
						<td colspan="1"><input  type="button" value="点击完成" id="sub" /></td>
						<td><input type="button" value="取消" onclick="window.location='/setup/home/work_order_maintain'" /></td>
					</tr>
                </table>
			</div>
		</div>
	</form>
</div>
	<script>
		$(function(){
			$("#sub").click(function(){
				if($("#dispatcher_id").val()==0){
					alert('请选择维修人!');
				}else{
					$("#filter").submit();
				}
			})

			//ajax联动效果
			$("#dispatcher_id").change(function(){
				var obj = $(this);
				$.ajax({
					type: "GET",
					data: "dispatcher_id="+obj.val(), 
					url: "/maintain/work_order/find_user_id",
					dateType: "json",                  
					success: function(data){
						var jsondata=eval("("+data+")");
						$("#dispatcher_tel").val(jsondata.telephone);
					},
					error:function(){
						alert('出错啦！');
					}
				})
			})
		})
	</script>
<div style="clear:both">
</div>
