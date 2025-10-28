#!/bin/bash

# Ticketing System - Quick Start Script
# This script helps you quickly start the PHP development server

echo "=========================================="
echo "   Ticketing System - Quick Start"
echo "=========================================="
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null
then
    echo "❌ PHP is not installed!"
    echo "Please install PHP first:"
    echo "  brew install php"
    exit 1
fi

# Display PHP version
PHP_VERSION=$(php -v | head -n 1)
echo "✅ PHP found: $PHP_VERSION"
echo ""

# Check if mysqli extension is available
if php -m | grep -q mysqli; then
    echo "✅ mysqli extension is available"
else
    echo "⚠️  Warning: mysqli extension might not be available"
fi

# Check if openssl extension is available
if php -m | grep -q openssl; then
    echo "✅ openssl extension is available"
else
    echo "⚠️  Warning: openssl extension might not be available (required for cloud DB)"
fi

echo ""
echo "=========================================="
echo "   Database Configuration"
echo "=========================================="
echo "Host: mysql-261a2305-angokul88-2e3f.d.aivencloud.com"
echo "Port: 11898"
echo "Database: defaultdb"
echo "SSL: Required"
echo ""

# Navigate to the script directory
cd "$(dirname "$0")"

echo "=========================================="
echo "   Starting PHP Development Server"
echo "=========================================="
echo ""
echo "Server will start at: http://localhost:8000"
echo ""
echo "Available pages:"
echo "  • Home:    http://localhost:8000/index.php"
echo "  • Login:   http://localhost:8000/login.php"
echo "  • About:   http://localhost:8000/about.php"
echo ""
echo "Press Ctrl+C to stop the server"
echo ""
echo "=========================================="
echo ""

# Start PHP built-in server
php -S localhost:8000
