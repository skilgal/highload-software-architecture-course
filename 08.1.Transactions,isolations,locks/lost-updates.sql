use db;
SET @@autocommit = 0;

CREATE TABLE `test_table` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `value` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into test_table (value) values (0);

begin; UPDATE test_table SET value=value + 1 WHERE id=1; do sleep (5); commit;

SET GLOBAL TRANSACTION ISOLATION LEVEL READ COMMITTED;
begin;
UPDATE test_table SET value=value + 1 WHERE id=1;
do sleep (5);
commit;

select value from test_table where id = 1;
SELECT IF( (select value from test_table where id = 1) = 2,'true','false') as result;

DROP TABLE test_table;
