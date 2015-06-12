<style type="text/css">
	.log{margin-top:10px;}
	.log_text{width:100%;float:left;}
	.log_text span{font-size:12px;margin-left:15px;}
</style>

<div class="base_center"> 
<div class="row-fluid"> 
<div class="span12 ">
	
	
	<div class="log_text">
		<?php foreach ($logs as $key => $log) {?>
			<table class="table">
				<thead><tr><a name=<?= $log->getId()?>></a>
					<th><h3><?= $log->getCreateTime()->format('Y-m-d H:i:s')?><span><?= " by ".$log->getAuthor()->getNameChn()?></span> </h3></th>
				</tr></thead>
				<tbody><tr>
					<td><?= nl2br($log->getContent())?></td>
				</tr></tbody>
			</table>
		<?php }?>	
	</div><!--log text-->

</div>
</div>
</div>
