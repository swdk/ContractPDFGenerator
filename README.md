# ContractPDFGenerator

This a Contract PDf Generator for generating pdf contracts given the names and terms in html file.
Included library from:
https://github.com/barryvdh/laravel-dompdf#installation

## Setting up
git clone "https://github.com/swdk/ContractPDFGenerator"

Remember to change .env.example to .env

```
> composer update
```

```
> composer require barryvdh/laravel-dompdf
```

## Laravel 5.x:

After updating composer, add the ServiceProvider to the providers array in config/app.php

Barryvdh\DomPDF\ServiceProvider::class,
You can optionally use the facade for shorter code. Add this to your facades:

'PDF' => Barryvdh\DomPDF\Facade::class,

```
> php artisan key:generate
```
## Detailed configuration please refer to https://github.com/barryvdh/laravel-dompdf#installation


## Usage
make sure your computer have the fonts for simplified chinese, we used wts11 in this example

```
> php artisan serve
```
In your Browser :
```
> http://localhost:8000/
```
Fill out the contract details <br>
The data in form will be passed to PDFController for generating pdf <br>
The contract will be in folder storage/app <br>

## Signature

```
> http://localhost:8000/remotesigntest
```

Please refer to app/Http/Controllers/phpsdk/test/RemoteSignTest.php for more debugging messages


## Part 1

![Screenshot](1.png)

## Part 2

![Screenshot](2.png)
## Part 3

![Screenshot](3.png)
## Part 4

![Screenshot](4.png)
