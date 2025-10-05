# 🏝️ Tourism Activity Booking System

A **Laravel 12**-based RESTful API for managing tourism activities and bookings.  
Users can browse, book, and cancel tourism activities, while the system handles email notifications, reminders, and booking confirmations using Laravel’s **Queues**, **Events**, and **Mailables**.

---

## 🚀 Features

### 🎫 Activity Management
- Create, read, update, and delete tourism activities.
- Upload and manage activity images.
- Filter and search activities by **name**, **location**, **price**, or **availability**.
- Automatic validation via **Form Requests**.

### 📅 Booking Management
- Book activities with available slots.
- Reduce available slots automatically after booking.
- Cancel bookings with custom reason.
- Automatically restore slots when a booking is cancelled.
- Prevent cancellation after the activity has started.

### 📧 Notifications & Emails
- Send **confirmation emails** to users on successful booking.
- Notify **admin** when a new booking is created.
- Send **reminder emails** to users 24 hours before activity start.
- All emails use **Laravel Queues** for asynchronous delivery.

### ⚙️ Event & Listener System
- Event: `BookingCreated`, `BookingCancelled`
- Listeners: 
  - `SendBookingConfirmationMail`
  - `NotifyAdminOfBooking`
  - `SendBookingCancellationMail`
- All listeners implement `ShouldQueue` for optimized performance.

### 🔍 Search & Filtering
- `GET /api/v1/activities?name=tehran&max_price=300&available=1`
- Scope-based filtering inside the `Activity` model (`scopeFilter`).

### 🔒 Authentication
- JWT-based authentication for users.
- Protected routes using Laravel middleware.

---

## 🧠 Technologies Used

| Category | Stack |
|-----------|--------|
| **Framework** | Laravel 12 |
| **Database** | MySQL |
| **Authentication** | JWT (Laravel Sanctum / tymon/jwt-auth) |
| **Queues** | Laravel Queue (Database / Redis) |
| **Scheduler** | Laravel Task Scheduling |
| **Mail Driver** | Mailtrap (sandbox environment) |
| **Testing** | PHPUnit / Postman |
| **API Format** | JSON (Custom json() helper) |

## ⚙️ Installation & Setup

### 1️⃣ Clone the repository
git clone https://github.com/yourusername/tourism-activity-booking.git
cd tourism-activity-booking

### 2️⃣ Install dependencies

composer install

### 3️⃣ Set up environment

cp .env.example .env
php artisan key:generate


Then update your `.env` file:

DB_DATABASE=booking_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_user
MAIL_PASSWORD=your_mailtrap_pass

QUEUE_CONNECTION=database

### 4️⃣ Run migrations

php artisan migrate


### 5️⃣ Run queue worker (for async emails)

php artisan queue:work


### 6️⃣ Run scheduler (for daily reminders)

php artisan schedule:work




## 🧩 API Endpoints

### 🔐 Auth

| Method | Endpoint                | Description             |
| ------ | ----------------------- | ----------------------- |
| POST   | `/api/v1/user/register` | Register a new user     |
| POST   | `/api/v1/user/login`    | Authenticate user (JWT) |

### 🏝️ Activities

| Method | Endpoint                  | Description            |
| ------ | ------------------------- | ---------------------- |
| GET    | `/api/v1/activities`      | List all activities    |
| POST   | `/api/v1/activities`      | Create new activity    |
| GET    | `/api/v1/activities/{id}` | Show specific activity |
| PUT    | `/api/v1/activities/{id}` | Update activity        |
| DELETE | `/api/v1/activities/{id}` | Delete activity        |

### 📆 Bookings

| Method | Endpoint                  | Description                     |
| ------ | ------------------------- | ------------------------------- |
| POST   | `/api/v1/bookings`        | Create booking                  |
| POST   | `/api/v1/bookings/cancel` | Cancel booking by activity name |

---

## 🧠 Logic Highlights

* **Custom Exception Handling:**
  Each exception (e.g. `InvalidActivityException`) implements `render()` to return consistent JSON output.

* **Custom `json()` helper:**
  All API responses follow a unified structure:

  {
    "status": "success",
    "data": { ... }
  }

* **Transactional Booking Logic:**
  Booking creation and use `DB::transaction()` to maintain data consistency.

* **Queued Mails & Listeners:**
  Every mail and event listener implements `ShouldQueue` for optimal async performance.


## 🧪 Testing

You can test endpoints via **Postman** or **Laravel HTTP tests**.

php artisan test


Example:

POST /api/v1/bookings
{
  "activity_id": 1,
  "slots_number": 2
}


## 🧭 Future Improvements

* [ ] Payment gateway integration (Zarinpal / Stripe sandbox)
* [ ] Multi-language email templates
* [ ] Admin dashboard (Vue.js or React)
* [ ] Role-based authorization (Admin / User)
* [ ] Activity ratings and reviews

---

## 🧑‍💻 Author

**[Amirhosein Ayinie]**
Laravel Developer & Backend Engineer
📧 [ayinie2003@gmail.com]
🔗 [LinkedIn](https://linkedin.com/in/amirhosein-ayinie-9367a9378) | [GitHub](https://github.com/amirayinie)


## ❤️ Credits

* Framework: [Laravel](https://laravel.com)
* Mail Testing: [Mailtrap](https://mailtrap.io)
* Queue System: Laravel Horizon / Database Queue
* Developed with 💻 & ☕ by You
