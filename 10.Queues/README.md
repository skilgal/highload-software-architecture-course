---
author: Dmytro Altsyvanovych
title: "10. Queues: Beanstalk, Redis strategies"
---

# Test scenarios

Run the environment

``` shell
docker-compose up -d
```

## Read

``` shell
./test.sh
```

Transaction rates of read operation

  Queue/Concurrency   10     30      50      100
  ------------------- ------ ------- ------- -------
  Beanstalk           2.81   15.85   11.76   11.67
  Redis AOF           6.93   15.85   13.94   12.06
  Redis RDB           7.44   15.85   15.25   12.06
                                             

## Write

``` shell
./test.sh
```

Transaction rates of write operation

  Queue/Concurrency   10      30      50      100
  ------------------- ------- ------- ------- ------
  Beanstalk           12.47   12.84   9.13    8.04
  Redis AOF           3.72    12.94   10.63   8.94
  Redis RDB           4.24    12.53   11.03   9.24
                                              
