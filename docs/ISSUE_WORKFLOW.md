# Issue に着手する流れ（3 コマンド分割）

Cursor のチャットで **`/`** を押し、一覧から **issue-start** / **issue-fix** / **issue-ship** のいずれかを選択する。

---

## どの Issue の作業中か（判別）

| タイミング | 判別方法 |
|------------|----------|
| **issue-start を実行するとき** | メッセージに書いた **Issue 番号**（例: `1` または `Issue 1`）を使う。 |
| **issue-fix / issue-ship を実行するとき** | **現在のブランチ名** で判別する。`issue/N` なら Issue #N の作業中とみなす。 |

→ issue-fix / issue-ship を使うときは、必ず **Issue 用ブランチ（issue/N）にいる** こと。違うブランチなら先に `git checkout issue/N` する。

---

## コマンドの呼び出し方（Cursor Commands）

1. チャット入力欄で **`/`** を入力する
2. 一覧から **issue-start** / **issue-fix** / **issue-ship** のいずれかを選択する
3. **issue-start** のときだけ、メッセージに **Issue 番号** を書く（例: `2`）
4. 送信する

---

## 推奨フロー

1. **`/issue-start`** ＋ Issue 番号（例: `2`）  
   → ブランチ作成 → テストシナリオ作成 → Canon TDD サイクル（目視確認の手前で終了）

2. **目視で動作確認**

3. **問題あり** → **`/issue-fix`**（ブランチはそのまま）  
   → 不具合をテストケースに追加 → TDD サイクルで直す → 必要なら 2 に戻る

4. **問題なし** → **`/issue-ship`**（ブランチはそのまま）  
   → 全体テスト・pint → コミット・プッシュ・PR 作成

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

## コマンドファイルの場所

- `.cursor/commands/issue-work.md` … 索引（3 コマンドの流れ・判別ルール）
- `.cursor/commands/issue-start.md` … 着手（ブランチ・Test List・TDD）
- `.cursor/commands/issue-fix.md` … 目視後の不具合をテストに追加して TDD
- `.cursor/commands/issue-ship.md` … 完了（テスト・pint・コミット・プッシュ・PR）
