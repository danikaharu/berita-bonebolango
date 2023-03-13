<p align="center"><img src="/public/template/home/assets/img/logo_berita.svg" alt="Logo" width="500"></p>

<div align="center">


</div>

## Table of Contents
1. [Requirements](#requirements)
2. [Features](#features)
3. [Setup](#setup)
4. [License](#license)

## Requirements
- Laravel ^9.x - [Laravel 9](https://laravel.com/docs/9.x)
- PHP ^8.1 - [PHP 8.1](https://www.php.net/releases/8.1/en.php)

## Features
- [x] Authentication ([Laravel Fortify](https://laravel.com/docs/9.x/fortify))
    - Login
    - Update profile information 
- [x] Roles and permissions ([Spatie Permissions](https://spatie.be/docs/laravel-permission/v5/introduction))
- [x] CRUD User
- [x] CRUD Article
- [x] CRUD Article Category
- [x] CRUD Gallery
- [x] CRUD Tabloid
- [x] Statistic ([Spatie Laravel Analytics](https://github.com/spatie/laravel-analytics))


## Setup
1. Clone or download from [Releases](https://github.com/danikaharu/berita-bonebolango/releases)
```shell
git clone https://github.com/danikaharu/berita-bonebolango
```

2. Install laravel dependency
```sh
composer install
```

3. Create copy of ```.env```
```sh
cp .env.example .env
```

4. Generate laravel key
```sh
php artisan key:generate
```

5. Set database name and account in ```.env```
```sh
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

6.  Run Laravel migrate and seeder
```sh
php artisan migrate --seed
``` 

7. Create the symbolic link
```sh
php artisan storage:link
``` 

8. Start development server
```sh
php artisan serve
``` 

## License
[MIT License](./LICENSE)
