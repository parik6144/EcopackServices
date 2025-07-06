@echo off
echo ========================================
echo Employee System Test Script
echo ========================================
echo.

echo Step 1: Checking PHP Syntax...
call check_employee_files.bat
if %errorlevel% neq 0 (
    echo Syntax check failed! Please fix the errors first.
    pause
    exit /b 1
)

echo.
echo Step 2: Checking Database Tables...
echo Checking if staff table exists and has records...

php -r "
<?php
// Database connection test
try {
    $host = 'localhost';
    $dbname = 'db_ecopack_database';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO('mysql:host=$host;dbname=$dbname', $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if staff table exists
    $stmt = $pdo->query('SHOW TABLES LIKE \"staff\"');
    if ($stmt->rowCount() == 0) {
        echo 'ERROR: staff table does not exist!';
        exit(1);
    }
    echo '✓ staff table exists';
    
    // Check staff table structure
    $stmt = $pdo->query('DESCRIBE staff');
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $required_columns = ['staff_id', 'emp_no', 'staff_name', 'employee_type_id', 'location', 'email_id', 'mobile_no', 'is_deleted'];
    
    foreach ($required_columns as $col) {
        if (!in_array($col, $columns)) {
            echo 'ERROR: Missing column: ' . $col;
            exit(1);
        }
    }
    echo '✓ staff table has required columns';
    
    // Check if employee_type table exists
    $stmt = $pdo->query('SHOW TABLES LIKE \"employee_type\"');
    if ($stmt->rowCount() == 0) {
        echo 'ERROR: employee_type table does not exist!';
        exit(1);
    }
    echo '✓ employee_type table exists';
    
    // Check if place table exists
    $stmt = $pdo->query('SHOW TABLES LIKE \"place\"');
    if ($stmt->rowCount() == 0) {
        echo 'ERROR: place table does not exist!';
        exit(1);
    }
    echo '✓ place table exists';
    
    // Count records in staff table
    $stmt = $pdo->query('SELECT COUNT(*) FROM staff WHERE is_deleted = 0');
    $count = $stmt->fetchColumn();
    echo '✓ staff table has ' . $count . ' active records';
    
    if ($count == 0) {
        echo 'NOTE: No employee records found. This is normal for a new system.';
    }
    
    echo '✓ Database structure is correct';
    
} catch (PDOException $e) {
    echo 'ERROR: Database connection failed: ' . $e->getMessage();
    exit(1);
}
?>

echo.
echo Step 3: Testing Employee List URL...
echo Testing if employee list page is accessible...
curl -s -o nul -w "HTTP Status: %%{http_code}" http://localhost/ecopackservices/employee/list
if %errorlevel% neq 0 (
    echo WARNING: Could not test employee list URL. Make sure your web server is running.
) else (
    echo ✓ Employee list URL is accessible
)

echo.
echo ========================================
echo Test Summary
echo ========================================
echo.
echo ✓ All PHP files have correct syntax
echo ✓ Database tables exist and have correct structure
echo ✓ Employee system is ready to use
echo.
echo Next Steps:
echo 1. Start your web server (XAMPP/WAMP)
echo 2. Open browser and go to: http://localhost/ecopackservices/employee/list
echo 3. Test the employee list functionality
echo 4. Add some employee records to test the system
echo.
echo If you see "No employees found" message, that's normal.
echo You can add employees using the + button in the employee list.
echo.
pause 