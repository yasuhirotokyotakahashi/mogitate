# Mogitate（モギタテ）

## アプリケーションURL
- 開発環境:http://localhost/products


## 機能一覧
- 商品一覧表示機能
- 商品検索機能
- 商品詳細表示機能
- 商品登録機能
- 商品更新機能
- 商品削除機能
- シンボリックリンクを使用した画像保存機能
- 季節の複数選択機能
- 並べ替え検索機能

## 使用技術（実行環境）
- フレームワーク：Laravel [8.83.8]
- PHP：[PHPバージョン: 7.4.9]
- データベース：MySQL [8.0.26 - MySQL Community Server - GPL]

## テーブル設計
以下は、主要なデータベーステーブルとそのフィールドの概要です。

| productsテーブル  |  |
|------------|---------|
| id         | PK      |
| name       |         |
| price      |         |
| image      |         |
| description|         |
| created_at |         |
| updated_at |         |

| seasonsテーブル  |  |
|------------|---------|
| id         | PK      |
| name       |         |
| created_at |         |
| updated_at |         |

| product_seasonテーブル  |  |
|------------|---------|
| id         | PK      |
| product_id | FK      |
| season_id  | FK      |
| created_at |         |
| updated_at |         |

## ER図
![もぎたて](https://github.com/yasuhirotokyotakahashi/mogitate/assets/128282431/670a0773-8916-46ce-98e7-2bc4fbd1eff1)


## 環境構築
プロジェクトをローカルで実行するための手順を以下に示します。docker及びdocker-composeは導入済みとします。


```bash
mkdir my-project
cd my-project
```
my-projectの箇所はお好きなディレクトリ名で作成してください。
```bash
git clone　https://github.com/yasuhirotokyotakahashi/mogitate.git
sudo chmod -R 777 *
cd mogitate
```
ここからdockerのビルドから最後まで一気に行います。
```bash
docker compose build
docker compose up -d
docker compose exec php bash

composer install

php artisan migrate
php artisan db:seed

```

##　無事localhost/productsでアクセスできると思います。
php artisan コマンドでエラーが出る際にはdockerを再起動することで修正できるかと思われます。必要に応じて、php artisan storage:linkなどもご使用ください。
