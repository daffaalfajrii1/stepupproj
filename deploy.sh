#!/usr/bin/env bash
# Deploy StepUp ke Hostinger.
# Dari komputer (Git Bash):  bash deploy.sh
# Langsung di server:        bash deploy.sh
set -euo pipefail

SSH_USER="${SSH_USER:-u245335773}"
SSH_HOST="${SSH_HOST:-stepupproject.tech}"
SSH_PORT="${SSH_PORT:-65002}"
BRANCH="${BRANCH:-main}"
REPO="${REPO:-https://github.com/daffaalfajrii1/stepupproj.git}"
DOMAIN_ROOT="/home/u245335773/domains/stepupproject.tech"
APP_DIR="$DOMAIN_ROOT/stepup"
WEB_DIR="$DOMAIN_ROOT/public_html"

deploy_on_server() {
    if [[ ! -d "$DOMAIN_ROOT" ]]; then
        echo "Folder domain tidak ada: $DOMAIN_ROOT"
        exit 1
    fi

    local php_bin composer_bin
    php_bin="${PHP_BIN:-php}"
    composer_bin="${COMPOSER_BIN:-composer}"

    if ! "$php_bin" -r 'exit(PHP_VERSION_ID >= 80200 ? 0 : 1);'; then
        echo "PHP di server harus 8.2 atau lebih baru. Sekarang: $("$php_bin" -v | head -n 1)"
        exit 1
    fi

    mkdir -p "$WEB_DIR/uploads"

    if [[ ! -d "$APP_DIR/.git" ]]; then
        echo "Mengambil kode pertama kali dari $REPO"
        rm -rf "$APP_DIR.new"
        git clone --branch "$BRANCH" --depth 1 "$REPO" "$APP_DIR.new"
        if [[ -f "$APP_DIR/.env" ]]; then
            cp "$APP_DIR/.env" "$APP_DIR.new/.env"
        fi
        rm -rf "$APP_DIR"
        mv "$APP_DIR.new" "$APP_DIR"
    else
        echo "Memperbarui $BRANCH"
        git -C "$APP_DIR" remote set-url origin "$REPO"
        git -C "$APP_DIR" fetch origin "$BRANCH"
        git -C "$APP_DIR" reset --hard "origin/$BRANCH"
    fi

    if [[ -L "$APP_DIR/public" ]]; then
        echo "Berkas publik ikut terbarui lewat tautan public_html"
    else
        echo "Menyalin folder public ke public_html"
        if command -v rsync >/dev/null 2>&1; then
            rsync -a --delete --exclude 'uploads/' "$APP_DIR/public/" "$WEB_DIR/"
        else
            find "$APP_DIR/public" -mindepth 1 -maxdepth 1 ! -name uploads -exec cp -a {} "$WEB_DIR/" \;
        fi
        rm -rf "$APP_DIR/public"
        ln -s "$WEB_DIR" "$APP_DIR/public"
    fi

    mkdir -p "$WEB_DIR/uploads" "$APP_DIR/storage/framework/cache/data" \
        "$APP_DIR/storage/framework/sessions" "$APP_DIR/storage/framework/views" \
        "$APP_DIR/storage/logs" "$APP_DIR/bootstrap/cache"
    chmod -R ug+rwx "$APP_DIR/storage" "$APP_DIR/bootstrap/cache" "$WEB_DIR/uploads"

    echo "Memasang dependensi"
    "$composer_bin" install --no-dev --optimize-autoloader --no-interaction --working-dir="$APP_DIR"

    if [[ ! -f "$APP_DIR/.env" ]]; then
        echo "File .env belum ada di $APP_DIR. Salin dari .env.example, isi database, lalu jalankan lagi."
        exit 1
    fi

    echo "Migrasi database"
    "$php_bin" "$APP_DIR/artisan" migrate --force
    "$php_bin" "$APP_DIR/artisan" config:cache
    "$php_bin" "$APP_DIR/artisan" route:cache
    "$php_bin" "$APP_DIR/artisan" view:cache

    echo "Selesai. Situs: https://stepupproject.tech"
}

if [[ -d "$DOMAIN_ROOT" ]]; then
    deploy_on_server
else
    echo "Mengirim $BRANCH ke origin"
    git push origin "$BRANCH"
    echo "Menjalankan deploy di $SSH_USER@$SSH_HOST"
    ssh -p "$SSH_PORT" "$SSH_USER@$SSH_HOST" 'bash -s' < "$0"
fi
