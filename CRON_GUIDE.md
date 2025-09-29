# 📋 Cron Job Scripts Guide - Which File to Use?

## 🎯 **RECOMMENDED FOR YOUR LIVE SERVER**

### ✅ **USE THIS ONE: `cron_simple.php`**
**Purpose:** Process generation bonuses (33% system) with 10-level structure
**Best for:** Live servers with 1,000+ users
**Features:**
- Session-free (no PHP warnings)
- Uses configuration file (cron_config.php)
- Auto-detects server paths
- Shows detailed progress and debugging
- Handles large user bases efficiently

**How to use:**
```bash
# In your cPanel Cron Jobs, set this command:
/usr/bin/php /var/www/vhosts/capitolmoneypay.com/httpdocs/db/cron_simple.php

# Or with specific date:
/usr/bin/php /var/www/vhosts/capitolmoneypay.com/httpdocs/db/cron_simple.php 2025-09-29
```

## 📁 **OTHER FILES EXPLAINED**

### `cron_config.php`
**Purpose:** Configuration file used by cron_simple.php
**Contains:** Server paths, batch sizes, memory limits, timezone
**Don't run this directly** - it's just configuration

### `cron_db.php`
**Purpose:** Session-free database connection for cron jobs
**Don't run this directly** - it's just a database connection file

### `cron_generation_bonus.php`
**Purpose:** Advanced version with path auto-detection
**Use when:** You have complex server setup or need advanced options
**More complex** than cron_simple.php

### `cron_generation_bonus_absolute.php`
**Purpose:** Version with hardcoded absolute paths
**Use when:** Auto-detection fails and you need manual path control
**Requires manual path editing**

### `crone_job.php` (Old file)
**Purpose:** SMS processing (not generation bonuses)
**Status:** Old file, not related to generation bonuses

## 🔧 **SETUP STEPS**

1. **Use `cron_simple.php`** - it's the most reliable
2. **Update `cron_config.php`** if needed (usually auto-detection works)
3. **Set up your cPanel cron job** to run cron_simple.php daily
4. **Test first** to make sure it works

## ⏰ **RECOMMENDED CRON SCHEDULE**

```
# Run daily at 2:00 AM
0 2 * * * /usr/bin/php /var/www/vhosts/capitolmoneypay.com/httpdocs/db/cron_simple.php
```

## 🎯 **SUMMARY**
- **For Generation Bonuses:** Use `cron_simple.php`
- **For Configuration:** Edit `cron_config.php` if needed
- **Don't use:** The other cron files unless cron_simple.php fails