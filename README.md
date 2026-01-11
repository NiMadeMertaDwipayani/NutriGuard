# 🥗 NutriGuard - Nutrition & Health Monitoring System

NutriGuard is a *Full Stack* web application designed to help users monitor their daily calorie intake and health conditions, while providing a transparent administration panel for managers.

This project is a combination of the Midterm Exam assignment (Basic CRUD), the REST API assignment, and the Final Exam Project (Business Logic & Data Visualization).

## 🚀 Key Features

### 👤 User Features
* **Meal Tracker:** Tracks daily meals with automatic calorie calculation.
* **Warning System:** Automatic warning triggers if calorie intake exceeds the daily limit.
* **Data Visualization:**
    * 📊 **Bar Chart:** Calorie history for the last 7 days.
    * 🍩 **Doughnut Chart:** Daily nutritional composition (Protein, Carbs, Fat).
* **Health Profile:** Manages personal medical history data.

### 👮 Admin Features
* **Ingredient Management:** CRUD (Create, Read, Update, Delete) operations for food ingredients, including photos & nutritional information.
* **User & Disease Management:** Manages user data and the list of diseases.
* **🕵️ Activity Log (CCTV):** Records every Create/Update/Delete activity performed on User, Ingredient, and Disease data in *real-time* (Audit Trail).

### 🔌 REST API (Integration)
The application provides endpoints accessible by third-party applications:
* `GET /api/ingredients` : Retrieves a list of food ingredients along with their nutritional info.
* `GET /api/reports?user_id=X` : Retrieves the user's weekly calorie recapitulation in JSON format.

## 🛠️ Tech Stack
* **Backend:** Laravel 11 (PHP)
* **Frontend:** Blade Templates & Tailwind CSS
* **Database:** MySQL
* **Charting:** Chart.js
* **Version Control:** Git & GitHub

## 📸 Screenshots

*(Add screenshots of the Admin Dashboard, Meal Tracker, and Charts here)*

## 📦 Installation Instructions

1.  **Clone the Repository**
    ```bash
    git clone [https://github.com/your-username/NutriGuard.git](https://github.com/your-username/NutriGuard.git)
    cd NutriGuard
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Configuration**
    * Duplicate the `.env.example` file and rename it to `.env`
    * Configure your database connection in `.env` (DB_DATABASE, DB_USERNAME, etc.)

4.  **Generate Key & Migrate**
    ```bash
    php artisan key:generate
    php artisan migrate
    ```

5.  **Run the Application**
    ```bash
    npm run build
    php artisan serve
    ```

---
**Developed by Ni Made Merta Dwipayani as a mid-exam project, rest API task and Final Exam (UAS) requirement for the Web Technology course.**

