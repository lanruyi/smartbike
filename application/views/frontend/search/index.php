<div class = "base_center">

<div style="clear:both"> </div>



<style>
    .sl_head{margin:0;clear:left;width:100%;background-color:#ddd;} 
    .sl_foot{margin:0;clear:left;width:100%;background-color:#ddd;height:12px;overflow:hidden} 
    .sl_head li{font-weight:bold} 
    .es_cc{ float:left;width:100%; line-height:14px;height:30px;}
    .es_cc ul.title {float:left;width:100px;color:white}
    .es_cc ul {overflow:hidden; list-style:none; margin:0;padding:6px 0 6px 8px;}
    .es_cc ul a{color:#333}
    .es_cc ul li{float:left;width:66px;padding:0;margin:0}
    .es_cc ul li.type{ width:58px}
    .es_cc ul li.station{ width:200px;padding:0 0 0 18px;text-align:left}
    .es_cc ul li.loadnum { width:80px}
    .es_cc ul li.building { width:56px}
    .es_cc ul li.colds{ width:60px}
</style>

<div style="clear:both;margin:30px 15px;font-size:15px;">
<? if(!$stations){?>
    没有找到 <b><?= $search?> </b> 相关的站点！
<?}else{?>
    找到 <?= count($stations)?> 个 和 <b><?= $search?> </b> 相关的站点！
<?}?>
</div>

<? foreach ($stations as $key=>$station): ?>
            <div class=es_cc>
               <ul style="background-color:<?= $key%2==0?"#fff":"#eee"?>">
                    <li class="city">
                      <?= $cities[$station['city_id']]['name_chn'] ?>&nbsp;
                    </li>
                    <li class="type">
                      <?= h_station_station_type_name_chn_slist($station['station_type']) ?>&nbsp;
                    </li>
                    <li class=building> 
                        <?= h_station_building_name_chn($station['building']) ?>&nbsp; 
                    </li>
                    <li class="station" 
                        style="background:url(<?= h_online_gif_new($station['alive'])?>) 0px 0px no-repeat;">
                        <a href="/frontend/single/day/<?= $station['id']?>">
                            <?= h_highlight_search_word($search,$station['name_chn'])?>
                        </a>  
                    </li>
                    <li class=loadnum> 
                        负载<?= $station['load_num'] ?>A 
                    </li>

               </ul>
            </div>
<?php endforeach?>


</div>

