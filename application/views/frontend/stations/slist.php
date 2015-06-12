<script>
$(function(){ $('.f_filter select[value!=0],.f_filter input[value!=""]').css({'background-color':'green','color':'white'}); })
</script>

<div class = "base_center">

<div style="clear:both"> </div>


<form style="margin:0;padding:0" id="filter" method="get" action="">
    <div class='f_filter'>
        <ul>
            <li>
                <?=$this->lang->line('search')?>: <input type="text" name="search" value="<?= $this->input->get('search') ?>" style="width:100px" >
            <input type='hidden' name='duibi' value='<?= $this->input->get('duibi')?>' />
            <input type='hidden' name='time' value='<?= $this->input->get('time')?>' />
            </li>
            <li>
                <?=$this->lang->line('load')?>:<?= h_station_total_load_select($total_load); ?>
            </li>
            <li>
                <?=$this->lang->line('build')?>:<?= h_station_building_select($building); ?>
            </li>
        <? if(ESC_PROJECT_TYPE_NPLUSONE != $this->current_project['type']){?>
            <li>
                <?=$this->lang->line('type')?>:<?= h_project_station_type_select($this->current_project['type'],$this->input->get('station_type')); ?>
            </li>
        <?}?>
            <li>
                <?=$this->lang->line('per page')?>:<input name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" style="width:25px" />
            </li>
            <li>
                <a href="javascript:void(0)" id="confirm_s" class="btn btn-primary"><?=$this->lang->line('confirm')?></a> 
            </li>
            <li>
                <a href="/frontend/stations/slist" class="btn  btn-primary"><?=$this->lang->line('clear')?></a>
            </li>
        </ul>
    </div>
</form>

<?= $pagination ?>

<style>
    .sl_head{margin:0;clear:left;width:100%;background-color:#ddd;} 
    .sl_foot{margin:0;clear:left;width:100%;background-color:#ddd;height:12px;overflow:hidden} 
    .sl_head li{font-weight:bold} 
    /*es_category_city*/
    .es_cc{ float:left;width:100%; line-height:14px;height:30px;}
    .es_cc ul.title {float:left;width:100px;color:white}
    .es_cc ul {overflow:hidden; list-style:none; margin:0;padding:6px 0 6px 8px;}
    .es_cc ul a{color:#333}
    .es_cc ul li{float:left;width:66px;padding:0;margin:0}
    .es_cc ul li.type{ width:58px}
    .es_cc ul li.station{ width:160px;padding:0 0 0 18px;text-align:left}
    .es_cc ul li.loadnum { width:36px}
    .es_cc ul li.total_load { width:58px}
    .es_cc ul li.building { width:56px}
    .es_cc ul li.colds{ width:60px}
    .es_cc ul li.saving_title{ width:155px;text-align:center;background-color:#666;color:#fff}
    .es_cc ul li.saving{ width:45px;text-align:center;overflow:hidden}
    .es_cc ul li.saving_op{ width:10px;text-align:center;overflow:hidden}
    .es_cc ul li.save_num{ width:110px;text-align:right;padding-right:6px;}
</style>

<div class="es_cc sl_head">
   <ul>
        <li class="type"> &nbsp;</li>
        <li class="station"> &nbsp; </li>
        <li class="loadnum"> <?=$this->lang->line('load')?> </li>
        <li class="total_load"> <?=$this->lang->line('level')?> </li>
        <li class="building"> <?=$this->lang->line('building')?> </li>
        <li class="colds"> &nbsp; </li>
        <li class="saving_title"> <?=$this->lang->line('Energy saving yesterday')?> </li>
        <li>  </li>
   </ul>
</div>
<?php foreach ($stations as $key=>$station): ?>
            <div class=es_cc>
               <ul style="background-color:<?= $key%2==0?"#fff":"#eee"?>">
                    <li class=type>
                      <?= h_station_station_type_name_chn_slist($station['station_type']) ?>&nbsp;
                    </li>
                    <li class="station" style="background:url(<?= h_online_gif_new($station['alive'])?>) 0px 0px no-repeat;">

                      <a href="/frontend/single/day/<?= $station['id']?>" style="font-weight:<?= ($station['id']==$this->input->cookie('last_station_id'))?"bold":"none" ?>">
                        <?= $station['name_chn']?></a> <?= h_station_force_on_color_name($station['force_on']) ?> 
                    </li>
                    <li class=loadnum> <?= $station['load_num'] ?>&nbsp; </li>

                    <li class=total_load> <?= h_station_total_load_name_chn($station['total_load']) ?>&nbsp; </li>
                    <li class=building> <?= h_station_building_name_chn($station['building']) ?>&nbsp; </li>
                    <li class=colds> <?= h_station_colds_num_name_chn($station['colds_num']) ?> </li>
            <? if ($saving_daydata_array[$station['id']]['err']){?>
                    <li style="color:#999;width:400px;"> <?= $saving_daydata_array[$station['id']]['err']?> </li>
            <?}elseif($station['station_type'] == ESC_STATION_TYPE_NPLUSONE){?>
                    <li class=saving> 
                        <?= $saving_daydata_array[$station['id']]['std_ac_energy'] ?>
                    </li>
                    <li class=saving_op> - </li> 
                    <li class=saving> 
                        <?= $saving_daydata_array[$station['id']]['ac_energy'] ?>
                    </li>
                    <li class=saving_op> = </li> 
                    <li class=saving> 
                        <?= $saving_daydata_array[$station['id']]['saving'] ?>
                    </li>
                    <li style="margin:0 0 0 15px;">
                    </li>
            <?}else{?>
                    
                    <li>AC节能：</li>
                    <li style="width:70px">
                        <?= $saving_daydata_array[$station['id']]['saving_p'] ?>%
                    </li>
                    <li style="width:70px">
                        <?= $saving_daydata_array[$station['id']]['saving'] ?>度
                    </li>
            <?}?>

               </ul>
            </div>
<?php endforeach?>
<div class=" sl_foot">
</div>

<?= $pagination ?>

</div>


<script>
    $(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/frontend/stations/slist";
            document.getElementById('filter').submit();
        });
    });
</script>
