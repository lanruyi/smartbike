<style type="text/css">
    .table_info{float:left;width: 180px; margin: 5px 0;padding: 7px 0;border-right: 1px #DCDCDC solid}
    .table_info li{padding: 3px 0 3px 15px}
    .body{float:left}
    .body li{padding: 3px 0 3px 10px}
</style>
<div class="base_center">
    <form id="filter" action="" method="get"> 
      <div class="filter">
          项目:<?= h_station_relative_select_sql('project_id', $projects, $conditions['project_id'], "", 150) ?>
          城市:<span id="city_select"><?= h_station_relative_select_sql('city_id', $cities, $conditions['city_id'], "") ?></span>

          日期:<input class="es_day" name='datetime' type="text"  style="width:68px;height:16px" 
	value=<?= $conditions['datetime']?> />
          报表类型：<?= h_report_time_type_select($conditions['time_type'],null)?>
      </div>
      <div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
      </div> 
   </form>  
       <div style="padding: 10px 0 10px 15px; font-size: 1.2em;font-weight:bold; background-color: #DCDCDC;">
            报表列表
       </div>    
       <div style="margin-bottom:10px;border-top:2px solid #4F79A9; border-bottom:1px solid #4F79A9;height: 120px;display: block">
          <div class ="table_info">
            <lu>
              <li width ="40px">项目:<?= $project_name_chn?></li>
              <li>城市:<?= $city_name_chn?></li>
              <li>日期:<?= $datetime_disp?></li>
              <li>报表类型:<?= $time_type_disp?></li>
              
            </lu>
          </div>    
          <div class="body"> 
           <lu>
              <li><a  href="/reporting/table/summarydata<?= "?".h_url_param_str($conditions)?>">项目分成结算表</a></li>
              <li><a  href="/reporting/table/savpairsdata/<?= $building_type_zhuan?><?= "?".h_url_param_str($conditions)?>">砖墙标杆站节能台账</a></li>
              <li><a  href="/reporting/table/comstationdata/<?= $building_type_zhuan?><?= "?".h_url_param_str($conditions)?>">砖墙普通节能站台账</a></li>
              <li><a  href="/reporting/table/savpairsdata/<?= $building_type_ban?><?= "?".h_url_param_str($conditions)?>">彩钢板标杆站节能台账</a></li>
              <li><a  href="/reporting/table/comstationdata/<?= $building_type_ban?><?= "?".h_url_param_str($conditions)?>">彩钢板普通节能站台账</a></li>
            </lu>
          </div>   
        </div>
    <div style="clear:both;border-top:1px solid #ffffff;width:1000px;height:1px"></div> 
 <script>
window.options = {
        "prj_cities":'<?= $prj_cities ?>',
        "city_id":'<?= $conditions['city_id']?>'
    }

    function project_cities(prj_id){
        //    var cities = jQuery.parseJSON(window.options.prj_cities);
        var cities = eval('('+window.options.prj_cities+')');
        str =  "<select id='city_id' name='city_id' value='"+window.options.city_id+"' style='width:100px;'>";
       // str += "<option value='0'"+(window.options.city_id==0?"selected":"")+">请选择</option>";
        $.each(cities[prj_id],function(i,n){
            str += "<option value='"+i+"'"+(window.options.city_id==i?"selected":"")+">"+n+"</option>";
        });      
        str += "</select>";
        $('#city_select').html(str);
    }

$(document).ready(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/reporting/home/index";
            document.getElementById('filter').submit();
        });
        $('#project_id').change(function(){
            project_cities($(this).attr("value"));
        });
        $('.es_day').datepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            inline: false,
            timezone: '+8000',
            defaultDate: '+7d', 
            onClose:function(datatimeText,instance){
            }
        });
	});
</script>
