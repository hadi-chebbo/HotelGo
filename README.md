# 🏨 HotelGo

> A full-featured hotel management system built with Laravel, MySQL, and Tailwind CSS.

---

## 👥 Team

| Member | Role |
|--------|------|
| *(add your names here)* | *(add roles here)* |

---

## ✨ Features

- **Room Management** — Browse, filter, and manage hotel rooms and availability
- **Booking System** — End-to-end reservation flow for guests
- **User Authentication** — Role-based access for admins, hotel staff, and guests
- **Dashboard** — Overview of bookings, occupancy, and revenue
- **Review System** — Guests can leave ratings and feedback
- **Payment Handling** — Integrated payment flow for reservations

---

## 👤 User Roles

| Role | Capabilities |
|------|-------------|
| **System Admin** | Full platform control, manage hotels & users |
| **Hotel Manager** | Manage their hotel's rooms, bookings, and staff |
| **Staff** | Handle check-ins, check-outs, and guest requests |
| **Guest** | Browse hotels, make bookings, leave reviews |

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel (PHP) |
| Database | MySQL |
| Frontend | Tailwind CSS, Blade |
| Auth | Laravel Sanctum / Breeze |
| Version Control | Git & GitHub |

---

## 🗄️ Database Schema

**Key tables:**

- `users` — id, name, email, role, password
- `hotels` — id, name, location, description, manager_id
- `rooms` — id, hotel_id, type, price, availability
- `bookings` — id, user_id, room_id, check_in, check_out, status
- `reviews` — id, user_id, hotel_id, rating, comment
- `payments` — id, booking_id, amount, status, paid_at

---

## 🔀 API Routes

### Auth
| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/register` | Register a new user |
| `POST` | `/api/login` | Login and get token |
| `POST` | `/api/logout` | Revoke token |

### Hotels
| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/hotels` | List all hotels |
| `GET` | `/api/hotels/{id}` | Get hotel details |
| `POST` | `/api/hotels` | Create a hotel *(admin)* |
| `PATCH` | `/api/hotels/{id}` | Update a hotel |
| `DELETE` | `/api/hotels/{id}` | Delete a hotel |

### Rooms
| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/hotels/{id}/rooms` | List rooms for a hotel |
| `POST` | `/api/hotels/{id}/rooms` | Add a room |
| `PATCH` | `/api/rooms/{id}` | Update a room |
| `DELETE` | `/api/rooms/{id}` | Delete a room |

### Bookings
| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/bookings` | List user's bookings |
| `POST` | `/api/bookings` | Create a booking |
| `PATCH` | `/api/bookings/{id}` | Update booking status |
| `DELETE` | `/api/bookings/{id}` | Cancel a booking |

---

## 🔒 Middleware

| Middleware | Purpose |
|------------|---------|
| `auth:sanctum` | Protects authenticated routes |
| `role:admin` | Restricts routes to system admins |
| `role:manager` | Restricts routes to hotel managers |
| `verified` | Requires email verification |

---

## 🚀 Getting Started

```bash
# Clone the repository
git clone https://github.com/your-username/hotelgo.git
cd hotelgo

# Install dependencies
composer install
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Configure your database in .env, then run migrations
php artisan migrate --seed

# Start the development server
php artisan serve
npm run dev
```

---

## 📅 Project Timeline

| Phase | Focus |
|-------|-------|
| Week 1 | Project setup, auth, database schema |
| Week 2 | Hotel & room management |
| Week 3 | Booking system & payments |
| Week 4 | Reviews, dashboard, testing |
| Week 5 | Polish, deployment, documentation |

---

## 📄 License

This project is for educational purposes.
