
<table class="sta_table" cellpadding="3" cellspacing="0" align="center" style="margin:10px 0">
<tr>
    <th class="" colspan=16> <?= $station->getNameChn();?> </td>
</tr>
<tr>
    <td style="width:30px;"><b>当前</b></td>
    <td style="width:50px;"><?= $station->getAlive() == ESC_ONLINE? "<font color=green>在线</font>":"<font color=red><b>不在线</b></font>" ?>  </td>
    <td style="width:35px;"><b>ESG</b></td>
    <td style="width:80px;"><?= $station->getEsg() ? $station->getEsg()->getId():"<font color=#f00><b>无ESG</b></font>"?>  </td>
    <td style="width:30px;"><b>城市</b></td>
    <td style="width:50px;"><?= h_station_city_name_chn($station) ?> </td>
    <td style="width:40px;"><b>负载</b> </td>
    <td style="width:70px;">(<b><?= $station->getLoadNum()?></b>)&nbsp; <?= h_station_total_load_name_chn($station->getTotalLoad())?>    </td>
    <td style="width:40px;"><b>建筑</b> </td>
    <td style="width:50px;"><?= h_station_building_name_chn($station->getBuilding())?> </td>
    <td style="width:30px;"><b>类型</b> </td>
    <td style="width:75px;"><?= h_station_station_type_name_chn($station->getStationType())?> </td>
    <td style="width:20px;"><b>N</b> </td>
    <td style="width:20px;"><?= $station->getNs()?> </td>
    <td style="width:30px;"><b>ROM</b> </td>
    <td><?= $station->getRomVersion() ?></td>
</tr>
<tr>
    <td><b>督导</b></td>
    <td> <?= $station->getCreator()?$station->getCreator()->getNameChn():"无记录"?> </td>
    <td><b>SIM卡</b></td>
    <td> <?= $station->getSimNum()?> </td>
    <td><b>强制</b></td>
    <td> <?= $station->getForceOn()==ESC_STATION_FORCE_ONOFF?"<font color=red><b>是</b></font>":"否"?> </td>
    <td><b>恒温柜</b></td>
    <td> <?= h_station_box_type_name_chn($station->getBoxType())?> </td>
    <td><b>外温感</b></td>
    <td> <?= $station->getEquipWithOutdoorSensor()==ESC_BEINGLESS?"<font color=red><b>无</b></font>":"有"?> </td>
    <td><b>风量</b></td>
    <td> <?= h_station_air_volume_name_chn($station->getAirVolume()) ?> </td>
    <td><b></b> </td>
    <td></td>
    <td><b>空调</b></td>
    <td> <?= $station->getColdsNum()?>台 </td>
</tr>
<tr>
    <td><b>地址</b></td>
    <td colspan=3>  
        <a href='#' title="<?= $station->getAddressChn()?>"><?= mb_substr($station->getAddressChn(),0,15)?></a>       
    </td>
    <td><b>备注</b></td>
    <td colspan=11>  
        <a href='#' title="<?= $station->getComment()?>"><?= mb_substr($station->getComment(),0,15)?></a>       
    </td>
</tr>
</table>

