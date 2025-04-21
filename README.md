# 🚀 X Post Scheduler

[![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?logo=mysql)](https://www.mysql.com/)
[![X API](https://img.shields.io/badge/X_API-v1.1-1DA1F2?logo=x)](https://developer.x.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)
[![GitHub Stars](https://img.shields.io/github/stars/yourusername/x-scheduler?style=social)](https://github.com/yourusername/x-scheduler/stargazers)

Welcome to **X Post Scheduler**, a **PHP-based tool** built on **XAMPP** to schedule and auto-post to X using the X API! 📅✨ Crafted with 💻 . This project is your go-to for automating X posts like a pro! 😎

## 📝 What is X Post Scheduler?

This tool lets you **schedule posts** via a simple HTML form, store them in a **MySQL** database, and automatically publish to X using a cron job. Built with **PHP**, **MySQL**, and the `abraham/twitteroauth` library, it’s perfect for social media enthusiasts, marketers, or devs looking to automate X presence! 🚀

**Tech Stack**:
- 🐘 **PHP**: Backend logic
- 🗄️ **MySQL**: Store scheduled posts
- 📡 **X API v1.1**: Post to X
- 📦 **XAMPP**: Local server
- 🔐 **vlucas/phpdotenv**: Secure credentials

## ✨ Features

- 📝 Schedule posts with text (up to 280 characters) and datetime
- 🗃️ Store posts in MySQL with `pending`, `posted`, or `failed` status
- 🤖 Auto-post to X using a cron job
- 🔄 Retry failed posts (up to 3 attempts)
- 🔒 Secure API credentials with `.env`
- 📱 Simple, responsive HTML form

## 🎥 Demo

Check out the app in action! 🖼️  
[🔗 Live Demo (Placeholder)](https://yourdomain.com/x-scheduler)  
*Coming soon: Hosted demo on GoDaddy!*

## 🛠️ Installation

Follow these steps to set up the X Post Scheduler locally on **XAMPP**:

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/yourusername/x-scheduler.git
   cd x-scheduler
   ```

2. **Install Dependencies**:
   Ensure [Composer](https://getcomposer.org/) is installed, then run:
   ```bash
   composer install
   ```

3. **Set Up X API Credentials**:
   - Go to [X Developer Portal](https://developer.x.com/)
   - Create an app with **Read and write** permissions
   - Copy **API Key**, **API Secret**, **Access Token**, **Access Token Secret**
   - Create `.env` in `x-scheduler/`:
     ```env
     CONSUMER_KEY=your_api_key
     CONSUMER_SECRET=your_api_secret
     ACCESS_TOKEN=your_access_token
     ACCESS_TOKEN_SECRET=your_access_token_secret
     ```

4. **Set Up MySQL Database**:
   - Open `http://localhost/phpmyadmin`
   - Create database: `x_scheduler`
   - Run:
     ```sql
     CREATE TABLE scheduled_posts (
         id INT AUTO_INCREMENT PRIMARY KEY,
         text VARCHAR(280) NOT NULL,
         schedule_time DATETIME NOT NULL,
         status ENUM('pending', 'posted', 'failed') DEFAULT 'pending',
         retry_count INT DEFAULT 0
     );
     ```

5. **Configure XAMPP**:
   - Start **Apache** and **MySQL** in XAMPP Control Panel
   - Place `x-scheduler/` in `C:\xampp\htdocs`

6. **Update Database Credentials**:
   - Edit `schedule.php`:
     ```php
     $db = new PDO('mysql:host=localhost;dbname=x_scheduler', 'root', '');
     ```

7. **Test Setup**:
   - Open `http://localhost/x-scheduler/index.html`
   - Schedule a test post and run `http://localhost/x-scheduler/cron.php`

## 🚀 Usage

1. **Schedule a Post**:
   - Open `http://localhost/x-scheduler/index.html`
   - Enter post text (e.g., “Hello X! #XAPI”) and schedule time
   - Click “Schedule Post”

2. **Run Cron Job**:
   - Manually: Open `http://localhost/x-scheduler/cron.php`
   - Auto: Set up a cron job (e.g., on hosting provider):
     ```bash
     * * * * * /usr/local/bin/php /path/to/cron.php
     ```

3. **Check Posts**:
   - View scheduled posts in `http://localhost/phpmyadmin` (`x_scheduler > scheduled_posts`)
   - Verify posts on your X profile (@yourusername)

📖 **Detailed Guide**: Download [x-scheduler-tutorial.pdf](x-scheduler-tutorial.pdf) for a step-by-step tutorial!


*Add screenshots to `screenshots/` folder in repo*

## 🤝 Contributing

Love automation? Want to add features like media uploads or analytics? 🌟  
1. Fork the repo
2. Create a branch: `git checkout -b feature-name`
3. Commit changes: `git commit -m "Add feature"`
4. Push: `git push origin feature-name`
5. Open a Pull Request

Check [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## 📜 License

This project is licensed under the [MIT License](LICENSE).

## 🌐 Connect with Me

Built with ❤️ by **Ambrish**,  passion for **AI**, **cybersecurity**, **web dev**, and **digital marketing**. Explore my other projects:
- 💼 [VoIP Automation System](https://github.com/ambristech/voip-automation)
- 🛒 [eCommerce Platform](https://github.com/ambristech/ecommerce-platform)

- 📫 GitHub: [yourusername](https://github.com/ambristech)
- 🔗 LinkedIn: [Your LinkedIn](https://linkedin.com/in/ambristech)
- 🐦 X: [@yourusername](https://x.com/ambristech)

Got ideas or collabs? DM me! Let’s build something epic! 🚀

---

⭐ **Star this repo if you find it useful!**  
#XPostScheduler #PHP #WebDev #Automation #LucknowTech
