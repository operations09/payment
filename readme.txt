# Range Markets — Deploy Guide

## 📁 Folder Structure
```
range-markets/
├── index.html                    ← Frontend
├── netlify.toml                  ← Netlify config
└── netlify/
    └── functions/
        ├── submit.js             ← Email backend
        └── package.json          ← nodemailer dependency
```

---

## 🚀 Step 1 — GitHub Upload

1. Go to **github.com** → Sign in
2. Click **"New repository"**
3. Name: `range-markets`
4. Click **"Create repository"**
5. Upload all files (drag & drop or use GitHub Desktop)

---

## 🌐 Step 2 — Netlify Deploy

1. Go to **netlify.com** → Sign in with GitHub
2. Click **"Add new site"** → **"Import an existing project"**
3. Choose **GitHub** → Select `range-markets` repo
4. Build settings:
   - Build command: *(leave empty)*
   - Publish directory: `.`
5. Click **"Deploy site"**

---

## ⚙️ Step 3 — Environment Variables (IMPORTANT!)

In Netlify → **Site Settings** → **Environment Variables** → Add:

| Key | Value |
|-----|-------|
| `SMTP_USER` | your_gmail@gmail.com |
| `SMTP_PASS` | your 16-digit app password |
| `ADMIN_EMAIL` | operations@rangeforex.com |

### Get Gmail App Password:
1. myaccount.google.com → Security
2. 2-Step Verification → **ON**
3. Search "App passwords" → Create → Copy 16-digit password

---

## ✅ Done!

Your site will be live at: `https://your-site-name.netlify.app`

Custom domain add பண்ண: Netlify → Domain Management → Add custom domain
