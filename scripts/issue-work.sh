#!/usr/bin/env bash
# Issue 番号を指定して実行。ブランチ作成 → テストが通るまで待つ → 全 OK でコミット・プッシュ・PR 作成
# 使い方: ./scripts/issue-work.sh 1
set -e
cd "$(dirname "$0")/.."

ISSUE_NUM="${1:?Issue 番号を指定してください。例: ./scripts/issue-work.sh 1}"
BRANCH="issue/${ISSUE_NUM}"

# ブランチがなければ作成
if ! git show-ref --verify --quiet "refs/heads/$BRANCH"; then
  git checkout -b "$BRANCH" 2>/dev/null || git checkout -b "$BRANCH" main
  echo "ブランチ $BRANCH を作成しました。"
else
  git checkout "$BRANCH"
fi

# テストが通るまでループ（その間に TDD で実装）
while true; do
  echo ""
  echo "--- composer test 実行 ---"
  if composer test 2>&1; then
    echo ""
    echo "全テストが通りました。コミット・プッシュ・PR を作成します。"
    break
  fi
  echo ""
  echo "テストが失敗しています。TDD で実装・修正してから Enter を押してください（終了は Ctrl+C）。"
  read -r
done

# スタイル整形
composer pint 2>/dev/null || true

# 変更があればコミット
if ! git diff --quiet || ! git diff --cached --quiet; then
  TITLE=""
  if command -v gh >/dev/null 2>&1; then
    TITLE="$(gh issue view "$ISSUE_NUM" --json title -q .title 2>/dev/null || true)"
  fi
  git add -A
  git commit -m "fix: Issue #${ISSUE_NUM} ${TITLE}" || true
fi

# プッシュ
if git remote get-url origin >/dev/null 2>&1; then
  git push -u origin "$BRANCH" 2>/dev/null || git push origin "$BRANCH"
fi

# PR 作成（gh があれば）
if command -v gh >/dev/null 2>&1; then
  gh pr create --base main --head "$BRANCH" --title "Issue #${ISSUE_NUM}" --body "Closes #${ISSUE_NUM}" 2>/dev/null || echo "PR を手動で作成: gh pr create --base main --head $BRANCH"
else
  echo "PR を手動で作成してください: ブランチ $BRANCH を main へ"
fi

echo "完了しました。"
