#!/usr/bin/env python3
"""GitHub Issue 一括登録（GitHub API）
使い方: REPO=owner/repo GITHUB_TOKEN=xxx python3 scripts/create-issues-api.py
"""
import os
import json
import urllib.request
import urllib.error

REPO = os.environ.get("REPO", "")
TOKEN = os.environ.get("GITHUB_TOKEN", "")
if not REPO or not TOKEN:
    print("REPO と GITHUB_TOKEN を設定してください。")
    print("例: REPO=yourname/change-seats-app GITHUB_TOKEN=ghp_xxx python3 scripts/create-issues-api.py")
    exit(1)

API = f"https://api.github.com/repos/{REPO}/issues"

ISSUES = [
    ("[認証] Laravel Breeze 等でログイン・会員登録を導入する", "教員向けの会員登録・ログイン・ログアウトを実装する。未ログイン時はトップ（ログイン画面）へリダイレクト。認証後はメイン画面へ遷移。"),
    ("[画面] トップページ（ログイン画面）を実装する", "ルート / をログイン画面とする。メール（またはユーザー名）・パスワードでログイン。会員登録ページへのリンクを表示。"),
    ("[画面] 会員登録ページを実装する", "/register で会員登録フォームを表示。登録後はログイン状態にしてメイン画面へリダイレクト。"),
    ("[画面] メイン画面と設定画面のルート・レイアウトを用意する", "認証済みユーザー向けにメイン画面（/home）と設定画面（/settings）のルートを定義。共通レイアウト（ヘッダー・ナビ・ログアウト）を用意。"),
    ("[DB] クラス・座席レイアウト・クラスメイト用のマイグレーションを作成する", "seat_layouts, classmates, seat_constraints, current_seats 用テーブルを SQLite で作成。技術設計の DB 設計に沿う。"),
    ("[設定] クラス人数・座席数・配置を設定画面で登録できるようにする", "設定画面でクラスメイトの人数、座席の行数・列数を入力・保存。座席配置は縦×横で定義。"),
    ("[設定] 現在の席（出席番号↔席位置）を登録できるようにする", "出席番号と席位置の対応を設定画面で登録・編集。席替え前の状態を現在の席として保持。"),
    ("[設定] クラスメイトの出席番号・視力・「近くにしない」を登録できるようにする", "出席番号（1〜N）、視力（なし/軽度/重度）、近くにしない（別の出席番号を複数指定）を登録。"),
    ("[席替え] 制約なしのランダム席割り当てを実装する", "座席レイアウトとクラスメイト人数に基づき、出席番号を席にランダムに割り当てるサービスを実装。まずは視力・近くにしないは考慮しない。"),
    ("[席替え] 視力（重度・軽度）に応じて前列優先で割り当てる", "重度→最前列からランダム、軽度→その次に前列を優先してランダム、その他は残りをランダム。"),
    ("[席替え] 「近くにしない」制約を満たすように割り当てる", "指定ペアが隣接（上下左右）しないように席替え結果を生成。制約を満たせない場合は再試行またはエラー。"),
    ("[席替え] 現在の席と完全に同じ配置にならないようにする", "席替え結果が現在の席と1人も動いていない状態にならないようにする。同一の場合はシャッフルをやり直す（上限回数あり）。"),
    ("[メイン] 席替えを実行し、結果の席表を表示する", "メイン画面で席替え実行ボタンでアルゴリズムを実行。結果を席表（出席番号のグリッド）として表示。"),
    ("[メイン] 納得いかない場合に再シャッフルできるようにする", "表示中の席替え結果に対して再シャッフルボタン。再シャッフル時も直前の結果と完全同一にしない。"),
    ("[メイン] 確定した席配置を保存する", "保存ボタンで表示中の席表を現在の席としてDBに保存。次回の席替えでこの結果が前回として参照される。"),
    ("[メイン] 席表を印刷用に表示する（紙印刷想定）", "確定した席表を印刷しやすいレイアウトで表示（出席番号のみ）。CSS @media print で印刷用スタイル。"),
    ("[改善] 設定・席替えのバリデーションとエラー表示を整理する", "座席数とクラス人数の整合、制約で席替えが不可能な場合のメッセージなどを整理。"),
    ("[拡張] 1ユーザーで複数クラスを管理できるようにする（任意）", "classes テーブルを導入し、クラス切り替えで別クラスの席替え・設定ができるようにする。優先度低。"),
]

def create_issue(title, body):
    req = urllib.request.Request(API, data=json.dumps({"title": title, "body": body}).encode("utf-8"), method="POST")
    req.add_header("Authorization", f"token {TOKEN}")
    req.add_header("Accept", "application/vnd.github.v3+json")
    req.add_header("Content-Type", "application/json; charset=utf-8")
    try:
        with urllib.request.urlopen(req) as res:
            data = json.loads(res.read().decode())
            print(f"Created: #{data.get('number')} {title}")
    except urllib.error.HTTPError as e:
        print(f"Error {e.code}: {title}")
        print(e.read().decode())

for title, body in ISSUES:
    create_issue(title, body)

print("Issue の登録が完了しました。")
