<!--新工单提示框-->
<script type="text/javascript" src="/static/site/js/swfobject.js"></script>
<script type="text/javascript">
    function play(c) {
        var sound = swfobject.getObjectById("sound");
        if (sound) {
            sound.SetVariable("f", c);
            sound.GotoFrame(1);
        }
    }
    function show(){
        $.ajax({
            type: "GET",
            data: "currentTime="+$("#currentTime").val(),
            url: "/maintain/work_order/ajax_get_new_bugs",
            dateType: "json",
            success: function(data){
                var data=eval("("+data+")");
                if(data.length>0){
                    $("#newFeedsCount").text(data.length);
                    $(".new-feed-tip").show();
                    play('/static/site/msg.mp3');
                    $(".show-new-feed").click(function(){
                        $(".show-new-feed").fadeOut("fast",function(){
                            $(".show-new-feed-loading").show();
                            location.href="/maintain/work_order/prepare_orders";
                        });

                    });
                }

            },
            error:function(){
            }
        })
    }

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
            document.getElementById('filter').action = "/maintain/work_order/prepare_orders";
            document.getElementById('filter').submit();
        });
       
        setInterval(show,10000);

        setInterval(function(){$("#blinktest").toggle()},500);


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
    <br/>
    基站类型:<?= h_station_station_type_select($this->input->get('station_type')); ?>
    每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
</div>
<div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
    <a href="/maintain/work_order/prepare_orders" class="btn btn-primary">清除查询</a>
</div>
</form>

</div>



<div class = "base_center">
    <div style="clear:right;"><?= $pagination ?></div>
    <input type="hidden" id="currentTime" value="<?= $currentTime?>"/>

    <object width="1" height="1" type="application/x-shockwave-flash" data="/static/site/sound.swf" id="sound" style="visibility: visible;">
        <param name="wmode" value="transparent">
    </object>

    <div class="new-feed-tip" style="display: none;height:35px;">
        <a class="show-new-feed" href="javascript:void(0)" style="text-decoration:blink;display: block;">
            <ul style="float:left;text-align:right;ist-style:none;padding:0;margin: 0;display:block;width:400px">
            <li id="blinktest" style="text-align:right" >
                请注意！
            </li>
            </ul>
            <ul style="text-align:left">
                共有
                <span id="newFeedsCount"></span>
                个新故障，点击显示
            </ul>
        </a>
        <div class="show-new-feed-loading" style="display: none;">最新故障列表读取中...</div>
    </div>
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
                    <td> <a href="javascript:if(confirm('确实要生成工单么'))location='/maintain/work_order/add_work_order/<?= $data['id'] ?>';void(0)">点击生成</a></td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>        
            <div style="clear:right;"><?= $pagination ?></div>
        </div>
</div>


