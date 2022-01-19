# Task

1.  Set up MySQL Cluster
    1.  Create 3 docker containers: \`mysql-master\`,
        \`mysql-slave-biba\`, \`mysql-slave-boba\`
    2.  Setup master slave replication (Master: mysql-m, Slave:
        mysql-s1, mysql-s2)
2.  Write script that will frequently write data to database
3.  Ensure, that replication is working
4.  Try to turn off mysql-s1,
5.  Try to remove a column in database on slave node
    1.  Remove random column
    2.  Remove the last one column

# Steps

``` {.shell session="db"}
function d_mysql() {
    COMMAND='export MYSQL_PWD=111; mysql -u root -D mydb -e "'$2'"'
    docker exec $1 sh -c $COMMAND;
}

export SELECT_CMD="select count(*) from tasks;"

```

## Set up MySQL cluster

Pass all steps from docker [readme](master-slave.md), I took base
project from
[GitHub](https://github.com/vbabak/docker-mysql-master-slave)

``` shell
./build
```

## Write script that will frequently write data to database

Create \`Tasks\` database table

``` {.bash session="db"}
docker exec mysql_master sh -c 'export MYSQL_PWD=111; mysql -u root -D mydb -e "CREATE TABLE IF NOT EXISTS tasks (task_id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, description TEXT)  ENGINE=INNODB;" '

```

Run permanent insertion

``` {.bash session="db"}
while :
do
    d_mysql mysql_master "insert into tasks (title, description) values ('title', 'description');"
    sleep 2
done

```

## Ensure, that replication is working

``` {.shell session="db"}
# check count on the master docker
d_mysql mysql_master $SELECT_CMD
sleep 5

# check count on the slave biba docker
d_mysql mysql_slave_biba $SELECT_CMD
sleep 5

# check count on the slave boba docker
d_mysql mysql_slave_boba $SELECT_CMD
sleep 5

```

With results

``` shell
╰─$ d_mysql mysql_master $SELECT_CMD

count(*)
454

╰─$ d_mysql mysql_slave_biba $SELECT_CMD
count(*)
465

╰─$ d_mysql mysql_slave_boba $SELECT_CMD

count(*)
467

```

## Try to turn off \`mysql~slavebiba~\`

``` shell
docker-compose stop mysql_slave_biba

```

``` shell
sql_slave_biba    | 2022-01-19T20:36:12.050468Z 0 [Note] InnoDB: Removed temporary tablespace data file: "ibtmp1"
mysql_slave_biba    | 2022-01-19T20:36:12.050544Z 0 [Note] Shutting down plugin 'MEMORY'
mysql_slave_biba    | 2022-01-19T20:36:12.050567Z 0 [Note] Shutting down plugin 'CSV'
mysql_slave_biba    | 2022-01-19T20:36:12.050581Z 0 [Note] Shutting down plugin 'sha256_password'
mysql_slave_biba    | 2022-01-19T20:36:12.050595Z 0 [Note] Shutting down plugin 'mysql_native_password'
mysql_slave_biba    | 2022-01-19T20:36:12.053403Z 0 [Note] Shutting down plugin 'binlog'
mysql_slave_biba    | 2022-01-19T20:36:12.134310Z 0 [Note] mysqld: Shutdown complete
mysql_slave_biba    |
mysql_slave_biba exited with code 0
mysql_master        | 2022-01-19T20:36:13.040274Z 5 [Note] Aborted connection 5 to db: 'unconnected' user: 'mydb_slave_user' host: '10.10.193.4' (failed on flush_net())
```

``` {.shell session="db"}
# check count on the master docker
d_mysql mysql_master $SELECT_CMD
sleep 5

# check count on the slave biba docker
d_mysql mysql_slave_biba $SELECT_CMD
sleep 5

# check count on the slave boba docker
d_mysql mysql_slave_boba $SELECT_CMD
sleep 5

```

``` shell
count(*)
953
Error response from daemon: Container 777fda1f8fd4fe307303223bc4ea096d5676c9d0f023a5d305473e99c36ab744 is not running
count(*)
958

```

## Try to remove a column in database on slave node

### Remove random column

``` shell
d_mysql mysql_master "ALTER TABLE tasks DROP COLUMN title;"

```

Run permanent insertion without \`title\` field

\`\`\`

while : do d~mysql~ mysql~master~ \"insert into tasks (description)
values (\\\"description~v2~\\\");\" sleep 2 done \`\`\`

### Remove the last one column [NO~ISSUES~]{.underline}

1.  Find the last column

``` {.shell session="db"}
d_mysql mysql_master "DESC tasks;"
```

╰─\$ d~mysql~ mysql~master~ \"desc tasks;\"

  ------------- -------------- ------ ----- --------- -----------------
  Field         Type           Null   Key   Default   Extra
  task~id~      int(11)        NO     PRI   NULL      auto~increment~
  title         varchar(255)   NO           NULL      
  description   text           YES          NULL      
  ------------- -------------- ------ ----- --------- -----------------

1.  Remove last column \`description\`

    ``` shell
    d_mysql mysql_master "ALTER TABLE tasks DROP COLUMN description;"
    ```

2.  Run permanent insertion without \`description\` field

Run permanent insertion without \`description\` field

``` {.bash session="db"}
while :
do
    d_mysql mysql_master "insert into tasks (title) values (\"title_v2\");"
    sleep 2
done

```
