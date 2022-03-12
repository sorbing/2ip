#!/usr/bin/bash

site="http://127.0.0.1:8090"

ip=$(curl -s "$site")

[[ "$ip" == "127.0.0.1" ]] || { echo "Failed getting IP: $ip"; exit 1; }

curl -s "$site/headers"

curl -i -H "Accept: application/json" "$site/info?ip=158.101.209.199&props=country_name,city,asn.name"
