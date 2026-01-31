# Issue 完了：テスト・pint・コミット・プッシュ・PR

目視確認まで終え、**この Issue の作業をリポジトリに反映して PR まで出す**ときに使う。

---

## どの Issue か（重要）

- **現在のブランチ名** で判別する。`git branch --show-current` が `issue/N` なら **Issue N** の完了処理とみなす。
- ブランチが `issue/N` でない場合は、先に正しいブランチにチェックアウトすること。

---

## 流れ

1. **現在ブランチを確認**: `issue/N` であることを確認する。
2. **全体テスト**: `composer test` で全テストが通ることを確認する。（issue-start では実行しない。ここと PR の CI で行う。）
3. **スタイル**: `composer pint` で整形し、必要なら `composer pint:test` でチェック。
4. **コミット**: 変更をコミットする（メッセージに Issue 番号を含めるとよい。例: `fix: Issue #N 〇〇`）。
5. **プッシュ**: `git push -u origin issue/N`（未プッシュの場合）または `git push`。
6. **PR 作成**: `gh pr create` が使えればそれで、使えなければ GitHub API で作成する。**手順案内で終わらせない。** PR の body に `Closes #N` を入れる。

---

## コマンド一覧

| 目的 | コマンド |
|------|----------|
| 完了確認 | `composer test` |
| スタイル整形 | `composer pint` |
| スタイルチェック | `composer pint:test` |
| PR 作成 | `gh pr create` または GitHub API |
