# Issue 6 Test List: [設定] クラス人数・座席数・配置を設定画面で登録できるようにする

受け入れ: 人数・座席数・配置を保存し、再表示できること。

## Happy path（正常系）

| # | 振る舞い | テストメソッド名 |
|---|----------|------------------|
| 1 | 認証済みユーザーが設定画面で座席の行数・列数を送信して保存できる | test_authenticated_user_can_save_seat_layout_rows_and_cols |
| 2 | 設定画面を表示すると保存済みの行数・列数が表示される | test_settings_page_displays_saved_rows_and_cols |
| 3 | 認証済みユーザーがクラスメイトの人数を送信して保存できる | test_authenticated_user_can_save_class_size |
| 4 | 設定画面を表示すると保存済みの人数が表示される | test_settings_page_displays_saved_class_size |

---

One Test at a Time: 上から 1 つずつ 🔴 RED → 🟢 GREEN → 🔵 BLUE で進める。
※ seat_layouts に rows, cols は既存。class_size（人数）はマイグレーションで追加する。
