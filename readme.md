# HTTP Utils - IP & request checker

## Development

```shell
./dev-serve.sh
./tests/run-tests.sh
```

## Usage

```shell
curl 2ip.fun
curl 2ip.fun/header
curl -s 2ip.fun/info[?ip=x.x.x.x&o=ip,country_name,city,asn.name&json&key=...] - ipdata.co information
curl -s 2ip.fun/quality[?ip=x.x.x.x&key=...] - ipdata.co + ipqualityscore.com compact information
```
