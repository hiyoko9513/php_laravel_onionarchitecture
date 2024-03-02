# infra memo
## php.ini
apiは30~60で十分
```text
max_execution_time = 30
```
## nginx.conf
time out時間設定
```text
proxy_connect_timeout 300s;
proxy_send_timeout 300s;
proxy_read_timeout 300s;
send_timeout 300s;
```
