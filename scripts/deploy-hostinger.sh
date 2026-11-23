#!/usr/bin/env bash
# Deploy StepUp di Hostinger (stepup/ + public_html/).
# Jalankan dari folder stepup: bash scripts/deploy-hostinger.sh
set -uo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
DOMAIN_ROOT="$(cd "$ROOT/.." && pwd)"
PUBLIC_HTML="${DOMAIN_ROOT}/public_html"

cd "$ROOT"

echo "==> git pull"
git pull origin main || {
    echo "git pull gagal. Deploy dihentikan." >&2
    exit 1
}

echo "==> composer install (Hostinger sering tanpa proc_open)"
if composer install --no-dev --optimize-autoloader --no-interaction --no-scripts; then
    echo "composer OK"
else
    echo "PERINGATAN: composer gagal/dilewati. Lanjut sync file." >&2
fi

if [[ ! -f "$ROOT/vendor/autoload.php" ]]; then
    echo "PERINGATAN: vendor/autoload.php tidak ada. Situs tetap 500 sampai folder vendor terunggah." >&2
fi

php artisan package:discover --ansi 2>/dev/null || true

echo "==> migrate + clear cache"
php artisan migrate --force || true
php artisan view:clear || true
php artisan config:clear || true
php artisan route:clear || true
php artisan cache:clear || true

echo "==> sync public -> public_html"
if [[ ! -d "$PUBLIC_HTML" ]]; then
    echo "public_html tidak ditemukan: $PUBLIC_HTML" >&2
    exit 1
fi

mkdir -p "$PUBLIC_HTML/uploads"

if [[ -L "$ROOT/public/uploads" ]]; then
    rm -f "$ROOT/public/uploads"
    mkdir -p "$ROOT/public/uploads"
fi

if command -v rsync >/dev/null 2>&1; then
    rsync -a --delete \
        --exclude 'uploads/' \
        --exclude 'index.php.bak-deploy' \
        "$ROOT/public/" "$PUBLIC_HTML/"
else
    find "$ROOT/public" -mindepth 1 -maxdepth 1 ! -name uploads -exec cp -a {} "$PUBLIC_HTML/" \;
fi

# Unggahan admin disimpan di public_html/uploads.
if [[ -d "$ROOT/public/uploads" && ! -L "$ROOT/public/uploads" ]]; then
    cp -a "$ROOT/public/uploads/." "$PUBLIC_HTML/uploads/" 2>/dev/null || true
    rm -rf "$ROOT/public/uploads"
fi
ln -sfn "$PUBLIC_HTML/uploads" "$ROOT/public/uploads"
chmod -R ug+rwx "$ROOT/storage" "$ROOT/bootstrap/cache" "$PUBLIC_HTML/uploads" 2>/dev/null || true

if ! grep -q "stepup/vendor/autoload.php" "$PUBLIC_HTML/index.php" 2>/dev/null; then
    echo "PERINGATAN: public_html/index.php belum mengarah ke folder stepup. Cek isinya." >&2
fi

echo "==> selesai"
echo "Buka https://stepupproject.tech"
