<div class='base_center'>


        <form id="filter" method="get" action="">
        <div class='filter'>
            项目:<?= h_make_select(h_array_2_select($projects),'project_id',$this->input->get('project_id'),""); ?>
            月份:<?= h_make_select($months,'time',$month,""); ?>
        </div>
        <div class='operate'>
	    <a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
        <a href="/backend/station/slist" class="btn btn-primary">清除查询</a>
        </div>
        </form>




<table class="table2">
        

        <tr>
            <td colspan=8 style="padding:5px;font-size:18px;
                    font-weight:bold;background-color:#ccc;text-align:left;">
                <?= h_month_str($month)?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <font style="font-weight:normal;font-size:12px;">
                    <a href="/reporting/table/common_table_all?project_id=<?= $project['id']?>&datetime=<?= $month?>&backurl=<?= $backurl?>">
                        普通站总表
                    </a>
                </font>
            </td>
        </tr>
        <tr>
            <td> </td>
            <td colspan=2> 砖墙 </td>
            <td colspan=2> 彩钢板 </td>
        </tr>
        <? foreach ($cities as $city_key=>$city){?>
            <tr>
                <td> <?= $city['name_chn']?> </td>

                    <? foreach (array(ESC_BUILDING_ZHUAN,ESC_BUILDING_BAN) as $building){?>
                        <td>
                                <a href="<?= h_url_report_saving_table_url($project['id'],
                                    $city['id'],$month,$building,$backurl)?>">基准标杆站报表</a>
                        </td>
                        <td>
                                <a href="<?= h_url_report_common_stage_table_url($project['id'],
                                    $city['id'],$month,$building,$backurl)?>">普通站--分期报表</a>
                        </td>
                    <?}?>


            </tr>
        <?}?>
</table>



<?php

    function h_month_str($time){
        return date("Y年m月",strtotime($time));
    }

?>

</div>


<script>
    $(function(){
        $("#download_xls").click(function(){
            document.getElementById('filter').action = "/reporting/table";
            document.getElementById('filter').submit();
        });
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/reporting/table";
            document.getElementById('filter').submit();
        });
    });
</script>
