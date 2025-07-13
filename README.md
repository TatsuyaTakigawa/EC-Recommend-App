# ECレコメンド機能付きショッピングサイト

このプロジェクトは、PHPで構築されたショッピングサイトに対し、Python（Flask + TensorFlow Recommenders）で作成したレコメンドAPIを連携させたWebアプリです。

---

## 💻 開発環境（前提）

- OS：Windows 10/11
- Python：3.12系
- PHP：XAMPP 8.2以上（Apache + MySQL）
- GitHub：コード共有
- 仮想環境名：`.venv312`

---

## 🧪 セットアップ手順

### 🔸 0. リポジトリをローカルにクローン

```powershell
cd 任意の作業フォルダ
git clone https://github.com/TatsuyaTakigawa/ec-recommend-app.git
cd ec-recommend-app
```

---


### 🔸 1. XAMPPの準備（PHP環境）

1. XAMPPをインストール  
   https://www.apachefriends.org/index.html

2. `php/` フォルダを以下の場所にコピー  
   ```
   C:\xampp\htdocs\php
   ```

3. XAMPPコントロールパネルから Apache & MySQL を起動

4. phpMyAdmin にアクセス  
   http://localhost/phpmyadmin

5. `db/` 配下の `.sql` ファイルを順に実行（DB構築）

---


### 🔸 2. Python仮想環境の構築（レコメンドAPI）

```powershell
# 仮想環境の作成
python -m venv .venv312

# 仮想環境の有効化（PowerShell）
.venv312\Scripts\Activate.ps1

# 依存パッケージのインストール
pip install -r requirements.txt
```

※仮想環境を抜けるときは：

```powershell
deactivate
```

---

## ✨ 開発チーム向けメモ

- GitHubはコード共有に使用（`main`ブランチのみを使用）

---

#### ※git/githubの初期設定はこちらから  
[https://git-scm.com/book/ja/v2](https://docs.github.com/ja/get-started/git-basics/set-up-git)
