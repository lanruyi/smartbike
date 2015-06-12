
<script>
    $(function(){
        $("#confirm_s").click(function(){
            //document.getElementById('filter').action = "/reporting/table";
            document.getElementById('filter').submit();
        });
    });
</script>

<div class="base_center">


<form id="filter" method="get" action="">
<div>
    月份 <input class='input2' name='datetime' value="<?= h_dt_format($datetime,"Y-m-d")?>" style="width:80px;">
<?
    $html_project_selects = h_array_2_html_select($projects);
    $html_project_selects[4]['css'] = "color:#f00;background-color:#eee";
    $html_project_selects[104]['css'] = "color:#f00;background-color:#eee";
?>
    项目 <?= h_make_html_select($html_project_selects,'project_id',$project_id,"",160) ?>
    <a href="javascript:void(0)" id="confirm_s" class="btn2">提交</a> 
</div>
</form>


<br />

<!--* 下列数据已经按档位统一化（如20-30A的统一化到25A）-->
<table class="table2">
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
        <?= h_round2($item['average_main_energy'])?>
        </td>
        <td>
        <?= $item['normal_std_num']?>
        /
        <?= $item['std_num']?>
        </td>
        <td>
        <?= isset($item['average_std_main_energy'])?h_round2($item['average_std_main_energy']):""?>
        </td>
        <td>
        <? $saving = isset($item['average_std_main_energy'])?
            ($item['average_std_main_energy'] - $item['average_main_energy']):"";?>
        <?= h_round2($saving)?>
        </td>
        <td>
        <? if (isset($item['average_std_main_energy']) && $item['average_std_main_energy']>0){?>
            <?= h_round2($saving*100 / $item['average_std_main_energy'])?>%
        <?}?>
        </td>
        <td>
        <?= h_round2($saving*1*0.6)?> 元
        </td>
    </tr>
    <? }?>
</table>
 
</div>
