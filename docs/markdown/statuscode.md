# ステータスコード
## 100番台

- 100 Continue：サーバーがリクエストの最初の部分を受け取り。まだサーバーから拒否されていないことを示す。
- 101 Switching Protocol：プロトコルの切り替えの要求

## 200番台

- 200 OK：リクエストが成功し、本文データが含まれる
- 201 Created：リクエストが成功し、新しいリソースが作成されたことを示す。ヘッダーのロケーションに新しいリソースへのURLを含める。
- 202 Accepted：非同期ジョブを受け付けたことを示す。実際の処理結果はベット受け取る。
- 204 No Content：リスエストは成功したが。レスポンスデータがないことを示す。クライアント側のビューを変更する必要がないことを意味する。

## 300番代(リダイレクト)

- 301 Moved Permanently
- 302 Found
- 303 See Othoer
- 304 Not Modified
- 307 Temporary Redirect
- 308 Permanent Redirect

## 400番台

- 400 Bad Request：その他エラー
- 401 Unauthorized：認証されていない
- 403 Forbidden：リソースに対するアクセス許可されていない
- 404 Not Found：リソースが存在しない
- 409 Conflict：リソースが競合して処理が完了できなかった
- 429 Too Many Requests：アクセス回数が制限回数を超えた為処理できなかった

## 500番台

- 500 Internal Server Error：サーバーサイドでアプリケーションエラーが発生
- 503 Service Unavakiable：サービスが一時的に利用できない。メンテナンス同期や過負荷で応答できないケース
