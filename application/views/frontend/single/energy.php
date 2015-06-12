<?
/********************************
Fast JJump 
../../../../static/site/js/frontend_month.js

********************************/
?>


</div>
<!---------------------------------------------------------------------------------------------------------------->
    <div class="base_center" >
              <div style="clear:both;height:1px;overflow:hidden"></div>
              <div class="es_time_bar" style="margin:10px 0 5px 0;">
                  <ul >
                      <li>
                          <a href="?station_id=<?= $station['id']?>&time=<?= h_dt_prev_month($current_month)?>"><font color="blue"> 上个月 </font></a>  |  
                          <a href="?station_id=<?= $station['id']?>&time=<?= h_dt_next_month($current_month)?>"><font color="blue"> 下个月 </font></a>  
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
                   <ul><font style="font-size:16px;font-weight:bold"><?= $time_disp ?>每日能耗统计表</font></ul>
                </div>
              <div style="clear:both;height:1px;overflow:hidden"></div>


                <div style="margin:0 10px 0 10px">

        <?php if($station['station_type'] == ESC_STATION_TYPE_SAVING||
            $station['station_type'] == ESC_STATION_TYPE_COMMON || 
            $station['station_type'] == ESC_STATION_TYPE_STANDARD){?>	
                <table class="table table-striped table-bordered table-condensed">

                    <tr>
                        <th style="width:90px;"> <?=$this->lang->line("Time")?> </th>
                    	<th style="width:52px;">  总能耗 </th>
                    	<th style="width:52px;"> 本站负载 </th>
                    	<th style="width:52px;"> 推算负载 </th>
                    	<th style="width:52px;">  </th>
                    	<th style="width:52px;"> DC能耗</th>
                    	<th style="width:52px;"> AC能耗 </th>
                    	<th style="width:52px;"> 凌晨我司<br>电表读数 </th>                       
                    </tr>

                <? foreach($daydatas as $key=>$daydata){?>
                        <tr>
                            <td> <?= h_dt_r_mouth_saving_day($daydata['day'])?></td>
                            <td> <?= $daydata['main_energy']?> </td>
                            <td> <?= $station['load_num']?> </td>
                            <td> <?= h_round2($daydata['true_load_num'])?></td>
                            <td> </td>
                            <td> <?= $daydata['dc_energy']?> </td>
                            <td> <?= $daydata['ac_energy']?> </td>
                            <td> <?= $daydata['fixdata']?$daydata['fixdata']['energy_main']:""?></td>

                        </tr>
                <? }?>
                <? if($monthdata){?>
                        <tr>
                            <td colspan="8"> 本月总计 </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> <?= $monthdata['main_energy']?> 
                                <? if($tmp_err){?>
                                    (<a href="#" title=<?= $tmp_err?>>注</a>) 
                                <?}?>
                            </td>
                            <td> </td>
                            <td> </td>
                            <? if($station['station_type'] == ESC_STATION_TYPE_STANDARD){?>
                                <td> </td>
                            <?}else{?>
                                <td> </td>
                            <?}?>
                            <td> <?= h_array_safe($monthdata,'dc_energy')?> </td>
                            <td> <?= h_array_safe($monthdata,'ac_energy')?> </td>
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
                    dateFormat: "yymmdd",
                    inline: false,
                    timezone: '+8000',
                    defaultDate: '+7d', 
                    onClose:function(datatimeText,instance){
                        $("#es_month_offset_0").attr("class","");
                        $("#es_month_offset_1").attr("class","");
                        window.global_options.time = $('#es_day input').attr("value") + '000000';
                        window.location.href="?station_id="+"<?= $station['id'] ?>"+"&time="+window.global_options.time;
                    }
                });
                $('#es_day input').attr("value",$.datepicker.formatDate("yy-mm",new Date("<?= h_dt_r_mouth_saving_day_input($current_month)?>")));


			});


		</script>
        




