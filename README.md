# Laravel rest api onion-architecture

## Dir structure

todo unittest git actions

```text
.
├── app
│   ├── Application // Application層
│   │   ├── Services // domain serviceでは表現出来ないもの
│   │   └── UseCases
│   │       └── Auth
│   │
│   ├── Domain // Domain層
│   │   ├── Models // entity等も全てここ
│   │   │   └── Auth
│   │   └── Repositories // interface
│   │       └── UserRepository.php
│   │
│   ├── Http // Presentation層
│   │   └── Requests // request model
│   │       └── Auth
│   │
│   ├── Infrastructures // Infrastructure層
│   │   └── Repositories // eloquentを使用したDB操作
│   │       └── Auth
│   │
│   └── Util // 言語特有のユーティリティ
└── docs //apiや自動生成docsを配置
```

## First time only

```shell
# コミットルール用
$ make git/commit-template

# laravel用(環境依存有)
$ composer install
$ cp .env.docker.example .env
$ php artisan key:generate
$ php artisan jwt:secret
$ php artisan storage:link
$ sudo chmod -R 775 bootstrap/cache && sudo chmod -R 775 storage
$ sudo chown -R www-data:admin storage && sudo chown -R www-data:admin bootstrap/cache
$ php artisan migrate:fresh --seed
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

## generate er
$ php artisan generate:erd docs/er/diagram.png
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
- [laravel(MailMessage)](./docs/markdown/laravel/mail-message.md)
- api document(postman): ./docs/postman/template.postman_collection.json

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
- api用の例外処理(詳細な例外は返さず汎用的な例外のみを返している。)
- cache etagを使用
- ユーザーステータスのロジック
- factoryとseederのテンプレート
- er図の自動生成(https://github.com/beyondcode/laravel-er-diagram-generator)

## メモ

- strtotimeの使用しない(2038年問題)
- date関数の使用しない(2038年問題)
- mysqlでtimestampの使用しない(2038年問題)
- addMonthの月末使用しない
- 日付フォーマットは規格以外のものを返す(フロントで適宜フォーマットすること)
- 一般公開APIの場合、jsonの命名をsnake_caseに変更する(難しい話)
- paging情報はheaderに格納する
- トークンのリフレッシュタイミングは「75% of token lifetime」
- 環境変数「TRUSTED_PROXIES」：ロードバランサー用

## やりたいこと

- コマンドのテンプレート作成
- スケージュールのテンプレート作成
- ソケットサーバーのテンプレート作成
- ブロードキャストのテンプレート作成
- SSO
- 2FA
- user role
