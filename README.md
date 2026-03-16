# MyCampaign

MyCampaign is a web application designed to manage political campaigns. It provides tools for organizing volunteers, tracking sympathizers, and managing campaign-related data across different geographical regions.

## About The Project

This application is built with the Laravel framework and utilizes several modern technologies to provide a robust and user-friendly experience. It includes features for user authentication, data management, and an administrative dashboard.

### Key Features:

*   **User Management:** Different user roles and permissions (Administrators, Volunteers, etc.).
*   **Campaign Management:** Create and manage campaign details.
*   **Volunteer & Sympathizer Tracking:** Keep a database of volunteers and supporters.
*   **Geographical Data:** Manage data based on states, municipalities, districts, and sections.
*   **Admin Dashboard:** An administrative interface to manage the application's data.

## Built With

This project is built using the following technologies:

*   [Laravel](https://laravel.com/) - The PHP framework for web artisans.
*   [Livewire](https://laravel-livewire.com/) - A full-stack framework for Laravel that makes building dynamic interfaces simple.
*   [Jetstream](https://jetstream.laravel.com/) - A beautifully designed application scaffolding for Laravel.
*   [AdminLTE](https://adminlte.io/) - A popular open-source admin dashboard & control panel theme.
*   [MySQL](https://www.mysql.com/) - The world's most popular open source database.
*   [Tailwind CSS](https://tailwindcss.com/) - A utility-first CSS framework for rapid UI development.
*   [Vite](https://vitejs.dev/) - Next Generation Frontend Tooling.

## Getting Started

To get a local copy up and running, follow these simple steps.

### Prerequisites

*   PHP >= 8.0.2
*   Composer
*   NPM
*   A database (MySQL is used in this project)

### Installation

1.  **Clone the repo**
    ```sh
    git clone https://github.com/your_username/MyCampaignWeb.git
    cd MyCampaignWeb
    ```

2.  **Install PHP dependencies**
    ```sh
    composer install
    ```

3.  **Install NPM dependencies**
    ```sh
    npm install && npm run dev
    ```

4.  **Create a copy of your .env file**
    ```sh
    cp .env.example .env
    ```

5.  **Generate an app encryption key**
    ```sh
    php artisan key:generate
    ```

6.  **Configure your database**

    Open the `.env` file and set your database connection details (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

7.  **Run the database migrations and seeders**

    This will create the necessary tables and populate them with initial data.
    ```sh
    php artisan migrate --seed
    ```

8.  **Start the development server**
    ```sh
    php artisan serve
    ```

You should now be able to access the application at `http://localhost:8000`.

## License

This project is licensed under the MIT License. See the `LICENSE` file for more information (or check the `composer.json` file).

## Contact

Project Link: [https://github.com/Luis-Rayas/MyCampaignWeb](https://github.com/Luis-Rayas/MyCampaignWeb)
