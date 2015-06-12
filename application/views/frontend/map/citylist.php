<script>

    $(function(){ $('.f_filter select[value!=0],.f_filter input[value!=""]').css({'background-color':'green','color':'white'}); })
</script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=3140E164A92ec6884b61b080e7bd973a"></script>
<script type="text/javascript" src="/static/jquery/convertor.js"></script>
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

    <div class='f_filter'>
        <ul>
            <li>
                <?=$this->lang->line("search")?>: <input type="text" id="search" name="search" value="<?= $this->input->get('search') ?>" style="width:100px" >
            </li>
            <li>
                <a href="javascript:void(0)" id="confirm_s" class="btn btn-mini btn-primary"><?=$this->lang->line("confirm")?></a> 
            </li>
            <li>
                <a href="/frontend/map/index" class="btn btn-mini btn-primary"><?=$this->lang->line("clear")?></a>
            </li>
        </ul>
    </div>

    <div class='detail_f'>
        <ul class=head> <?=$this->lang->line("load")?> </ul>
        <ul class=body>
                <li class="<?= ""==$this->input->get('total_load')?"active":""?>"> 
                     <a href='?<?= $total_load_empty?>'><?=$this->lang->line("Total")?></a> </li>
            <? foreach($total_loads as $total_load){ ?>
                <li class="<?= $total_load['id']==$this->input->get('total_load')?"active":""?>"> 
                     <a href="?<?= $total_load['url']?>"><?= $total_load['name_chn']?></a> </li>
            <?} ?>
        </ul>
        <ul class=line> </ul>
        <ul class=head> <?=$this->lang->line("build")?> </ul>
        <ul class=body>
            <li class="<?= ""==$this->input->get('building')?"active":""?>"> 
                     <a href='?<?= $building_empty?>'><?=$this->lang->line("Total")?></a> </li>
            <? foreach($buildings as $building){ ?>
                <li class="<?= $building['id']==$this->input->get('building')?"active":""?>"> 
                    <a href="?<?= $building['url']?>"><?= $building['name_chn']?></a> </li>
            <?} ?>
        </ul>
        <ul class=line> </ul>
        <ul class=head> <?=$this->lang->line("type")?> </ul>
        <ul class=body>
                <li class="<?= ""==$this->input->get('station_type')?"active":""?>"> 
                     <a href='?<?= $station_type_empty?>'><?=$this->lang->line("Total")?></a> </li>
            <? foreach($station_types as $station_type){ ?>
                <li class="<?= $station_type['station_type']==$this->input->get('station_type')?"active":""?>"> 
                    <a href="?<?= $station_type['url']?>"><?= $station_type['name_chn']?></a> </li>
            <?} ?>
        </ul>
        <ul class=line> </ul>
        <ul class=head> <?=$this->lang->line("Areas")?> </ul>
        <ul class=body>
                <li class="<?= ""==$this->input->get('district_id')?"active":""?>"> 
                     <a href='?<?= $district_id_empty?>'><?=$this->lang->line("Total")?></a> </li>
            <? foreach($areas as $area){ ?>
                <li class="<?= $area['id']==$this->input->get('district_id')?"active":""?>"> 
                    <a href="?<?= $area['url']?>"><?= $area['name_chn']?></a> </li>
            <?} ?>
        </ul>
    </div>

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
    
    //坐标转换完之后的回调函数
    translateCallback = function (point,name_chn){
        var xx = point.lng;
        var yy = point.lat;
        var marker = new BMap.Marker(new BMap.Point(xx, yy));  // 创建标注
        var label = new BMap.Label(name_chn,{offset:new BMap.Size(21,0)});
        marker.setLabel(label);
        map.addOverlay(marker);
    };

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
    var citypoint =  new BMap.Point(<?= $city['lng']?>,<?= $city['lat']?>);
    //这里可以增加过滤条件，暂时没写
    var points = filter(point);

    var viewport = map.getViewport(points);
    var name_chn ="";
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
        var gpsPoint = new BMap.Point(point[i].lng,point[i].lat);
        BMap.Convertor.translate(gpsPoint,0,translateCallback,point[i].name_chn);
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
