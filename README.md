# target-practice

```sh
php -S 127.0.0.1:8000 index.php
docker run -v $(pwd):/zap/wrk/:rw -t owasp/zap2docker-weekly zap-baseline.py \
  -a -t http://host.docker.internal:8000 -J alerts.json
```
