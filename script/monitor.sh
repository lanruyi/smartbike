#!/bin/sh
#   NAME: monitor.sh
# 
#	purpose:
# 		monitor
#	usage:
#		1. Please copy this file to  /etc/init.d/  
#		2. make this file executable  chmod 777 monitor.sh
#		3. add a line to  the last line of /etc/init.d/rcS
#			/etc/init.d/monitor.sh $
#		4. Please set how often you will check the svm by check_time 
#	Note:
#		N/A
#	Author: chuanqi.zheng@airborne-es.com.cn 
#	2012-4-26   V1.0	created	
#	2012-5-28   v1.2    add new_kits lauch process
#
# ------------------------------------------------

dir=/home/AB/BS
svm_name=svm
kits_name=kits.scode
new_kits_name=new_kits.scode
app_name=app.sab
new_app_name=new_app.sab
check_time=120 # 2min
wait_new_rom_time=1800 # 30min

#where the log path you want to place
#DATE='date +%Y%m%d%h'

#First, launch the SVM
while [ true ] 
do

#判断是否要启动new_kits
if [ -e $dir/$new_kits_name ]
then
    killall -9 $svm_name 
    $dir/$svm_name  $dir/$new_kits_name $dir/$app_name >/dev/null &
    sleep $wait_new_rom_time
    #杀掉新的rom 再次启动老的rom （如果oss已经确认更新，老的rom就是新的rom）
    killall -9 $svm_name 
    $dir/$svm_name  $dir/$kits_name $dir/$app_name >/dev/null &
fi

#进程守护
PROCESS_NUM=`ps -w | grep "$svm_name" | grep -v "grep" | wc -l`
if [ $PROCESS_NUM -eq 1 ]
then
	echo "Sedona VM already gets running!"
else
	echo "The VM is not running. Now getting Sedona VM running..." 
    killall -9 $svm_name 
    $dir/$svm_name  $dir/$kits_name $dir/$app_name >/dev/null &
	  {    
		echo date  #显示日期                                              
        echo "Sedona VM get running!"
      } >> $dir/monitor_log_$(date  '+%Y%m%d_%H').txt
fi
sleep $check_time
done

