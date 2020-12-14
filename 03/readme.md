`minikube addons disable ingress`  

`helm repo add bitnami https://charts.bitnami.com/bitnami`  
`helm repo add stable https://charts.helm.sh/stable`  
`helm repo add prometheus-community https://prometheus-community.github.io/helm-charts`  

`helm repo update`  

`helm install mysql bitnami/mysql -f ./helm/mysql-values.yaml`  
`helm install prom stable/prometheus-operator -f ./helm/prometheus.yaml --atomic`  
`helm install prom prometheus-community/kube-prometheus-stack -f ./helm/prometheus.yaml --atomic`  
`helm install nginx stable/nginx-ingress -f ./helm/nginx-ingress.yaml --atomic`  

wait wait wait  

`kubectl apply -f .`  

`kubectl port-forward service/prom-prometheus-operator-prometheus 9090`  
`kubectl port-forward service/prometheus-operated 9090`  
`kubectl port-forward service/prom-grafana 9000:80`  
логин: admin  
пароль: prom-operator  

`docker run --network=host --rm jordi/ab -k -c 10 -n 10000 http://bit.homework/bitapp/bruhanov/user/1`