<style>
    .title{margin-bottom:10px;padding:10px 10px 0px 10px;font-size:20px;}
    .body{padding:10px 20px 20px 0px;font-size:10px} 
    .table{font-size:10px;padding:10px 20px 20px 0px;}
</style>

<div class="base_center">

<div class="title">
修改角色 
</div>

<div class="body">
<? 
$attributes = array("class"=>"add_role");
$hidden = array('id' => $role['id']);
echo form_open("/backend/role/update_role",$attributes,$hidden); 
?>

    <ul>ID: <input readonly='readonly' type="text" name="id" value="<?= $role['id'] ?>" /> </ul>
    <ul>
      角色名称: 
        <input type="text" name="name_chn" value="<?= $role['name_chn'] ?>" /> </ul>
    <ul>
        <table class="table">
            <tr>
                <td colspan=4>  前端权限 </td>
            </tr>
            <tr>
                <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__FRONTEND_READ?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__FRONTEND_READ)?"checked":"" ?> > 
                    前端数据查看 
                </td>
                <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__FRONTEND_DETAIL?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__FRONTEND_DETAIL)?"checked":"" ?> > 
                    前端详细数据查看 
                </td>
                <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__FRONTEND_CONTROL?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__FRONTEND_CONTROL)?"checked":"" ?> > 
                    前端简单控制 
                </td>

            </tr>
            <tr>
                <td colspan=4>  后端权限 </td>
            </tr>
            <tr>
               <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__BACKEND_STATION_DATA?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_STATION_DATA)?"checked":"" ?> > 后端基站管理+数据查看 </td>
               <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__BACKEND_ESG?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_ESG)?"checked":"" ?> > 后端ESG管理 </td>
               <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__BACKEND_ADMINISTRATOR?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_ADMINISTRATOR)?"checked":"" ?> > 后端超级管理 </td>
               <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__BACKEND_AGING?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_AGING)?"checked":"" ?> > 后端老化管理 </td>
               <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__BACKEND_STATION_LOG?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_STATION_LOG)?"checked":"" ?> > 后端基站维护日志 </td>
               <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__BACKEND_INSTALLATION?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_INSTALLATION)?"checked":"" ?> > 后端施工管理 </td>
               <td> <input type="checkbox" name='authorities[]' value=<?= ESC_AUTHORITY__REPORTING?> 
                    <?= h_auth_check_role($role,ESC_AUTHORITY__REPORTING)?"checked":"" ?> > 报表系统查看 </td>

            </tr>
        </table>
    </ul>
    <ul><?php echo form_submit("","提交"); ?> </ul>
    
<?php echo form_close(); ?>
</div>

<div style="padding:0px 20px 20px 25px;">
<a href="/backend/role">返回</a>
</div>

</div>
