# target-practice

```sh
php -S 127.0.0.1:8000
docker run -v $(pwd):/zap/wrk/:rw -t owasp/zap2docker-stable zap-baseline.py \
  -a -t http://host.docker.internal:8000 -J alerts.json
```
