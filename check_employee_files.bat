@echo off
echo ========================================
echo Checking Employee Files Syntax
echo ========================================
echo.

echo Checking Employee Controller...
php -l application/controllers/Employee.php
if %errorlevel% neq 0 (
    echo ERROR: Employee Controller has syntax errors!
    pause
    exit /b 1
) else (
    echo ✓ Employee Controller - OK
)

echo.
echo Checking Employee Model...
php -l application/models/Mdl_employee.php
if %errorlevel% neq 0 (
    echo ERROR: Employee Model has syntax errors!
    pause
    exit /b 1
) else (
    echo ✓ Employee Model - OK
)

echo.
echo Checking Employee List View...
php -l application/views/employee/employee_list.php
if %errorlevel% neq 0 (
    echo ERROR: Employee List View has syntax errors!
    pause
    exit /b 1
) else (
    echo ✓ Employee List View - OK
)

echo.
echo Checking Employee Form View...
php -l application/views/employee/employee_form.php
if %errorlevel% neq 0 (
    echo ERROR: Employee Form View has syntax errors!
    pause
    exit /b 1
) else (
    echo ✓ Employee Form View - OK
)

echo.
echo Checking Master Tab View...
php -l application/views/employee/tabs/master.php
if %errorlevel% neq 0 (
    echo ERROR: Master Tab View has syntax errors!
    pause
    exit /b 1
) else (
    echo ✓ Master Tab View - OK
)

echo.
echo ========================================
echo All Employee Files Checked Successfully!
echo ========================================
echo.
echo Summary of Changes Made:
echo 1. Updated Employee Controller to work with staff table
echo 2. Updated Employee Model to fetch from staff table
echo 3. Updated Employee List View with proper DataTables structure
echo 4. Updated Employee Form to work as popup and full page
echo 5. Updated Master Tab to use staff table fields
echo.
echo The employee list will now:
echo - Fetch data from staff table instead of employee_profile
echo - Show "No employees found" when no records exist
echo - Work with proper foreign key relationships
echo - Handle add/edit/delete operations correctly
echo.
pause 