# Issue 5 Test List: [DB] クラス・座席レイアウト・クラスメイト用のマイグレーションを作成する

受け入れ: `php artisan migrate` でエラーなくテーブルが作成されること。

## Happy path（正常系）

| # | 振る舞い | テストメソッド名 |
|---|----------|------------------|
| 1 | migrate を実行するとエラーなく完了し、seat_layouts テーブルが存在する | test_migrate_creates_seat_layouts_table |
| 2 | migrate 後に classmates テーブルが存在する | test_migrate_creates_classmates_table |
| 3 | migrate 後に seat_constraints テーブルが存在する | test_migrate_creates_seat_constraints_table |
| 4 | migrate 後に current_seats テーブルが存在する | test_migrate_creates_current_seats_table |

---

One Test at a Time: 上から 1 つずつ 🔴 RED → 🟢 GREEN → 🔵 BLUE で進める。
※ 技術設計「4. DB 設計」に沿ったカラムとする。1 ユーザー 1 クラス想定で user_id で紐づける。
