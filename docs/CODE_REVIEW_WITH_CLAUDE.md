# GitHub と Claude（Cursor）を使ったコードレビュー

このドキュメントでは、change-seats-app で **Git のブランチ運用** と **Cursor 上の Claude を使ったコードレビュー** の手順をまとめます。

## 前提

- GitHub アカウントあり
- リポジトリ名: `change-seats-app`
- ローカルでは Cursor を使用し、AI（Claude）でレビューを依頼する想定

---

## 1. Git リポジトリの初期設定

```bash
cd /path/to/change-seats-app
git init
git add .
git commit -m "Initial Laravel project with TDD setup"
git branch -M main
git remote add origin https://github.com/<あなたのユーザー名>/change-seats-app.git
git push -u origin main
```

GitHub で **change-seats-app** リポジトリをあらかじめ作成しておいてください（README なしで OK）。

---

## 2. 開発フロー（ブランチ運用）

1. **main** は常に「テスト・Pint が通っている状態」に保つ
2. 機能・修正ごとに **ブランチを切る**
   - 例: `feature/seat-change`, `fix/login-validation`
3. ブランチで開発 → **テストと Pint をローカルで通す**
4. **main にマージ** する前に、Cursor で Claude にコードレビューを依頼する（下記）
5. 問題なければ main にマージ（PR を使う場合は GitHub 上でマージ）

### ブランチの例

```bash
git checkout -b feature/seat-change
# 開発・テスト・Pint
composer test
composer pint:test
git add .
git commit -m "feat: 席替え機能の土台を追加"
git push -u origin feature/seat-change
```

---

## 3. Cursor（Claude）でコードレビューする方法

GitHub 単体には「Claude が自動でレビューする」機能はありません。  
**Cursor 上で Claude に「差分をレビューして」と依頼する**運用を推奨します。

### 方法 A: 差分をそのまま貼ってレビュー依頼

1. ターミナルで `git diff main` を実行し、変更内容をコピーする
2. Cursor のチャットで次のように依頼する:
   - 「この差分をコードレビューしてください。TDD と PHP/Laravel のルールに沿っているか、セキュリティや可読性も見てください。」
3. 差分を貼り付ける（または `@` でファイルを指定）
4. 指摘を反映してからコミット・プッシュ

### 方法 B: ファイル指定でレビュー依頼

1. 変更したファイルを Cursor で開く
2. チャットで `@ファイル名` を指定して:
   - 「このファイル（またはこのPRの変更）をコードレビューしてください」
3. `.cursor/rules` の TDD・PHP/Laravel ルールがコンテキストに入るので、それに沿った指摘を求められる

### 方法 C: PR の差分を GitHub からコピー

1. GitHub で Pull Request を作成
2. 「Files changed」の内容をコピー
3. Cursor チャットに貼り付けて「この PR をレビューしてください」と依頼

---

## 4. マージ前チェックリスト

- [ ] `composer test` が通る
- [ ] `composer pint:test` が通る（必要なら `composer pint` で整形）
- [ ] Cursor（Claude）でコードレビューを依頼し、指摘を反映した
- [ ] コミットメッセージが分かりやすい（例: `feat: 〇〇を追加`, `fix: △△を修正`）

---

## 5. （任意）GitHub でブランチ保護と CI

- **Branch protection**: `main` に対して「PR 必須」「レビュー 1 以上」などを設定すると、直接 push を防げます。
- **GitHub Actions**: プッシュや PR のたびに `composer test` と `composer pint:test` を回すワークフローを追加すると、CI で品質を担保できます。

CI 用のワークフロー例は `.github/workflows/` に別途用意することを推奨します（例: `tests.yml` で PHP と Composer を実行）。

---

## まとめ

| やること | 手段 |
|---------|------|
| コードの品質・TDD ルール準拠 | Cursor で Claude に「差分をレビューして」と依頼 |
| テスト・スタイルの確認 | ローカルで `composer test` と `composer pint:test` |
| 履歴と共同開発 | GitHub でブランチ・PR を運用 |
| 本番反映 | main にマージ後、契約している WEB サーバーへデプロイ |

「Git 上でクロードコードを使ってコードレビューする」は、上記のとおり **Git のブランチ＋PR で差分を管理し、その差分を Cursor の Claude に渡してレビューする** 形で実現できます。
