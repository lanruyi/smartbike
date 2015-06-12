<style type="text/css">
.energy_over{color: #FF0000}
.energy_below{color: #0f0}
</style>    
<div class = "base_center">
    
    <form id ="filter" action="" method="get">
    <div class="filter"> 
        
          
          城市:<?= h_make_select(h_array_2_select($cities),'city_id',$city_id,null); ?>
          项目:<?= h_make_select(h_array_2_select($projects),'project_id',$project_id,null); ?>
       
        日期:<input class="es_day" name='date' type="text"  style="width:68px; height:16px" 
                value="<?= h_dt_format($datetime,"Y-m-d")?>" />
       
         </div>
    <!--确定按键-->  
    <div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
    </div>
    </form> 
    
    
    <table class="table2">
    <tr>
        <td></td>
        <td></td>
        <td colSpan='4'>基准站</td>
        <td colSpan='4'>标杆站</td>
        <td></td>
        <td></td>  
    </tr>
    <tr>
        <td>建筑类型</td>
        <td>档位</td>
        <td>基准站名</td>
        <td>标称负载</td>
        <td>实际负载</td>
        <td>日总能耗</td>
        <td>标杆站名</td>
        <td>额定负载</td>
        <td>实际负载</td>
        <td>日总能耗</td>
        <td>节能率</td>
        <td>节能量</td>  
    </tr>
    <? foreach($pairs as $pair){?>
        <tr>
            <td>
                <?= h_station_building_name_chn($pair['std']['building'])?>
            </td>
            <td>
                <?= h_station_total_load_name_chn($pair['std']['total_load'])?>
            </td>
            <td>
                <a href="/backend/energy?station_id=<?= $pair['std']['id']?>&datetime=<?= h_dt_format($datetime)?>">
                    <?= $pair['std']['name_chn']?>
                </a>
            </td>
            <td><?= $pair['std']['load_num']?></td>
            <td><?= h_round2($pair['std_daydata']['true_load_num'])?></td>
            <td style="background-color:#ddd"><?= h_round2($pair['std_daydata']['main_energy'])?></td>

            <td>
                <a href="/backend/energy?station_id=<?= $pair['sav']['id']?>&datetime=<?= h_dt_format($datetime)?>">
                    <?= $pair['sav']['name_chn']?>
                </a>
            </td>
            <td><?= $pair['sav']['load_num']?></td>
            <td><?= h_round2($pair['sav_daydata']['true_load_num'])?></td>
            <td style="background-color:#ddd"><?= h_round2($pair['sav_daydata']['main_energy'])?></td>
            <td><?= h_round2($pair['rate']*100)."%"?></td>
            <td><?= h_round2(h_e_jiangsu_save_energy($pair['sav_daydata']['main_energy'],$pair['rate'])) ?></td>  
        </tr>
    <?}?>
</table>
    
    
    
    
    
    
    
    
    
    
<script>
    $(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/analysis/home/energy_compare";
            document.getElementById('filter').submit();
        });
        $('.es_day').datepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            inline: false,
            timezone: '+8000',
            defaultDate: '+7d', 
            onClose:function(datatimeText,instance){
            }
        });
	});
</script>
