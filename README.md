[![Build Status](https://travis-ci.org/phoro3/php_image_bbs.svg?branch=master)](https://travis-ci.org/phoro3/php_image_bbs)
[![Coverage Status](https://coveralls.io/repos/github/phoro3/php_image_bbs/badge.svg?branch=master)](https://coveralls.io/github/phoro3/php_image_bbs?branch=master)

# 画像つきの掲示板

## 機能
- ユーザーごとのログイン機能
- 画像つきの投稿ができる
- 自分の投稿の編集・削除

## 目的
- Slimに慣れる
- PHPでの画像の扱い方を知る
- Travis CIを使ってみる

## 実行方法
1. DBのセットアップ
DBにログインし、`/conf/db`にあるSQL文を用いてテーブル作成とダミーデータの挿入を行う 

例：PostgresSQLの場合
```
\i create_table.sql
\i insert_dummy.sql
```
