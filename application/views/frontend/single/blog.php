<script>
$(function(){ $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'}); })
function change(num){
    switch(num){
        case"1";
        var div=document.getElementById('diary_select');
        div.style.visibility="vistble";
        case "2";
        var div=document.getElementById('diary_select');
        div.style.vistbility="hidden";

    }

}
</script>

<div class=base_center>
   
	 
<style>
    .add_blog_block{width:1000px;}
    .add_blog_block ul{margin:0px;padding:0px;}
    .add_blog_block ul>li{float:left;margin:0px;padding:0px;height:32px;}
    .add_blog_block ul>li.title{line-height:32px;font-size:16px;font-weight:bold;margin:0 10px 0 10px;color:#fff }
    .add_blog_block ul>li.text{line-height:32px;margin:0 10px 0 10px;color:#fff }
    .add_blog_block ul.title{background-color:#666;height:32px;}
    .add_blog_block ul>textarea{width:990px;height:80px;}

</style>

<!--添加日记-->
<div class="add_blog_block">
    <?= form_open("/frontend/single/station_blog_add/".$station['id'],"",""); ?>
    <ul class='title'>
        <li class='title'>
        <font>添加日志</font>
        </li>
        <li class='text'>
	 	<font>日志类型:</font>
        </li>
        <li>
	 	<select id="diary"  onchange="change(this.value);" name="blog_type" style="width:120px;margin:2px;">  
	 			<option name="gz" value="">故障日记</option> 
	 			<option name="wh" value="" selected>维护日记</option>
	 	</select> 
        </li>
        <span id="diary_select">
	 	<?//= h_bug_type_select($this->input->get('type')); ?>
        </span>
	</ul>
    <ul>
        <textarea name="content"></textarea>
	</ul>
	<ul>
	 	<div style="">
	 		<?php echo form_submit("","提交日志"); ?>
	 	</div>	
	</ul>
    <?= form_close(); ?>
</div>

    
<form id="filter" method="get" action="">
<div class='filter'>    
    <input type='hidden' name='station_id' value="<?= $this->input->get('station_id')?>" />
    开始时间:<input type="text" name="start_time" style="width:80px" value="<?= $this->input->get('start_time') ?>"> 
    结束时间:<input type="text" name="stop_time" style="width:80px" value="<?= $this->input->get('stop_time') ?>"> 
    每页显示:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
</div>
<div class='operate'>
    <button type="submit" class="btn btn-primary">确定查询</button> 
    <? if($station){ ?>
        <a href="/frontend/single/blog?station_id=<?= $station['id'] ?>" class="btn btn-primary">清除查询</a>
      <?}else{?>
        <a href="/frontend/single/blog" class="btn btn-primary">清除查询</a>
      <?}?>
</div>
</form>

 
<?= $pagination?>
<table class="table table-striped table-bordered table-condensed">
<thead>
<tr>
	<th>#</th>
	<th>站点名称</th>
	<th>日志内容</th>
	<th>创建时间</th>
	<th>作者</th>
	<th colspan="2">操作</th>
</tr>
</thead>

<tbody>
<?php foreach($blogs as $blog){?>
<tr>
<td> <?= $blog['id'] ?></td>
<td> <?= $blog['station_name_chn']?></td>
<td> <a href="/backend/blog/mod_blog/<?= $blog['id'] ?>" style="color:black;">
	<?php if(mb_strlen($blog['content'])>40){
				echo mb_substr($blog['content'], 0, 40)."... <全文>";
			}else{ echo $blog['content']; }
?></a></td>
<td> <?= $blog['create_time']?></td>
<td> <?= $blog['author_name_chn']?></td>
<td> <a href="#" onclick="confirm_jumping('确定删除日志','/frontend/single/del_blog/<?= $blog['id'] ?>?baseurl=<?= $backurlstr ?>')">删除</a></td>
<td> <a href="/backend/blog/mod_blog/<?= $blog['id']?>?backurl=<?= $backurlstr ?>">编辑</a></td>
</tr>
<?php }?>
</tbody>
</table>
<?= $pagination?>

</div>
