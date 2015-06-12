<div class=base_center>


    <div style="margin:0;width:100%">
    <font>后台 >> 空调不受控自动排查</font>
    </div>

    <br />
    <div style="width:1000px;">
    <input type=text id="datetime" value=<?= h_dt_format("-1 day","Y-m-d H:i:s")?> style="width:100px"/>
    <a href="javascript:void(0)" id="start">开始计算</a>
    &nbsp;&nbsp;
    <a href="javascript:void(0)" id="stop">停止</a>
    &nbsp;&nbsp;
    <a href="javascript:void(0)" id="goback">重算</a>
    &nbsp;&nbsp;
    <a href="javascript:void(0)" id="clear">清空</a>
    &nbsp;&nbsp;
    &nbsp;&nbsp;
    &nbsp;&nbsp;
    <a href="javascript:void(0)" id="close">清除过期故障（30分钟）</a>
    </div>
    <div id="disp" style="background-color:#000;color:#fff;width:1000px;height:200px;overflow-y:scroll;">
    </div>


    
<script>    
window.num = 0;
window.result = 0;
window.close_result = 0;
window.all = <?= count($station_groups)?>;
window.station_ids_array = <?= json_encode($station_groups)?>;

function close(){
    window.close_result = $.ajax({ url: "/backend/bug/go_close_over_time_bugs", 
        context: document.body, 
        data:{},
        success: function(msg){
            old = $("#disp").html();
            $("#disp").html(old + '<br> 共关闭: '+ window.close_result.responseText);
        }
    });
}

function start(){
    if(window.num >= window.all){
        return;
    }

    old = $("#disp").html();
    $("#disp").html(old + '<br> 计算结果: ' + window.result.status + " " + window.result.responseText);
    old = $("#disp").html();
    $("#disp").html(old + '<br> 正在计算: ('+(window.num+1)+"/"+window.all+") 基站id:" + 
        window.station_ids_array[window.num]);
    $("#disp").scrollTop(100000000);
    window.result = $.ajax({ url: "/backend/bug/go_colds_out_ctrl/", 
        context: document.body, 
        data:{
            station_ids_str:window.station_ids_array[window.num],
            datetime:$("#datetime").val()
        },
        success: function(msg){
            start();
        }
    });
    console.log(window.result);
    window.num++;
}    
$(function(){
    $("#start").click(function(){start()});
    $("#close").click(function(){close()});
    $("#goback").click(function(){ window.num = 0; });
    $("#stop").click(function(){ window.num = 10000000; });
    $("#clear").click(function(){ $("#disp").html(" "); });

})
</script>    
    
</div>
