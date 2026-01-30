# Issue に着手する流れ

**Cursor のチャットで `/` を押し、一覧から `issue-work` を選択する。メッセージに Issue 番号（例: 1）を書いて送信する。**

---

## コマンドの呼び出し方（Cursor Commands）

1. チャット入力欄で **`/`** を入力する
2. 一覧に表示される **`issue-work`** を選択する（`.cursor/commands/issue-work.md` の内容がチャットに挿入される）
3. 続けて **Issue 番号** を書く（例: `1` または `Issue 1`）
4. 送信する

すると、エージェントが次の流れで動く:

1. **ブランチ作成** … `issue/N` を作成・チェックアウト
2. **テストシナリオ** … Issue の内容から設計・開発プロセスを作成する **際に** テストシナリオを決め、一覧を出す
3. **Canon TDD のサイクル** … シナリオごとに「テストを 1 つ書く → Red → コード作成 → １個だけ Green → リファクタ」を回す
4. **全シナリオ OK** … `composer test` で全体確認 → `composer pint` → コミット・プッシュ・PR 作成（または手順を案内）

※ コマンドの定義: `.cursor/commands/issue-work.md`

---

## コマンド一覧（TDD 用・エージェントが使う）

| 目的 | コマンド |
|------|----------|
| Red 確認・全テスト | `composer test` |
| Green・Refactor 後（１個だけ） | `php artisan test --filter=メソッド名` |
| 完了確認 | `composer test` |
| スタイル整形 | `composer pint` |
| スタイルチェック | `composer pint:test` |

---

## スクリプト（任意）

Cursor を使わないとき用に、`./scripts/issue-work.sh N` でブランチ作成〜テストが通るまで待機〜PR まで行うスクリプトもある。通常は **`/issue N`** を優先して使う。
