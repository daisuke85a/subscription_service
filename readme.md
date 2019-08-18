# プロジェクトについて
## 概要
3人チームで架空の有料webサービス制作した    
<a href="https://note.mu/muchoco/n/n8adced84de9c">むちょこ道場</a>のチーム開発課題  

## 要件 
* 月額1000円, 3000円, 5000円の3つのプラン
* 自動請求機能（stripeのテスト環境を利用）
* アカウント認証機能（プランの管理を含む）
  * ユーザ登録（メールアドレス、パスワード）
  * ログイン、ログアウト
  * 退会
  * ログイン後、本人の契約中プランを表示
  * その他、パスワードリセット機能等はあってもなくてもOK
* ユーザ一覧が閲覧できる管理画面
  * 管理ユーザーのみが表示できる
  * 表示するのは、ID,メールアドレス、プラン、ステータス（有効/無効）、作成日時、更新日時
* 好きなフレームワークを使ってOK
* なるべくテストを書いてください（推奨）
* わかりやすい資料は<a href="https://docs.google.com/presentation/d/14292HhO-bvdtNf2idg2phZQiuSs33NTPLl2LZ-3cyzM/edit#slide=id.p">こちら</a>

## チームで追加した詳細仕様 
提示された要件に足りない仕様をチームで補完した。  
### 通常フロー
1. 管理ユーザー登録済みの場合は、月額1000円, 3000円, 5000円の3つのプランを表示する
2. ユーザーがプランを選択すると、ユーザ登録画面を表示する
3. ユーザーがユーザ登録すると、クレジットカード番号入力画面を表示する
4. ユーザーがクレジットカード番号を入力すると、Stripeに課金登録される
5. Stripeに課金登録が完了すると、登楼した課金プラン、退会ボタンを表示する。

### 退会フロー
1. 課金登録済みのユーザーがログインする
2. システムが課金プラン、退会ボタンを表示する。
3. ユーザーが退会ボタンを押すと、Stripeに課金停止を請求する
4. Stripeへの課金停止処理が完了すると、退会済み画面を表示する
5. 退会済みの状態表示と、再入会用に月額1000円, 3000円, 5000円の3つのプランを表示する

### 再入会フロー
1. 課金未登録ユーザーがログインする
2. 退会済みの状態表示と、再入会用に月額1000円, 3000円, 5000円の3つのプランを表示する
3. プラン選択後のフローは通常フローと同様

### 管理ユーザーのフロー
1. 管理ユーザー未登録の場合は、管理ユーザー登録画面を表示する
2. 管理ユーザはユーザー管理画面のみ開けることとする
 

## 検証環境  
* PHP7.3.1
* MySQL8.0.14
* Google Chrome最新バージョン

## 期間
* 2019/08/13 PM 10:00 〜 2019/08/19 AM 09:00

## 開発環境の構築手順
1. $ git clone https://github.com/daisuke85a/subscription_service.git subscription_service  
2. $ cd ./subscription_service
3. $ composer install
4. $ cp .env.example .env
5. $ php artisan key:generate
6. .envファイルを以下に書き換える  
   1. DB_DATABASE=subscription_service
   2. STRIPE_KEY=Stripeで発行するキーコード
   3. STRIPE_SECRET=Stripeで発行するシークレットキー
7. mysql > create database subscription_service CHARACTER SET utf8mb4;  
8. $ php artisan migrate
9. $ php artisan serve

(追記)
テストを行う場合、.env.testingファイルの以下をお使いの環境に合わせて書き換える。
DB_HOST=127.0.0.1
DB_PORT=8889 
DB_DATABASE=subscription_service_testing
DB_USERNAME=root
DB_PASSWORD=root

## チームメンバーと役割
* だいすけ <a href="https://github.com/daisuke85a">GitHub</a> <a href="https://twitter.com/daisuke7924">Twitter</a> 
  * 要件定義の補完
  * マネジメント
    * チームのGitリポジトリの管理
    * 全体の進捗を把握し、期限に間に合うように調整する
    * プロジェクトのGit Flowの定義
  * 技術リード
    * アーキテクチャー選定
    * 全体の画面遷移図作成
      * パスと対応する画面を定義
    * View,Controller,Modelの責務分掌や大まかな設計の策定
    * Pull Requestの承認
  * 担当機能
    * 自動請求機能（stripeのテスト環境を利用）
    * アカウント認証機能
      * 退会
      * ログイン後、本人の契約中プランを表示
      * 再入会（追加した仕様）
* Danri <a href="https://github.com/Danri0817">GitHub</a> <a href="https://twitter.com/Danri_">Twitter</a> 
  * 担当機能
    * ルートパスにアクセスした時状態に応じて画面遷移する
* るー <a href="https://github.com/prostarting">GitHub</a> <a href="https://twitter.com/ru_programing">Twitter</a>
  * 担当機能
    * アカウント認証機能
      * ログイン、ログアウト
    * 管理画面
      * 一般ユーザー、管理ユーザーの管理
      * 管理画面表示表示
  
## アーキテクチャー
* Laravel ver5.5を採用
  * 理由：当初はLaravel ver5.8での開発を試みたがスキル不足で諦めた  
  * 対応するLaravel Cashierのバージョンの仕様が調べづらく、キャッチアップできなかった。

## スケジュール
* GitHubのリポジトリを作る（だいすけ）
  * 〜8/13
* 詳細仕様、全体設計、役割分担を決める
  * 8/14 21:00〜22:00 ZOOMで話す
* それぞれが実装する
  * 8/14 22:00〜8/16 21:00　２日
* それぞれの実装をマージする
  * 8/16 21:00〜8/17 21:00　１日
* 17日（土）のクラウド会議で、チームメイトが書いたコードを解説（できたらレビューも）する。
  * 他人が書いたコードを読む力
  * 他人が読みやすいコードを書く力  
* 動作確認し動かない部分を直す 8/17 21:00〜 8/18 21:00　１日
* 余裕があったらテストコードを書く。
* 提出 8/18 21:00にだす
  * 期限は8/19 09:00だがバッファをとる

## Gitのルール
* GitHub上のMaster/Developへのpushは禁止
* ローカル環境で最新のDevelopからgit branchしてfeature/adminのような自分専用のブランチを作ろう
* 自分専用のブランチにpushすること。
* Developに取り入れたくなったら、GitHub上でPullRequestの操作をする
  * 競合していた場合は解消してからPullRequestしてほしい。（解消が難しい場合は要相談）

# 以下はLaravelの情報

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Pulse Storm](http://www.pulsestorm.net/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
