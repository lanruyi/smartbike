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
    function add_savpairs(bm){
        $("#bm").val("bm"+bm);
        document.getElementById('add_savpairs').submit()
    }
</script>


<a href="<?= h_url_report_recalc_savpairs($project['id'],$city['id'],$building,$datetime,$backurl)?>"> 重算本页节能 </a>
<br>
<br>

<form id="add_savpairs" action="<?= h_url_report_add_savpairs($project['id'],$city['id'],$building,$datetime,$backurl)?>" method='post'>
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
            <td style="width:120px;"> 节能对 </td>
            <td> 
        <? if(isset($savpairs[$total_load])){?>
            <table>
                 <tr class=mtitle> 
                    <td> 基准站</td>
                    <td> 标杆站</td>
                    <td> 节能率</td>
                    <td> </td>
                 </tr> 
                <? foreach ($savpairs[$total_load] as $key => $savpair){?>
                     <tr> 
                        <td> 
                            <a href="/backend/station/slist?station_ids=<?= $savpair['std_station']['id']?>">
                                <?= $savpair['std_station']['name_chn']?> (<?= $savpair['std_station']['load_num']?>A)
                            </a>
                        </td>
                        <td> 
                            <a href="/backend/station/slist?station_ids=<?= $savpair['sav_station']['id']?>">
                                <?= $savpair['sav_station']['name_chn']?> (<?= $savpair['sav_station']['load_num']?>A)
                            </a>
                        </td>
                        <td> <?= $savpair['save_rate']*100?>%</td>
                        <td> <a href="<?= h_url_report_del_savpair($savpair['id'],
                            $project['id'],$city['id'],$building,$datetime,$backurl)?>">删除</a> </td>
                    </tr>
                <?}?>
            </table>
        <?}else{?>
            本档位无节能对
        <?}?>
        </tr>
        <tr>
            <td> 添加对 </td>
            
            <td> 
                <?if (isset($stations[$total_load][ESC_STATION_TYPE_STANDARD])){?>
                    <?= h_make_select(
                        h_array_2_select($stations[$total_load][ESC_STATION_TYPE_STANDARD]),
                        "add_stations[".$total_load."][".ESC_STATION_TYPE_STANDARD."]",0," ",160) ?>
                <?}else{?>
                    本档位无基准站
                <?}?>
                <?if (isset($stations[$total_load][ESC_STATION_TYPE_SAVING])){?>
                    <?= h_make_select(
                        h_array_2_select($stations[$total_load][ESC_STATION_TYPE_SAVING]),
                        "add_stations[".$total_load."][".ESC_STATION_TYPE_SAVING."]",0," ",160) ?>
                <?}else{?>
                    本档位无标杆站
                <?}?>
                &nbsp;&nbsp;
                <a href="javascript:add_savpairs(<?= $total_load?>)">添加</a>
            </td>
        </tr>
        <tr>
            <td> 能耗信息 </td>
            <td>
                <table>
                 <tr class=mtitle> 
                    <td> </td>
                    <td> 基站名</td>
                    <td> 本月能耗</td>
                    <td> 额外交流功率(w)</td>
                    <td> 本月扣除</td>
                    <td> 人工设定</td>
                    <td> 备注 </td>
                 </tr> 
                <?foreach (array(ESC_STATION_TYPE_STANDARD,ESC_STATION_TYPE_SAVING) as $station_type){?>
                    <?if (isset($stations[$total_load][$station_type])){?>
                    <?foreach ($stations[$total_load][$station_type] as $station){?>
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
                               <?= $station['extra_ac']?>w
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
                <?}?>
                    <tr>
                        <td colspan=5 style="text-align:center">
                            <a href="javascript:add_savpairs(<?= $total_load?>)"> 保存 </a>
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

