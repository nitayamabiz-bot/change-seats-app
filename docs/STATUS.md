# 開発のいまどこまでできているか

## 現状（いま）

| 項目 | 状態 |
|------|------|
| **ブランチ** | `issue/1` |
| **コミット** | 1 件（Issue #1 認証まわりでコミット済み） |
| **未コミット** | なし（working tree clean） |
| **テスト** | 30 件すべて成功 |
| **スタイル（Pint）** | チェック通過 |

**＝ 開発とエラーチェックは終わっている。あとは Git に上げるだけ。**

---

## おわって Git にあげる手順

### 1. 認証を通す（ここで失敗しているなら）

GitHub には**パスワードでは push できない**ので、次のどれかが必要です。

**A. トークンで一度だけ push する（手軽）**

1. GitHub → Settings → Developer settings → Personal access tokens  
   → **repo** にチェックでトークン作成してコピー
2. ターミナルで実行（`トークン` を貼り替え）:
   ```bash
   cd /Users/ni/Desktop/change-seats-app
   git remote set-url origin "https://nitayamabiz-bot:トークン@github.com/nitayamabiz-bot/change-seats-app.git"
   git push -u origin issue/1
   ```

**B. SSH で push する**

1. `cat ~/.ssh/id_ed25519.pub` の内容を GitHub → Settings → SSH and GPG keys に登録
2. ターミナルで実行:
   ```bash
   cd /Users/ni/Desktop/change-seats-app
   git remote set-url origin git@github.com:nitayamabiz-bot/change-seats-app.git
   git push -u origin issue/1
   ```
3. 初回だけ「yes」と入力

### 2. PR を出す

push できたら:

- GitHub のリポジトリを開く → 「Compare & pull request」が出たらクリック  
  または
- `gh pr create --base main --head issue/1 --title "Issue #1 認証" --body "Closes #1"`（`gh` が入っていれば）

---

## エラーチェック結果（再確認したいとき）

```bash
cd /Users/ni/Desktop/change-seats-app
composer test    # テスト
composer pint:test   # スタイル
```

両方通っていれば、そのまま push して問題ない状態です。
