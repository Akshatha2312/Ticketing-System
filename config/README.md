# Database Configuration

## Setup Instructions

### Option 1: Using Environment Variables (Recommended - Secure)

1. **Copy the `.env.example` file to `.env`:**
   ```bash
   cp .env.example .env
   ```

2. **Edit `.env` with your actual database credentials:**
   ```bash
   DB_HOST=your-database-host.aivencloud.com
   DB_PORT=11898
   DB_NAME=defaultdb
   DB_USER=your-username
   DB_PASS=your-password
   ```

3. **Start the server (environment variables are loaded automatically):**
   ```bash
   ./start-server.sh
   ```

### Option 2: Using db.php Template (Legacy)

1. **Copy the template file:**
   ```bash
   cp config/db.php.example config/db.php
   ```

2. **Edit `config/db.php` with your actual database credentials**

## Current Implementation

The application now uses **environment variables** for database configuration:
- Database credentials are loaded from `.env` file
- The `.env` file is ignored by Git (secure)
- `config/db.php` reads from environment variables

## Security Notes

⚠️ **IMPORTANT:**
- Never commit `config/db.php` with real credentials to Git
- The actual `db.php` file is listed in `.gitignore` for security
- Keep your database credentials private
- Use environment variables in production

## Files

- `db.php.example` - Template file (safe to commit)
- `db.php` - Your actual config (DO NOT COMMIT - in .gitignore)
- `cloud_db_setup.sql` - Database schema (commit if no sensitive data)
