<script>

    $(function(){ $('.f_filter select[value!=0],.f_filter input[value!=""]').css({'background-color':'green','color':'white'}); })
</script>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />   
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<style>
.container,.footer{margin:10px auto 0;width:1000px;}
.container{position:relative;height:600px;text-align:left;background:#fff;}
.wider{width:998px;height:100%;border:1px solid #808080;height:600px;}

.detail_f{margin:0;padding:0}
.detail_f ul{float:left;margin:2px 0;padding:0;}
.detail_f ul.head{width:35px;text-align:left;font-weight:bold;padding:4px 0 0 0;}
.detail_f ul.body{width:965px;}
.detail_f ul.line{width:1000px;border-bottom:1px dashed #ccc;height:2px;}
.detail_f ul li{float:left;margin:2px;padding:1px 6px;background-color:#ddd;}
.detail_f ul li a{color:#000;}
.detail_f ul li.head{width:35px;text-align:left;font-weight:bold}
.detail_f ul li.active{background-color:#69c;color:#fff}
.detail_f ul li.active a{background-color:#69c;color:#fff}
.line{width:1000px;border-bottom:1px dashed #ccc;height:2px;}
</style>
<div class = "base_center">
    <div style="clear:both"> </div>


    <div style='clear:both;border-bottom:2px solid #933;width:1000px;height:20px'>
    </div>
    
    <? if(count($correct_stations)>0){?>
        <div class="container clearfix">
            <div id="map" class="wider">
            </div>
        </div>    
    <? }elseif(count($stations)>0){?>
        <div style="width:980px;height:200px">
            <center><p style="padding-top:90px;font-size:24px;color:red"><?=$this->lang->line("Total")?>:<?= count($stations)?>&nbsp;<?=$this->lang->line("map_error_none")?></p></center>
        </div>
    <? }else{ ?>
        <div style="width:980px;height:200px">
            <center><p style="padding-top:90px;font-size:24px;color:green">没有符合该条件的基站</p></center>
        </div>
    <? } ?>
    <? if(count($wrong_stations)>0){ ?>
        <div style='width:1000px;height:auto;margin-top:10px;'>
            <p><?=$this->lang->line("map_error_mes")?></p>
            <div class=line> </div>
            <? foreach($wrong_stations as $k=>$wrong_station){?>
                <div style='width:100%;min-height:30px;line-height:30px;margin-left:20px;'>
                     <?= h_station_type($k)?>(<?= count($wrong_station)?>):
                     <? foreach($wrong_station as $station){?>
                        <?= $station['name_chn']?>&nbsp;&nbsp;
                     <? } ?>           
                </div>
                <div class=line> </div>
            <? } ?>
        </div>
    <?}?>
</div>

<script>
    //过滤条件
       function filter(arr){
        var tmp =  new Array();
        for(var i in arr){
                tmp.push(arr[i]);
        }
        return tmp;
   }

    //给地图创建标注
    function addMarker(name_chn,lng,lat,i){
    //marker.setLabel(station);     
        marker[i] = new BMap.Marker(new BMap.Point(lng, lat));  // 创建标注
        var label = new BMap.Label(name_chn,{offset:new BMap.Size(21,0)});
        marker[i].setLabel(label);
        map.addOverlay(marker[i]);
    }

    var point =new Array();
    <?php foreach ($correct_stations as $station):?>
        point["<?= $station['id']?>"]={
        "id":"<?= $station['id']?>",
        "lng":"<?= $station['lng']?>",
        "lat":"<?= $station['lat']?>",
        "name_chn":"<?= $station['name_chn']?>"
        }
    <?php endforeach?> 
    var marker=new Array();

    var map = new BMap.Map("map");
    var opts = {type:BMAP_NAVIGATION_CONTROL_SMALL}
    map.addControl(new BMap.NavigationControl(opts));

    //创建城市的point，做过滤用
    var citypoint =  new BMap.Point(122,33);
    //这里可以增加过滤条件，暂时没写
    var points = filter(point);

    var viewport = map.getViewport(points);
    
    map.centerAndZoom(viewport.center, viewport.zoom);

    //添加控件
    map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用

    //添加缩放插件
    map.addControl(new BMap.OverviewMapControl());              //添加默认缩略地图控件
    map.addControl(new BMap.OverviewMapControl({isOpen:true, anchor: BMAP_ANCHOR_TOP_RIGHT}));   //右上角，打开
    map.disableDoubleClickZoom(); //禁止双击放大
    map.addControl(new BMap.NavigationControl());  
    map.addControl(new BMap.ScaleControl());  
    map.addControl(new BMap.MapTypeControl()); 
    map.addControl(new BMap.ScaleControl());                    // 添加默认比例尺控件 
    map.addControl(new BMap.ScaleControl({anchor: BMAP_ANCHOR_BOTTOM_LEFT}));                    // 左下 
    for (var i in point) {
        addMarker(point[i].name_chn,point[i].lng,point[i].lat,i);
    }
</script>


<script>
    //地图切换全屏
    
    function toFullScreen() {
        map.disableAutoResize();
        var curPix = map.pointToPixel(map.getCenter());
        var newPix = new BMap.Pixel(curPix.x, curPix.y);
        var newCenter = map.pixelToPoint(newPix);
        var offset =$("#map").offset();
        $("#map").css("position","absolute").css("left","-"+offset.left+"px").css("top","-"+offset.top+"px").css("width",$(window).width()).css("height",$(window).height()+offset.top);
        map.checkResize();
        map.setCenter(newCenter);
        map.enableAutoResize();
    }
    function toNormal(){
        map.disableAutoResize();
        var curPix = map.pointToPixel(map.getCenter());
        var newPix = new BMap.Pixel(curPix.x, curPix.y);
        var newCenter = map.pixelToPoint(newPix);
        $("#map").css("position","relative").css("left","").css("top","").css("width","998px").css("height","600px").css("z-index","0");
        map.checkResize();
        map.setCenter(newCenter);
        map.enableAutoResize();
    }


       status = true;
       $("#map").dblclick(function(){
            if(status){
                toFullScreen();
                status = false;
            }else{
                toNormal();
                status = true;
            }
       }) 

    document.onkeydown = function (e) {
        var theEvent = window.event || e;
        var code = theEvent.keyCode || theEvent.which;
        if (code == 13) {
            location.href = "/frontend/map/index?search="+$("#search").val();   
        }
    } 
    $(function(){
        $("#confirm_s").click(function(){
            location.href = "/frontend/map/index?search="+$("#search").val();
        });
    });
</script>
