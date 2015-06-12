
<style type="text/css">  
	#map{ height:550px; border:1px solid gray; margin: 0 auto;} 

</style>  
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>  



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
                              //{"lng":"120.298","lat":"31.568","type1":"0","type2":"0","warning":["告警条目1","告警条目2","告警条目3"]},
                              //{"lng":"120.299","lat":"31.569","type1":"0","type2":"1"},
    ]
      // BMap.
			var map = new BMap.Map("map");          // 创建地图实例  
			//var point = new BMap.Point(120.299, 31.568);  // 创建点坐标  
			//map.centerAndZoom(point, 9);                 // 初始化地图，设置中心点坐标和地图级别  
			//map.centerAndZoom("无锡");
			/*setTimeout(function(){
				map.panTo(new BMap.Point(120.299, 31.568));
			},2000);*/
			//map.enableScrollWheelZoom();  // 开启鼠标滚轮缩放  
			map.enableKeyboard();         // 开启键盘控制 
			//map.enableContinuousZoom();   // 开启连续缩放效果  
			//map.enableInertialDragging(); // 开启惯性拖拽效果 
			
			map.addControl(new BMap.NavigationControl());   //各种控件
			map.addControl(new BMap.ScaleControl());  
			map.addControl(new BMap.OverviewMapControl());  
			map.addControl(new BMap.MapTypeControl());  
			//map.addControl(new BMap.CopyrightControl());
			
			//var opts = {anchor: BMAP_ANCHOR_TOP_LEFT, offset: new BMap.Size(20,60)}; //控件摆放位置 TOP BOTTOM LEFT RIGHT
			//map.addControl(new BMap.NavigationControl(opts));
			
			//var opts = {type: BMAP_NAVIGATION_CONTROL_SMALL};   //控件外观 LARGE SMALL PAN ZOOM
			//map.addControl(new BMap.NavigationControl(opts));
			
			//var marker = new BMap.Marker(point);  //标注
			//map.addOverlay(marker);
			
			/* 事件 
			map.addEventListener("click", function(e){   
				alert(e.point.lng + "," + e.point.lat);	
			});
			
			map.addEventListener("zoomend", function(){   
				alert("地图缩放至：" + this.getZoom() + "级");	
			});
	
			map.addEventListener("dragend", function(){  
				var center = map.getCenter();
				alert("地图中心变更为：" + center.lng + "," +center.lat);	
			});
			*/
      /*
			var local = new BMap.LocalSearch(map, {
				renderOptions: {map: map, panel: "results"}
			});
			local.search("无锡工商银行");
     【#results{width: 380px; height: 200px;float:left; border:1px solid gray; margin-left: 10px;} 】
     【		<div id="results"></div> 】
      */
      
      
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
          var myIcon = new BMap.Icon("/static/site/img/markers.png", new BMap.Size(21, 25), {
            anchor: new BMap.Size(10, 25),                  // 指定定位位置
            // imageOffset: new BMap.Size(0 - station.type1 * 21, 0 - station.type2 * 25)   // 设置图片偏移 
            imageOffset: new BMap.Size(0, 0) 
          });
          var marker = new BMap.Marker(point, {icon: myIcon});
          map.addOverlay(marker);
          
          var label = new BMap.Label(station.name_chn,{offset:new BMap.Size(25,0)});
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
      //var pointArr = [new BMap.Point(lng,lat),new BMap.Point(lng,lat)]
      /*var pointArr = [new BMap.Point(120.299, 31.568),
                      new BMap.Point(120.300, 31.569),
                      new BMap.Point(120.301, 31.570),
                      new BMap.Point(120.302, 31.571)] */
      
      var pointArr=[];

      for (var i = 0; i < window.global_options.length; i ++) {

        pointArr[i] = new BMap.Point(window.global_options[i].lng, window.global_options[i].lat);
        
        addMarker(i,pointArr[i],window.global_options[i]);
      }
      
      map.setViewport(pointArr,{zoomFactor: -1});
      
      

  // 自定义覆盖物的构造函数
    function ComplexCustomOverlay(point, txtarray){
      this._point = point;
      this._text = txtarray.join('<br>');
      this._line = txtarray.length;
    }
     // 继承API的BMap.Overlay();
    ComplexCustomOverlay.prototype = new BMap.Overlay(); 
    
    // 实现初始化方法
    ComplexCustomOverlay.prototype.initialize = function(map){
      // 保存map对象实例
      this._map = map;  
      // 创建div元素，作为自定义覆盖物的容器  文本高18px
      var div = this._div = document.createElement("div");
      div.style.position = "absolute";
      div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
      div.style.backgroundColor = "#ff0000";
      div.style.color = "white";
      div.style.height = (18*this._line) + "px";
      div.style.padding = "0 4px";
      div.style.lineHeight = "18px";
      div.style.whiteSpace = "nowrap";
      div.style.MozUserSelect = "none";
      div.style.fontSize = "12px";
      var span = this._span = document.createElement("span");
      div.innerHTML = this._text;
         
      //var that = this;
      // 创建arrow
      var arrow = this._arrow = document.createElement("div");
      arrow.style.background = "url(/static/site/img/label.png) 0 -30px no-repeat";
      arrow.style.position = "absolute";
      arrow.style.width = "11px";
      arrow.style.height = "10px";
      arrow.style.top =  (18*this._line-1) + "px"; // -1 for beautiful!!
      arrow.style.left = "20px";
      arrow.style.overflow = "hidden";
      div.appendChild(arrow);
     
      /* 
      div.onmouseover = function(){
        this.style.backgroundColor = "#6BADCA";
        this.style.borderColor = "#0000ff";
        this.getElementsByTagName("span")[0].innerHTML = that._overText;
        arrow.style.backgroundPosition = "0px -20px";
      }

      div.onmouseout = function(){
        this.style.backgroundColor = "#EE5D5B";
        this.style.borderColor = "#BC3B3A";
        this.getElementsByTagName("span")[0].innerHTML = that._text;
        arrow.style.backgroundPosition = "0px 0px";
      }
      */
      // 将div添加到覆盖物容器中
      map.getPanes().labelPane.appendChild(div);
      
      return div;
    }
    // 绘制覆盖物
    ComplexCustomOverlay.prototype.draw = function(){
      var map = this._map;
      var pixel = map.pointToOverlayPixel(this._point);
      this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
      this._div.style.top  = pixel.y - (10+26+18*this._line) + "px"; // 10为arrow高度，26相对[x,y]高度调整，18为自定义覆盖物div的高度
    }

    // 添加覆盖物
    for (var i = 0; i < window.global_options.length; i ++) {
	   if(window.global_options[i].warning)
	   {
		    temp_map_point = new BMap.Point(window.global_options[i].lng,window.global_options[i].lat);
		    var myCompOverlay = new ComplexCustomOverlay(temp_map_point, window.global_options[i].warning);
		    map.addOverlay(myCompOverlay);
	   }
    }

		</script> 

