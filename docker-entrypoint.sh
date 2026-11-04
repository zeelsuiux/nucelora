#!/bin/bash
set -e

# Start MariaDB server
service mariadb start

# Ensure root access without password and grant privileges
mariadb -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD('');" 2>/dev/null || true
mariadb -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' IDENTIFIED VIA mysql_native_password USING PASSWORD('');" 2>/dev/null || true
mariadb -e "FLUSH PRIVILEGES;" 2>/dev/null || true

# Verify if database and products exist, if not import
if ! mariadb -e "SELECT 1 FROM lymko_db.products LIMIT 1;" >/dev/null 2>&1; then
    echo "Initializing database lymko_db from database/init.sql..."
    mariadb -e "CREATE DATABASE IF NOT EXISTS lymko_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    mariadb lymko_db < /var/www/html/database/init.sql
    echo "Database initialized successfully!"
fi

# Execute CMD (Apache foreground)
exec "$@"
