#!/usr/bin/bash

site="http://127.0.0.1:8090"

#curl -s -H "Accept: application/json" "$site/info?ip=158.101.209.199&o=ip,country_name,city,asn.name"
#curl -s "$site/info?ip=158.101.209.199&o=ip,country_name,city,asn.name&json"
curl -s "$site/info?ip=158.101.209.199&o=ip,country_name,city,asn.name"
