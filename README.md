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
That can be changed in `docker-composer.yml`.

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
Response
```json
{
  "invoiceEntries": [
    {
      "productId": "1ecd4a4b-cca6-607e-82d0-e1bcc9fbbc99",
      "productName": "product 1",
      "quantity": 1,
      "taxRate": "42.26",
      "basePricePerItem": "243.00",
      "taxAmountPerItem": "102.69",
      "basePriceTotal": "243.00",
      "taxAmountTotal": "102.69",
      "total": "345.69"
    },
    {
      "productId": "1ecd4a4b-ccac-6474-ae16-e1bcc9fbbc99",
      "productName": "product 2",
      "quantity": 2,
      "taxRate": "82.39",
      "basePricePerItem": "640.00",
      "taxAmountPerItem": "527.29",
      "basePriceTotal": "1280.00",
      "taxAmountTotal": "1054.59",
      "total": "2334.59"
    }
  ],
  "total": "2680.28",
  "totalTaxAmount": "1157.28",
  "totalBasePrice": "1523.00"
}
```
For  `invoiceFormat:"xml"`:
```xml
<?xml version="1.0"?>
<response>
    <invoiceEntries>
        <productId>1ecd4a4b-cca6-607e-82d0-e1bcc9fbbc99</productId>
        <productName>product 1</productName>
        <quantity>1</quantity>
        <taxRate>42.26</taxRate>
        <basePricePerItem>243.00</basePricePerItem>
        <taxAmountPerItem>102.69</taxAmountPerItem>
        <basePriceTotal>243.00</basePriceTotal>
        <taxAmountTotal>102.69</taxAmountTotal>
        <total>345.69</total>
    </invoiceEntries>
    <invoiceEntries>
        <productId>1ecd4a4b-ccac-6474-ae16-e1bcc9fbbc99</productId>
        <productName>product 2</productName>
        <quantity>2</quantity>
        <taxRate>82.39</taxRate>
        <basePricePerItem>640.00</basePricePerItem>
        <taxAmountPerItem>527.29</taxAmountPerItem>
        <basePriceTotal>1280.00</basePriceTotal>
        <taxAmountTotal>1054.59</taxAmountTotal>
        <total>2334.59</total>
    </invoiceEntries>
    <total>2680.28</total>
    <totalTaxAmount>1157.28</totalTaxAmount>
    <totalBasePrice>1523.00</totalBasePrice>
</response>

```