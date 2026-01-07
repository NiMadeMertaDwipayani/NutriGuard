# NutriGuard 🛡️

**Your Personal Food Safety Assistant**

NutriGuard is a web-based platform designed to assist users in managing food safety and nutrition information. This project demonstrates a modern implementation of a **RESTful API** backend using **Laravel 12**, featuring secure authentication and robust data management.

## 🚀 Tech Stack

* **Framework:** Laravel 12
* **Language:** PHP 8.2+
* **Database:** MySQL
* **Authentication:** JWT-Auth (`php-open-source-saver/jwt-auth`)
* **API Testing:** Postman

## ✨ Key Features

### 🔐 Secure Authentication (JWT)
* **Stateless Authentication:** Implemented using **JSON Web Tokens (JWT)** for secure API access without session cookies.
* **Role-Based Protection:** Critical endpoints are protected using Middleware (`auth:api`), ensuring only authorized users can modify data.

### 📡 RESTful API Architecture
* **CRUD Operations:** Full Create, Read, and Delete capabilities for "Ingredients" data management.
* **Standardized JSON Responses:** All API responses follow a consistent format (`status`, `message`, `data`) for easy frontend integration.
* **Input Validation:** Server-side validation to prevent invalid data entry (returns `422 Unprocessable Content`).

## 🔌 API Endpoints Reference

| Method | Endpoint | Description | Auth (Token) |
| :--- | :--- | :--- | :---: |
| `POST` | `/api/login` | Authenticate admin & retrieve JWT Token | ❌ |
| `GET` | `/api/ingredients` | Retrieve list of food ingredients | ❌ |
| `POST` | `/api/ingredients` | Add a new ingredient to database | ✅ |
| `DELETE` | `/api/ingredients/{id}` | Remove an ingredient by ID | ✅ |

## 🛠️ Installation & Setup

If you want to run this project locally:

1.  **Clone the repository**
    ```bash
    git clone [https://github.com/NiMadeMertaDwipayani/NutriGuard.git](https://github.com/NiMadeMertaDwipayani/NutriGuard.git)
    ```
2.  **Install Dependencies**
    ```bash
    composer install
    ```
3.  **Setup Environment**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Generate JWT Secret**
    ```bash
    php artisan jwt:secret
    ```
5.  **Run Migrations**
    ```bash
    php artisan migrate
    ```
6.  **Start Server**
    ```bash
    php artisan serve
    ```

---
*Developed by **Ni Made Merta Dwipayani** as a mid-exam project and rest API task.*
