<div class="base_center">
    <br />
    <table class="table2">
    <thead>
        <tr>
            <td>项目运营类型</td>
            <td>所属项目</td>
        </tr>
    </thead>
    <tbody>
        <? foreach(h_project_ope_type_array() as $k=>$pro) {?>
        <tr>
            <td>
                <b><?=$pro?></b>
            </td>
            <td>
            <? foreach ($this->project->findProjectTypeProjects($k) as $k2=>$project){?>
                <a href="/frontend/project/change_project/<?= $project['id']?>"><?= $project['name_chn']?></a>&nbsp;&nbsp;
            <?}?>
            </td>
        </tr>
        <? }?>
    </tbody>
    </table>
</div>
