# Rahatlatıcı Müzikler Uygulaması

Uygulama İçeriği:
  - check servisi ile force_update veya soft_update
  - login servisi ile token oluşturma
  - register servisi ile üyelik oluşturma
  - category servisi ile içerik listeleme
  - favorite servisi ile favori ekleme veya favori kaldırma

Gereksinimler:
> docker-compose version 1.25.4
> PHP 7.2.28

### Kurulum
```sh
$ git clone https://github.com/burakerenel/TeknasyonApi
$ cd TeknasyonApi
$ cd src && cp .env.example .env && composer update
$ chmod -R 777 storage && chmod -R 777 bootstrap/cache
```

.env dosyası düzenlenmesi gereken alan
> DB_HOST=DockerLocalIp
> DB_PORT=3306
> DB_DATABASE=homestead
> DB_USERNAME=homestead
> DB_PASSWORD=secret


.env dosyası düzenlendikten sonra database migrate edilmesi gereklidir.
```sh
$ cd ..
$ docker-compose build && docker-compose up -d
$ cd src
$ php artisan key:generate
$ php artisan migrate
$ php artisan passport:install
```

---------------------------------------------------------------------

### Servisler

-register servisi ile kullanıcı oluşturulmalıdır.
-login servisi ile client token oluşturuluyor.
-middleware korumalı sayfalara Header Authorization: Bearer token olarak gönderilmelidir.
