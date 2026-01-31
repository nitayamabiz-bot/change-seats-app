# 目視確認後の不具合をテストに追加して TDD で直す

目視で動作確認した結果、**不具合や不足していた振る舞い**がある場合に使う。それをテストケースに追加し、Canon TDD サイクルで実装・リファクタまで行う。

---

## どの Issue か（重要）

- **現在のブランチ名** で判別する。`git branch --show-current` が `issue/N` なら **Issue N の作業中** とみなす。
- 例: ブランチが `issue/2` → Issue #2 の修正。Test List は `docs/issue-2-test-list.md`、テストは既存の Issue #2 用テストファイルに追加。
- ブランチが `issue/N` でない場合は、先に `issue-start` でその Issue のブランチに切り替えるか、正しいブランチにチェックアウトすること。

---

## 流れ

1. **現在ブランチを確認**: `issue/N` であることを確認する。N を Issue 番号として使う。
2. **追加するテストシナリオを決める**: 目視で見つけた不具合・不足を「〇〇のとき △△になる」という 1 シナリオ＝1 テストメソッドで書く。
3. **Test List に追記**: `docs/issue-N-test-list.md` に追加シナリオとテストメソッド名を追記する。
4. **TDD サイクル**: 追加したシナリオについてだけ、🔴 RED → 🟢 GREEN → 🔵 BLUE を回す。
   - テストを 1 つ書く（🔴 RED）→ `composer test` で失敗確認
   - 最小限の実装（🟢 GREEN）→ `php artisan test --filter=メソッド名` で 1 個だけ確認
   - リファクタ（🔵 BLUE）→ 同じ 1 個で再確認
5. **全テスト確認**: 追加後も `composer test` で全体が通ることを確認する。`composer pint` でスタイルを整える。

---

## ルール・コマンド

- 1 回に通すテストは **１個だけ**。Canon TDD に従う。
- 🔴 RED 確認: `composer test`
- 🟢 GREEN・🔵 BLUE 後（１個だけ）: `php artisan test --filter=メソッド名`
- 追加完了後: `composer test` → `composer pint`

問題が解消したら、**issue-ship** でコミット・プッシュ・PR まで進める。
