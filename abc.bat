@echo off
REM Create folders
mkdir application\views\employee\tabs\personal
mkdir assets\css\employee
mkdir assets\js\employee

REM Create view files
type nul > application\views\employee\employee_form.php
type nul > application\views\employee\tabs\master.php
type nul > application\views\employee\tabs\payment.php
type nul > application\views\employee\tabs\administration.php
type nul > application\views\employee\tabs\statutory.php
type nul > application\views\employee\tabs\personal\main.php
type nul > application\views\employee\tabs\personal\address.php
type nul > application\views\employee\tabs\personal\academic.php
type nul > application\views\employee\tabs\personal\family.php
type nul > application\views\employee\tabs\personal\nomination.php
type nul > application\views\employee\tabs\personal\career.php
type nul > application\views\employee\tabs\personal\medical.php
type nul > application\views\employee\tabs\personal\emergency.php
type nul > application\views\employee\tabs\personal\attachments.php

REM Create CSS files
type nul > assets\css\employee\employee_form.css
type nul > assets\css\employee\master.css
type nul > assets\css\employee\personal_main.css
type nul > assets\css\employee\personal_address.css
type nul > assets\css\employee\personal_academic.css
type nul > assets\css\employee\personal_family.css
type nul > assets\css\employee\personal_nomination.css
type nul > assets\css\employee\personal_career.css
type nul > assets\css\employee\personal_medical.css
type nul > assets\css\employee\personal_emergency.css
type nul > assets\css\employee\personal_attachments.css
type nul > assets\css\employee\payment.css
type nul > assets\css\employee\administration.css
type nul > assets\css\employee\statutory.css

REM Create JS files
type nul > assets\js\employee\employee_form.js
type nul > assets\js\employee\master.js
type nul > assets\js\employee\personal_main.js
type nul > assets\js\employee\personal_address.js
type nul > assets\js\employee\personal_academic.js
type nul > assets\js\employee\personal_family.js
type nul > assets\js\employee\personal_nomination.js
type nul > assets\js\employee\personal_career.js
type nul > assets\js\employee\personal_medical.js
type nul > assets\js\employee\personal_emergency.js
type nu
