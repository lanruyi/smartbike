<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Chart{
	public function __construct(){
		include(APPPATH."libraries/pChart/class/pData.class.php");
		include(APPPATH."libraries/pChart/class/pDraw.class.php");
		include(APPPATH."libraries/pChart/class/pImage.class.php");
		include(APPPATH."libraries/pChart/class/pPie.class.php");
	}
	

	
	function draw_es_colds_fan_on($params){
		$DataSet = new pData;  
		 
		 foreach ($params['fan_0_on'] as $param) {
			 if($param[1]!=null){ $DataSet->AddPoint($param[1],"fan_0"); $DataSet->AddPoint($param[0],"create_time");  }
			 else { $DataSet->AddPoint('VOID',"fan_0"); $DataSet->AddPoint($param[0],"create_time"); }
		 }
		 foreach ($params['colds_0_on'] as $param) {
			 if($param[1]!=null){ $DataSet->AddPoint($param[1],"colds_0"); }
			 else { $DataSet->AddPoint('VOID',"colds_0"); }
		 }
		 foreach ($params['colds_1_on'] as $param) {
			 if($param[1]!=null){ $DataSet->AddPoint($param[1],"colds_1"); }
			 else { $DataSet->AddPoint('VOID',"colds_1"); }
		 }
		 
		 $DataSet->AddAllSeries();  
		 $DataSet->SetAbsciseLabelSerie("create_time"); 
		 
		 $Test = new pChart(300,200); 
		 $Test->setFontProperties(APPPATH."libraries/pChart/Fonts/simsun.ttc",8);  
		 
		 
		 $path = str_replace("\\","/",STATICPATH);
		 $imgroute = "site/img/mobile/".$params['imgName'];
		 $Test->Render($path.$imgroute);
		 
		 return $imgroute;
	}	
	

	function draw_es_colds_fan_on_pie($params){
		 $myData = new pData(); 
 
		 /* Add data in your dataset */ 
		 $myData->addPoints($params['value'],"Value");
		 $myData->addPoints($params['name'],"Name");
		
		 $myData->setAbscissa("Name");	
		
		 /* Create a pChart object and associate your dataset */ 
		 $myPicture = new pImage(240,130,$myData);
		
		 /* Choose a nice font */
		 $myPicture->setFontProperties(array("FontName"=>APPPATH."libraries/pChart/Fonts/simsun.ttc","FontSize"=>10));
		
		 /* Create the pPie object */ 
		 $pieChart = new pPie($myPicture,$myData);
		
		 $pieChart->setSliceColor(0,array("R"=>255,"G"=>187,"B"=>102)); // color:#ffbb66
		 $pieChart->setSliceColor(1,array("R"=>215,"G"=>102,"B"=>24)); // color:#d76618
		 $pieChart->setSliceColor(2,array("R"=>29,"G"=>71,"B"=>111)); // color:#1d476f
		 $pieChart->setSliceColor(3,array("R"=>153,"G"=>221,"B"=>221)); // color:#99dddd
		 
		 /* Draw a splitted pie chart */ 
		 $pieChart->draw3DPie(80,90,array("Radius"=>60,"WriteValues"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));
		 $myPicture->drawText(150,30,$params['title'],array("FontSize"=>12));
		 $pieChart->drawPieLegend(160,50,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL));

 		/* Render the picture (choose the best way) */
 		 $path = str_replace("\\","/",STATICPATH);
		 $imagefile = "site/img/mobile/".$params['imgName'];
		 $myPicture->Render($path.$imagefile); 
		 
		 return $imagefile;
	}
	
	function draw_es_temperature($params){
		 $myData = new pData();  
		
		 /* Add data in your dataset */ 
		 $myData->addPoints($params['indoor_tmp'],"站内温度");
		 $myData->addPoints($params['outdoor_tmp'],"站外温度");
		 $myData->addPoints($params['time'],"时间");
		
		 // $myData->setAxisName(0,"Temperature");
		 $myData->setAbscissa("时间");
 		 $myData->setXAxisDisplay(AXIS_FORMAT_TIME,"H:i");
		 
		 $myData->setPalette("站内温度",array("R"=>215,"G"=>102,"B"=>24)); //color:#d76618
		 $myData->setPalette("站外温度",array("R"=>29,"G"=>71,"B"=>111)); //color:#1d476f
		 
		 /* Create a pChart object and associate your dataset */ 
		 $myPicture = new pImage(480,180,$myData);
		
		 /* Choose a nice font */
		 $myPicture->setFontProperties(array("FontName"=>APPPATH."libraries/pChart/Fonts/simsun.ttc","FontSize"=>10));
		
		 /* Define the boundaries of the graph area */
		 $myPicture->setGraphArea(30,40,460,160); 
		
		 /* Draw the scale, keep everything automatic */ 
		 $x_interval = (60/$params['x_interval'])*4-1;
		 $myPicture->drawScale(array("LabelSkip"=>$x_interval,"SkippedTickAlpha"=>0));
		
		 /* Draw the scale, keep everything automatic */ 
		 $myPicture->drawSplineChart();
		 $myPicture->drawText(5,20,$params['title'],array("FontSize"=>12));
		 $myPicture->drawLegend(415,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL,"Family"=>LEGEND_FAMILY_LINE));

 		/* Render the picture (choose the best way) */
 		 $path = str_replace("\\","/",STATICPATH);
		 $imagefile = "site/img/mobile/".$params['imgName'];
		 $myPicture->Render($path.$imagefile); 
		 
		 return $imagefile;
	}



	function draw_es_power($params){
		 $myData = new pData();  
		
		 /* Add data in your dataset */ 
		 $myData->addPoints($params['power_main'],"总功率");
		 $myData->addPoints($params['power_dc'],"DC功率");
		 $myData->addPoints($params['time'],"时间");
		
		 // $myData->setAxisName(0,"Temperature");
		 $myData->setAxisDisplay(0,AXIS_FORMAT_METRIC);
		 $myData->setAbscissa("时间");
 		 $myData->setXAxisDisplay(AXIS_FORMAT_TIME,"H:i");
		 
		 $myData->setPalette("总功率",array("R"=>215,"G"=>102,"B"=>24)); //color:#d76618
		 $myData->setPalette("DC功率",array("R"=>29,"G"=>71,"B"=>111)); //color:#1d476f
		 
		 /* Create a pChart object and associate your dataset */ 
		 $myPicture = new pImage(480,180,$myData);
		
		 /* Choose a nice font */
		 $myPicture->setFontProperties(array("FontName"=>APPPATH."libraries/pChart/Fonts/simsun.ttc","FontSize"=>10));
		
		 /* Define the boundaries of the graph area */
		 $myPicture->setGraphArea(30,40,460,160); 
		
		 /* Draw the scale, keep everything automatic */ 
		 $x_interval = (60/$params['x_interval'])*4-1;
		 $myPicture->drawScale(array("LabelSkip"=>$x_interval,"SkippedTickAlpha"=>0));
		
		 /* Draw the scale, keep everything automatic */ 
		 $myPicture->drawSplineChart();
		 $myPicture->drawText(5,20,$params['title'],array("FontSize"=>12));
		 $myPicture->drawLegend(430,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL,"Family"=>LEGEND_FAMILY_LINE));

 		/* Render the picture (choose the best way) */
 		 $path = str_replace("\\","/",STATICPATH);
		 $imagefile = "site/img/mobile/".$params['imgName'];
		 $myPicture->Render($path.$imagefile); 
		 
		 return $imagefile;
	}
	
	function draw_es_colds_tmp($params){
		 $myData = new pData();  
		
		 /* Add data in your dataset */ 
		 $myData->addPoints($params['colds_0_tmp'],"空调0温度");
		 $myData->addPoints($params['colds_1_tmp'],"空调1温度");
		 $myData->addPoints($params['time'],"时间");
		
		 // $myData->setAxisName(0,"Temperature");
		 $myData->setAbscissa("时间");
 		 $myData->setXAxisDisplay(AXIS_FORMAT_TIME,"H:i");
		 
		 $myData->setPalette("空调0温度",array("R"=>215,"G"=>102,"B"=>24)); //color:#d76618
		 $myData->setPalette("空调1温度",array("R"=>29,"G"=>71,"B"=>111)); //color:#1d476f
		 
		 
		 /* Create a pChart object and associate your dataset */ 
		 $myPicture = new pImage(480,180,$myData);
		
		 /* Choose a nice font */
		 $myPicture->setFontProperties(array("FontName"=>APPPATH."libraries/pChart/Fonts/simsun.ttc","FontSize"=>10));
		
		 /* Define the boundaries of the graph area */
		 $myPicture->setGraphArea(30,40,460,160); 
		
		 /* Draw the scale, keep everything automatic */ 
		 $x_interval = (60/$params['x_interval'])*4-1;
		 $myPicture->drawScale(array("LabelSkip"=>$x_interval,"SkippedTickAlpha"=>0));
		
		 /* Draw the scale, keep everything automatic */ 
		 $myPicture->drawSplineChart();
		 $myPicture->drawText(5,20,$params['title'],array("FontSize"=>12));
		 $myPicture->drawLegend(410,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL,"Family"=>LEGEND_FAMILY_LINE));

 		/* Render the picture (choose the best way) */
 		 $path = str_replace("\\","/",STATICPATH);
		 $imagefile = "site/img/mobile/".$params['imgName'];
		 $myPicture->Render($path.$imagefile); 
		 
		 return $imagefile;
	}	

	function draw_es_humidity($params){
		 $myData = new pData();  
		
		 /* Add data in your dataset */ 
		 $myData->addPoints($params['indoor_hum'],"站内湿度");
		 $myData->addPoints($params['time'],"时间");
		
		 // $myData->setAxisName(0,"Temperature");
		 $myData->setAbscissa("时间");
 		 $myData->setXAxisDisplay(AXIS_FORMAT_TIME,"H:i");
		 
		 $myData->setPalette("站内湿度",array("R"=>215,"G"=>102,"B"=>24)); //color:#d76618
		 
		 /* Create a pChart object and associate your dataset */ 
		 $myPicture = new pImage(480,180,$myData);
		
		 /* Choose a nice font */
		 $myPicture->setFontProperties(array("FontName"=>APPPATH."libraries/pChart/Fonts/simsun.ttc","FontSize"=>10));
		
		 /* Define the boundaries of the graph area */
		 $myPicture->setGraphArea(30,40,460,160); 
		
		 /* Draw the scale, keep everything automatic */ 
		 $x_interval = (60/$params['x_interval'])*4-1;
		 $myPicture->drawScale(array("LabelSkip"=>$x_interval,"SkippedTickAlpha"=>0));
		
		 /* Draw the scale, keep everything automatic */ 
		 $myPicture->drawSplineChart();
		 $myPicture->drawText(5,20,$params['title'],array("FontSize"=>12));
		 $myPicture->drawLegend(415,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL,"Family"=>LEGEND_FAMILY_LINE));

 		/* Render the picture (choose the best way) */
 		 $path = str_replace("\\","/",STATICPATH);
		 $imagefile = "site/img/mobile/".$params['imgName'];
		 $myPicture->Render($path.$imagefile); 
		 
		 return $imagefile;		
	}
	
	function draw_es_box_temprature($params){
		 $myData = new pData();  
		
		 /* Add data in your dataset */ 
		 $myData->addPoints($params['box_tmp'],"恒温柜温度");
		 $myData->addPoints($params['time'],"时间");
		
		 // $myData->setAxisName(0,"Temperature");
		 $myData->setAbscissa("时间");
 		 $myData->setXAxisDisplay(AXIS_FORMAT_TIME,"H:i");
		 
		 $myData->setPalette("恒温柜温度",array("R"=>215,"G"=>102,"B"=>24)); //color:#d76618
		 
		 /* Create a pChart object and associate your dataset */ 
		 $myPicture = new pImage(480,180,$myData);
		
		 /* Choose a nice font */
		 $myPicture->setFontProperties(array("FontName"=>APPPATH."libraries/pChart/Fonts/simsun.ttc","FontSize"=>10));
		
		 /* Define the boundaries of the graph area */
		 $myPicture->setGraphArea(30,40,460,160); 
		
		 /* Draw the scale, keep everything automatic */ 
		 $x_interval = (60/$params['x_interval'])*4-1;
		 $myPicture->drawScale(array("LabelSkip"=>$x_interval,"SkippedTickAlpha"=>0));
		
		 /* Draw the scale, keep everything automatic */ 
		 $myPicture->drawSplineChart();
		 $myPicture->drawText(5,20,$params['title'],array("FontSize"=>12));
		 $myPicture->drawLegend(405,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL,"Family"=>LEGEND_FAMILY_LINE));

 		/* Render the picture (choose the best way) */
 		 $path = str_replace("\\","/",STATICPATH);
		 $imagefile = "site/img/mobile/".$params['imgName'];
		 $myPicture->Render($path.$imagefile); 
		 
		 return $imagefile;
	}	
		
	

}
 