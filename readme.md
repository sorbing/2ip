# HTTP Utils - IP & request checker

## Usage

```shell
curl 2ip.fun
curl 2ip.fun/headers
curl 2ip.fun/h
curl 2ip.fun/info[?ip=x.x.x.x&o=ip,country_name,city,asn.name&json&key=...] - ipdata.co information
curl 2ip.fun/i
curl -s 2ip.fun/quality[?ip=x.x.x.x&key=...] - ipdata.co + ipqualityscore.com compact information
curl -s 2ip.fun/q

curl 2ip.fun/help
```

## TODO

```shell
curl 2ip.fun/bl/x.x.x.x | blacklist/x.x.x.x << https://www.s-sols.com/ru/setup-own-mail-server#whitelist
curl 2ip.fun/scan|nmap|ports
```

## Development

```shell
./dev-serve.sh
./tests/run-test-all.sh
./tests/run-test-h.sh
```

## Deploy on your server

```shell
git clone git://github.com/sorbing/2ip.git .
cp config.example.php config.php
```
