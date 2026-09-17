#!/bin/bash

set -euo pipefail

THEME_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
THEME_BUILD_DIR="$THEME_ROOT/build"

build_frontend_assets() {
    echo "building front end assets"
    npm run build
    cp -r "assets" "$THEME_BUILD_DIR/"
}

copy_theme_files_to_build_dir() {
    echo "building theme folder"
    mkdir -p "build"
    cp -r "parts" "$THEME_BUILD_DIR/"
    cp -r "vendor" "$THEME_BUILD_DIR/"
    cp -r "include" "$THEME_BUILD_DIR/"
    cp "front-page.php" "$THEME_BUILD_DIR/"
    cp "archive-shooting.php" "$THEME_BUILD_DIR/"
    cp "functions.php" "$THEME_BUILD_DIR/"
    cp "home.php" "$THEME_BUILD_DIR/"
    cp "index.php" "$THEME_BUILD_DIR/"
    cp "page-contact.php" "$THEME_BUILD_DIR/"
    cp "single-post.php" "$THEME_BUILD_DIR/"
    cp "single-shooting.php" "$THEME_BUILD_DIR/"
    cp "style.css" "$THEME_BUILD_DIR/"
}

install_composer_dependencies() {
    echo "intalling composer dependencies"
    composer install --no-dev --prefer-dist --optimize-autoloader
}

run_build_script() {
    echo "building theme"
    install_composer_dependencies
    copy_theme_files_to_build_dir
    build_frontend_assets
}

if [ -d "$THEME_BUILD_DIR" ]; then
    rm -rf "$THEME_BUILD_DIR"
    run_build_script
else
    run_build_script
fi

echo "theme is ready to use!"
