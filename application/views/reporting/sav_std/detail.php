<style>
.mtitle td{font-size:8px;font-weight:bold;height:12px;background-color:#ccc;line-height:12px;overflow:hidden}
</style>
<div class=base_center>

<a href="<?= urldecode($backurl)?>"> 返回 </a>
<br>
项目:<?= $project['name_chn']?>
<br>
城市:<?= $city['name_chn']?>
<br>
时间:<?= $this->input->get('datetime')?>
<br>
建筑类型:<?= h_station_building_name_chn($this->input->get('building'))?>
<br>
<br>

<script>
    function add_sav_std(bm){
        $("#bm").val("bm"+bm);
        document.getElementById('add_sav_std').submit()
    }
</script>


<br>

<form id="add_sav_std" action="/reporting/sav_std/add_sav_stds?project_id=<?= $project['id']?>&city_id=<?=$city['id']?>&building=<?=$building?>&datetime=<?=$datetime?>&backurl=<?=$backurl?>" method='post'>
    <input id="bm" type=hidden value=0 name=bookmark />
<table class="table2">
    <? foreach (h_station_total_load_array() as $total_load => $total_load_name){?>
        <tr>
            <td colspan=2 style="background-color:#666;color:#fff;font-weight:bold;font-size:14px;">
                <?= $total_load_name?> 
                <a name="bm<?= $total_load?>"></a>
            </td>
        </tr>
        <tr>
            <td style="width:120px;"> 基准站 </td>
            <td style="text-align:left"> 
        <? if(isset($sav_stds[$total_load])){?>
            <table>
                 <tr class=mtitle> 
                    <td> 基准站</td>
                    <td> </td>
                 </tr> 
                <? foreach ($sav_stds[$total_load] as $sav_std){?>
                     <tr> 
                        <td> 
                            <a href="/backend/station/slist?station_ids=<?= $sav_std['std']['id']?>">
                                <?= $sav_std['std']['name_chn']?> (<?= $sav_std['std']['load_num']?>A)
                            </a>
                        </td>
                        <td> <a href="/reporting/sav_std/del/<?= $sav_std['id']?>?project_id=<?= $project['id']?>&city_id=<?=$city['id']?>&building=<?=$building?>&datetime=<?=$datetime?>&bookmark=bm<?=$total_load?>">删除</a> </td>
                    </tr>
                <?}?>
            </table>
            <b>平均基准月能耗:<?= isset($sav_std_averages[$total_load])?$sav_std_averages[$total_load]['average_main_energy']:0?></b>
        <?}else{?>
            本档位无已设定基准站
        <?}?>
        </tr>
        <tr>
            <td> 添加基准站 </td>
            
            <td style="text-align:left"> 
                <?if (isset($stations[$total_load])){?>
                    <?= h_make_select(
                        h_array_2_select($stations[$total_load]),"add_stations[".$total_load."]",0," ",160) ?>
                <?}else{?>
                    本档位无基准站
                <?}?>
                <a href="javascript:add_sav_std(<?= $total_load?>)">添加</a>
            </td>
        </tr>
        <tr>
            <td> 能耗信息 </td>
            <td>
                <table>
                 <tr class=mtitle> 
                    <td> </td>
                    <td> 基站名</td>
                    <td> 本月能耗(度)</td>
                    <td> 额外交流功率(w)</td>
                    <td> 月扣除</td>
                    <td> 人工设定</td>
                    <td> 备注 </td>
                 </tr> 
                 <?if (isset($stations[$total_load])){?>
                    <?foreach ($stations[$total_load] as $station){?>
                        <tr>
                            <td>
                                <?= h_station_station_type_name_chn_slist($station['station_type'])?> &nbsp;&nbsp;
                            </td>
                            <td>
                                <?= $station['name_chn']?>                        
                            </td>
                            <td>
                                <?= $station['monthdata']['main_energy']?>                        
                            </td>
                            <td>
                                <?= $station['extra_ac']?>                        
                            </td>
                            <td>
                                - <?= h_power_to_month_energy($station['extra_ac'],$datetime)?>                        
                            </td>
                            <td>
                                <input name="true_energies[<?= $station['monthdata']['id']?>]" 
                                    style="width:100px" value="<?= $station['monthdata']['true_energy']?>" />                        
                            </td>
                            <td>
                                <textarea name="reason[<?= $station['monthdata']['id']?>]" 
                                    style="height:32px;width:360px" /><?= $station['monthdata']['reason']?></textarea>                        
                            </td>
                        </tr>
                    <?}?>
                 <?}?>
                    <tr>
                        <td colspan=7 style="text-align:center">
                            <a href="javascript:add_sav_std(<?= $total_load?>)"> 保存 </a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="javascript:void()"> 取消 </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?}?>
</table>
</form>

</div>

