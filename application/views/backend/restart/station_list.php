<script>
$(function(){ })
    $(document).ready(function(){
        $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'}); 
    });
</script>

<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px ;}
</style>

<div class=base_center>

<div style="margin:0;width:100%">
<font>后台 >> 基站重启统计</font>
</div>

<form id="filter" method="get" action="">
<div class='operate'>
    <a href="/backend/restart/station_list?type=day&time=<?= h_dt_date_str("")?>" class="btn btn-primary">今日重启</a>
    <a href="/backend/restart/station_list?type=day&time=<?= h_dt_date_str("-1 day")?>" class="btn btn-primary">昨日重启</a>
</div>
</form>

    <? if(isset($station) && $station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>


    <?= $pagination?>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th>#</th>
                <th>基站</th>
                <th>重启次数</th>
                <th>详细</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($stations as $station): ?>
            <tr>
                <td><?= $station['id']?></td>
                <td><?= $station['name_chn']?></td>
                <td><?= $station_array[$station['id']]?></td>
                <td><a href="/backend/restart?station_id=<?= $station['id']?>&restart_start_time=<?= $start_time?>&restart_stop_time=<?= $stop_time?>">详细</a></td>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
    <?= $pagination?>

</div>

