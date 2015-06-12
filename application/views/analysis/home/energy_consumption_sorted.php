<style type="text/css">
.energy_over{color: #FF0000}
.energy_below{color: #0f0}
</style>    
<div class = "base_center">
    
    <form id ="filter" action="" method="get">
    <div class="filter"> 
        
          
          城市:<?= h_station_relative_select_sql('city_id',$cities,$city_id,null); ?>
          项目:<?= h_station_relative_select_sql('project_id',$projects,$project_id,null); ?>
       
        日期:
          <input class="es_day" name='date' type="text"  style="width:68px; height:16px" value="<?= $date?>" />
       
         <input type="radio" name="algorithm" value="rate" <?= ($algorithm==="rate")? "checked":" "?>>按节能算法A排序
        
        <input type="radio" name="algorithm" value="rate1" <?= ($algorithm==="rate1")? "checked":" "?>>按节能算法B排序
         </div>
    <!--确定按键-->  
    <div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
    </div>
    </form> 
    
    
    <table class="table">
    <tr>
        <td>标杆站名</td>
        <td>建筑</td>
        <td>额定负载</td>
        <td>实际负载</td>
        <td>基准站名 </td>
        <td>额定负载</td>
        <td>实际负载</td>
        <td>A节能率</td>
        <td>A节能量</td>  
        <td>B节能率</td>
        <td>B节能量</td>
    </tr>
    <? foreach ($stations as $station){?>
    <tr>
        <td><a href="/backend/station/slist?station_ids=<?= $station["id"]?>"><?= $station["name_chn"]?></a>
        </td>
        <td><?= h_station_building_name_chn($station["building"]) ?>
        </td>    
        <td><?= $station["load_num"]?>
        </td>    
        <td><?= $dc_energy_array[$station["id"]]?>
        </td>  
        
        <td><a href="/backend/station/slist?station_ids=<?= $standard_station_array[$station["id"]]["id"]?>"><?= $standard_station_array[$station["id"]]["name_chn"]?></a>
        </td>
        
           
        <td><?= $standard_station_array[$station["id"]]["load_num"]?>
        </td> 
        
        </td>    
        <td><?= $std_dc_energy_array[$station["id"]]?>
        </td>  
         <? if (!$saving_daydata_array[$station["id"]]['err']){?>
        <td>
            <?= $saving_daydata_array[$station["id"]]['contract_energy_saving_rate']*100 ?> <?= "%"?>
           
        </td>
        <td>
             <?= round($saving_daydata_array[$station["id"]]['contract_energy_saving_rate']*$saving_daydata_array[$station["id"]]['main_energy']/(1-$saving_daydata_array[$station["id"]]['contract_energy_saving_rate']),2) ?>度
        </td>    
        <td>
            <?= $saving_daydata_array[$station["id"]]['contract_energy_saving_rate1']*100 ?><?= "%"?>
        </td>
        <td>
           <?= round($saving_daydata_array[$station["id"]]['contract_energy_saving_rate1']*$saving_daydata_array[$station["id"]]['main_energy']/(1-$saving_daydata_array[$station["id"]]['contract_energy_saving_rate1']),2) ?>度
        </td> 
        
        <? }else{ ?>
           
        <td><?= $saving_daydata_array[$station["id"]]['err']?></td> <td></td> <td></td> <td></td>
        <? }?>
    </tr>
    <?}?>
</table>
    
    
    
    
    
    
    
    
    
    
    <script>
	
    $(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/analysis/home/energy_consumption_sorted";
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
        function energy_type_check(){
            
        }
</script>
