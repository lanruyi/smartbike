<div class=base_center>


    <div style="margin:0;width:100%">
    <font>后台 >> 故障相关设置和操作 </font>
    </div>

    <br />
    <h3> 1.空调不受控自动排查 </h3>
    <form action="/backend/bug/update_bug_configs" method="post">
    <table class="table2">
    <tr>
        <td>
        </td>
        <? foreach(h_station_total_load_array() as $total_load=>$total_load_name){?>
            <? foreach(h_station_building_array() as $building=>$building_name){?>
            <td>
                <?= $total_load_name."<br>".$building_name?> 
            </td>
            <?}?>
        <?}?>
    </tr>
    <? foreach($projects as $project){?>
        <tr>
            <td>
                <?= $project['name_chn']?>
            </td>
            <? foreach(h_station_total_load_array() as $total_load=>$name){?>
                <? foreach(h_station_building_array() as $building=>$name){?>
                <td>
                <input name="b42_config[<?=$project['id']?>][<?=$total_load?>][<?=$building?>]" 
                    value="<?= h_array_safe(h_array_safe(h_array_safe($b42_config,$project['id']),$total_load),$building)?>" 
                    type="text" style="width:42px"/>
                </td>
                <?}?>
            <?}?>
        </tr>
    <?}?>
    <tr>
    <td colspan=15>
    <a href="/backend/bug/doAnalysisMainEnergy">点此进行一次手动排查</a>
    &nbsp;&nbsp;
    &nbsp;&nbsp;
    &nbsp;&nbsp;
    &nbsp;&nbsp;  
    <input type="submit" />
    </td>
    </tr>
    </table>
    </form>



    
</div>
