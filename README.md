# 🏨 HotelGo.

> A comprehensive hotel management & booking platform — from room discovery to checkout.

![Laravel](https://img.shields.io/badge/Laravel-f05340?style=flat-square&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00adef?style=flat-square&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38bdf8?style=flat-square&logo=tailwindcss&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-f7df1e?style=flat-square&logo=javascript&logoColor=black)
![Chart.js](https://img.shields.io/badge/Chart.js-ff6384?style=flat-square&logo=chartdotjs&logoColor=white)

👤 **Fatima JANNOUN** · 👤 **Hadi CHEBBO**

---

## 📖 Overview

HotelGo is a full-stack hotel management and booking system built with the Laravel framework. It supports the complete booking lifecycle — from browsing available hotels to processing payments — while providing role-specific dashboards, a loyalty program, and automated email notifications.

The platform serves four distinct user types: unauthenticated guests, registered customers, hotel administrators, and system administrators — each with their own permission scope enforced through custom middleware.

---

## ✨ Core Features

| Feature | Description |
|---------|-------------|
| 🔐 **Authentication & RBAC** | Laravel Breeze scaffolding with email verification and four role levels enforced by custom middleware |
| 📅 **Reservation System** | Online and walk-in bookings with real-time availability calendar, date conflict checks, and status tracking |
| 💳 **Payment Handling** | Deposit and full payment flows, tracked per reservation with support for multiple payment methods |
| 🎁 **Loyalty & Promo Codes** | Points earned on every booking, redeemable for discounts. Hotel admins manage promo codes with validity windows |
| 🔍 **Search & Filtering** | Dynamic query builder search by name, location, price range, and room type with paginated results |
| ⭐ **Reviews & Ratings** | Only verified guests may review. Average ratings recalculate in real-time and power top-hotel rankings |
| 📊 **Dashboards & Analytics** | Chart.js-powered metrics: revenue, bookings, room stats, and ratings for both admin types |
| ✉️ **Email Notifications** | SMTP transactional emails for cancellations, account changes, and day-before reminders via Laravel Scheduler |

---

## 👥 User Roles

### 🟡 System Admin — Full Control
- Create & manage all hotels
- Block / unblock users
- Global analytics dashboard
- Manage all user roles

### 🔵 Hotel Admin — Hotel Scope
- Manage rooms & room types
- Handle online & walk-in bookings
- Create promo codes
- Hotel-specific dashboard

### 🟢 Customer — Registered User
- Make & cancel reservations
- Apply promo codes
- Earn loyalty points
- Submit hotel reviews

### 🟣 Guest — Unauthenticated
- Browse & search hotels
- View ratings & details
- See top-rated hotels
- Register to unlock more

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel (PHP) |
| Database | MySQL |
| Frontend | Tailwind CSS + Blade Templates |
| Charts | Chart.js |
| Auth | Laravel Breeze |
| Email (Dev) | Mailtrap |
| Scheduling | Laravel Scheduler |

---

## 🗄️ Database Schema

### `users`
```
id · name · email · phone · role (0/1/2) · loyalty_points
```

### `hotels`
```
id · user_id (FK) · name · description · location · email · image
```

### `room_types`
```
id · hotel_id (FK) · type (unique/hotel) · capacity · price_per_night
```

### `rooms`
```
id · hotel_id (FK) · room_type_id (FK) · room_number (unique/hotel) · floor · status
```

### `reservations`
```
id · user_id (FK) · room_id (FK) · hotel_id (FK) · guest_id? (FK) · promo_code_id? (FK)
check_in · check_out · total
```

### `payments`
```
id · reservation_id (FK) · amount · method · status · transaction_date
```

### `reviews`
```
id · user_id (FK) · hotel_id (FK) · comment · rating
```

### `promo_codes`
```
id · hotel_id (FK) · code · discount_% · start_date · end_date
```

---

## 🔀 Web Routes

### Public

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/` | Homepage & top hotels |
| `GET` | `/search` | Search hotels |
| `GET` | `/hotels/index` | List all hotels |
| `GET` | `/hotels/{hotel}/show` | Hotel detail page |

### Authenticated Users

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/profile` | Edit profile |
| `PATCH` | `/profile` | Update profile |
| `DELETE` | `/profile` | Delete account |
| `GET` | `/reservations` | My reservations & points |
| `PATCH` | `/reservations/{reservation}` | Cancel reservation |

### Hotel Admin — `/hotel-admin/`

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/hotel-admin/dashboard` | Hotel dashboard |
| `POST` | `/hotel-admin/rooms/create` | Create room |
| `PUT` | `/hotel-admin/rooms/{room}/edit` | Update room |
| `POST` | `/hotel-admin/reservations/create` | Walk-in reservation |
| `PATCH` | `/hotel-admin/promocodes/{code}/activate` | Toggle promo code |

### System Admin — `/admin/`

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/admin/users` | List all users |
| `POST` | `/admin/users/{user}/block` | Block user |
| `POST` | `/admin/hotels/create` | Create hotel |
| `DELETE` | `/admin/hotels/{hotel}/delete` | Delete hotel |
| `GET` | `/admin/analytics` | System analytics |

---

## 🔒 Middleware Strategy

| Middleware | Purpose |
|------------|---------|
| `auth` | Verifies user session. Redirects unauthenticated requests to login |
| `verified` | Ensures email is confirmed before accessing dashboards and reservations |
| `CheckIfBlocked` | Prevents blocked users from accessing any part of the application |
| `SystemAdminMiddleware` | Restricts system admin routes — checks `role = 1` in database |
| `HotelAdminMiddleware` | Restricts hotel admin routes — checks `role = 2` in database |

> Layers run in order: **auth → verified → block check → role authorization**

---

## 📅 Project Timeline

| Phase | Focus |
|-------|-------|
| **Week 1** | Laravel project setup, schema design, migrations with constraints, foreign keys, and unique indexes |
| **Week 2** | Models, controllers, business logic for reservations, payments, loyalty points, and reviews |
| **Week 3** | Blade layouts, Tailwind CSS, reusable components, reservation calendar, and Chart.js dashboards |
| **Week 4** | Unit, feature, and end-to-end testing. Bug fixes, query optimization, and production preparation |

---

## 🚀 Getting Started

```bash
# Clone the repository
git clone https://github.com/hadi-chebbo/hotelgo.git
cd hotelgo

# Install dependencies
composer install
npm install && npm run build

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start the development server
php artisan serve
```

> 📧 Add your **Mailtrap** credentials to `.env` to test email notifications locally.

---

Academic project · All rights reserved by Fatima JANNOUN & Hadi CHEBBO
