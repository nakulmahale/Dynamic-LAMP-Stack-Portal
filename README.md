# 📢 Dynamic LAMP Stack Deployment on RHEL 10

A complete deployment of a multi-tier LAMP (Linux, Apache, MariaDB, PHP) stack web server configured on Red Hat Enterprise Linux 10.

## 🚀 Tech Stack
* **OS:** Red Hat Enterprise Linux 10 (RHEL 10)
* **Web Server:** Apache (httpd 2.4)
* **Database:** MariaDB Server
* **Scripting Engine:** PHP 8.x with PDO extension
* **Frontend:** HTML5, CSS3, JavaScript

## 📌 Features
* Secure database connection handling via PHP Data Objects (PDO).
* Dynamic web interface displaying persistent records from MariaDB `app_db`.
* Client-side search and live record filtering via vanilla JavaScript.
* Firewalld and SELinux boolean permissions (`httpd_can_network_connect_db`) configured for web-to-database communication.

## 🛠️ Quick Setup
1. Clone repository into Apache document root:
