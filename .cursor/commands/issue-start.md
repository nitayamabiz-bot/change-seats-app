# Issue に着手する（ブランチ・テストシナリオ・TDD）

**GitHub Issue 番号をこのメッセージに書いてください（例: 1 または Issue 1）。** 指定がなければ番号を聞く。

指定された Issue（N）について、次の流れを**目視確認の手前まで**進める。

---

## どの Issue か

- **このコマンドでは**: メッセージに書いた Issue 番号 N を使う。
- **以降のコマンド（issue-fix / issue-ship）では**: **現在のブランチ名**で判別する。ブランチが `issue/N` なら「Issue N の作業中」とみなす。

---

## ファイルの配置（生成・編集先）

| 種類 | 配置先 | 例（Issue 1 の場合） |
|------|--------|------------------------|
| **テストシナリオ一覧（Test List）** | `docs/issue-N-test-list.md` | `docs/issue-1-test-list.md` |
| **テストコード** | `tests/Feature/` または `tests/Unit/`（ドメインでサブディレクトリ可） | `tests/Feature/Auth/AuthenticationTest.php` |
| **ソース（実装）** | Laravel の慣習どおり | `app/Http/Controllers/`, `routes/web.php` など |

---

## 1. ブランチ

- `issue/N` ブランチを作成またはチェックアウトする（`git checkout -b issue/N` など）。

---

## 2. Test List 作成

- 実装前に振る舞いシナリオを **docs/issue-N-test-list.md** にリスト化する。
- Happy path（正常系）・Edge cases（境界値）・Error cases（異常系）。Issue の内容と docs/TECHNICAL_DESIGN.md から導く。
- 1 シナリオ ＝ 1 テストメソッド名まで決める。

---

## 3. Implementation: Canon TDD（Kent Beck）

### TDD Cycle（厳守）

```
🔴 RED → 🟢 GREEN → 🔵 BLUE → Repeat
```

| Phase | Action | Rule |
|-------|--------|------|
| 🔴 RED | テストを書く | 実装より先にテスト。テストは失敗すること |
| 🟢 GREEN | 実装を書く | その 1 個が通る最小限のコードのみ |
| 🔵 BLUE | リファクタリング | テストを GREEN に保ちながら改善 |

### Two Hats Rule

- 🎩 HAT 1 (GREEN): Make it work
- 🎩 HAT 2 (BLUE): Make it right  
- ⚠️ 2 つの帽子を同時にかぶらない

### One Test at a Time

1. リストから 1 シナリオ選ぶ → そのテストを 1 つ書く（🔴 RED）
2. `composer test` で失敗を確認する
3. その 1 個が通る最小限のコードを書く（🟢 GREEN）
4. `php artisan test --filter=メソッド名` で **１個だけ** テストを実施し、通ることを確認する
5. テストを GREEN に保ちながらリファクタリング（🔵 BLUE）。同じ 1 個のテストで再確認する
6. 次のシナリオへ（1〜5 を繰り返す）

### Checkpoint（各フェーズ完了時に報告）

- 🔴 RED: [behavior] test fails as expected
- 🟢 GREEN: [behavior] implemented and test passes
- 🔵 BLUE: Refactoring complete, tests remain GREEN

---

## 4. ここまでで終了

- **全シナリオが GREEN になったらこのコマンドは終了。**
- 次は **目視で動作確認** する。問題があれば **issue-fix** で不具合をテストに追加して TDD を回す。問題なければ **issue-ship** でコミット・プッシュ・PR まで進める。

---

## ルール・コマンド

- Kent Beck の Canon TDD にのみ従う。1 回に通すテストは **１個だけ**。
- 🔴 RED 確認: `composer test`
- 🟢 GREEN・🔵 BLUE 後（１個だけ）: `php artisan test --filter=メソッド名`
- スタイル: `composer pint`
