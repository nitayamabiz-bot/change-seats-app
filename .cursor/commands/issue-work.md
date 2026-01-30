# Issue に着手する（Canon TDD）

GitHub Issue 番号をこのメッセージに書いてください（例: 1 または Issue 1）。指定がなければ番号を聞く。

指定された Issue（N）について、次の流れで進める。

---

## 1. ブランチ

- `issue/N` ブランチを作成またはチェックアウトする（`git checkout -b issue/N` など）。

---

## 2. Implementation: Canon TDD（Kent Beck）

実装タスクは Kent Beck の Canon TDD に従う。

### TDD Cycle（厳守）

```
🔴 RED → 🟢 GREEN → 🔵 BLUE → Repeat
```

| Phase | Action | Rule |
|-------|--------|------|
| 🔴 RED | テストを書く | 実装コードより先にテストを書く。テストは失敗すること |
| 🟢 GREEN | 実装を書く | テストを通す最小限のコードのみ |
| 🔵 BLUE | リファクタリング | テストを GREEN に保ちながら改善 |

### Two Hats Rule（Kent Beck）

```
🎩 HAT 1 (GREEN): Make it work - 動くコードを書く
🎩 HAT 2 (BLUE):  Make it right - 構造を改善する

⚠️ 2つの帽子を同時にかぶらない
```

### Implementation Flow

1. **Test List 作成**: 実装前に振る舞いシナリオをリスト化する
   - Happy path（正常系）
   - Edge cases（境界値）
   - Error cases（異常系）
   - その Issue の内容と docs/TECHNICAL_DESIGN.md から導く。1 シナリオ＝1 テストメソッド。

2. **One Test at a Time**: リストから 1 つずつ「テスト → 実装 → リファクタリング」を回す。
   - そのシナリオのテストを 1 つ書く（🔴 RED）
   - `composer test` で失敗を確認する
   - その 1 個が通る最小限のコードを書く（🟢 GREEN）
   - `php artisan test --filter=メソッド名` で **１個だけ** テストを実施し、通ることを確認する
   - テストを GREEN に保ちながらリファクタリングする（🔵 BLUE）。同じ 1 個のテストで再確認する
   - 次のシナリオへ

3. **Checkpoint**: 各フェーズ完了時に状態を報告する
   - `🔴 RED: [behavior] test fails as expected`
   - `🟢 GREEN: [behavior] implemented and test passes`
   - `🔵 BLUE: Refactoring complete, tests remain GREEN`

---

## 3. 完了後

- 全シナリオが GREEN になったら: `composer test` で全体確認 → `composer pint` → 変更をコミット・プッシュ → PR 作成（`gh pr create` または手順を案内）。

---

## ルール

- Kent Beck の Canon TDD にのみ従う。独自の手順は追加しない。
- 1 回に通すテストは **１個だけ**。GREEN・BLUE 後の確認もその 1 個だけ実行する。
- 2 つの帽子を同時にかぶらない（GREEN で「動かす」、BLUE で「きれいにする」を分ける）。

## コマンド

- 🔴 RED 確認: `composer test`
- 🟢 GREEN・🔵 BLUE 後（１個だけ）: `php artisan test --filter=メソッド名`
- 完了確認: `composer test`
- スタイル: `composer pint`
