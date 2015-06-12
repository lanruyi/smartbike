<?php

include "model.systest.php";

//执行函数
if (!isset($argv[1])) {
    error_report();
} elseif ($argv[1] == 'test') {
    //调用自己的单元测试
    test_test();
}

