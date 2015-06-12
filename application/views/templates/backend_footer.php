<div id="back-top" style="right: 50px; bottom: 50px;">
    <a href="#top">
        <span>
            <img src="/static/site/img/gotop.png" />
        </span>
    </a>
</div>
<div class="base_center">
<hr>
    <li style="color:#999;list-style:none"><strong> &copy; 2012 Designed by<a href="mailto:xiangchen.cn@gmail.com"> Airborne</a> </strong> 
        &nbsp;&nbsp; Page use {elapsed_time}S and {memory_usage}</strong> 
    </li>
</div>

</body>

<script>
 $(document).ready(function(){
        $('#create_start_time').datepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            inline: false,
            timezone: '+8000',
            defaultDate: '+0d', <!--------默认时间 +0 为当前时间   +7 为当前时间加7天-------->
            onClose:function(datatimeText,instance){
                window.global_options = $('#start_time').attr("value");
            }
        });
        $('#start_time').attr("value",window.global_options);
    });
        $('#create_stop_time').datepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            inline: false,
            timezone: '+8000',
            defaultDate: '+0d', <!--------默认时间 +0 为当前时间   +7 为当前时间加7天-------->
            onClose:function(datatimeText,instance){
                window.global_options = $('#stop_time').attr("value");
            }
        });
        $('#stop_time').attr("value",window.global_options);
    </script>
</html>
