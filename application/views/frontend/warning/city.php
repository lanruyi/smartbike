<script>
$(function(){ $('.f_filter select[value!=0],.f_filter input[value!=""]').css({'background-color':'green','color':'white'}); })
</script>

<div class = "base_center">

<div style="clear:both;height:1px;overflow:hidden"> </div>
<div style="margin:10px 0 8px 0 ;height:44px;background-color:#eee;border:1px solid #ddd;padding:0 8px;">
    <div style="float:left;height:44px;line-height:44px;color:#666;font-size:12px;padding:0 10px;">
        <?= $this->current_city['name_chn']?>&nbsp;&nbsp;
        <font style="font-size:18px;font-weight:bold">
            <?= $warning_nums_of_city['p'][ESC_WARNING_PRIORITY__HIGH]?>
        </font>
        &nbsp;高级报警&nbsp;&nbsp;  
        <font style="font-size:18px;font-weight:bold">
            <?= $warning_nums_of_city['p'][ESC_WARNING_PRIORITY__MIDDLE]?>
        </font>
        &nbsp;中级报警&nbsp;&nbsp;
        <font style="font-size:18px;font-weight:bold">
            <?= $warning_nums_of_city['p'][ESC_WARNING_PRIORITY__LOW]?>
        </font>
        &nbsp;低级报警&nbsp;&nbsp;
    </div>
</div>
<div style="clear:both;height:1px;overflow:hidden"> </div>
<div style="margin:0px 0 18px 0;background-color:#eee;border:1px solid #ddd;padding:0;overflow:auto;">
        <? foreach ( h_warning_type_array() as $key=>$name ) {?>
            <? if(!isset($warning_nums_of_city['w'][$key]) || $warning_nums_of_city['w'][$key] == 0 ) continue;?>
            <li style="float:left;width:30px;display:block;text-align:right;
                        font-weight:bold;font-size:15px;padding:5px;">
                <a href='/frontend/warning/index?type=<?= $key?>'>
                    <?= $warning_nums_of_city['w'][$key]?>
                </a>
            </li> 
            <li style="float:left;width:116px;display:block;text-align:left;padding:5px">
                <a href='/frontend/warning/index?type=<?= $key?>'><?= $name?></a>
            </li>
        <? }?>
</div>



<?= $pagination ?>

<style>
    .sl_head{margin:0;clear:left;width:100%;background-color:#ddd;border:1px solid #ccc;border-bottom:0;line-height:14px;height:24px;} 
    .sl_head li{font-weight:bold} 

    .es_cc{ float:left;width:100%; border-left:1px solid #ccc;border-right:1px solid #ccc;}
    .es_cc ul {overflow:hidden; list-style:none; margin:0;padding:0 0 0 10px;line-height:25px;height:25px;}
    .es_cc ul  a{color:#333}
    .es_cc ul li{ float:left;width:66px;}
    .es_cc ul li.type{ width:80px;}
    .es_cc ul li.warning {  width:130px;height:28px; padding:0 0 0 25px;text-align:left}
    .es_cc ul li.station { width:200px}
    .es_cc ul li.last_time { width:120px}
</style>

            <div class="es_cc sl_head">
               <ul>
                    <li class="warning"> &nbsp; </li>
                    <li class="station"> &nbsp; </li>
                    <li class="last_time"> &nbsp; </li>
                    <li>  </li>
                    <li>  </li>
               </ul>
            </div>
<?php foreach ($warnings as $key=>$warning): ?>
            <div class=es_cc>
               <ul style="background-color:<?= $key%2==0?"#fff":"#eee"?>">
                    <li class=warning style="background:url(<?= h_warning_priority_png($warning['priority']) ?>) 0px 5px no-repeat;">
                      <?= h_warning_type_name_chn($warning['type']) ?>
                    </li>
                    <li class=station>
                      <a href="/frontend/single/day/<?= $warning['station_id']?>"><?= $warning['station_id'] ?></a>
                    </li>
                    <li class='last_time'>
                      <?= h_last_time($warning['start_time']) ?>
                    </li>
               </ul>
            </div>
<?php endforeach?>
    <div style="margin:0;clear:left;width:100%;background-color:#ddd;
            border:1px solid #ccc;border-bottom:0;height:2px;"></div>

<?= $pagination ?>

</div>


<script>
</script>
