# phpstorm helperコード補完
## install
```shell
$ composer require --dev barryvdh/laravel-ide-helper
```

## 補完コード生成
```shell
# Model
$ php artisan ide-helper:models --write --reset
# Facade
$ php artisan ide-helper:generate
# メタファイル
$ php artisan ide-helper:meta
```

## 自動生成ファイル
```text
_ide_helper.php
_ide_helper_models.php
.phpstorm.meta.php
```
