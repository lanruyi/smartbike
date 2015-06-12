<div class='base_center'>


<table class="table2">
        
    <tr>
        <th> </th>
        <th style="width:170px"> </th>
    </tr>

    <? foreach ($month_array as $month){?>
        <tr>
            <td colspan=3 style="padding:5px;font-size:15px;font-weight:bold;background-color:#ccc">
                <?= h_month_str($month)?> &nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td colspan=2> 
                <a href="/tool/no_box_fan_time_detail_all?month=<?=$month?>" >本月总表</a>
            </td>
        </tr>
        <? foreach ($cities as $city_key=>$city){?>
            <tr>
                <td> <?= $city['name_chn']?> </td>
                <td>
                    <a href="/tool/no_box_fan_time_detail?city_id=<?=$city['id']?>&month=<?=$month?>"><?= $city['name_chn']?>新风开启时间报表</a>
                </td>
            </tr>
        <?}?>
    <?}?>
</table>



<?php

    function h_month_str($time){
        return date("Y年m月",strtotime($time));
    }

?>

</div>

