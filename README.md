# Stock management

a small project to handle stock of products and recieps

## Table of Contents

- [Technologies Used](#technologies-used)
- [API Requests](#api-requests)

### Technologies Used
-Client side : Vue js 3, TailwindCss
-Server side : Laravel

### Project Structer 
In the project i've used a pattern called Actions in Action, that follow the next flow route->controller->action.
The advantage of this structer is to avoid the "Monster class"... .  
if you are intrested in this pattern you can find more info in this blog : 
[Blog link](https://martinjoo.dev/domain-driven-design-with-laravel-actions-in-action)

## API Requests

| Method    | Endpoint     | Description                |
| :-------- | :------- | :------------------------- |
| `GET` | `http://127.0.0.1:8000/api/products` | **GetAllProducts** |
| `PUT` | `http://127.0.0.1:8000/api/products/:id` | **AddDetailsToProductsInDB**|
| `GET` | `http://127.0.0.1:8000/api/recipes` | **GetAllRecieps**|
| `POST` | `http://127.0.0.1:8000/api/recipes/:id` | **StoreReciepeWithProducts**|


