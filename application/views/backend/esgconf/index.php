<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px ;}

</style>

<script>
$(function(){
    $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'});
})
</script>

<div class="base_center">
<div style="margin:0;width:100%">
<font>后台 >> 设置列表</font>
</div>

<div style="clear:left;"><?= $pagination ?></div>

<div class=row-fluid>
<div class="span12">
<table class="table table-striped table-bordered table-condensed">
    <tr>
        <td> 基站名 </td>
        <?php foreach (h_esgconf_array() as $_c=>$_esgconf){?>
            <td> <?= $_c?> </td>
        <?}?>
    </tr>
    <?php foreach ($esgconfs as $esgconf){?>
        <tr>
            <td>
            </td>
            <?php foreach (h_esgconf_array() as $_c=>$_esgconf){?>
                <td> <?= $esgconf[$_esgconf['en']]?> </td>
            <?}?>
        </tr>
    <?}?>
</table>
<div style="clear:left;"><?= $pagination ?></div>
</div>
</div>
</div>
