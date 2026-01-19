# coachtechフリマ

## 概要
coachtechフリマは、ユーザーが商品を出品・購入できるフリマアプリです。会員登録、ログイン、商品出品、購入、コメント、いいね機能を備えており、メール認証には Mailhog を使用しています。

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:shiori-nampo/coachtech-flea-market.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

> *MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください*
``` bash
mysql:
    platform: linux/x86_64
    image: mysql:8.0.26
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=flea_db
DB_USERNAME=flea_user
DB_PASSWORD=flea_pass
```
5. アプリケーションキーの作成
```bash
php artisan key:generate
```

6. マイグレーションの実行
```bash
php artisan migrate
```

7. ストレージリンクの作成
```bash
php artisan storage:link
```

8. 初期データ投入
```bash
php artisan db:seed
```

## 使用技術(実行環境)
- Docker / Docker Compose
- PHP8.1.33
- Laravel8.83.29
- MySQL8.0.44
- MailHog(メール認証用)

## ER図
![doc](er_diagram.png)

## URL
- 開発環境:http://localhost:8000/
- phpMyAdmin:http://localhost:8080
- MailHog:http://localhost:8025

## メール認証(MailHog)
.envに以下を追加してください

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="coachtech-flea-market"

※ 認証メールは MailHog(http://localhost:8025)で確認できます。

## ログイン情報

### 管理者ユーザー
本アプリでは管理者ユーザーは存在せず、すべて一般ユーザーとして利用します。

動作確認は、新規ユーザー登録を行なってください。

