<div class=base_center>


    <table class="table table-striped table-bordered table-condensed">
        <tr>
          <th width="8%"> <b>基站</b> </th>
          <th width="10%"> <b>同步电表</b> </th>
          <th width="10%"> <b>操作</b> </th>
        </tr>
        <? foreach($wrong_corrects as $wrong_correct){?>
        <tr>
            <td> <?= $wrong_correct['station_name_chn']?> </td>
            <td> <?= $wrong_correct['slope']?> </td>
            <td> <a href="/backend/correct?station_id=<?= $wrong_correct['station_id']?>">跳到后台查看</a> </td>
        </tr>
        <?}?>
    </table>



</div>
