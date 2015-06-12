<?
echo"<b>1当前所有人被载入的模块及其函数</b>";
echo"<hr>";

echo phpinfo();

$exten_list = get_loaded_extension();

foreach($exten_list as $extension)
{
    echo "$extension<br/>";
    echo "<ul>";
    $ext_func=get_extension_funcs($extension);
    foreach($ext_func as $Func){
        echo "<li>$func</li>";
    }
    echo "</ul>";
}
