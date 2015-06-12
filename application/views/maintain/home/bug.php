<script>
    $(function(){
        $("#project_id").change(function(){
            var obj = $(this);
            $.ajax({
                type: "GET",
                data: "project_id="+obj.val(), 
                url: "/maintain/home/ajax_get_areas",
                dateType: "json",                  
                success: function(data){
                    var jsondata=eval("("+data+")");
                    var str="";
                    for(var i=0;i<jsondata.length;i++){
                        str+="<option value="+jsondata[i].id+">"+jsondata[i].name_chn+"</option>";
                    }
                    $("#city_id").html(str);
                },
                error:function(){
                }
            })
        })
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/maintain/home/bug";
            document.getElementById('filter').submit();
        });
    });
</script>
<!--测试提示框-->
<style type="text/css">
.new-feed-tip { background: none repeat scroll 0 0 #F0F5F8; border: 1px solid #CEE1EE; margin-top: 10px; margin-bottom: 10px;}
.feed-module a:link, .feed-module a:hover, .feed-module a:visited { color: #336699;}
.show-new-feed{ margin:10px; text-align:center; }
.show-new-feed-loading{ margin: 10px;text-align: center;}
</style>



<div class = "base_center">

    <div style="margin:0;width:100%">
    <font>运维 >> <a href="/maintain/home/bug"><?= $menu?></a> </font>
    </div>

<form id="filter" method="get" action="">
<div class='filter'>
    搜索站名: <input type="text" name="search" value="<?= $this->input->get('search') ?>" style="width:100px" >
    工单:<?= h_common_select('work_order_id',$work_orders,$this->input->get('work_order_id')); ?>
    项目:<?= h_common_select('project_id',$projects,$this->input->get('project_id')); ?>
    城市:<?= h_common_select('city_id',$cities,$this->input->get('city_id')); ?>
    在线:<?= h_alive_select($this->input->get('alive')); ?>
    督导:<?= h_common_select('creator_id',$creators,$this->input->get('creator_id')); ?>
    <br/>
    基站类型:<?= h_station_station_type_select($this->input->get('station_type')); ?>
    基站ID: <input type="text" name="station_ids" value="<?= $this->input->get('station_ids') ?>" style="width:100px" >
    每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
</div>
<div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
        <a href="/maintain/home/bug" class="btn btn-primary">清除查询</a>

        <p style="float:right">
            <!--<a href="javascript:void(0)" id="download_xls" class="btn btn-primary">工单页面</a>-->
            <a href="work_order_list" id="download_xls" class="btn btn-primary">工单页面</a>
        </p>
</div>
</form>

</div>



<div class = "base_center">
    <div style="clear:right;"><?= $pagination ?></div>
    <div style="with:100%;height:auto;float:left">
        <div style="float:left;width:600px;height:auto;border:1px solid #ffffff">
            >>生成工单
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                    <th></th>
                    <th colspan=4> <b>参数</b> </th>
                    <th colspan=1> <b>操作</b> </th>
                    </tr>
                    <tr>
                    <th width="5%"> <b>#</b> </th>
                    <th width="23%"> <b>故障站点</b> </th>
                    <th width="10%"><b>城市</b></th>
                    <th > <b>故障类型</b> </th>
                    <th width="10%"><b>督导</b></th>
                    <th width="12%"> <b>生成工单</b> </th>           
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php foreach ($datas as $data): ?>
                    <tr>
                    <td> <?= $data['id']?> </td>
                    <td> <div style="width:40px;float:left"><?= h_station_type($data['station_type'])?></div><?= $data['name_chn']?> </td>
                    <td> <?= $data['city_name_chn']?> </td>
                    <td> <?= $data['bug_name_chn']?>(<?= $data['bug_point']?>)  </td>
                    <td> <?= $data['creator_name']?>  </td>
                    <td> <a href="javascript:if(confirm('确实要生成工单么'))location='/maintain/home/add_work_order/<?= $data['id'] ?>';void(0)">点击生成</a></td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>        
        </div>
        <div style="float:left;width:376px;height:auto;margin-left:20px">
            <div style="float:left;width:376px;heigt:auto;">
             >>工单派发
                 <div style="overflow:auto;width:376px;max-height:200px;float:left;">
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                            <th></th>
                            <th colspan=4> <b>参数</b> </th>
                            <th colspan=1> <b>操作</b> </th>
                            </tr>
                            <tr>
                            <th width="5%"> <b>#</b> </th>
                            <th > <b>故障站点</b> </th>
                            <th width="15%"><b>城市</b></th>
                            <th width="15%"><b>监控</b></th>
                            <th width="15%"><b>维护</b></th>
                            <th width="12%"> <b>操作</b> </th>           
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php foreach ($work_order_confirms as $work_order_confirm): ?>
                            <tr>
                            <td> <?= $work_order_confirm['id']?> </td>
                            <td> <div style="width:40px;float:left"><?= h_station_type($work_order_confirm['station_type'])?></div><?= $work_order_confirm['name_chn']?> </td>
                            <td> <?= $work_order_confirm['city_name_chn']?> </td>
                            <td> <?= $work_order_confirm['creator_name_chn']?>  </td>
                            <td> <?= $work_order_confirm['dispatcher_name_chn']?>  </td>
                            <td><a target='_blank' href="work_order_status/<?= $work_order_confirm['work_order_id']?>">查看</a></td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="float:left;height:25px;width:376px;"></div>
            <div style="float:left;width:376px;height:auto;">
            >>下站维修 
                <div style="overflow:auto;width:376px;max-height:200px;float:left;">   
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                            <th></th>
                            <th colspan=4> <b>参数</b> </th>
                            <th colspan=1> <b>操作</b> </th>
                            </tr>
                            <tr>
                            <th width="5%"> <b>#</b> </th>
                            <th > <b>故障站点</b> </th>
                            <th width="15%"><b>城市</b></th>
                            <th width="15%"><b>监控</b></th>
                            <th width="15%"><b>维护</b></th>
                            <th width="12%"> <b>操作</b> </th>           
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php foreach ($work_order_fixs as $work_order_fix): ?>
                            <tr>
                            <td> <?= $work_order_fix['id']?> </td>
                            <td> <div style="width:40px;float:left"><?= h_station_type($work_order_fix['station_type'])?></div><?= $work_order_fix['name_chn']?> </td>
                            <td> <?= $work_order_fix['city_name_chn']?> </td>
                            <td> <?= $work_order_fix['creator_name_chn']?>  </td>
                            <td> <?= $work_order_fix['dispatcher_name_chn']?>  </td>
                            <td><a target='_blank' href="work_order_status/<?= $work_order_fix['work_order_id']?>">查看</a></td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="float:left;height:25px;width:376px;"></div>
            <div style="float:left;width:376px;height:auto;">
                <div style="overflow:auto;width:376px;max-height:200px;float:left;">
                >>等待系统确认
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                            <th></th>
                            <th colspan=4> <b>参数</b> </th>
                            <th colspan=1> <b>操作</b> </th>
                            </tr>
                            <tr>
                            <th width="5%"> <b>#</b> </th>
                            <th > <b>故障站点</b> </th>
                            <th width="15%"><b>城市</b></th>
                            <th width="15%"><b>监控</b></th>
                            <th width="15%"><b>维护</b></th>
                            <th width="12%"> <b>操作</b> </th>           
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php foreach ($work_order_confirm_fixs as $work_order_confirm_fix): ?>
                            <tr>
                            <td> <?= $work_order_confirm_fix['id']?> </td>
                            <td> <div style="width:40px;float:left"><?= h_station_type($work_order_confirm_fix['station_type'])?></div><?= $work_order_confirm_fix['name_chn']?> </td>
                            <td> <?= $work_order_confirm_fix['city_name_chn']?> </td>
                            <td> <?= $work_order_confirm_fix['creator_name_chn']?>  </td>
                            <td> <?= $work_order_confirm_fix['dispatcher_name_chn']?>  </td>
                            <td><a target='_blank' href="work_order_status/<?= $work_order_confirm_fix['work_order_id']?>">查看</a></td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div style="clear:right;"><?= $pagination ?></div>
    <!--<input type="hidden" id="currentTime" value="<?= $currentTime?>"/>
    <div class="new-feed-tip" style="display: none;">
        <a class="show-new-feed" href="javascript:void(0)" style="display: block;">
            有
            <span id="newFeedsCount"></span>
            个新故障，点击显示
        </a>
        <div class="show-new-feed-loading" style="display: none;">最新故障读取中...</div>
    </div>

    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
            <th></th>
            <th colspan=5> <b>参数</b> </th>
            <th colspan=2> <b>操作</b> </th>
            </tr>
            <tr>
            <th width="5%"> <b>#</b> </th>
            <th width="20%"> <b>故障站点</b> </th>
            <th width="6%"><b>城市</b></th>
            <th > <b>故障类型</b> </th>
            <th width="6%"><b>督导</b></th>
            <th width="13%"> <b>故障时间</b> </th>
            <th width="8%"> <b>生成工单</b> </th>
            <th width="10%"> <b>工单状态</b> </th>            
            </tr>
        </thead>
        <tbody id="tbody">
            <?php foreach ($datas as $data): ?>
            <tr>
            <td> <?= $data['id']?> </td>
            <td> <div style="width:40px;float:left"><?= h_station_type($data['station_type'])?></div><?= $data['name_chn']?> </td>
            <td> <?= $data['city_name_chn']?> </td>
            <td> <?= $data['bug_name_chn']?>(<?= $data['bug_point']?>)  </td>
            <td> <?= $data['creator_name']?>  </td>
            <td> <?= $data['start_time']?>  </td>
            <td><?if($data['order_status']==0){?> <a href="javascript:if(confirm('确实要生成工单么'))location='/maintain/home/add_work_order/<?= $data['id'] ?>';void(0)">点击生成</a>
                <?}elseif($data['order_status']==1){?><a href="javascript:if(confirm('已生成工单，请删除该工单后继续！点击确定删除该工单'))location='/maintain/home/del_work_order/<?= $data['id'] ?>';void(0)">点击生成</a><?} ?></td>
            <td> <?if($data['order_status']==0){?>未派发<?}elseif($data['order_status']==1){?>已生成<?} ?>  </td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>
    <div style="clear:right;"><?= $pagination ?></div>
    -->
</div>

<!--
<script>
    $(function(){
        function show(){
            $.ajax({
                type: "GET",
                data: "currentTime="+$("#currentTime").val(), 
                url: "/maintain/home/ajax_get_new_bugs",
                dateType: "json",                  
                success: function(data){
                    var data=eval("("+data+")");
                    if(data.length>0){
                        $("#newFeedsCount").text(data.length);
                        $(".new-feed-tip").show();
                        $(".show-new-feed").click(function(){
                            $(".show-new-feed").fadeOut("fast",function(){
                               $(".show-new-feed-loading").show();
                               location.href="/maintain/home/bug";
                             });
                            
                        });
                    }
                },
                error:function(){
                    alert('报错啦！');
                }
            })
        }      
        setInterval(show,10000);
    
    })
</script>
-->
