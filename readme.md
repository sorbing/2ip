# HTTP Utils - IP & request checker

## Development

```shell
./dev-serve.sh
./tests/run-tests.sh
```

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

## Deploy on your server

```shell
git clone git://github.com/sorbing/2ip.git .
cp config.example.php config.php
```
