# Order handling MVP

Used variation of chain-of-responsibility pattern to handle order placement request. 
Handlers should be registered as services in `config/services.yml`
using tag `order_handler` and some `priority`, so they can be sorted.
One of the handlers should mark Order as `handled`, 
otherwise chain runner will throw an exception.

Custom total calculation logic achieved via decorators.

Used BC Math lib for money calculation

## Usage
### Run:
Project is dockerized and can be run with `docker-compose up -d`. 

Nginx service is configured to proxy requests coming on `11080` port. 

Sent emails can be viewed via `mailcatcher` at `http://127.0.0.1:21080`

### API

#### Country list
```shell script
curl http://127.0.0.1:11080/api/countries
```

#### Order list
```shell script
curl http://127.0.0.1:11080/api/orders
```

#### Product list
```shell script
curl http://127.0.0.1:11080/api/products
```

#### Example JSON data for order placement request
```shell script
curl http://127.0.0.1:11080/api/products/example
```


#### Place new order
```shell script
curl -X POST http://127.0.0.1:11080/api/products -d '{
  "countryCode": "FI",               # enum(FI, PL)
  "email": "example@example.com",
  "sendInvoiceViaEmail": true,
  "invoiceFormat": "json",           # enum(json, xml)
  "products": [
    {
      "productId": "1ecd4a4b-cca6-607e-82d0-e1bcc9fbbc99",
      "quantity": 1
    },
    {
      "productId": "1ecd4a4b-ccac-6474-ae16-e1bcc9fbbc99",
      "quantity": 2
    }
  ]
}'
```