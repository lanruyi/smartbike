
<script>
    $(function(){
        $("#confirm_s").click(function(){
            start = $("select#start_s_year").val()+$("select#start_s_month").val()+"01";
            stop  = $("select#stop_s_year").val()+$("select#stop_s_month").val()+"01";
            $("input#start_month").val(start);
            $("input#stop_month").val(stop);
            document.getElementById('filter').submit();
        });
    });
</script>

<div class="base_center">


<form id="filter" method="get" action="">
<div>

<?
    $html_project_selects = h_array_2_html_select($projects);
    $html_project_selects[4]['css'] = "color:#f00;background-color:#eee";
    $html_project_selects[104]['css'] = "color:#f00;background-color:#eee";
?>
    项目 <?= h_make_html_select($html_project_selects,'project_id',$project_id,"",160) ?>
<br />
    开始月份: <?= h_html_year_month_select("start_s",$start_month)?>
    结束月份: <?= h_html_year_month_select("stop_s",$stop_month)?>
    <input type="hidden" id="start_month" name="start_month" value=<?= $start_month?>></input>
    <input type="hidden" id="stop_month"  name="stop_month"  value=<?= $stop_month?>></input>
    <a href="javascript:void(0)" id="confirm_s" class="btn2"> [提交] </a> 
</div>
</form>


<br />

<table class="table2">
    <tr style="background-color:#ccc">
        <td colspan=6 style="text-align:left;font-weight:bold"> 
            总平均
        </td>
    </tr>
    <tr style="background-color:#ccc">
        <td> 档位 </td>
        <td> 数据正常月数 </td>
        <td> 平均基准能耗 </td>
        <td> 平均节能 </td>
        <td> 节能率 </td>
        <td> 估算月收益(电费1元 分6成) </td>
    </tr>
    <?
        foreach(h_station_total_load_array() as $total_load => $name){
        $average_std_main = $total_info[$total_load]['num']?
                    $total_info[$total_load]['average_std_main']/$total_info[$total_load]['num']:0;
        $saving = $total_info[$total_load]['num']?
                    $total_info[$total_load]['saving']/$total_info[$total_load]['num']:0;
        $saving_rate = $average_std_main?$saving/$average_std_main:0;
    ?>
    <tr>
        <td>
            <b><?= h_station_total_load_name_chn($total_load)?></b>
        </td>
        <td> <?= $total_info[$total_load]['num']?> </td>
        <td> <?= h_round2($average_std_main)?> </td>
        <td> <?= h_round2($saving)?> </td>
        <td> <?= h_round2($saving_rate*100)?>% </td>
        <td> <?= h_round2($saving*1*0.6)?> 元 </td>
    </tr>
    <?}?>
</table>

<br />

<!--* 下列数据已经按档位统一化（如20-30A的统一化到25A）-->

<?foreach($month_data as $month=>$info){?>
<table class="table2">
    <tr style="background-color:#ccc">
        <td colspan=8 style="text-align:left;font-weight:bold"> 
            <?= h_dt_format($month,"Y年m月")?> 
        </td>
    </tr>
    <tr style="background-color:#ccc">
        <td> 档位 </td>
        <td> 正常/节能站数量 </td>
        <td> 单站平均月能耗 </td>

        <td> 正常/基准站数量 </td>
        <td> 单站平均月基准能耗 </td>

        <td> 单站平均月节能 </td>
        <td> 节能率 </td>
        <td> 估算月收益(电费1元 分6成) </td>
    </tr>
    <? foreach($info as $total_load => $item){?>
    <?
    $saving_rate = $item['saving'] && $item['average_std_main']? 
        $item['saving']*100/$item['average_std_main'] : 0;
    ?>
    <tr>
        <td>
            <b><?= h_station_total_load_name_chn($total_load)?></b>
        </td>
        <td>
        <?= $item['normal_num']?>
        /
        <?= $item['num']?>
        </td>
        <td>
        <?= h_round2($item['average_main'])?>
        </td>
        <td>
        <?= $item['normal_std_num']?>
        /
        <?= $item['std_num']?>
        </td>
        <td>
        <?= h_round2($item['average_std_main'])?>
        </td>
        <td>
        <?= h_round2($item['saving'])?>
        </td>
        <td>
        <?= h_round2($saving_rate)?>%
        </td>
        <td>
        <?= h_round2($item['saving']*1*0.6)?> 元
        </td>
    </tr>
    <? }?>
</table>
</br>
<? }?>
 
</div>
