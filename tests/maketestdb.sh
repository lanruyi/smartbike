echo "删除原有test数据库..."
mysql -uroot -h127.0.0.1 -e"drop database esdata_test"
mysql -uroot -h127.0.0.1 -e"drop database esarchive_test"
echo "导出最新数据库结构..."
mysqldump --opt -d esdata -uroot -h127.0.0.1 > /tmp/esdatastruct.sql
mysqldump --opt -d esarchive -uroot -h127.0.0.1 > /tmp/esarchivestruct.sql
echo "创建新test数据库..."
mysql -uroot -h127.0.0.1 -e"create database esdata_test"
mysql -uroot -h127.0.0.1 -e"create database esarchive_test"
echo "导入数据库结构..."
mysql -uroot -h127.0.0.1 esdata_test < /tmp/esdatastruct.sql
mysql -uroot -h127.0.0.1 esarchive_test < /tmp/esarchivestruct.sql
