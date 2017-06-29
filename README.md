# ContractPDFGenerator

This a Contract PDf Generator for generating pdf contracts given the names and terms in html file.
Included library from:
https://github.com/barryvdh/laravel-dompdf#installation

#Setting up
git clone "https://github.com/swdk/ContractPDFGenerator"

Remember to change .env.example to .env


composer update
composer require barryvdh/laravel-dompdf


#Laravel 5.x:

After updating composer, add the ServiceProvider to the providers array in config/app.php

Barryvdh\DomPDF\ServiceProvider::class,
You can optionally use the facade for shorter code. Add this to your facades:

'PDF' => Barryvdh\DomPDF\Facade::class,
#Lumen:

After updating composer add the following lines to register provider in bootstrap/app.php

$app->register(\Barryvdh\DomPDF\ServiceProvider::class);
To change the configuration, copy the config file to your config folder and enable it in bootstrap/app.php:

$app->configure('dompdf');

php artisan key:generate

#Detailed configuration please refer to https://github.com/barryvdh/laravel-dompdf#installation


#Usage
php artisan serve
localhost

http://localhost:8000/form
The data in form will be passed to PDFController for generating pdf
The form will be in folder storage/app
