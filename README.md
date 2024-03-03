# laravel rest api onion-architecture
## First time only
```shell
# コミットルール用
$ make git/commit-template[release-drafter.yml](.github%2Fworkflows%2Frelease-drafter.yml)

# laravel用(環境依存有)
$ composer install
$ cp .env.docker.example .env
$ php artisan key:generate
$ php artisan jwt:secret
$ php artisan storage:link
$ sudo chmod -R 775 bootstrap/cache && sudo chmod -R 775 storage
$ sudo chown -R www-data:admin storage && sudo chown -R www-data:admin bootstrap/cache
$ php artisan migrate:fresh
$ php artisan db:seed --force
```

## When committing
```shell
$ ./vendor/bin/pint
```

## As necessary
```shell
# when code updated
## Model
$ php artisan ide-helper:models --write --reset
## Facade
$ php artisan ide-helper:generate
## Metafile
$ php artisan ide-helper:meta

## clear cache()
$ php artisan optimize:clear
$ composer dump-autoload
```

## Documents
- [Git Commit Rule](./docs/markdown/git-commit.md)
- [jwtの導入覚書](./docs/markdown/jwt-install.md)
- [open api選定](./docs/markdown/about-open-api.md)
- [phpstorm helper](./docs/markdown/phpstorm-helper.md)
- [status code](./docs/markdown/statuscode.md)
- [rest](./docs/markdown/rest.md)
- [release drafter](./docs/markdown/release-drafter.md)
- [api infra memo](./docs/markdown/infra-memo.md)

## やっていること
- timestampの削除(2038年問題)
- emoji prefix
- oasのテンプレート配置
- api化
- jwtのインストール
- アクセスログの追加(request id毎)
- phpstorm helper library(補完用)
- pintの導入
- 日付フォーマット(API規格)
- 不適切なロジックの例外スロー(laravel機能)
- 多言語用のファイルを配置(一部：要カスタマイズ)
- config設定(必要なもののみ)
- プルリクによってリリースノートを作成し、自動バージョニングを行う
- 共通例外処理(validationエラー処理)
- オニオンアーキテクチャ

## 禁忌(覚書)
- strtotimeの使用(2038年問題)
- date関数の使用(2038年問題)
- mysqlでtimestampの使用(2038年問題)
- addMonthの月末使用
- 日付フォーマットは規格以外のものを返す(フロントで適宜フォーマットすること)

## todo
- pint gitaction
- オニオンアーキテクチャのフォルダー構成

## 考慮
- SSO
- 2FA
- unit test(+ about tests mock=>mockery https://www.youtube.com/watch?v=ZSjc2tqUmmI)
- git actions(test...)
- seeder
- maintenance mode
- sanctum
- request headers(accept, referer, X-XSRF-TOKEN)
- user role
- docs generator(https://scramble.dedoc.co, ER)
- write db, read db settings
- envoy(product deploy)
- Migration Guide
- Enforce preflight

## やりたいこと(本gitの趣旨とはかけ離れてしまうけど)
- コマンドのテンプレート作成
- スケージュールのテンプレート作成
- ソケットサーバーのテンプレート作成
- ブロードキャストのテンプレート作成
