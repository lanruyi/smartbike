<div class=base_center>

<style>
.detail_f{margin:0;padding:0}
.detail_f ul{float:left;margin:2px 0;padding:0;}
.detail_f ul.head{width:35px;text-align:left;font-weight:bold;padding:4px 0 0 0;}
.detail_f ul.body{width:965px;}
.detail_f ul.line{width:1000px;border-bottom:1px dashed #ccc;height:2px;}
.detail_f ul li{float:left;margin:2px;padding:1px 6px;background-color:#ddd;}
.detail_f ul li a{color:#000;}
.detail_f ul li.head{width:35px;text-align:left;font-weight:bold}
.detail_f ul li.active{background-color:#69c;color:#fff}
.detail_f ul li.active a{background-color:#69c;color:#fff}
</style>

<div class='detail_f'>
    <ul class=head> 项目 </ul>
    <ul class=body>
            <li class="<?= ""==$this->input->get('project_id')?"active":""?>"> 
                 <a href='?<?= $project_empty?>'>全部</a> </li>
        <? foreach($projects as $project){ ?>
            <li class="<?= $project['id']==$this->input->get('project_id')?"active":""?>"> 
                 <a href='?<?= $project['url']?>'><?= $project['name_chn']?></a> </li>
        <?} ?>
    </ul>
    <ul class=line> </ul>
    <ul class=head> 城市 </ul>
    <ul class=body>
            <li class="<?= ""==$this->input->get('city_id')?"active":""?>"> 
                 <a href='?<?= $city_empty?>'>全部</a> </li>
        <? foreach($cities as $city){ ?>
            <li class="<?= $city['id']==$this->input->get('city_id')?"active":""?>"> 
                <a href='?<?= $city['url']?>'><?= $city['name_chn']?></a> </li>
        <?} ?>
    </ul>
    <ul class=line> </ul>
    <ul class=head> 故障 </ul>
    <ul class=body>
            <li class="<?= ""==$this->input->get('type')?"active":""?>"> 
                 <a href='?<?= $type_empty?>'>全部</a> </li>
        <? foreach($bug_types as $bug_type){ ?>
            <li class="<?= $bug_type['type']==$this->input->get('type')?"active":""?>"> 
                <a href='?<?= $bug_type['url']?>'><?= $bug_type['name_chn']?></a> </li>
        <?} ?>
    </ul>
</div>


<div style='clear:both;border-bottom:2px solid #933;width:1000px;height:20px'>
</div>

<?= $pagination?>
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
<th> <b>项目</b> </th>
<th> <b>城市</b> </th>
<th> <b>故障站点</b> </th>
<th> <b>故障类型</b> </th>
<th> <b>故障参数</b> </th>
<th> <b>故障开始时间</b> </th>
<th> <b>故障状态</b> </th>
</tr>
</thead>
<tbody>
<?php foreach ($bugs as $bug): ?>
<tr>
<td> <?= $bug['project_name_chn']?> </td>
<td> <?= $bug['city_name_chn']?> </td>
<td> <a href="/backend/station/slist?station_ids=<?= $bug['station_id']?>"  target="_blank"><?= $bug['station_name_chn']?></a> </td>
<td> <?= h_bug_type_name_chn($bug['type'])?>  </td>
<td> <?= $bug['arg']?>  </td>
<td> <?= $bug['start_time']?>  </td>
<td> <?= h_bug_status_name_chn($bug['status'])?>  </td>
</tr>
<?php endforeach?>
</tbody>
</table>
<?= $pagination?>

</div><!--span9 content-->
