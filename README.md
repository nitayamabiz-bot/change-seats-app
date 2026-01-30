# change-seats-app

教員向け **ランダム席替えアプリ**（PHP / Laravel）。出席番号・視力・「近くにしない」制約を満たし、前回と同一にならない席替えを行い、保存・印刷まで対応します。

- 技術設計: [docs/TECHNICAL_DESIGN.md](docs/TECHNICAL_DESIGN.md)
- 実装 Issue 一覧: [docs/ISSUES_FOR_GITHUB.md](docs/ISSUES_FOR_GITHUB.md)

PHP（Laravel）で **Canon TDD（テスト駆動開発）** に従って開発します。

## 開発の進め方（Canon TDD）

Canon TDD にのみ従います。

- 設計から開発プロセスを作成する **際に** テストシナリオを作成する
- テスト実行して失敗（コードがないため）→ コード作成 → **１個だけ**テスト実施 → 通ればテスト結果を変えずに可能な限りリファクタリング
- 全てのテストシナリオが終われば完了

→ **Issue 着手**: チャットで **`/`** を押し、**issue-work** を選択して Issue 番号を書くと、ブランチ作成〜テストシナリオ〜TDD サイクル〜PR まで進める。詳細: [docs/ISSUE_WORKFLOW.md](docs/ISSUE_WORKFLOW.md)  
→ Canon TDD 詳細: [docs/CANON_TDD_PROCESS.md](docs/CANON_TDD_PROCESS.md) と [.cursor/rules/tdd-workflow.mdc](.cursor/rules/tdd-workflow.mdc)

### Canon TDD 用コマンド

| コマンド | 説明 |
|---------|------|
| `composer test` | 全テスト実行（Red 確認・最終確認用） |
| `php artisan test --filter=メソッド名` / `composer test:one -- フィルタ` | **1 個だけ**テスト実行（Green・Refactor 確認用） |
| `composer test:unit` | Unit テストのみ |
| `composer test:feature` | Feature テストのみ |
| `composer test:coverage` | カバレッジ付き |
| `composer tdd` | TDD Watch（定期的にテスト再実行） |
| `composer pint` | コードスタイル整形 |
| `composer pint:test` | スタイルチェックのみ |

### コードレビュー（GitHub + Claude）

Git のブランチ運用と、Cursor 上の Claude を使ったコードレビュー手順は [docs/CODE_REVIEW_WITH_CLAUDE.md](docs/CODE_REVIEW_WITH_CLAUDE.md) を参照してください。

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
