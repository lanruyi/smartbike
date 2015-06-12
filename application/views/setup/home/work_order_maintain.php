<!--新工单提示框-->
<script type="text/javascript" src="/static/site/js/swfobject.js"></script>
<script type="text/javascript">
    var flashvars = {};
    var params = {
        wmode: "transparent"
    }; 
    var attributes = {};
    swfobject.embedSWF("/static/site/sound.swf", "sound", "1", "1", "9.0.0", "/static/site/expressInstall.swf", flashvars, params, attributes);

    function play(c) {
        var sound = swfobject.getObjectById("sound");
        if (sound) {
            sound.SetVariable("f", c);
            sound.GotoFrame(1);
        }
    }
</script>
<style type="text/css">
.new-feed-tip { background: none repeat scroll 0 0 #F0F5F8; border: 1px solid #CEE1EE; margin-top: 10px; margin-bottom: 10px;}
.feed-module a:link, .feed-module a:hover, .feed-module a:visited { color: #336699;}
.show-new-feed{ margin:10px; text-align:center; }
.show-new-feed-loading{ margin: 10px;text-align: center;}
</style>	
<div class="base_center">
    <div style="margin:0px 0px 10px 400px;width:100%">
    <font style="font-size:25px">工单维修列表</font>
	</div>
	<div style="clear:right;"><?= $pagination ?></div>
	<input type="hidden" id="currentTime" value="<?= $currentTime?>"/>
    <div class="new-feed-tip" style="display: none;height:35px;">
        <a class="show-new-feed" href="javascript:void(0)" style="display: block;">
            共有
            <span id="newFeedsCount"></span>
            个新维修工单，点击显示
        </a>
        <div class="show-new-feed-loading" style="display: none;">最新维修工单读取中...</div>
        <object width="1" height="1" type="application/x-shockwave-flash" data="/static/site/sound.swf" id="sound" style="visibility: visible;">
       		<param name="wmode" value="transparent">
   		</object>
	</div>
	
	<table class="table table-striped table-bordered table-condensed">
		<thead>
		<tr>
		<th></th>
		<th colspan=5> <b>参数</b> </th>
		<th colspan=1> <b>操作</b> </th>
		</tr>
		<tr>
		<th width="6%"> <b>工单ID</b> </th>
		<th width="16%"> <b>基站名</b> </th>
		<th width="15%"> <b>故障类型</b> </th>
		<th > <b>监控日志</b> </th>
		<th width="15%"> <b>基站地址</b></th>
		<th width="13%"> <b>创建时间</b></th>
		<th width="10%"> <b>确认</b> </th>
		</tr>
		</thead>
			<tbody>
			<?php foreach ($work_orders as $work_order): ?>
			<tr>
			<td> <?= $work_order['id']?> </td>
			<td> <div style="width:40px;float:left"><?= h_station_type($work_order['station_type'])?></div>
				<?= $work_order['station_name_chn']?> </td>
			<td> 
				<? if(count($work_order['bug_types'])>0){
						foreach($work_order['bug_types'] as $bug_type){
							echo h_bug_type_name_chn($bug_type['type']);
							echo "&nbsp;&nbsp;";
						}
					}else{?>
					故障已经消失
				<?}?>
			</td>
			<td> <a target="_blank" href="/setup/home/work_order_status/<?=$work_order['id']?>" ><?php if(mb_strlen($work_order['creator_remark'])>34){echo mb_substr($work_order['creator_remark'],0,34)."..<全文>";}else{echo $work_order['creator_remark'];}?> </a> </td>
			<td> <?= $work_order['address_name_chn']?></td>
			<td> <?= $work_order['create_time'] ?></td>
			<td> <? if($work_order['status']==ESC_WORK_ORDER__CREATE){?> <a href="javascript:if(confirm('确实此操作'))location='/setup/home/confirm_order/<?= $work_order['id']?>';void(0)"><button style="color:red">确认工单</button></a><?}
			elseif($work_order['status']==ESC_WORK_ORDER__CONFIRM){?> <a href="javascript:if(confirm('确实此操作'))location='/setup/home/before_fixed_order/<?= $work_order['id']?>';void(0)"><button style="color:blue">完成工单</button></a><?}
			elseif($work_order['status']==ESC_WORK_ORDER__FIX){?><span>等待系统确认...</span><?}?>

			</tr>
				<?php endforeach?>
			</tbody>
	</table>
	<?= $pagination?>
</div>

<script>
    $(function(){
        function show(){
            $.ajax({
                type: "GET",
                data: "currentTime="+$("#currentTime").val(), 
                url: "/setup/home/ajax_get_new_work_orders",
                dateType: "json",                  
                success: function(data){
                    var data=eval("("+data+")");
                    if(data.length>0){
                        $("#newFeedsCount").text(data.length);
                        $(".new-feed-tip").show();
                        play('/static/site/msg1.mp3');
                        $(".show-new-feed").click(function(){
                            $(".show-new-feed").fadeOut("fast",function(){
                               $(".show-new-feed-loading").show();
                               location.href="/setup/home/work_order_maintain";
                             });
                            
                        });
                    }
                },
                error:function(){
                }
            })
        }      
        setInterval(show,10000);   
    })

</script>
