---
author: Dmytro Altsyvanovych
title: 12. Balancing
---

Set up load balancer on nginx that will have 1 server for UK, 2 servers
for US, and 1 server for the rest. In case of failure, it should send
all traffic to backup server. Health check should happen every 5 seconds

# Preparation

1.  Install ngrok \`brew install ngrok/ngrok/ngrok\`
2.  Install chrome extension \`Touch VPN\`

# Test

1.  Set location to US ![us1](resources/us1-server.png)
    ![us2](resources/us2-server.png)
2.  Set location to US but all servers are unavailable
    ![backup-no-available](resources/backup-server.png)
3.  Set VPN for non-defined country
    ![backup-non-defined](resources/backup-no-defined.png)
4.  Set location to UK ![uk](resources/uk-server.png)
5.  Disable VPN ![no-vpn](resources/no-vpn.global.png)
