#!/usr/bin/env bash
# Dari komputer (Git Bash), di folder proyek: bash deploy.sh
# Mengirim cabang main, lalu server menariknya dan menyalin berkas publik.
set -euo pipefail

SSH_USER="${SSH_USER:-u245335773}"
SSH_HOST="${SSH_HOST:-stepupproject.tech}"
SSH_PORT="${SSH_PORT:-65002}"
APP_DIR="/home/u245335773/domains/stepupproject.tech/stepup"
BRANCH="${BRANCH:-main}"

if [[ -d "/home/u245335773/domains/stepupproject.tech" ]]; then
    exec "$(cd "$(dirname "$0")" && pwd)/scripts/deploy-hostinger.sh"
fi

if [[ -n "$(git status --porcelain)" ]]; then
    echo "Masih ada perubahan yang belum di-commit. Commit dulu, lalu jalankan lagi."
    git status --short
    exit 1
fi

echo "==> kirim $BRANCH ke GitHub"
git push origin "$BRANCH"

echo "==> perbarui server"
ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" "cd '$APP_DIR' && bash scripts/deploy-hostinger.sh"
