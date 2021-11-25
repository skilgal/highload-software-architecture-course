#!/bin/bash

concurrent_users=(10 25 50 100)
tx_commits=(0 1 2)

for tx in "${tx_commits[@]}"; do
    for users in "${concurrent_users[@]}"; do
        echo "tx=$tx and users=$users"
        echo "Set 'innodb_flush_log_at_trx_commit' to $tx"
        mycli db -u root -p password -e "SET GLOBAL innodb_flush_log_at_trx_commit=$tx;"

        siege --time=30s --concurrent=$users "http://localhost:9000/add POST" | grep transact
    done
done
