<style>
    .title{text-align:center;float:left;}
    .title ul{text-align:center;font-size:15px;}
    .table{width:400px;}
</style>

<div class="base_center">

    <form id="filter" method="post" action="/maintain/work_order/update_work_order"> 
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
						<td>维修人:</td>
						<td><?= h_common_select('dispatcher_id',$dispatchers,$dispatcher_id,200); ?></td> 
					<tr>
						<td>维修人电话:</td>
						<td><input type="text" id="dispatcher_tel" name="dispatcher_tel" value="<?= $dispatcher_tel ?>" /> </td>
					</tr>
					<tr>
						<td>监控日志:</td>
						<td><textarea style="width:255px" name="creator_remark"><?= $dispatcher_remark ?></textarea></td>
					</tr>
				 
					<tr>
						<td><input  type="button" value="修改" id="sub" /></td> 
						<td><input type="button" value="返回" onclick="window.location='/maintain/work_order/prepare_orders'" /></td>
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
<div style="clear:both"></div>
