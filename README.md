# Laravel rest api onion-architecture
## Dir structure
固有もの
```text
.
├── app
│   ├── Application // アプリケーション層
│   │   └── Services
│   │       └── Auth
│   ├── Domain // ドメイン層
│   │   ├── Models
│   │   │   └── Auth
│   │   └── Repositories
│   │       └── UserRepository.php
│   ├── Http // UI層
│   │   └── Requests // リクエストモデル
│   │       └── Auth
│   ├── Infrastructures // インフラ層(永続化)
│   │   └── Repositories
│   │       └── Auth
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
- [laravel(MailMessage)](./docs/markdown/laravel/mail-message.md)

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

## 考慮
- loginとrefreshで返しているラストログインフォーマットが異なる
- リフレッシュトークンとアクセストークン
- date header gmtが入っている
- user status(login etc...)
- seeder factories()
- request headers(accept, referer, X-XSRF-TOKEN)
- envoy(product deploy)
- Enforce preflight
- sanctum
- docs generator(https://scramble.dedoc.co, ER)
- unit test(+ about tests mock=>mockery https://www.youtube.com/watch?v=ZSjc2tqUmmI)
- git actions(test...)

キャッシュの情報をレスポンスヘッダに入れよう

HTTP にはキャッシュのための機構が用意されています。API 開発者は、レスポンスにいくつかのヘッダを含め、リクエストのヘッダをバリデーションするだけで、キャッシュの恩恵に与れます。

これについて、ETag を使うやり方と Last-Modified を使うやり方があります。

ETag

レスポンスを送る際に、レスポンス内容のハッシュかチェックサムを ETag ヘッダに含めます。つまりこのヘッダは、レスポンス内容に変更があった際に変わるものとなります。これを受け取ったクライアントは、レスポンス内容をキャッシュしつつ、今後同一 URL のリクエストを投げる際に、ETag の内容を If-None-Match ヘッダに含めるようにします。API は、ETag 値と If-None-Match の内容が一致していれば、レスポンス内容の代わりに 304 Not Modified というステータスコードを返します。

Last-Modified

これは基本的には ETag と同様の概念ですが、タイムスタンプを使う点が異なります。Last-Modified ヘッダには RFC 1123 で提案された形式の日時データが含まれていて、これを If-Modified-Since ヘッダの内容と比較することでキャッシュを制御します。注意点としては、HTTP の仕様では3つの異なる日時形式が定義されていて、API サーバはそのいずれの形式でも許容できるようにする考慮する必要があるということです。

## やりたいこと
- コマンドのテンプレート作成
- スケージュールのテンプレート作成
- ソケットサーバーのテンプレート作成
- ブロードキャストのテンプレート作成
- SSO
- 2FA
- user role
