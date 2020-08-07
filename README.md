<p align="center">
    <img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400">
    <img src="https://rits.dev/wp-content/themes/rits/assets/imgs/logotipo-2.png" width="300"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>


## Desafio Rits - Desenvolvimento de software, e-commerce e outsourcing de TI
Foi realizado a criação de uma API em laravel e o front em Laravel<br>
Para emular o projeto, basta seguir os requisitos básico do Laravel 7.x, que se encontra no link: https://laravel.com/docs/7.x

Após o clone do projeto, basta entrar no projeto e seguir o procedimento abaixo<br>
<ul>
    <li>executar o comando "composer install"</li>
    <li>npm install</li>
    <li>executar o comando "git clone https://github.com/laradock/laradock.git"</li>
</ul>

Com isso, a API e o front esta pronto para inicializar.<br>
A API utiliza o laradock para instanciar o docker

Para utilizar o Docker na api, entre na pasta laradock e execute o comando "sudo docker-compose up -d nginx mysql phpmyadmin".<br>
OBS: Após o git clone do laradock, deve-se configurar um arquivo .env dentro da pasta laradock, existe um arquivo .env.example para melhor entendimento.



#### Rotas da API

```
+--------+----------+----------------------------------------------------+-------------------------+---------------------------------------------------------+------------+
| Domain | Method   | URI                                                | Name                    | Action                                                  | Middleware |
+--------+----------+----------------------------------------------------+-------------------------+---------------------------------------------------------+------------+
|        | POST     | api/customers/create                               | customers.store         | App\Http\Controllers\CustomerController@store           | api        |
|        | POST     | api/customers/{customerId}/orders                  | customers.orders.all    | App\Http\Controllers\OrderController@allFromCustomer    | api        |
|        | POST     | api/customers/{customerId}/orders/create           | customers.orders.create | App\Http\Controllers\OrderController@storeFromCustomer  | api        |
|        | PUT      | api/customers/{customerId}/orders/{orderId}/cancel | customers.orders.cancel | App\Http\Controllers\OrderController@cancelFromCustomer | api        |
|        | DELETE   | api/customers/{customerId}/orders/{orderId}/delete | customers.orders.delete | App\Http\Controllers\OrderController@deleteFromCustomer | api        |
|        | GET|HEAD | api/customers/{customerId}/orders/{orderId}/show   | customers.orders.show   | App\Http\Controllers\OrderController@showFromCustomer   | api        |
|        | POST     | api/orders                                         |                         | App\Http\Controllers\OrderController@all                | api        |
|        |          |                                                    |                         |                                                         | auth       |
|        | PUT      | api/orders/{orderId}/change-status                 | orders.change           | App\Http\Controllers\OrderController@changeStatus       | api        |
|        |          |                                                    |                         |                                                         | auth       |
|        | DELETE   | api/orders/{orderId}/delete                        | orders.delete           | App\Http\Controllers\OrderController@delete             | api        |
|        |          |                                                    |                         |                                                         | auth       |
|        | POST     | api/products                                       | products.all            | App\Http\Controllers\ProductController@all              | api        |
|        |          |                                                    |                         |                                                         | auth       |
|        | POST     | api/products/create                                | products.store          | App\Http\Controllers\ProductController@store            | api        |
|        |          |                                                    |                         |                                                         | auth       |
|        | PUT      | api/products/update                                | products.update         | App\Http\Controllers\ProductController@update           | api        |
|        |          |                                                    |                         |                                                         | auth       |
|        | GET|HEAD | api/products/{productId}                           | products.show           | App\Http\Controllers\ProductController@show             | api        |
|        |          |                                                    |                         |                                                         | auth       |
|        | DELETE   | api/products/{productId}/delete                    | products.delete         | App\Http\Controllers\ProductController@delete           | api        |
|        |          |                                                    |                         |                                                         | auth       |
+--------+----------+----------------------------------------------------+-------------------------+---------------------------------------------------------+------------+

```


#### Rotas da API
```
+--------+----------+----------------------------------------------------+-------------------------+------------------------------------------------------------------------+------------+
| Domain | Method   | URI                                                | Name                    | Action                                                                 | Middleware |
+--------+----------+----------------------------------------------------+-------------------------+------------------------------------------------------------------------+------------+
|        | GET|HEAD | /                                                  | home                    | App\Http\Controllers\HomeController@index                              | web        |
|        | GET|HEAD | customers/create                                   | web.customers.create    | App\Http\Controllers\CustomerController@webCreateCustomer              | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | POST     | customers/store                                    | web.customers.store     | App\Http\Controllers\CustomerController@webStoreCustomer               | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | DELETE   | customers/{customerId}/delete                      | web.customers.delete    | App\Http\Controllers\CustomerController@webDeleteCustomer              | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | GET|HEAD | customers/{customerId}/edit                        | web.customers.edit      | App\Http\Controllers\CustomerController@webEditCustomer                | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | POST     | customers/{customerId}/update                      | web.customers.update    | App\Http\Controllers\CustomerController@webUpdateCustomer              | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | DELETE   | orders/{orderId}/delete                            | web.orders.delete       | App\Http\Controllers\OrderController@webDeleteProduct                  | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | GET|HEAD | orders/{orderId}/edit                              | web.orders.edit         | App\Http\Controllers\OrderController@webEditProduct                    | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | POST     | orders/{orderId}/status                            | web.orders.status       | App\Http\Controllers\OrderController@webStatusOrder                    | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | POST     | password/confirm                                   |                         | App\Http\Controllers\Auth\ConfirmPasswordController@confirm            | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | GET|HEAD | password/confirm                                   | password.confirm        | App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm    | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | POST     | password/email                                     | password.email          | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web        |
|        | GET|HEAD | password/reset                                     | password.request        | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web        |
|        | POST     | password/reset                                     | password.update         | App\Http\Controllers\Auth\ResetPasswordController@reset                | web        |
|        | GET|HEAD | password/reset/{token}                             | password.reset          | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web        |
|        | GET|HEAD | products/create                                    | web.products.create     | App\Http\Controllers\ProductController@webCreateProduct                | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | POST     | products/store                                     | web.products.store      | App\Http\Controllers\ProductController@webStoreProduct                 | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | DELETE   | products/{productId}/delete                        | web.products.delete     | App\Http\Controllers\ProductController@webDeleteProduct                | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | GET|HEAD | products/{productId}/edit                          | web.products.edit       | App\Http\Controllers\ProductController@webEditProduct                  | web        |
|        |          |                                                    |                         |                                                                        | auth       |
|        | POST     | products/{productId}/update                        | web.products.update     | App\Http\Controllers\ProductController@webUpdateProduct                | web        |
|        |          |                                                    |                         |                                                                        | auth       |
+--------+----------+----------------------------------------------------+-------------------------+------------------------------------------------------------------------+------------+
```
#### TDD
<img src="https://i.imgur.com/OsZWYZy.png">
<br>


## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
