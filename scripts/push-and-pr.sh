#!/usr/bin/env bash
# プッシュして PR までやる（認証が通っている前提）
set -e
cd "$(dirname "$0")/.."

echo "--- テスト実行 ---"
composer test
echo ""
echo "--- プッシュ ---"
git push -u origin issue/1
echo ""
if command -v gh >/dev/null 2>&1; then
  echo "--- PR 作成 ---"
  gh pr create --base main --head issue/1 --title "Issue #1 - 認証基盤" --body "Closes #1" || echo "PR は手動で作成してください"
else
  echo "PR は GitHub で手動作成: issue/1 → main"
fi
echo "完了"
