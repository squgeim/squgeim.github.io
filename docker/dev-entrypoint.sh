#!/bin/sh
set -e

echo "==> Initial build"
make

echo "==> Serving at http://localhost:${PORT:-8080}"
php -S "0.0.0.0:${PORT:-8080}" &

echo "==> Watching src/ for changes..."
while true; do
  find src/ -name "*.php" -o -name "*.md" | entr -dn make
done
