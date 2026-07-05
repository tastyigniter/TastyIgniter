#!/usr/bin/env bash
set -euo pipefail

VERSION="${VERSION:?VERSION is required}"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT="$(cd "${SCRIPT_DIR}/../.." && pwd)"
STAGE_NAME="tastyigniter-${VERSION}"
STAGING="$(mktemp -d)/${STAGE_NAME}"
ARCHIVE="${ROOT}/${STAGE_NAME}.zip"

cd "${ROOT}"

export COMPOSER_PROCESS_TIMEOUT=0

echo "==> Installing production dependencies..."
composer update \
  --no-dev \
  --optimize-autoloader \
  --no-interaction \
  --prefer-dist \
  --no-scripts

echo "==> Publishing assets..."
cp .env.example .env
php artisan key:generate --force
php artisan vendor:publish --tag=laravel-assets --ansi --force
php artisan package:discover --ansi
rm -f .env

echo "==> Staging release tree..."
mkdir -p "${STAGING}"
rsync -a \
  --exclude '.git/' \
  --exclude '.github/' \
  --exclude 'tests/' \
  --exclude 'node_modules/' \
  --exclude 'composer-dev.json' \
  --exclude 'composer-dev.lock' \
  --exclude 'auth.json' \
  --exclude '.env' \
  --exclude '.env.*' \
  --exclude 'phpunit.xml' \
  --exclude 'phpunit.xml.dist' \
  --exclude '.phpunit.result.cache' \
  --exclude 'storage/logs/' \
  --exclude 'storage/framework/cache/' \
  --exclude 'storage/framework/sessions/' \
  --exclude 'storage/framework/views/' \
  --exclude 'storage/temp/' \
  --exclude 'storage/debugbar/' \
  --exclude 'storage/clockwork/' \
  "${ROOT}/" "${STAGING}/"

echo "==> Creating ${ARCHIVE}..."
rm -f "${ARCHIVE}"
(cd "$(dirname "${STAGING}")" && zip -rq "${ARCHIVE}" "${STAGE_NAME}")

echo "==> Done: ${ARCHIVE}"
