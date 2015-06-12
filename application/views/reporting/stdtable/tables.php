<div class='base_center'>

<div style="float:left;width:1000px;margin:12px 0;">
    <ul>
    <? foreach ($projects as $p){?>
        <li style="float:left;font-weight:<?= $p['id']==$project['id']?"bold":""?>">
        <a href="?project_id=<?= $p['id']?>">
            <?= $p['name_chn']?>
        </a>
        <br/>
        </li>
    <?}?>
    </ul>
</div>


<table class="table2">
        
    <tr>
        <th> </th>
        <th style="width:170px"> </th>
        <th style="width:170px"> </th>
        <th style="width:160px"> </th>
    </tr>

    <? foreach ($month_array as $month){?>
        <tr>
            <td colspan=7 style="padding:5px;font-size:15px;font-weight:bold;background-color:#ccc">
                <?= h_dt_format($month,"Y年m月")?>
            </td>
        </tr>
        <tr>
            <td> </td>
            <td colspan=1> 砖墙 </td>
            <td colspan=1> 彩钢板 </td>
            <td> </td>
        </tr>
        <? foreach ($cities as $city_key=>$city){?>
            <tr>
                <td> <?= $city['name_chn']?> </td>
                <td>
                <a href="<?= "/reporting/stdtable/stage/".ESC_BUILDING_ZHUAN.
                "?project_id=".$project['id'].
                "&city_id=".$city['id'].
                "&datetime=".$month.
                "&backurl=".$backurl?>"> <?= h_dt_format($month,"m月")?>砖墙分期报表 </a>
                </td>
                <td>
                <a href="<?= "/reporting/stdtable/stage/".ESC_BUILDING_BAN.
                "?project_id=".$project['id'].
                "&city_id=".$city['id'].
                "&datetime=".$month.
                "&backurl=".$backurl?>"> <?= h_dt_format($month,"m月")?>板房分期报表 </a>
                </td>
                <td>
                 结算报表
                </td>
            </tr>
        <?}?>
    <?}?>
</table>



</div>


