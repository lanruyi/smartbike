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
                 <a href='?<?= $project['url'] ?>'><?= $project['name_chn']?></a> </li>
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
    <ul class=head> 年份 </ul>
    <ul class=body>
        <? foreach($years as $year){ ?>
            <li class="<?= $year['id'] == $get_year?"active":""?>"> 
                <a href='?<?= $year['url']?>'><?= $year['name_chn']?></a> </li>
        <?} ?>
    </ul>
    <ul class=line> </ul>
    <ul class=head> 月份 </ul>
    <ul class=body>
        <? foreach($months as $key => $month){ ?>
            <li class="<?= $month['id'] == $get_month?"active":""?>">
                <a href='?<?= $month['url']?>'><?= $month['name_chn'] ?></a> </li>
        <?} ?> 
    </ul>
    <ul class=line> </ul>
    <ul class=head> 类型 </ul>
    <ul class=body>
            <li class="<?= ""==$this->input->get('type_id')?"active":""?>"> 
                <a href='?<?= $type_empty?>'>全部</a> </li>
        <? foreach($types as $key => $type){ ?>
            <li class="<?= $type['id'] == $this->input->get('type_id')?"active":""?>">
                <a href='?<?= $type['url']?>'><?= $type['name_chn'] ?></a> </li>
        <?} ?> 
    </ul>
</div>

    <div style='clear:both;border-bottom:2px solid #933;width:1000px;height:20px'>
    </div>

    <div style="clear:both;height:1px;overflow:hidden"></div>

    <div class='chart_title'>
       <ul><?=$get_month?>月故障统计图</ul>
    </div>
    <div style="clear:both;height:1px;overflow:hidden"></div>
    <div style="margin-top:5px;">
        <? if(isset($bug_day_counts)){?>
        <?=  h_draw_bug_month_column($bug_day_counts,$days) ?>
        <?}?>
    </div>

    <div style='clear:both;border-bottom:2px solid #933;width:1000px;height:20px'> </div>

    <table class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
    <th> <b>日期</b> </th>
    <th> <b>故障数量</b> </th>
    <th> <b>故障变化数</b> </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($bugs as $bug): ?>    
    <tr>
    <td> <?= $bug['day']?> </td>
    <td> <?= $bug['count']?> </td>
    <td> <?= $bug['change']?> </td>
    </tr>
    <?php endforeach?>
    </tbody>
    </table>
</div>
