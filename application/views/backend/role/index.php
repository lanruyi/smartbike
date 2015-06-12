<div class=base_center>


<a href ="/backend/role/add_role" class="btn btn-success"> <i class="icon-plus-sign icon-white"></i> 添加角色 </a>
<br>
<br>

<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th></th>
      <th colspan=2> <b>参数</b> </th>
      <th>  </th>
    </tr>
    <tr>
      <th> <b>#</b> </th>
      <th>角色名称</th>
      <th>权限值</th>
      <th> <b>修改</b> </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($roles as $role): ?>
    <tr>
      <td><?= $role['id'] ?>      </td>
      <td><?= $role['name_chn'] ?>     </td>
      <td><?= h_auth_display($role['authorities']) ?>     </td>
      <td><a href="/backend/role/mod_role/<?= $role['id']?>">修改</a></td>
    </tr>
    <tr>
      <td colspan=6> 
        <table class=table>
            <tr>
               <td colspan=7>  前端权限 </td>
            </tr>
            <tr>
               <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__FRONTEND_READ)?"*":"&nbsp;" ?>) 前端数据查看</td>
                <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__FRONTEND_DETAIL)?"*":"&nbsp;" ?>) 前端详细数据查看</td>
               <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__FRONTEND_CONTROL)?"*":"&nbsp;" ?>) 前端简单控制</td>

            </tr>
            <tr>
               <td colspan=7>  后端权限</td>
            </tr>
            <tr>              
               <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_STATION_DATA)?"*":"&nbsp;" ?>) 后端基站管理+数据查看 </td>
               <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_ESG)?"*":"&nbsp;" ?>) 后端ESG管理 </td>
               <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_ADMINISTRATOR)?"*":"&nbsp;" ?>) 后端超级管理 </td>
               <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_AGING)?"*":"&nbsp;" ?>) 后端老化管理 </td>
               <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_STATION_LOG)?"*":"&nbsp;" ?>) 后端基站维护日志 </td>
               <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__BACKEND_INSTALLATION)?"*":"&nbsp;" ?>) 后端施工管理 </td>
               <td> (<?= h_auth_check_role($role,ESC_AUTHORITY__REPORTING)?"*":"&nbsp;" ?>) 报表系统查看</td>
            </tr>
        </table>
      </td>
    </tr>
    <?php endforeach?>
  </tbody>
</table>

</div>
