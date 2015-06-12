<style>
	.title{text-align:center;float:left;}
    .table{
        width:1000px;height:200px;font-weight:600;
		}
</style>

<div class="base_center">
		<!--工单系统详细清单页面-->
		<div class="title">
			<div style="margin:10px 0px 10px 0px">
				<font style="font-size:30px">详细工单清单</font>
			</div>
            <div style="margin:20px 0px 0px 0px;">
				<table  border="2" class="table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<td width="10%">ID:</td>
							<td><?= $id ?></td>
						</tr>
						<tr>
							<td width="10%">基站ID:</td>
							<td><?= $station_id?></td>
						</tr>
						<tr>
							<td width="10%">基站名:</td>
							<td><?= $station_name_chn?></td>
						</tr>
						<tr>
							<td width="10%">监控人:</td>
							<td><?=$create_name_chn?></td>
						</tr>
						<tr>
							<td width="10%">维修人:</td>
							<td><?= $dispatcher_name_chn?>
							</td>
						</tr>
						<tr>
							<td width="10%">维修人电话:</td>
							<td><?= $dispatcher_tel['telephone']?></td>
						</tr>
						<tr>
							<td width="10%">基站地址:</td>
							<td><?= $address_name_chn?></td>
						</tr>
						<tr>
							<td width="10%">故障类型:</td>
							<td>
								<? if(count($bug_types)){
										foreach($bug_types as $bug_type){
											echo h_bug_type_name_chn($bug_type['type']);
											echo "&nbsp;&nbsp;";
										}

									}else{
										echo "故障已经消失";
									}?>
							</td>
						</tr>
						<tr>
							<td width="10%">创建时间:</td>
							<td><?= $create_time?></td>
						</tr>
						<tr>
							<td width="10%">监控日志:</td>
							<td><?= $creator_remark?></td>
						</tr>
						<tr>
							<td width="10%">修复日志:</td>
							<td><?= $dispatcher_remark?></td>
						</tr>
					</thead>					
                </table>
            </div>
		</div>
			
</div>
<div style="clear:both"></div>

