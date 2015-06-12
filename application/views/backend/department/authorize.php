<script>
function de_confirm(){

if( confirm("确认删除吗?")){
alert("已经删除");
}
else return false;
}
</script>
<div class=base_center>


<table class="table table-striped table-bordered table-condensed" border=1 width=1000>
<form action="/backend/department/department_role" method="post" charset="utf-8">
<thead>
<tr>
<th></th>
<th colspan=<?=count($roles)?>> <b><?=$department_msg['name_chn']?></b> </th>
</tr>
    <tr>
<td> 添加授权</td>
<?php foreach($roles as $role){?>
<td>    
    <input type="radio" name="role_id"  value="<?=$role['id']?>"
<?php if($department_msg['role_id'] == $role['id']){
                        echo "checked=checked"; 
} ?>
     ><?=$role['name_chn']?>
</td>
<?php }?>
    </tr>

    <tr>
        <td colspan="100%" align="right"><input type="submit" value="提交" /></td>
    </tr>
    <input type="hidden" name ="did" value="<?=$get['id']?>">
</form>

</table>

</div>



