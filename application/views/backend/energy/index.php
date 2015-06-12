<div class=base_center>

<div style="margin:0;width:100%">
<font>后台 >> 能耗列表</font>
</div>

    <? if(isset($station) && $station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>

<!-------------------------------------------------------------------->

<a href="?station_id=<?= $station['id']?>&datetime=<?= h_dt_sub_month($datetime)?>"> 上个月 </a>  |  
<a href="?station_id=<?= $station['id']?>&datetime=<?= h_dt_add_month($datetime)?>"> 下个月 </a>    
<br />
<br />

<table class="table2">

<tr style="background-color:#ccc">
<td colspan=2 >  <?= h_dt_format($datetime,"Y年m月")?> 能耗统计 </td>
</tr>

<tr>
<td> 总能耗  </td> 
<td>  <?= $monthdata['main_energy']?> (<?= $normal_sum_total?> / <?= $normal_count?> * <?= h_dt_past_days_of_month($datetime)?>)</td>
</tr>

<tr>
<td>  直流能耗 </td> 
<td>  <?= $monthdata['dc_energy']?> (<?= $normal_sum_dc?> / <?= $normal_count?> * <?= h_dt_past_days_of_month($datetime)?>) </td>
</tr>

</table>

<br />

<table class="table2">

<tr>
<td colspan=9 style="text-align:left"> <?= h_dt_format($datetime,"Y年m月")?> 每日能耗  </td>
</tr>

<tr style="background-color:#ccc">
<td> 日期 </td>
<td> 负载 </td>
<td> 真实负载 </td>
<td> 总能耗 </td>
<td> dc能耗 </td>
<td> 基准能耗 </td>
<td> 节能量 </td>
<td> 节能率 </td>
<td> </td>
</tr>

<? foreach($daydatas as $daydata){?>

<tr>
<td> <?= h_dt_format($daydata['day'],"Y-m-d")?></td>
<td> <?= $daydata['load_num']?> </td>
<td> <?= h_round2($daydata['true_load_num'])?> </td>
<td> <?= $daydata['main_energy']?> </td>
<td> <?= $daydata['dc_energy']?> </td>
<? if($project['type'] == ESC_PROJECT_TYPE_STANDARD_SAVING && $station['station_type'] == ESC_STATION_TYPE_COMMON){?>
<td> <?= h_round2($daydata['std_average'])?> </td>
<td> <?= $daydata['main_energy']?h_round2($daydata['std_average'] - $daydata['main_energy']):""?> </td>
<td> <?= $daydata['main_energy']&&$daydata['std_average']?
    h_round2(($daydata['std_average'] - $daydata['main_energy'])*100/$daydata['std_average']):""?>% </td>
<?}else{?>
<td></td>
<td></td>
<td></td>
<?}?>
<td> <?= h_ddct_color($daydata['calc_type'])?> </td>
</tr>

<?}?>

</table>


</div>

