<div class=row-fluid>
<div class="span12">


<?php 
$attributes = array("class"=>"fake_data");
$hidden = array();
echo form_open("/sysm/home/insert_fake_data",$attributes,$hidden); ?>

    <ul>start time: <?php echo form_input("name_chn"); ?> </ul>
    <ul>stop time: <?php echo form_input("name_py"); ?> </ul>
    <ul><?php echo form_submit("","submit"); ?> </ul>
    
<?php echo form_close(); ?>

<a href="#">add</a>

</div><!--span9 content-->
