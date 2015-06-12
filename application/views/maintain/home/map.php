<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />	
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>

<div class=base_center>
<style>
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

body{font-family:"微软雅黑";text-align:center;}
img:hover{filter:alpha(opacity=90);-moz-opacity:0.9;-khtml-opacity: 0.9;opacity: 0.9;}
label{margin:0 10px 0 0;}
/** clearfix **/
.clearfix{display:block;zoom:1;}
.clearfix:after{content:".";display:block;height:0;clear:both;visibility:hidden;}
/** map **/
.container,.footer{margin:10px auto 0;width:1000px;}
.container{position:relative;height:600px;text-align:left;background:#fff;}
.wider,#sider{width:800px;height:100%;border:1px solid #808080;float:left;}
#sider{width:197px;border-width:1px 1px 1px 0;}
.infowin{width:200px;height:100px;float:left;}
.myinfopic{width:90px;height:90px;padding:3px;border:1px solid #999;}
#peoplelist dl a{display:block;width:100%;height:30px;line-height:30px;}
#peoplelist dl a:hover{background:#4EB9C6;color:#fff;}
#peoplelist dt a{color:#fff;}
#peoplelist dt{background:#56A97D;color:#fff;text-indent:10px;}
#peoplelist dd{text-indent:20px;}
.trafficX{padding:10px;position:relative;margin:10px auto;text-align:left;border:1px solid #ccc;width:980px;background:#fff;}
.btn a{padding:5px;display:inline-block;color:#fff;background:#56A97D;-webkit-border-radius:5px;-moz-border-radius:5px;}
#btnFind{position:absolute;left:-80px;}
.btn a:hover{background:#4EB9C6;}
.btn-close{position:absolute;right:10px;}
.intro{color:#a0a0a0;font-size:12px;}
.trafficTableX td{width:240px;}
.trafficTableX input,
.trafficTableX select{width:250px;border:1px solid #ccc;padding:3px;}
.trafficTableX .btn{margin:0 10px 0 0;}
.trafficTableX .btn a{padding:5px 20px;}
.trafficTableX h4 span{font-size:12px;font-weight:400;color:red;padding:0 0 0 10px;}
#result,#peoplelist{width:100%;height:100%;}
</style>

<div class='detail_f'>
    <ul class=head> 项目 </ul>
    <ul class=body>
            <li class="<?= ""==$this->input->get('project_id')?"active":""?>"> 
                 <a href='?<?= $project_empty?>'>全部</a> </li>
        <? foreach($projects as $project){ ?>
            <li class="<?= $project['id']==$this->input->get('project_id')?"active":""?>"> 
                 <a href='?<?= $project['url']?>'><?= $project['name_chn']?></a> </li>
        <?} ?>
    </ul>
    <ul class=line> </ul>
    <ul class=head> 城市 </ul>
    <ul class=body>
    	<li style="width:28px"></li>
        <? foreach($cities as $city){ ?>
            <li class="<?= $city['id']==$city_id?"active":""?>"> 
                <a href='?<?= $city['url']?>'><?= $city['name_chn']?></a> </li>
        <?} ?>
    </ul>
    <ul class=line> </ul>
    <ul class=head> 故障 </ul>
    <ul class=body>
            <li class="<?= ""==$this->input->get('type')?"active":""?>"> 
                 <a href='?<?= $type_empty?>'>全部</a> </li>
        <? foreach($bug_types as $bug_type){ ?>
            <li class="<?= $bug_type['type']==$this->input->get('type')?"active":""?>"> 
                <a href='?<?= $bug_type['url']?>'><?= $bug_type['name_chn']?></a> </li>
        <?} ?>
    </ul>
</div>


<div style='clear:both;border-bottom:2px solid #933;width:1000px;height:20px'>
</div>
<? if(count($tmps)>0){?>
  <div id="trafficBox" class="trafficX clearfix" style="display:none;">
    <a href="javascript:void(0);" onclick="btnClose();" class="btn-close"><img src="/static/site/img/close.png" alt="关闭" title="关闭" /></a>
    <table class="trafficTableX">
        <tr>
            <td><h4>起点<span id="startP">&nbsp;</span></h4></td>
            <td><h4>终点<span id="endP">&nbsp;</span></h4></td>
            <td><h4>&nbsp;</h4></td>
        </tr>
        <tr>
            <td>
            	经纬度坐标
            </td>
                <td>
                <select id="destination" onchange="bugChange()">
                	<? foreach ($tmps as $tmp){ ?>
                		<option value="<?= $tmp['id']?>"> <?= $tmp['station']?></option>
               	    <? } ?>
                </select>
            </td>
            <td><span class="btn"><a onclick="myBus();" href="javascript:void(0);">公交</a></span><span class="btn"><a onclick="myCar();" href="javascript:void(0);">自驾</a></span></td>
        </tr>
        <tr class="intro">
            <td>选起点：右键点击地图（下拉列表暂不可用）</td>
            <td>选终点：右键点击地图（下拉列表暂不可用）</td>
            <td>选择交通工具</td>
        </tr>
    </table>
</div>
<div class="container clearfix">
    <div id="btnFind" class="btn"><a href="javascript:void(0);" onclick="btnFind();">故障基站</a></div>			
  	<div id="map" class="wider"></div>
    <div id="sider">
        <div id="result" style="display:none;"></div>
        <div id="peoplelist"></div>
    </div>
</div>
 <script type="text/javascript">
	  //定义一些方法，这是过滤数据，如果基站太远则剔除
   function filter(arr){
		var tmp =  new Array();
		for(var i in arr){
			//var pointA = new BMap.Point(arr[i].lng,arr[i].lat); 
			//if( Math.floor(map.getDistance(pointA,citypoint))<2000000){	//这里的单位可能是cm,不懂
				tmp.push(arr[i]);
			//}
		}
		//如果因为基站距离城市太远，且只有一个。这里也给这个bug提供了一个处理
		//if(tmp.length==0){
			//tmp.push(arr[0]);
		//}
		return tmp;
   }	

   //选择下拉框
   function selectIndex(arr){
   	var n=arr.length;
   	var result="";
   	for(var i=0;i<n;i++){
   		result+="<option value='"+arr[i].id+"'>"+arr[i].station+"</option>";
   	}
   	return result;
   }


   var marker=new Array();

   //给地图创建标注
   function addMarker(type,lng,lat,station,i){
   	//marker.setLabel(station);  	
   	    marker[i] = new BMap.Marker(new BMap.Point(lng, lat));  // 创建标注
	   	var label = new BMap.Label(station,{offset:new BMap.Size(21,0)});
		marker[i].setLabel(label);
		map.addOverlay(marker[i]);
		var infoWindow = new BMap.InfoWindow("<p style='font-size:14px;'>"+type+"</p>");
		marker[i].addEventListener("click", function(){this.openInfoWindow(infoWindow)});              // 将标注添加到地图中
	} 

	//一些常用方法
	function $(id){
		return document.getElementById(id);
	}

	function displayBlock(id){
   	    $(id).style.display = 'block';
	}
	function hiddenHidden(id){
    	$(id).style.display = 'none';
	}

	function btnFind(){
    	displayBlock('trafficBox');
    	hiddenHidden('btnFind');
	}
	
	function btnClose(){
	    displayBlock('peoplelist');
	    hiddenHidden('result');
	    displayBlock('btnFind');
	    hiddenHidden('trafficBox');
	    for(var i in marker){
	    	map.addOverlay(marker[i]);
	    }
	    $('startP').innerHTML = '';
	    startPoint = null;
	    $('endP').innerHTML = '';
	    endPoint = null;
	    $('sider').style.width = '197px';
	    $('map').style.width = '800px';
	}

	function bugChange(){
		var i=$('destination').value;
		//alert(i);
		$('endP').innerHTML = point[i].lng + ',' + point[i].lat;
		endPoint = new BMap.Point(point[i].lng, point[i].lat);
	}

     var point =new Array();
     <?php foreach ($tmps as $tmp):?>
        point["<?= $tmp['id']?>"]={
        "type":"<?= $tmp['type']?>",
        "id":"<?= $tmp['id']?>",
        "lng":"<?= $tmp['lng']?>",
        "lat":"<?= $tmp['lat']?>",
        "station":"<?= $tmp['station']?>"
		}
    <?php endforeach?>
	var map = new BMap.Map("map");
	//创建城市的point，做过滤用
	var citypoint =  new BMap.Point(<?= $city['lng']?>,<?= $city['lat']?>);

	var points = filter(point);

	var viewport = map.getViewport(points);
	
	map.centerAndZoom(viewport.center, viewport.zoom);

	//添加控件
	map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
	map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用

	//添加缩放插件
	map.addControl(new BMap.OverviewMapControl());              //添加默认缩略地图控件
	map.addControl(new BMap.OverviewMapControl({isOpen:true, anchor: BMAP_ANCHOR_TOP_RIGHT}));   //右上角，打开
	
	map.addControl(new BMap.NavigationControl());  
	map.addControl(new BMap.ScaleControl());  
	map.addControl(new BMap.MapTypeControl()); 
	map.addControl(new BMap.ScaleControl());                    // 添加默认比例尺控件 
	map.addControl(new BMap.ScaleControl({anchor: BMAP_ANCHOR_BOTTOM_LEFT}));                    // 左下

	//设置起点和终点
	var startPoint;
	var endPoint;
	var menu = new BMap.ContextMenu();
	var txtMenuItem = [
	    {
	        text:'选起点',
	        callback:function(e){
	            $('startP').innerHTML = e.lng + ',' + e.lat;
	            startPoint = new BMap.Point(e.lng,e.lat);
	        }
	    },
	    {
	        text:'选终点',
	        callback:function(e){
	            $('endP').innerHTML = e.lng + ',' + e.lat;
	            endPoint = new BMap.Point(e.lng,e.lat);
	        }
	    }
	];

	for(var i=0; i < txtMenuItem.length; i++){
		    menu.addItem(new BMap.MenuItem(txtMenuItem[i].text,txtMenuItem[i].callback,100));
		}
		map.addContextMenu(menu);  

	for (var i in point) {
		 	 addMarker(point[i].type,point[i].lng, point[i].lat,point[i].station,i);
	  }
	
	//bus
	function myBus(){
	    //map.clearOverlays();
	    displayBlock('result');
	    hiddenHidden('peoplelist');
	    var transit = new BMap.TransitRoute(map, {renderOptions: {map: map, panel: 'result'}});
	    transit.search(startPoint, endPoint);
	    $('sider').style.width = '297px';
	    $('map').style.width = '700px';
	}
	//car
	function myCar(){
	    //map.clearOverlays();
	    displayBlock('result');
	    hiddenHidden('peoplelist');    
	    var driving = new BMap.DrivingRoute(map, {renderOptions:{map: map, panel: 'result', autoViewport: true}});
	    driving.search(startPoint, endPoint);
	    startPoint.enableDragging();//开启起点拖拽功能
	    endPoint.enableDragging();//开启终点拖拽功能
	    $('sider').style.width = '297px';
	    $('map').style.width = '700px';
	}
</script>
<? }else{ ?>
	<div style="width:980px;height:200px">
		<center><p style="padding-top:90px;font-size:24px;color:green">恭喜你！木有故障~</p></center>
	</div>
<? } ?>
