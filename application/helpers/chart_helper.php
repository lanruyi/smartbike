<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main_helper.php");






//$items 是名字和所占数量 不一定要满100;
function h_draw_line_pie($items,$param){
    $color_num = isset($param['color'])?    $param['color']    :1;
    $width     = isset($param['width'])?    $param['width']    :600;
    $height    = isset($param['height'])?   $param['height']   :20;
    $has_text  = isset($param['has_text'])? $param['has_text'] :true;

    //$color_array[0] = array("#0a82a4","#51f7d3","#E0c246","#ffef79","#ff7345","#a10053","#deef5b","#256b4f");
    $color_array[0] = array("#9bb","#779","#b9b","#131");
    $color_array[1] = array("#8b8","#696","#474","#58b","#369","#157","#e00");
    $color_array[2] = array("#474","#58b","#157","#e00");
    $total = 0;
    foreach($items as $item){
        $total += $item[0];
    }
    if($total == 0) return "";

    if($has_text){
        foreach($items as $key => $item){
            echo "<div style='float:left;width:10px;height:10px;
                    background-color:".$color_array[$color_num][$key].";
                    margin:4px 2px 0 2px;
                    overflow:hidden;font-size:8px;'> </div>";
            echo "&nbsp;&nbsp;";
            echo "<div style='float:left;width:85px'>";
            echo $item[1].":<font style='font-size:16px;font-weight:bold'>".$item[0]."</font>";
            echo "</div>";
        }
    }
    $res = "<div class='line_pie' style='float:left;width:".$width."px;height:".$height."px;margin-top:3px'><ul>";
    foreach($items as $key => $item){
        $percent = round($item[0]*100/$total,3);
        $res.="<li style='width:".$percent."%;background-color:".$color_array[$color_num][$key].";height:".$height."px'></li>";
    }
    $res.="</ul></div>";
    $res.="<div style='clear:both'></div>";
    return $res;
}


function h_draw_chart_day_ac_saving_2($saving){
    $num_std = $saving['std'] * 10;
    $num_saving = $saving['saving'] * 10;
?>

                    <div style="margin:0 0 10px 35px;padding:0;width:960px;height:20px">
                        <span style="background-color:#1d476f;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;本站:<?= $saving['self']?>度&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="background-color:#66dd88;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;节能:<?= $saving['saving']<0?0:$saving['saving']?>度&nbsp;&nbsp;&nbsp;&nbsp;
                        ( 基准:<?= $saving['std']?>度&nbsp;&nbsp;&nbsp;&nbsp;
                        节能率:<?= $saving['saving']<0?0:$saving['saving_p']?>% &nbsp;&nbsp;&nbsp;&nbsp;每格代表0.1度)
                    </div>
<style>
.chart_day_ac_saving_2{margin:0 0 0 32px;padding:0;background-color:#fff;width:948px;}
.chart_day_ac_saving_2 ul{list-style:none;padding0;width:10px;margin:0 0px 3px 0;height:8px;background-color:#ccc;float:left;}
</style>
                    <div class="chart_day_ac_saving_2">
                        <? for($i=0;$i<$num_std;$i++){ ?>
                            <ul style="background-color:<?= $i<$num_saving?"#66dd88":"#1d476f"?>;<?= $i%10==9?"margin-right:5px":""?>"></ul>
                        <?}?>
                    </div>
                    <div style="clear:both;height:1px;overflow:hidden">

<?
}


function h_draw_chart_day_ac_saving_0($saving){
?>

                    <div style="margin:0 0 10px 35px;padding:0;width:960px;height:20px">
                    </div>

<?
}

function h_draw_chart_day_ac_saving($saving){
?>

                    <div style="margin:0 0 10px 35px;padding:0;width:960px;height:20px">
                        <span style="background-color:#d76618;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;基准:<?= $saving['std']?>度&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="background-color:#1d476f;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;本站:<?= $saving['self']?>度&nbsp;&nbsp;&nbsp;&nbsp;
                        <span style="background-color:#66dd88;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;节能:<?= $saving['saving']<0?0:$saving['saving']?>度&nbsp;&nbsp;&nbsp;&nbsp;
                        节能率:<?= $saving['saving']<0?0:$saving['saving_p']?>%;
                    </div>
                    <div style="margin:0 0 0 35px;padding:0;background-color:#ddd;width:945px;height:30px">
                        <div style="margin:0;padding:0;background-color:#d76618;width:<?= $saving['std']*9 ?>px;height:10px"></div> 
                        <div style="margin:0;padding:0;background-color:#1d476f;width:<?= $saving['self']*9 ?>px;height:10px"></div> 
                        <div style="margin:0;padding:0;background-color:#66dd88;width:<?= $saving['saving']<0?0:$saving['saving']*9 ?>px;height:10px"></div> 
                    </div>
                    <div style="margin:0 0 0 35px;padding:0;width:900px;height:20px;overflow:hidden">
                        <? for($i=0;$i<11;$i++){?>
                        <ul style="float:left;margin:0;padding:0;width:90px;font-size:9px;"> <?= $i*10?>度 </ul>
                        <?}?>
                    </div>

<?
}

function chart_max_value($array_a,$array_b){
    $max = 0;
    $t = array_merge($array_a?$array_a:array(),$array_b?$array_b:array());
    foreach($t as $item){
        if($item>$max){
            $max = $item;
        }
    }
    return $max;
}






function h_draw_chart_ac_column($energy_dc,$energy_main = null){
                $is_std = ($energy_main == null);
                $max = chart_max_value($energy_dc,$energy_main);
                $width = 980;
                $margin = 36;
                $height = 90;
                
                if ($max > 15 && $max <= 20) {
                    $level = 20;
                }elseif($max > 10 && $max <= 15) {
                    $level = 15;
                }elseif($max>5 && $max <= 10){
                    $level = 10;
                }elseif($max<=5 && $max>2){
                    $level = 5;
                }elseif($max<=2 && $max>1){
                    $level = 2;
                }elseif($max<=1){
                    $level = 1;
                }
                $bg_pic = '/static/site/img/chart_bg/chart_bg_power_'.$level.'.jpg'.hsid(); //网格纵坐标
                $plus = 90/$level;
?>
                        
<style>
.ac_column_chart {margin:0px;padding:0;width:980px;height:<?= $height?>px;background:url('<?= $bg_pic?>');border-bottom:1px solid #999}
.ac_column_chart li,ul{list-style:none;float:left;margin:0;padding:0;display:block}
.ac_column_chart ul.y_index{float:left;margin:0;padding:0;height:<?= $height?>px;width:33px;font-size:8px;background-color:#fff;text-align:right}
.ac_column_chart ul.y_index li{list-style:none;float:left;margin:0;padding:0;height:18px;width:25px;font-size:8px;}



</style>

                    <div style="margin:0 0 10px 35px;padding:0;width:945px;height:20px;text-align:right">
                        <? if (!$is_std){?>
                        <span style="background-color:#d76618;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;总能耗&nbsp;&nbsp;
                        <? }?>
                        <span style="background-color:#1d476f;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;DC能耗&nbsp;&nbsp;
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
                        <? for ($i = 0;$i<24;$i++){?>
                            <ul style="height:<?= $height?>px;width:3px;font-size:9px;"> &nbsp; </ul>
                            <ul style="height:<?= $height?>px;width:3px;font-size:9px;border-left:1px solid #ccc"> &nbsp; </ul>
                            <? if ($is_std){?>
                            <ul style="height:<?= $height?>px;width:13px;font-size:9px;"> &nbsp; </ul>
                            <?}else{?>
                            <ul style="height:<?= $height?>px;width:13px;font-size:9px;">
                                <li style="height:<?= $height - $energy_main[$i]*$plus ?>px;width:13px;"> &nbsp; </li>
                                <li style="background-color:#d76618;">
                                    <a href="javascript:void(0);" 
                                    style="display: block;height:<?= $energy_main[$i]*$plus ?>px;width:13px;" 
                                    title="<?= round($energy_main[$i],2) ?>度"> </a>
                                </li>
                            </ul>
                            <?}?>
                            <ul style="height:<?= $height?>px;width:2px;font-size:9px;"> &nbsp; </ul>
                            <ul style="height:<?= $height?>px;width:13px;font-size:9px;">
                                <li style="height:<?= $height - $energy_dc[$i]*$plus ?>px;width:13px;"> &nbsp; </li>
                                <li style="background-color:#1d476f;">
                                    <a href="javascript:void(0);" 
                                    style="display: block;height:<?= $energy_dc[$i]*$plus ?>px;width:13px;" 
                                    title="<?= round($energy_dc[$i],2) ?>度"> </a>
                                </li>
                            </ul>
                            <ul style="height:<?= $height?>px;width:4px;font-size:9px;"> &nbsp; </ul>
                        <?}?>
                    </div>
                    <div style="width:990px;height:20px;overflow:hidden">
                        <ul style="width:38px;">&nbsp; </ul>
                        <? for ($i = 0;$i<24;$i++){?>
                        <ul style="width:39px;font-size:9px;"> <?= $i?>点 </ul>
                        <?}?>
                    </div>
<?

}











function h_draw_chart_switchon($fan_ons,$colds_0_ons,$colds_1_ons = null){
                $width = 980;
                $margin = 36;
                $height = 91;
                $chart_width = $width-$margin;
                $hour_width=round($chart_width/24,1);
?>
<style>
.switchon_chart div.name_margin{float:left; margin:0px;padding:0;width:<?= $margin?>px;height:19px;text-align:center;font-size:8px}
.switchon_chart div.white_line{float:left; margin:0px;padding:0;width:<?= $chart_width?>px;height:4px;background-color:#fff}
.switchon_chart div.line{float:left; margin:0px;padding:0;width:<?= $chart_width?>px;height:16px;}
.switchon_chart div.white_line ul{float:left;margin:0;padding:0;width:<?= $hour_width-1?>px;height:4px;border-left:1px solid #999}

</style>


                    <div style="margin:0 0 10px 35px;padding:0;width:945px;height:20px;text-align:right">
                        <span style="background-color:#49d900;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;新风开&nbsp;&nbsp;
                        <span style="background-color:#ddeecc;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;新风关&nbsp;&nbsp;
                        <span style="background-color:#426ab3;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;空调开&nbsp;&nbsp;
                        <span style="background-color:#ccddee;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;空调关&nbsp;&nbsp;
                    </div>

<div class=switchon_chart>
                    <div class=name_margin>  </div>
                    <div class=line>
                    <? foreach ($fan_ons as $key => $fan_on){
                        if($key){
                            if($fan_on_temp_len < $fan_on[0]){
                               $this_width =  round(($fan_on[0] - $fan_on_temp_len)*$chart_width/86400,1);
                               $color = ($fan_on[1] == 1) ? "#49d900":"#eee";
                               ?>
                                   <ul style="float:left;margin:0;padding:0;height:20px;width:<?= $this_width?>px;font-size:8px;background-color:<?= $color?>;overflow:hidden">&nbsp;</ul>
                               <?
                            }
                        }
                        
                        $fan_on_temp_len = $fan_on[0];
                        $fan_on_temp_value = $fan_on[1];
                    }?>
                    </div>
                    <div class=white_line> 
                        <? for ($i = 0;$i<24;$i++){?>
                        <ul></ul>
                        <?}?>
                    </div>
                    <div class=name_margin>  </div>
                    <div class=line> 
                    <? foreach ($colds_0_ons as $key => $colds_0_on){
                        if($key){
                            if($colds_0_on_temp_len < $colds_0_on[0]){
                               $this_width =  round(($colds_0_on[0] - $colds_0_on_temp_len)*$chart_width/86400,1);
                               $color = ($colds_0_on[1] == 1) ? "#426ab3":"#eee";
                               ?>
                                   <ul style="float:left;margin:0;padding:0;height:20px;width:<?= $this_width?>px;font-size:8px;background-color:<?= $color?>;overflow:hidden">&nbsp;</ul>
                               <?
                            }
                        }
                        
                        $colds_0_on_temp_len = $colds_0_on[0];
                        $colds_0_on_temp_value = $colds_0_on[1];
                    }?>
                    </div>
                    <div class=white_line> 
                        <? for ($i = 0;$i<24;$i++){?>
                        <ul></ul>
                        <?}?>
                    </div>
                    <div class=name_margin>  </div>
                    <div class=line> 
                    <? foreach ($colds_1_ons as $key => $colds_1_on){
                        if($key){
                            if($colds_1_on_temp_len < $colds_1_on[0]){
                               $this_width =  round(($colds_1_on[0] - $colds_1_on_temp_len)*$chart_width/86400,1);
                               $color = ($colds_1_on[1] == 1) ? "#426ab3":"#eee";
                               ?>
                                   <ul style="float:left;margin:0;padding:0;height:16px;width:<?= $this_width?>px;font-size:8px;background-color:<?= $color?>;overflow:hidden">&nbsp;</ul>
                               <?
                            }
                        }
                        
                        $colds_1_on_temp_len = $colds_1_on[0];
                        $colds_1_on_temp_value = $colds_1_on[1];
                    }?>
                    </div>
                    <div class=white_line> 
                        <? for ($i = 0;$i<24;$i++){?>
                        <ul></ul>
                        <?}?>
                    </div>
                    <div style="float:left;margin:0px;padding:0;width:990px;height:20px;overflow:hidden">
                        <ul style="float:left;margin:0;padding:0;width:36px;">&nbsp; </ul>
                        <? for ($i = 0;$i<24;$i++){?>
                        <ul style="float:left;margin:0;padding:0;width:<?= $hour_width?>px;font-size:9px;"> <?= $i?>点 </ul>
                        <?}?>
                    </div>
</div>
<?
}

//每月bug统计图
function h_draw_bug_month_column($bug_day_counts,$days){
                $max = chart_max_single_value($bug_day_counts);
                $width = 980;
                $margin = 36;
                $height = 90;
                if($max>2000){
                    $level = 5000;
                }elseif($max>1000 && $max<=2000){
                    $level = 2000;
                }elseif($max>500 && $max <=1000){
                    $level = 1000;
                }elseif($max<=500 && $max>200){
                    $level = 500;
                }elseif($max<=200 && $max>100){
                    $level = 200;
                }elseif($max<=100){
                    $level = 100;
                }
                $bg_pic = '/static/site/img/chart_bg/chart_bg_power_2.jpg'.hsid();
                $plus = 90/$level;

?>
                        
<style>
.ac_column_chart {margin:0px;padding:0;width:980px;height:<?= $height?>px;background:url('<?= $bg_pic?>');border-bottom:1px solid #999}
.ac_column_chart ul.y_index{float:left;margin:0;padding:0;height:<?= $height?>px;width:33px;font-size:8px;background-color:#fff;text-align:right}
.ac_column_chart ul.y_index li{list-style:none;float:left;margin:0;padding:0;height:18px;width:25px;font-size:8px;}



</style>

                    <div style="margin:0 0 10px 35px;padding:0;width:945px;height:20px;text-align:right">
                        <span style="background-color:#d76618;height:10px;overflow:hidden">&nbsp;&nbsp;</span>&nbsp;&nbsp;故障数量&nbsp;&nbsp;
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
                        <?  $m=count($bug_day_counts); 
                            for ($i = 1;$i<=$days;$i++){?>
                            <ul style="float:left;margin:0;padding:0;height:<?= $height?>px;width:3px;font-size:9px;"> &nbsp; </ul>
                            <ul style="float:left;margin:0;padding:0;height:<?= $height?>px;width:3px;font-size:9px;border-left:1px solid #ccc"> &nbsp; </ul>
                            <? if ($i<=$m){?>
                                <ul style="float:left;margin:0;padding:0;height:<?= $height?>px;width:13px;font-size:9px;">
                                    <li style="list-style:none;float:left;margin:0;padding:0;height:<?= $height - $bug_day_counts[$i][1]*$plus ?>px;width:13px;"> &nbsp; </li>
                                    <li style="list-style:none;float:left;margin:0;padding:0;height:<?= $bug_day_counts[$i][1]*$plus ?>px;width:13px;background-color:#d76618"> &nbsp; </li>
                                </ul>
                            <? }else{ ?>
                                <ul style="float:left;margin:0;padding:0;height:<?= $height?>px;width:13px;font-size:9px;">
                                    <li style="list-style:none;float:left;margin:0;padding:0;height:<?= $height ?>px;width:13px;"> &nbsp; </li>
                                </ul>
                            <? } ?>
                            <ul style="float:left;margin:0;padding:0;height:<?= $height?>px;width:4px;font-size:9px;"> &nbsp; </ul>
                        <?}?>
                    </div>
                    <div style="margin:0px;padding:0;width:990px;height:20px;overflow:hidden">
                        <ul style="float:left;margin:0;padding:0;width:45px;">&nbsp; </ul>
                        <? for ($i = 1;$i<=$days;$i++){?>
                            <ul style="float:left;margin:0;padding:0;width:24px;font-size:9px;"> <?= $i?> </ul>
                        <?}?>
                    </div>
<?
}

function chart_max_single_value($array_a){
    $max = 0;
    foreach($array_a as $item){
        if($item[1]>$max){
            $max = $item[1];
        }
    }
    return $max;
}

