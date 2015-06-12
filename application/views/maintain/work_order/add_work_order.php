<style>
    .title{text-align:center;float:left;}
    .title tr{text-align:center;font-size:15px;}
    .table{width:400px;}
</style>

<div class="base_center">
		<!--工单系统主页面-->
    <form id="filter" method="post" action="/maintain/work_order/insert_work_order"> 
		<div class="title">
			<div style="margin:0px 0px 10px 0px">
                <font style="font-size:30px">分发工单</font>
			</div>
            <div style="margin:20px 0px 0px 0px;">
                <table class="table">
					<tr>
						<td style="width:100px">基站ID:</td>
						<td><input  readonly='readonly' type="text" name="station_id" value="<?= $station_id ?>" /></td>
					</tr>
					<tr>
						<td>基站名:</td>
						<td><input readonly="readonly" type="text" name="station_name_chn" value="<?= $name_chn ?>" /></td>
					</tr>
					<tr>
						<td>监控人:</td>
						<td><input readonly='readonly' type="text" name="creator_name_chn" value="<?= $creator_name_chn ?>" /></td>
					</tr>
					<tr>
						<td>故障类型: </td>
						<td>
							<? foreach($bug_types as $bug){
								echo h_bug_type_name_chn($bug['type']);
								echo "&nbsp;&nbsp;";
							}?>
					</tr>
					<tr>
						<td>工单类型:</td>
						<td>
							<input type="radio" id="work_order_type" name="work_order_type" value="1" checked="checked"/>我方工单&nbsp;&nbsp;&nbsp;
							<input type="radio" id="work_order_type" name="work_order_type" value="2" />第三方工单
						</td>
					</tr>
					<tr id="person">
						<td>维修人:</td>
						<td><?= h_common_select('dispatcher_id',$dispatchers,$this->input->get('dispatcher_id'),200); ?></td>
					</tr>
					<tr id="tel">
						<td>维修人电话:</td>
						<td><input type="text" id="dispatcher_tel" name="dispatcher_tel" value="" /></td>
					</tr>
					<tr id="third_party" style="display:none">
						<td>
							<div>
								<li>运营商联系信息:</li>
								<li>空调维修：张小三：13999999999</li>
								<li>电池维修：张小四：13999999999</li>
								<li>维修主管：张小五：13999999999</li>
							</div>
						</td>
					</tr>
					<tr>
						<td>监控日志:</td>
						<td><textarea style="width:255px" name="creator_remark"></textarea></td>
					</tr>
					<tr>
						<td colspan="1"><input  type="button" value="生成工单" id="sub" /></td>
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
				if($("#dispatcher_id").val()==0 && $("#tel").css('display')=='table-row'){
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
			//工单类型
			$("input:radio").click(function(){
				var obj = $(this).val();
				if(obj==2){
					$("#person").hide();
					$("#tel").hide();
					$('#third_party').show();
					$("#sub").val("第三方工单");
					$("#filter").attr("action","/maintain/work_order/insert_third_party");
				}else{
					$("#tel").show();
					$("#person").show();
					$('#third_party').hide();
					$("#sub").val("我方工单");
					$("#filter").attr("action","/maintain/work_order/insert_work_order");
				}
			})
		})
	</script>
<div style="clear:both">
</div>
