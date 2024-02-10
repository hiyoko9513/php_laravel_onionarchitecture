## 覚書
laravel jwtのインストール
```shell
$ composer require tymon/jwt-auth
```
config/app.php
```php
'providers' => ServiceProvider::defaultProviders()->merge([
        // 下記を追加
        Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
    ])->toArray(),
```
設定ファイルの生成(config/jwt.php)
```shell
$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
キーの生成
```shell
$ php artisan jwt:secret
```
