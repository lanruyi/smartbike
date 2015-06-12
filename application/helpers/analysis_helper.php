<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("chart_helper.php");

//基站能耗
function h_draw_energy_column($stations,$color=array("#acb","#d76618")){
				
				$max = 0;
				foreach($stations as $station){
					$max < $station['main_energy']?$max = $station['main_energy']:"";
                }
				$width = 980;
                $margin = 36;
                $height = 90;
                if($max>150){
                    $level = 300;
					$p=10;
                }elseif($max<=150 && $max>100){
                    $level = 200;
					$p=5;
                }elseif($max<=100 && $max>50){
                    $level = 100;
					$p=2;
                }elseif($max<=50){
                    $level = 50;
					$p=1;
                }
                $bg_pic = '/static/site/img/chart_bg/chart_bg_power_'.$p.'.jpg'.hsid();
                $plus = $height/$level;
?>
                        
<style>
.ac_column_chart {margin:0px;padding:0;width:980px;height:<?= $height?>px;background:url('<?= $bg_pic?>') repeat-x;border-bottom:1px solid #999}
.ac_column_chart ul{list-style:none;float:left;margin:0; padding:0;}
.ac_column_chart ul li{list-style:none;float:left;margin:0; padding:0;}
.ac_column_chart ul.y_index{float:left;margin:0;padding:0;height:<?= $height?>px;width:33px;font-size:8px;background-color:#fff;text-align:right}
.ac_column_chart ul.y_index li{list-style:none;float:left;margin:0;padding:0;height:18px;width:25px;font-size:8px;}
</style>

                    <div style="margin:0 0 10px 35px;padding:0;width:945px;height:20px;text-align:right;">
                       
                        <span style="background-color:<?= $color[1]?>;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;dc&nbsp;&nbsp;
                        <span style="background-color:<?= $color[0]?>;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;ac&nbsp;&nbsp;   
                    </div>
                    <div class="ac_column_chart">
                            
                            <ul class="y_index">
                                <li> <?= 1.0*$level?> </li>
                                <li> <?= 0.8*$level?> </li>
                                <li> <?= 0.6*$level?> </li>
                                <li> <?= 0.4*$level?> </li>
                                <li> <?= 0.2*$level?> </li>
                                <li style="background-color:#fff;width:32px">&nbsp;</li>
                            </ul>
                        		
                        <? foreach($stations as $station){?>
                            <div style="float:left;width:52px;">

                                
                                <ul style="float:left;margin:0;padding:0;height:<?= $height?>px;width:3px;font-size:9px;border-left:1px solid #ccc"> &nbsp; </ul>
                            
                            
                                <ul style="float:left;margin:0;padding:0;height:<?= $height?>px;width:45px;font-size:9px;"title="<?=$station['station_name_chn']?>">
                                    <li style="list-style:none;float:left;margin:0;padding:0;height:<?= $height - $station['main_energy']*$plus ?>px;width:45px;"> &nbsp;</li>
				    <li style="margin:0 7px;height:<?= $station['ac_energy']*$plus ?>px;width:30px;background-color:<?= $color[0]?>;"title="ac:<?=$station['ac_energy']?>"> &nbsp; </li>				
                                    <li style="margin:0 7px;height:<?= $station['dc_energy']*$plus ?>px;width:30px;background-color:<?= $color[1]?>;"title="dc:<?=$station['dc_energy']?>"> &nbsp; </li>	
				</ul> 
                                <ul style="float:left;margin:0;padding:0;height:<?= $height?>px;width:3px;font-size:9px;"> &nbsp; </ul>
                            </div>
                        <?}?>  
                    </div>
                    <div style="float:left;width:980px;height:40px;padding:0 0 0 33px">
                    <? foreach($stations as $station){?>
                            <ul style="text-align:center;float:left;margin:0;padding:0;list-style:none;height:40px;width:52px;" title="<?= $station['city_name_chn']?>: <?=$station['station_name_chn']?>">
                                <font style="font-size:9px"><?= $station['city_name_chn']?></font></br>
                                 <?= mb_substr($station['station_name_chn'],0,3)?>..
                            </ul>
                    <?}?>  
                    </div>
                    <div style="clear:both"></div>
<?	
}
