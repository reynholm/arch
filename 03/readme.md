Убираем ingress, если был установлен как дополнение  
`minikube addons disable ingress`  

Подключаем необходимые helm репозитории  
`helm repo add bitnami https://charts.bitnami.com/bitnami`  
`helm repo add stable https://charts.helm.sh/stable`  
`helm repo add prometheus-community https://prometheus-community.github.io/helm-charts`  

И обновляем индексы  
`helm repo update`  

Устанавливаем prometheus, mysql и ingress (ВНИМАНИЕ! порядок установки важен)  
`helm install prom prometheus-community/kube-prometheus-stack -f ./helm/prometheus.yaml --atomic`  
`helm install mysql bitnami/mysql -f ./helm/mysql-values.yaml`  
`helm install nginx stable/nginx-ingress -f ./helm/nginx-ingress.yaml --atomic`  

Ждем пока все поставится и запустится.  

Запускаем все остальное  
`kubectl apply -f .`  

Включаем перенаправление портов для доступа в web морды Prometheus и Grafana  
`kubectl port-forward service/prometheus-operated 9090`  
`kubectl port-forward service/prom-grafana 9000:80`  
Для Grafana login/password: admin / prom-operator

Для создания нагрузки можно воспользоваться контейнером с Apache Benchmark  
`docker run --network=host --rm jordi/ab -k -c 20 -n 50000 http://bit.homework/bitapp/bruhanov/user/1`  

Конфиг дашборда можно взять тут  
`grafana/dashboard.json`