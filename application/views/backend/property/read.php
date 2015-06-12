<div class="base_center">

    <div style="margin:0;width:100%">
    <font>后台 >> 基站读取esg属性</font>
    </div>

    <? if(isset($station) && $station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>

<?= $station['name_chn']?>

<? if($gp_command){?>
    正在获取中,请稍候...
<?}else{?>
    <a class="btn" href="/backend/property/send_command/<?= $station['id']?>">获取本站属性</a>
<?}?>



<a class="btn" href="javascript:void(0)">刷新</a>
<br>
<br>
<? if($property){?>
    <table class=table style="width:300px">
    <?  foreach( h_property_array() as $pkey=>$pname){ ?>
        <tr>
            <td>
                <?= $pname?>
            </td>
            <td>
                <?= $property[$pname] ?><br>
            </td>
        </tr>
    <?} ?>
    上一次读取时间：<?= $property['update_time'] ?><br><br>
    </table>
<?}else{?>
    从未读取过站点设置

<?}?>

</div>


</div>


