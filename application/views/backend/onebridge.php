<div class=base_center>

        <? $this->load->view("backend/onestation",array('station'=>$station))?>

        <style>
            
            input{ width: 100%;}
            textarea{ width: 100%;}
             
        </style>

        <div>
            <a href="?a=0"> 默认 </a>
            <a href="?a=1"> 测试全空 </a>
            <a href="?a=2"> 结束命令 </a>
            <a href="?a=3"> 上传设置和属性 </a>
            <a href="?a=4"> 上传报警 </a>
            <a href="?a=5"> 上传报警关闭 </a>
        </div>

        <form name="commandform">
            <b>Url:</b>
            <input name="commandurl" value="/s?debug" />
            <div id="buttons">
                <button type="button" onclick="getHTML('GET')">GET</button>
                <button type="button" onclick="getHTML('POST')">POST</button>
            </div>
            <b>Message Body:</b>
            <textarea name="messagebody" rows="3" ><?= $body ?></textarea>
            <b>Command Response:</b>
            <textarea name="response" rows="3" ></textarea>
            <b>Command Response page:</b>
            <div id="response_page" style="height:400px;overflow:auto;border:1px solid #000">
            </div>
        </form>

</div>

<script language="JavaScript">
function getHTML(command)
{
    if (window.XMLHttpRequest)
    {
        var http = new XMLHttpRequest();
        http.open(command, document.commandform.commandurl.value, true);
        var postdata = document.commandform.messagebody.value;
        if(command === "POST"){
            http.setRequestHeader("Content-length", postdata.length);
            http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        }
        http.send(postdata);

        http.onreadystatechange = function()
        {
            if(http.readyState == 4)
            {
                if(http.status==200)
                {
                    document.getElementById("response_page").innerHTML = http.responseText;
                    document.commandform.response.value=http.responseText
                }
                else
                {
                    document.commandform.response.value="Error "+http.status
                }
            }
        }
    }
    return false;
}
</script>
