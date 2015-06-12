<script>
    $(function(){
        $("#project_id").change(function(){
            var obj = $(this);
            $.ajax({
                type: "GET",
                data: "project_id="+obj.val(), 
                url: "/maintain/work_order/ajax_get_areas",
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
            document.getElementById('filter').action = "/maintain/work_order/fixed_orders";
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
    </div>

<form id="filter" method="get" action="">
<div class='filter'>
    搜索站名: <input type="text" name="search" value="<?= $this->input->get('search') ?>" style="width:100px" >
    项目:<?= h_common_select('project_id',$projects,$this->input->get('project_id')); ?>
    城市:<?= h_common_select('city_id',$cities,$this->input->get('city_id')); ?>   
    督导:<?= h_common_select('station_creator_id',$station_creators,$this->input->get('station_creator_id')); ?>
    监控:<?= h_common_select('creator_id',$work_order_creators,$this->input->get('creator_id')); ?>
    维修<?= h_common_select('dispatcher_id',$work_order_dispatchers,$this->input->get('dispatcher_id')); ?>
    <br/>
    基站类型:<?= h_station_station_type_select($this->input->get('station_type')); ?>
    基站ID: <input type="text" name="station_ids" value="<?= $this->input->get('station_ids') ?>" style="width:100px" >
    每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
</div>
<div class='operate'>
    <a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
    <a href="/maintain/work_order/fixed_orders" class="btn btn-primary">清除查询</a>
</div>
</form>

</div>



<div class = "base_center">
    <div style="clear:right;"><?= $pagination ?></div>
            >><?= $title?>
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                    <th></th>
                    <th colspan=7> <b>参数</b> </th>
                    <th colspan=1> <b>操作</b> </th>
                    </tr>
                    <tr>
                    <th width="5%"> <b>#</b> </th>
                    <th width="15%"> <b>故障站点</b> </th>
                    <th width="10%"><b>城市</b></th>
                    <th > <b>故障类型</b> </th>
                    <th width="6%"><b>督导</b></th>
                    <th width="6%"><b>监控</b></th>
                    <th width="6%"><b>维护</b></th>
                    <th width="13%"><b>派发时间</b></th>                    
                    <th width="10%"> <b>查看</b> </th>           
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php foreach ($datas as $data): ?>
                    <tr>
                    <td> <?= $data['id']?> </td>
                    <td> <div style="width:40px;float:left"><?= h_station_type($data['station_type'])?></div><?= $data['s_name_chn']?> </td>
                    <td> <?= $data['city_name_chn']?> </td>
                    <td> <?= $data['bug_name_chn']?> </td>
                    <td> <?= $data['station_creator_name_chn']?>  </td>
                    <td> <?= $data['work_order_creator_name_chn']?>  </td>
                    <td> <?= $data['dispatcher_name_chn']?>  </td>
                    <td> <?= $data['create_time']?>  </td>
                    <td>
                        <a class="btn btn-primary btn-mini" href="#" onclick="confirm_jumping('点击关闭','/maintain/work_order/before_close_work_order/<?=$data['id']?>') ">点击验收</a>
                    </td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>        
            <div style="clear:right;"><?= $pagination ?></div>
        </div>
</div>

