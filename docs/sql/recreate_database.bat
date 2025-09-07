@echo off
echo ====================================
echo Point 100: Database Recreation Script
echo ====================================
echo.

REM Configuration - Update these values as needed
set DB_HOST=localhost
set DB_USER=root
set DB_PASS=
set DB_NAME=arsoa

echo WARNING: This script will DROP and RECREATE all eeform1 tables!
echo All existing data will be LOST!
echo.
echo Database: %DB_NAME%
echo Host: %DB_HOST%
echo User: %DB_USER%
echo.
set /p CONFIRM=Are you sure you want to continue? (yes/no): 

if not "%CONFIRM%"=="yes" (
    echo Operation cancelled.
    pause
    exit /b
)

echo.
echo Creating backup of existing data...
echo.

REM Create backup script
echo -- Backup existing data > backup_existing.sql
echo SET @backup_date = NOW(); >> backup_existing.sql
echo CREATE TABLE IF NOT EXISTS eeform1_submissions_backup AS SELECT *, @backup_date as backup_date FROM eeform1_submissions WHERE 1=0; >> backup_existing.sql
echo INSERT INTO eeform1_submissions_backup SELECT *, @backup_date FROM eeform1_submissions; >> backup_existing.sql

REM Execute backup (ignore errors if tables don't exist)
mysql -h %DB_HOST% -u %DB_USER% %DB_PASS% %DB_NAME% < backup_existing.sql 2>nul

echo Executing database recreation script...
mysql -h %DB_HOST% -u %DB_USER% %DB_PASS% %DB_NAME% < recreate_eeform1.sql

if %ERRORLEVEL% neq 0 (
    echo ERROR: Database recreation failed!
    echo Check MySQL connection and permissions.
    pause
    exit /b 1
)

echo.
echo Database recreation completed successfully!
echo.

echo Running database tests...
php test_eeform1_database.php

if %ERRORLEVEL% neq 0 (
    echo WARNING: Database tests failed!
    echo Please check the test output above.
) else (
    echo.
    echo ====================================
    echo Point 100 COMPLETED SUCCESSFULLY!
    echo ====================================
    echo.
    echo - Old tables removed
    echo - New schema imported
    echo - All tests passed
    echo - Database ready for use
)

echo.
echo Cleaning up temporary files...
del backup_existing.sql 2>nul

echo.
pause