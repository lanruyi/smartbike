<style>
    .city_title{width:100%;margin:0;float:left;height:25px;line-height:25px;text-align:center}
    .city_title font.city_name{margin-left:10px;font-size:16px;font-weight:bold}

    .city_body{ float:left;background-color:#fff; width:100%;  }
    .stations_block{ float:left;width:16.1%;margin:0;margin-left:0.5%;margin-bottom:5px;padding:0;background-color:#eee; height:175px; }
    .stations_block ul{ float:left;list-style:none;width:100%;margin:0}
    .stations_block ul li{ float:left;list-style:none;width:100%; width:98%;margin:2px 0 0 1%}
    .stations_block ul li.stations_block_title{ background-color:#666; color:white; text-align:center}
    .stations_block ul li.stations_block_standard{ background-color:#888; color:white;}
    .stations_block ul li.stations_block_saving{ background-color:#aaa; color:white;}
    .stations_block ul li a{color:#000;}
</style>


<div style="float:left;width:98%;margin:0;margin-left:1%;padding-top:5px;"> 
<div class='es_sub2_menu' style="border-bottom:4px solid #ccc">  
    <ul>
        <!--<li class="<?= $this->input->get('city_id')?"":"active" ?>"> 
        <a  href="/frontend/stations/category"> 全部 </a> </li>
        <li class="divider-vertical"></li>-->
    <? foreach($cities as $city){?>
        <li class="<?= $city_id == $city->getId()?"active":"" ?>"> 
        <a  href="/frontend/stations/category_city/<?=  $city->getId() ?>"> <?= $city->getNameChn()?> </a> </li>
        <li class="divider-vertical"></li>
    <? }?>
        <li style="float:right"> 
            图例: <font style="background-color:#888;color:#fff">[基准]-基准站</font> 
                  <font style="background-color:#aaa;color:#fff">[标杆]-标杆节能站</font> 
                  <font>[普通]-普通节能站</font>
                  <font style="font-weight:bold;color:#900">[安装中]-正在安装</font> </li>
    </ul>
</div>
</div>



<style>
/*es_category_city*/
.es_cc{ float:left;width:25%;}
.es_cc_title{ float:left;width:98%;margin:0 1%;margin-top:10px;padding:1px;border-bottom:3px solid #f93;}
.es_cc_title font.cate{ font-weight:bold;font-size:14px;color:#666}
.es_cc_body{ float:left;width:98%;margin:0 1%;border:1px solid #999;border-top:0 }
.es_cc_body ul { float:left; width:99%;list-style:none; margin-left:0.5%}
.es_cc_body ul li{ float:left;width:95%;list-style:none; margin:0 0 5px 5px}
.es_cc_body ul li a{color:#333}
.es_cc_body ul.big{margin-bottom:2px;margin-top:5px;}
.es_cc_body ul.big li{ width:95%;font-size:13px;}
</style>


<div style="float:left;width:98%;margin:0;margin-left:1%;padding-top:5px;"> 
<? foreach($station_array as $total_load => $builds){?>
    <? foreach($builds as $build => $stations){?>
        <div class='es_cc'>
            <div class='es_cc_title' style="border-bottom:4px solid <?= ($build == ESC_BUILDING_ZHUAN)?"darkorange":"darkblue" ?>;">
                <font class=cate><?= h_station_total_load_name_chn($total_load)." - ".h_station_building_name_chn($build)?></font>
            </div>
            <div class='es_cc_body' id=es_cc_body_<?= $total_load."_".$build?>>
                <ul class="big">
                 <? if(!count($stations['standard'])) {?> <li> 
                      <font style="color:#999">无基准站</font> <?}?>
                 <? foreach($stations['standard'] as $station){ ?>
                   <li>
                      <?= in_page_station_item($station) ?> 
                   </li>
                 <?}?>
                 <? if(!count($stations['saving'])) {?> <li>
                     <font style="color:#999">无节能标杆站</font> <?}?>
                 <? foreach($stations['saving'] as $station){ ?>
                   <li>
                      <?= in_page_station_item($station) ?> 
                   </li>
                 <?}?>
                </ul>
                <ul style="float:left;width:99%;margin:0;margin-left:0.5%;height:4px;overflow:hidden;border-top:1px solid #aaa"> </ul>
                <ul>
                 <? foreach($stations['common'] as $station){ ?>
                   <li>
                      <?= in_page_station_item($station) ?> 
                   </li>
                 <?}?>
                </ul>
            </div>
        </div>
    <? }?>
<? }?>
</div>

<? function in_page_station_item($station){ ?>

      <?= h_online_mark($station->isOnline(),12,6)?> 
      <?= h_station_type_mark_category($station->getStationType())?>
      <a href="/frontend/single/realtime/<?= $station->getId()?>" style="">
        <?= $station->getNameChnShort(12)?> <?=  ESC_STATION_UNDER_CONSTRUCT_NEW == $station->getUnderConstruct()? '<font color=#f00>[在装]</font>':'' ?></a> 
<?}?>

<?
function h_station_type_mark_category($type){
    $mark = array();
    $mark[ESC_STATION_TYPE_COMMON] = "[普]";
    $mark[ESC_STATION_TYPE_SIXPULSONE] = "[6+1]";
    $mark[ESC_STATION_TYPE_STANDARD] = "[标准]";
    $mark[ESC_STATION_TYPE_SAVING] = "[标杆]";
    return $mark[$type];
}
?>

<script>
    $(document).ready(function(){
        function max4(a,b,c,d){
            var m = a>b?a:b;
            var m = m>c?m:c;
            var m = m>d?m:d;
            return m;
        }
        function initLayout() {  
            var right; 
            var left;
            var h;
            <? foreach($station_array as $total_load => $builds){?>
                <? if($total_load%2==0){continue;} ?>
                a1 = $('#es_cc_body_<?= $total_load."_".ESC_BUILDING_BAN?>');
                a2 = $('#es_cc_body_<?= $total_load."_".ESC_BUILDING_ZHUAN?>');
                a3 = $('#es_cc_body_<?= ($total_load+1)."_".ESC_BUILDING_BAN?>');
                a4 = $('#es_cc_body_<?= ($total_load+1)."_".ESC_BUILDING_ZHUAN?>');
                a1.css('height','auto');
                a2.css('height','auto');
                a3.css('height','auto');
                a4.css('height','auto');
                h =  max4(a1.height(),a2.height(),a3.height(),a4.height());
                a1.height(h);
                a2.height(h);
                a3.height(h);
                a4.height(h);
            <? }?>
        };  
        initLayout();  
        $(window).resize(function(){  
            initLayout();  
        });  
    });  
</script>

