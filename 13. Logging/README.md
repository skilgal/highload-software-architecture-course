## MySQL (slow_query_log)  FileBeat +  ElasticSearch + Kibana 


# Start

```
docker-compose up -d
```

# Connect to database 

 - slow query log configuration [Slow log в MySQL](https://ruhighload.com/%D0%9A%D0%B0%D0%BA+%D0%B2%D0%BA%D0%BB%D1%8E%D1%87%D0%B8%D1%82%D1%8C+slow+log+%D0%B2+mysql%3F)
 
```
mycli -u root -p <root_password_from_config>
>> SET GLOBAL slow_query_log = 'ON';
>> Select sleep(4);
```

# MySql logs

```
tail -f ./db/logs/mysql-slow.log
```

#Kibana

 - Display slow query log 
 
 ![Slow Logs](./pictures/slow-logs-kibana.png) 
