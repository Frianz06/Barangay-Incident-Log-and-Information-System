# 📋 Barangay Incident Log and Information System

A web-based incident logging, tracking, and reporting system designed for Barangay-level governance.  
Built from scratch as a small capstone project for **BSIT – 2nd Year, National College of Science & Technology**.

🗓️ **Development Timeline:**  
**Start:** October 2024  
**Completed:** December 2024

---

## 📌 Features

✅ Submit incident reports from the user side  
✅ Admin-side incident monitoring and resolution logging  
✅ Automatic archiving of resolved reports  
✅ Login/Registration system for Admins and Users  
✅ Admin dashboard for monitoring pending/resolved/archived incidents  
✅ Generate PDF reports using FPDF (Incident, Resolve, Archive)  
✅ Bootstrap modal for welcome message  
✅ Form validation and feedback  
✅ Modular headers per user role and page type  

---

## 💻 Technologies Used

- PHP 7+
- MySQL (phpMyAdmin)
- Bootstrap 5
- Font Awesome
- JavaScript (including AJAX)
- DataTables
- FPDF
- Manual CSS

---

## 📂 Project Structure
Barangay-Incident-Log/
├── admin_archive_log.php
├── admin_dashboard.php
├── admin_incident_log.php
├── admin_log.php
├── admin_resolve_log.php
├── brgy_san_francisco.sql
├── css/
├── dashboard/
├── EME_user_report.php
├── FINAL PAPER.pdf
├── fpdf/
├── Group Photos/
├── images/
├── img/
├── includes/
│ ├── headers/
│ ├── admin_config.php
│ ├── admin_log_form.php
│ ├── admin_register.php
│ ├── admin_resolve_form.php
│ ├── user_config.php
│ ├── user_report_form.php
│ └── ...etc
├── index.php
├── js/
├── MUST READ.txt
├── reports_pdf/
├── user_dashboard.php
├── user_log.php
├── user_report.php

---

## ⚙️ Setup Instructions (Using XAMPP)

1. **Download or Clone the Repository:**
   ```bash
   git clone https://github.com/your-username/Barangay-Incident-Log.git
   
2. Place the Project Folder:
Move the folder into htdocs/ directory of your XAMPP installation.

3. Import the Database:

Open http://localhost/phpmyadmin

Create a new database (e.g., brgy_san_francisco)

Import the file: brgy_san_francisco.sql from the project root

4. Run the System:
Access it through your browser at:
http://localhost/Barangay-Incident-Log/

👤 Author
Ychicko Legaspi
2nd Year BSIT Student
📍 National College of Science & Technology
🗓️ October – December 2024

📎 License
This repository is currently private/unlicensed. All rights reserved by the author.
