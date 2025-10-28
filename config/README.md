# Database Configuration

## Setup Instructions

1. **Copy the template file:**
   ```bash
   cp config/db.php.example config/db.php
   ```

2. **Edit `config/db.php` with your actual database credentials:**
   - Get your credentials from your cloud database provider (Aiven, AWS RDS, etc.)
   - Update the following values:
     - `$host` - Your database host
     - `$username` - Your database username
     - `$password` - Your database password
     - `$dbname` - Your database name (usually 'defaultdb')
     - `$port` - Your database port (usually 11898 for Aiven)

3. **Import the database schema:**
   ```bash
   mysql -h YOUR_HOST -P YOUR_PORT -u YOUR_USERNAME -p'YOUR_PASSWORD' --ssl-mode=REQUIRED YOUR_DATABASE < config/cloud_db_setup.sql
   ```

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
