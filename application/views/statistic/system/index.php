<div class="base_center">


<table class="table2">
    <tr style="background-color:#ccc;font-weight:50">
        <td> 基站总数 </td>
        <td> 在线总数 </td>
        <td> 在线率</td>
    </tr>
    <tr>
        <td> <?= $system['total']?>  </td>
        <td> <?= $system['total_online']?>  </td>
        <td> 
            <?= $system['total']?h_round2($system['total_online']*100/$system['total']):""?>%    
        </td>
    </tr>
</table>

<br />

<table class="table2">
    <tr style="background-color:#ccc;font-weight:50">
        <td> 合同（执行）基站总数 </td>
        <td> 在线总数 </td>
        <td> 在线率</td>
    </tr>
    <tr>
        <td> <?= $contracted['total']?>  </td>
        <td> <?= $contracted['total_online']?>  </td>
        <td> 
            <?= $contracted['total']?h_round2($contracted['total_online']*100/$contracted['total']):""?>%    
        </td>
    </tr>
</table>

<br />

<table class="table2">
    <tr style="background-color:#ccc;font-weight:50">
        <td> 项目名 </td>
        <td> 基站数量 </td>
        <td> 在线基站数 </td>
        <td> 基站在线率 </td>
    </tr>
<? foreach($projects as $project){?>
    <tr>
        <td>
        <?= $project['name_chn']?>    
        </td>
        <td>
        <?= $project['num']?>    
        </td>
        <td>
        <?= $project['online_num']?>    
        </td>
        <td>
        <?= $project['num']?h_round2($project['online_num']*100/$project['num']):""?>%    
        </td>
    </tr>
<?}?>
</table>

</div>
