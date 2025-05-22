# XKCD Email Subscription Service

This PHP project sends daily XKCD comic updates to a list of subscribed users via email every morning at 9:00 AM.

## 📦 Features

- Fetches the latest XKCD comic from the XKCD API
- Sends formatted HTML emails to subscribed users
- Each email includes an unsubscribe link
- Secure credentials management using `.env`
- Automatically scheduled with cron jobs

---

## 🛠️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/Udit-exe/XKCD-comic.git
cd src
````

---

### 2. Install Dependencies

Make sure you have [Composer](https://getcomposer.org/) installed. Then run:

```bash
composer require phpmailer/phpmailer
```

---

### 3. Create a `.env` File

Inside the `src/` directory, create a file named `.env`:

```env
SMTP_USER=your_email@gmail.com
SMTP_PASS=your_app_password
```

> ⚠️ Do not commit this file! It is already ignored via `.gitignore`.

---

### 4. Manually Add Subscriber Emails
`for testing puspose only.`
Edit `src/registered_emails.txt` and add one email per line:

```
example1@gmail.com
example2@gmail.com
```

---

### 5. Setup Cron Job (Linux/macOS)

This will run the email script daily at 9:00 AM.


## 🧪 Manual Test

To test manually, run:

```bash
php src/cron.php
```

---

## 📁 Project Structure

```
src/
├── cron.php                  # Main script for sending emails
├── registered_emails.txt     # Email list
├── .env                      # SMTP credentials (not committed)
├── utils.php                 # Fetches and formats XKCD comic
├── unsubscribe.php           # Handles unsubscribes
├── style.css                 # Frontend styling
```

---

## 🔒 Security Notice

Never commit the `.env` file. Ensure your `.gitignore` includes:

```
src/.env
```

---

## Sample Emails
<img src="https://github.com/user-attachments/assets/899d06ae-9d54-423c-a1be-99e20bb43f65" width="300" />
<br>
<img src="[https://github.com/user-attachments/assets/47201f09-b2d0-410a-95bb-0a039037ba59" width="300" />

