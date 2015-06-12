      <!-- BEGIN Portlet PORTLET-->
      <div class="portlet tabbable">
         <div class="portlet-title">
            <div class="caption"><i class="icon-filter"></i>基站筛选</div>
         </div>
         <div class="portlet-body">


              数据显示工具： 
              <a href="/backend/data?station_id=<?= $this->input->get('station_id')?>&type=recent" 
                   class="<?= $type == "recent"?"a_active":""?>" >
               最新60条数据
              </a> 
              &nbsp;&nbsp;&nbsp;
              <a href="/backend/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_format("now")?>&type=day" 
                   class="<?= $type == "day" && h_dt_start_time_of_day($datetime) == h_dt_start_time_of_day("now") ?"a_active":""?>" >
               当天全部数据
              </a> 
              &nbsp;&nbsp;&nbsp;
              数据压缩:
              <a href="/backend/data?<?= h_set_query_string_param($_SERVER['QUERY_STRING'],"compress",1) ?>"
                   class="<?= $this->input->get("compress") == 1 ?"a_active":""?>" >
               不压缩
              </a> 
              <a class="ajaxify" target="#tab3" href="/newback/ajax/data/18"
                   class="<?= $this->input->get("compress") == 5 ?"a_active":""?>" >
               压缩5倍
              </a> 
              <a href="/backend/data?<?= h_set_query_string_param($_SERVER['QUERY_STRING'],"compress",10) ?>"
                   class="<?= $this->input->get("compress") == 10 ?"a_active":""?>" >
               压缩10倍
              </a> 
               
           </div>

           <div class="es_day" >按时间日期显示:&nbsp;&nbsp;&nbsp;&nbsp;<input name='time' type="text"  style="width:68px;height:16px">
          &nbsp;&nbsp;&nbsp;
          <a href="/backend/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_sub_day($datetime)?>&type=day" >
            往前一天
          </a> 
          &nbsp;&nbsp;&nbsp;
          <a href="/backend/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_add_day($datetime)?>&type=day" >
            往后一天
          </a> 

        <a class="<?= ($type=="day")?"a_active":""?>" 
            href="/backend/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_format($datetime)?>&type=day" >
            全天
        </a>
        
            <? foreach (range(0,23) as $t){?>
            <? $t = sprintf('%02d',$t);?>
                &nbsp;&nbsp;
                <a class=" <?= (h_dt_format($this->input->get('time'),"H") == $t && $type=="hour")?"a_active":""?>" 
                    href="/backend/data?station_id=<?= $this->input->get('station_id')?>&time=<?= h_dt_format($datetime,"Ymd".$t."0000")?>&type=hour" >
                    <?= $t?>:00
                </a>
            <?}?>

         </div>
      </div>

      <table class="table table-bordered table-striped table-condensed flip-content">
         <thead>

            <tr>
                <th colspan=8> <b>温度</b> </td>
                <th colspan=2> <b>湿度</b> </td>
                <th colspan=4> <b>开关</b> </td>
                <th colspan=2> <b>电能</b> </td>
                <th colspan=2> <b>功率</b> </td>
                <th> <b></b> </td>
            </tr>
            <tr>
                <th> <b>室内</b> </td>
                <th> <b>室外</b> </td>
                <th> <b>真实</b> </td>
                <th> <b>空调1</b> </td>
                <th> <b>空调2</b> </td>
                <th> <b>恒温</b> </td>
                <th> <b>恒温1</b> </td>
                <th> <b>恒温2</b> </td>
                <th> <b>内</b> </td>
                <th> <b>外</b> </td>
                <th> <b>风</b> </td>
                <th> <b>空1</b> </td>
                <th> <b>空2</b> </td>
                <th> <b>恒</b> </td>
                <th> <b>总</b> </td>
                <th> <b>dc</b> </td>
                <th> <b>总</b> </td>
                <th> <b>dc</b> </td>
                <th> <b>采样时间</b> </td>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($datas as $data): ?>
            <tr>
               <td> <?= $data['indoor_tmp']?>  </td>
               <td> <?= $data['outdoor_tmp']?>  </td>
               <td> <?= isset($data['true_out_tmp'])?$data['true_out_tmp']:""?>  </td>
               <td> <?= $data['colds_0_tmp']?>  </td>
               <td> <?= $data['colds_1_tmp']?>  </td>
               <td> <?= $data['box_tmp']?>  </td>
               <td> <?= isset($data['box_tmp_1'])?$data['box_tmp_1']:""?>  </td>
               <td> <?= isset($data['box_tmp_2'])?$data['box_tmp_2']:""?>  </td>
               <td> <?= $data['indoor_hum']?>  </td>
               <td> <?= $data['outdoor_hum']?>  </td>
               <td class="<?= $data['fan_0_on']?"success":""?>">   <?= $data['fan_0_on']?>   </td>
               <td class="<?= $data['colds_0_on']?"warning":""?>"> <?= $data['colds_0_on']?> </td>
               <td class="<?= $data['colds_1_on']?"warning":""?>"> <?= $data['colds_1_on']?> </td>
               <td> <?= $data['colds_box_on']?>  </td>
               <td> <?= $data['energy_main']?>  </td>
               <td> <?= $data['energy_dc']?>  </td>
               <td> <?= $data['power_main']?>  </td>
               <td> <?= $data['power_dc']?>  </td>
               <td class="<?= h_compare_dur($data['create_time'],"",10)?"success":"" ?>" style="width:130px"> 
                   <?= $data['create_time']?>  
               </td>
            </tr>
            <?php endforeach?>
            <tr>
               <td>1</td>
               <td class="success">s</td>
               <td class="warning">w</td>
               <td class="danger">d</td>
            </tr>
         </tbody>
      </table>

   </div>
</div>



<style>


.datalist{ border:1px solid #999; background-color:#fff; font-size:12px; width:100%; }
.datalist th{ border:1px solid #666;color:#fff;background-color:#999; font-weight:bold; padding:2px; text-align:center; }
.datalist td{ border:1px solid #666;padding:2px; text-align:center; }

.datalist tr{ background: #fff;} 
.datalist tr:nth-child(2n){ background: #ddd; } 


.datalist td.name_alive{ background: #6f6 }
.datalist td.fan_on_0{  }
.datalist td.fan_on_1{ background: #0f0; }
.datalist td.colds_0_on_0{  }
.datalist td.colds_0_on_1{ background: #f93; }
.datalist td.colds_1_on_0{  }
.datalist td.colds_1_on_1{ background: #9dd; }

.datalist .leftline{ border-left: 2px solid #444; }
.datalist .rightline{ border-right: 2px solid #444; }
</style>

<table class="datalist" >
</table>

