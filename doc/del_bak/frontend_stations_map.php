
<style type="text/css">  
	#map{ height:550px; border:1px solid gray; margin: 0 auto;} 

</style>  
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>  



<div class="base_center">
<div class="container-fluid">

    <div class="row-fluid"> <!--chart row 1--> 
        <div class="span9">
        <div id="map"></div>
        </div>  
	</div>
</div>




<script type="text/javascript">  
    window.global_options=[ 
    <?php foreach ($stations as $station):?>
        {"alive":"<?= $station->getAlive();?>",
        "name_chn":"<?= $station->getNameChn()?>",
        "lng":"<?= $station->getLng()?>",
        "lat":"<?= $station->getLat()?>",

        "station_type_name":"<?= $station->getStationType();?>",
        "total_load_name":"<?= $station->getTotalLoad();?>",
        "building_name":"<?= $station->getBuilding();?>",
        "fan_type_name":"<?= $station->getFanType();?>",
        "colds_0_type_name":"<?= $station->getColds0Type();?>",
        "colds_1_type_name":"<?= $station->getColds1Type();?>",
        "type1":"0",
        "type2":"0"},
    <?php endforeach?>
                            
    ]
      // BMap.
			var map = new BMap.Map("map");          // 创建地图实例  
			map.enableKeyboard();         // 开启键盘控制 

			
			map.addControl(new BMap.NavigationControl());   //各种控件
			map.addControl(new BMap.ScaleControl());  
			map.addControl(new BMap.OverviewMapControl());  
			map.addControl(new BMap.MapTypeControl());        
      
      // 编写自定义函数，创建标注，添加标注点击事件
      

      function infoContent(station){
            var str = "";
            if(station.alive === "1"){
                str += '               当前状态: <span class="label label-success">在线！</span><br>';
            }else{
                str += '               当前状态：<span class="label label-important">不在线</span><br>';
            }
            str += '   站点类型: '+station.station_type_name + "<br/>";
            str += '   负载类型: '+station.total_load_name + "<br/>";
            str += '   建筑材料: '+station.building_name + "<br/>";
            str += '   新风类型: '+station.fan_type_name + "<br/>";
            str += '   空调0类型: '+station.colds_0_type_name + "<br/>";
            str += '   空调1类型: '+station.colds_1_type_name;
            return str;
      }
      
      function addMarker(i,point, station){     	
          var myIcon = new BMap.Icon("/static/site/img/marker1.png", new BMap.Size(21, 25), {
            anchor: new BMap.Size(10, 25),                  // 指定定位位置
            // imageOffset: new BMap.Size(0 - station.type1 * 21, 0 - station.type2 * 25)   // 设置图片偏移 
            imageOffset: new BMap.Size(0, 0) 
          });
          var marker = new BMap.Marker(point, {icon: myIcon});
          map.addOverlay(marker);
          
          var label = new BMap.Label(station.name_chn,{offset:new BMap.Size(21,0)});
          if(station.alive === "1"){
          	 label.setStyle({color:"green",border:"2px solid green"});	
          }else{
          	 label.setStyle({color:"red",border:"2px solid red"});
          }
          marker.setLabel(label);
           
          marker.addEventListener("click",function(){
            var marker_opts = { title: "<h5 style='margin:0 0 2px 0'>"+station.name_chn+"</h4>" };
            var infoWindow = new BMap.InfoWindow(infoContent(station),marker_opts);
            this.openInfoWindow(infoWindow);
          });
      }

      
      // [2]根据提供的地理区域或坐标获得最佳的地图视野
      
      var pointArr=[];

      for (var i = 0; i < window.global_options.length; i ++) {

        pointArr[i] = new BMap.Point(window.global_options[i].lng, window.global_options[i].lat);
        
        addMarker(i,pointArr[i],window.global_options[i]);
      }
      
      map.setViewport(pointArr,{zoomFactor: -1});
      
		</script> 
</div>
