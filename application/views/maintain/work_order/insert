<style>
	.title{text-align:center;float:left;}
    .table{
        width:1000px;height:200px;font-weight:600;
		}
</style>

<div class="base_center">
		<div class="title">
			<div style="margin:10px 0px 10px 0px">
				<font style="font-size:30px"><?= $title?></font>
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
							<td width="10%">基站地址:</td>
							<td><?= $address_name_chn?></td>
						</tr>
						<tr>
							<td width="10%">故障类型:</td>
							<td>
								<? foreach($bug_types as $bug){
									echo h_bug_type_name_chn($bug['type']);
									echo "&nbsp;&nbsp;";
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
					</thead>
					
                </table>						
						<input type="button" value="修改" onclick="window.location='/maintain/work_order/modify_third_party/<?=$id?>'" />
						<input type="button" value="返回"  onclick="window.location='/maintain/work_order/third_party'" />
					
				<?php echo form_close(); ?>
            </div>
		</div>
			
</div>
<div style="clear:both"></div>

