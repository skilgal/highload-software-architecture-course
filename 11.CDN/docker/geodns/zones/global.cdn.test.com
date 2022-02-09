; Content for Global views
$ORIGIN .
$TTL 3600       ; 1 hour
cdn.example.com           IN SOA  ns1.example.com. hostmaster.example.com. (
                                2021121120 ; serial
                                900        ; refresh (15 minutes)
                                600        ; retry (10 minutes)
                                86400      ; expire (1 day)
                                3600       ; minimum (1 hour)
                                )
$TTL 0  ; 0 seconds
                        NS      ns1.example.com.
                        NS      ns2.example.com.
$TTL 3600       ; 1 hour
                        A       172.16.238.200
