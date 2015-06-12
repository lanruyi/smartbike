<?
/********************************
Fast JJump 
../../../../static/site/js/frontend_month.js

********************************/
?>
<style>
.realtime_box{ margin-top:8px; float:left;width:100%; border-top:3px solid #333; border-bottom:3px solid #333;}
.realtime_box ul{ margin:0;padding:0; float:left; width:100%; list-style:none}
.realtime_box ul li{height:40px; margin:2px; font-size:9px; line-height:18px;float:left; text-align:center;list-style:none; border-right:1px solid #666}
.realtime_box ul li font{ font-size:20px;}
.realtime_box ul li div{ font-size:20px;}
</style>

</div>
<!---------------------------------------------------------------------------------------------------------------->
    <div class="base_center" >
              <div style="clear:both;height:1px;overflow:hidden"></div>
              <div class="es_time_bar" style="margin:10px 0 5px 0;">
                  <ul >
                      <li style="width:750px;text-align:left;"> 
                        <font style="font-size:22px;font-weight:bold"><?= $time_disp ?>节能表</font>
                      </li>
                      <li>
                          <a href="?time=<?= h_dt_prev_month($current_month)?>"> 
                            << <?=$this->lang->line("Last month")?> 
                          </a> |
                          <a href="?time=<?= h_dt_next_month($current_month)?>"> 
                            <?=$this->lang->line("Next month")?> >> 
                          </a>
                      </li>
                      <li class="divider-vertical"></li>
                      <li id="es_day">  
                          <input type="text"  style="width:52px;height:16px"> &nbsp; 
                      </li>
                      <li class="divider-vertical"></li>
                  </ul>                
              </div>


              <div style="clear:both;height:1px;overflow:hidden"></div>
                <div class='chart_title'>
                   <ul><?=$this->lang->line("AC energy-saving form this month")?> (kw.h)</ul>
                </div>
              <div style="clear:both;height:1px;overflow:hidden"></div>


                <div style="margin:0 10px 0 10px">

        <?php if($station['station_type'] == ESC_STATION_TYPE_SAVING||
            $station['station_type'] == ESC_STATION_TYPE_COMMON || 
            $station['station_type'] == ESC_STATION_TYPE_STANDARD){?>	
                <table class="table table-striped table-bordered table-condensed">

                    <tr>
                        <th style="width:90px;"> <?=$this->lang->line("Time")?> </th>
                    	<th style="width:52px;"> 本站能耗 </th>
                    	<th style="width:52px;"> 本站负载 </th>
                    	<th style="width:52px;"> 节能率 </th>
                    	<th style="width:52px;"> 节能量 </th>
                    	<th style="width:52px;"> 本站DC</th>
                    	<th style="width:52px;"> 本站AC </th>
                    	<th style="width:52px;"> 凌晨我司<br>电表读数 </th>
                    	<th style="width:52px;"> 天气预报 </th>
                        
                    </tr>

                <? foreach($daydatas as $key=>$daydata){?>
                        <tr>
                            <td> <?= h_dt_r_mouth_saving_day($daydata['day'])?></td>
                            <td> <?= $daydata['main_energy']?> </td>
                            <td> <?= $station['load_num']?> </td>
                            <td> <?= $daydata['rate']?h_round2($daydata['rate']*100)."%":""?></td>
                            <td> <?= $daydata['rate'] > 0 && $daydata['rate'] < 1 ?
                                        h_round2($daydata['main_energy']*$daydata['rate']/(1-$daydata['rate'])):""?></td>
                            <td> <?= $daydata['dc_energy']?> </td>
                            <td> <?= $daydata['ac_energy']?> </td>
                            <td> <?= $daydata['fixdata']?$daydata['fixdata']['energy_main']:""?></td>
                            <td> </td>
                        </tr>
                <? }?>
                <? if($monthdata){?>
                        <tr>
                            <td colspan="9"> 本月总计 </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> <?= $monthdata['main_energy']?> 
                                <? if($tmp_err){?>
                                    (<a href="#" title=<?= $tmp_err?>>注</a>) 
                                <?}?>
                            </td>
                            <td> </td>
                            <? if($station['station_type'] == ESC_STATION_TYPE_STANDARD){?>
                                <td> </td>
                                <td> </td>
                            <?}else{?>
                                <td> <?= isset($month_saving_rate)?h_round2($month_saving_rate*100)."%":""?></td>
                                <td> <?= isset($month_saving_rate)?
                                            h_round2($monthdata['main_energy']*$month_saving_rate/(1-$month_saving_rate)):""?></td>
                            <?}?>
                            <td> <?= h_array_safe($monthdata,'dc_energy')?> </td>
                            <td> <?= h_array_safe($monthdata,'ac_energy')?> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                <? }?>

                </table>   

        <?php }elseif($station['station_type'] ==ESC_STATION_TYPE_NPLUSONE){?>    
                <table class="table table-bordered ">
<style>
tr.month_tr_standard td{ background-color:#cfc; }
tr.h th{ background-color:#ccc; }
</style>

                    <tr class="h">
                        <th style="width:85px;"> <?=$this->lang->line("Time")?> </th>
                        <th style="width:15px;"></th>
                        <th style="width:15px;"></th>
                        <th style="width:55px;"> <?=$this->lang->line("DC energy consumption")?></th>
                        <th style="width:55px;"> <?=$this->lang->line("The total energy consumption")?></th>
                        <th style="width:320px;" colspan=2> <?=$this->lang->line("AC energy consumption")?></th>
                        <th style="width:225px;" colspan=2> <?=$this->lang->line("AC energy savings")?></th>
                        <th style=""> <?=$this->lang->line("Energy saving rate")?> </th>
                    </tr>

                <?php foreach($day_datas['days'] as $key=>$item){?>
                        <tr class=<?= $item['is_standard']?"month_tr_standard":""?> >
                            <td> <?= h_dt_r_mouth_saving_day($item['time'])?></td>
                            <td> </td>             
                            <td> <?= $item['err']?"<a href='javascript:void(0)' style='color:#f00' title=".$item['err'].">err</a>":""?></td>             
                            <td> <?= $item['dc_energy']?> </td>
                            <td> <?= $item['main_energy']?> </td>
                            <td style="width:55px"> <?= $item['ac_energy']?> </td>
                            <td> <div style="height:10px;width:<?= $item['ac_energy']?$item['ac_energy']*2:0?>px;background-color:
                                <?= $item['is_standard']?"#d76618":"#1d476f"?>;overflow:hidden">&nbsp;</div> </td>             
                    <?if($item['is_standard']){?>
                            <td colspan=3 style="color:#999"> <?=$this->lang->line("Base day")?> </td>             
                    <? }else{?>
                            <td style="width:55px"> <?= $item['ac_save']?> </td>             
                            <td> <div style="height:10px;width:<?= $item['ac_save']?$item['ac_save']*2:0?>px;background-color:#666;overflow:hidden">&nbsp;</div> </td>             
                            <td> <?= $item['ac_save_p']?round($item['ac_save_p'],0)."%":"-"?> </td>             
                    <? }?>
                        </tr>
                <?php }?>
          
                </table>  


                </table>   
            
        	<?php }?>                  
            </div>

            </div>
        </div>

		<script type="text/javascript" src="/static/site/js/frontend_basic.js?id=<?= hsid()?>"></script>
		<script type="text/javascript" src="/static/site/js/frontend_month.js?id=<?= hsid()?>"></script>
		<script type="text/javascript">
		// Json struct for different params. Initial: time, last 3_hours
			window.global_options = {
                "station_id": "<?= $station['id'] ?>",
                "day_offset": "0",
                "time": ""
            }

            $(document).ready(function(){


                $("#es_refresh").click(function(){ window.location.reload();});

                $('#es_day input').datepicker({
                    showButtonPanel: true,
                    dateFormat: "yy-mm",
                    inline: false,
                    timezone: '+8000',
                    defaultDate: '+7d', 
                    onClose:function(datatimeText,instance){
                        $("#es_month_offset_0").attr("class","");
                        $("#es_month_offset_1").attr("class","");
                        window.global_options.time = $('#es_day input').attr("value") + ' 00:00:00';
                        window.location.href="?time="+window.global_options.time;
                    }
                });
                $('#es_day input').attr("value",$.datepicker.formatDate("yy-mm",new Date("<?= h_dt_r_mouth_saving_day_input($current_month)?>")));


			});


		</script>
        




