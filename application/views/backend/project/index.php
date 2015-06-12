<div class=base_center>
   
<?= $pagination?>
    
    
<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th> <b>#</b> </th>
      <th>项目名称</th>
      <th>项目运营状态</th>
      <th>是否产品</th>
      <th> <b>修改</b> </th>
    </tr>
  </thead>
  <tbody>

    <?php foreach ($projects as $project): ?> 
    <tr>
      <td><?= $project['id'] ?></td>
      <td><?= $project['name_chn'] ?></td>
      <td><?=h_project_ope_type($project['ope_type'])?></td>
      <td><?= $project['is_product'] ?></td>
      <td><a href="/backend/project/mod_project/<?= $project['id']?>">修改</a></td>
    </tr>
    <tr>
      <td colspan=6> 
        <div>
        <span style="color:green;">项目类型:</span>
            <?= h_project_type_name_chn($project['type'])?>
        </div>
        <div>
        <span style="color:green;">项目城市:</span>
            <? foreach($this->area->findProjectCities($project['id']) as $city) {?>
            <?= $city['name_chn'] ?> &nbsp;
            <? }?>
        </div>

        <div>
        <span style="color:green;">项目用户:</span>
        </div>
        <div>
        <span style="color:green;">项目基站:</span>
        </div>
      </td>
    </tr>
    <?php endforeach?>        
  </tbody>
</table>
 
<?= $pagination?>

</div>
