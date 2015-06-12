<div class = "base_center">
    
    <form id ="filter" action="" method="get">
    <div class="filter"> 
        
          
          项目:<?= h_make_select(h_array_2_select($projects),'project_id',$project_id,null,160); ?>
          城市:<?= h_make_select(h_array_2_select($cities),'city_id',$city_id,"全部"); ?>
          建筑:<?= h_station_building_select($building); ?>
          负载:<?= h_station_total_load_select($load_level,null); ?>
          日期:<input class="es_day" name='date' type="text"  style="width:68px; height:16px" value="<?= h_dt_format($datetime,"Y-m-d")?>" />
            （默认为昨日）
          <br>
         </div>
    <div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
    </div>
    </form> 
    
    <?= $pagination?>
    
    <table class="table2">
    <tr>
        <td>城市</td>
        <td>站名</td>
        <td>类型</td>
        <td>标称负载(现在)</td>
        <td>标称负载(当天)</td>
        <td>总能耗(当天)</td>
        <td>换算能耗(当天)</td>  
    </tr>
    <? foreach($daydatas as $daydata){?>
    <tr>
        <td><?= $daydata['city']['name_chn']?></td>
        <td>
            <a href="/backend/station/slist?station_ids=<?= $daydata['station']['id']?>">
                <?= $daydata['station']['name_chn']?>
            </a>
        </td>
        <td><?= h_station_station_type_name_chn($daydata['station']['station_type'])?></td>
        <td><?= $daydata['station']['load_num']?></td>
        <td><?= $daydata['load_num']?></td>
        <td><?= $daydata['main_energy']?></td>
        <td><?= h_round2(h_mid_energy($daydata['main_energy'],$daydata['load_num']))?></td>  
    </tr>
    <?}?>
    </table>

    <?= $pagination?>

</div>



<script>
	
    $(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/analysis/home/energy_sort";
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
