# Debugging Guide for skin_scores API Issue

## Problem Description
Data is being saved to skin_scores during form submission, but the API `/api/eeform1/submission/{id}` returns empty skin_scores data.

## Debugging Steps Implemented

### 1. Model Level Debugging (Eeform1Model.php)
- **Table Existence Check**: Verifies if `eeform1_skin_scores` table exists
- **Fallback Mechanism**: Uses `eeform1_moisture_scores` if new table doesn't exist
- **Data Insertion Logging**: Logs success/failure of each skin_score insertion
- **SQL Query Logging**: Shows exact SQL queries being executed
- **Database Error Checking**: Catches and logs any database errors

### 2. Controller Level Debugging (Eeform1.php)
- **Response Structure Logging**: Logs the complete API response structure
- **Data Count Verification**: Shows count of skin_scores and moisture_scores
- **Sample Data Logging**: Displays sample records for verification

### 3. Standalone Debug Script (debug_skin_scores.php)
- **Direct Database Check**: Bypasses CodeIgniter to check database directly
- **Table Structure Verification**: Shows table schema and existence
- **Data Verification**: Displays actual records in the database

## How to Use the Debugging

### Step 1: Check Error Logs
After calling the API endpoint, check your PHP error logs for entries like:
```
Table eeform1_skin_scores exists: YES/NO
SQL Query for skin_scores: SELECT * FROM eeform1_skin_scores WHERE submission_id = 2
Found skin_scores records count: X for submission_id: 2
API submission response debug for ID 2:
skin_scores count: X
```

### Step 2: Run Debug Script
Execute `debug_skin_scores.php` to get direct database information:
```bash
php debug_skin_scores.php
```

This will show:
- Whether tables exist
- Record counts
- Sample data
- Recent submissions

### Step 3: Check Form Submission
Submit a new form and check logs for:
```
Processing skin categories for submission_id: X
Available form data fields: field1, field2, ...
Successfully inserted skin_score: {...} with ID: X
```

### Step 4: Identify the Issue
Based on the logs, the issue could be:

1. **Table Missing**: `eeform1_skin_scores` table doesn't exist
   - Solution: Create the table using schema in docs/sql/eeform1.md

2. **Data Not Inserting**: Form data not being saved
   - Check if form field names match expected pattern: `{category}_{type}`
   - Verify database connection and permissions

3. **Data Not Retrieving**: Data exists but not being fetched
   - Check SQL query syntax and table name
   - Verify submission_id is correct

4. **Data Not Returning**: Data fetched but not included in API response
   - Check final response structure in logs
   - Verify array keys are correctly assigned

## Expected Log Flow (Success Case)
```
Processing skin categories for submission_id: 3
Available form data fields: moisture_severe, moisture_warning, moisture_healthy, ...
Successfully inserted skin_score: {"submission_id":3,"category":"moisture","score_type":"severe","score_value":2} with ID: 15
...
Table eeform1_skin_scores exists: YES
SQL Query for skin_scores: SELECT * FROM eeform1_skin_scores WHERE submission_id = 3
Found skin_scores records count: 24 for submission_id: 3
API submission response debug for ID 3:
skin_scores count: 24
```

## Cleanup
After identifying and fixing the issue, remove debugging code:
1. Remove error_log statements from model and controller
2. Delete debug_skin_scores.php
3. Remove DEBUGGING_GUIDE.md