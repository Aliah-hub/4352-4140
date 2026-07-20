#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

if ! command -v php >/dev/null 2>&1; then
  echo "PHP is required but not found in PATH." >&2
  exit 1
fi

cd "$ROOT_DIR"

sqlite3 writable/Mobile_money.db < base.sql

cd "$ROOT_DIR/public"
php -S localhost:8080
