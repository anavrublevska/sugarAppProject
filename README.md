<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Dziennik posiłków

Dziennik posiłków to system dla osób z cukrzycą, wspomagający kontrolę takich procesów jak:
- prowadzenie historii posiłków
- odnotowanie dawki insuliny na posiłek
- analiza zmian poziomu cukru
- obliczanie wartości odżywczych posiłków
- odnotowanie miejsc podania insuliny

## Instalacja

Sklonuj projekt z repozytorium. Zainstaluj pakiety **(composer install)**. Ustaw odpowiednie wartości w pliku `.env` wzorując się na pliku `.env.example`.

Wygeneruj klucz aplikacji poleceniem **(php artisan key:generate)**

Wykonaj migracje **(php artisan migrate)** oraz uruchom seedy **(php artisan db:seed)**. Seedy utworzą 2 użytkowników oraz listę produktów dostępnych dla wszystkich użytkowników.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
