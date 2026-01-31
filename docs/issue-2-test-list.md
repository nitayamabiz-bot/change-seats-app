# Issue 2 Test List: [画面] トップページ（ログイン画面）を実装する

受け入れ: ログインフォームが表示され、登録ページへ遷移できること。

## Happy path（正常系）

| # | 振る舞い | テストメソッド名 |
|---|----------|------------------|
| 1 | ゲストが / にアクセスするとログインフォームが表示される（200） | test_guest_sees_login_form_at_root |
| 2 | / で表示されるページにメール・パスワード入力がある | test_root_page_has_email_and_password_inputs |
| 3 | / で表示されるページに会員登録ページへのリンクがある | test_root_page_has_link_to_register |

## Edge cases（境界値）

| # | 振る舞い | テストメソッド名 |
|---|----------|------------------|
| 4 | ログイン済みユーザーが / にアクセスすると /home へリダイレクトされる | test_logged_in_user_visiting_root_is_redirected_to_home |

---

One Test at a Time: 上から 1 つずつ 🔴 RED → 🟢 GREEN → 🔵 BLUE で進める。
※ Issue 1 の「ゲストが / にアクセスするとログインへリダイレクト」は、Issue 2 により「/ がログイン画面」になるため、シナリオ 1 に統合する。
