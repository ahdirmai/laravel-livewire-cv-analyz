<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></p>

# CV Analyzer By Ahdirmai

## About The Project

CV Analyzer is a web application built with Laravel and Livewire that helps analyze and process curriculum vitae (CV) documents. This project aims to streamline the CV review process and provide insights into candidate profiles.

## Features

-   User Authentication: Secure login and registration system.
-   Dashboard: A central hub for users to manage their activities.
-   CV Upload and Analysis: Users can upload CV documents for automated analysis.
-   Generate History: Keep track of past CV analyses and results.
-   Responsive Design: Works seamlessly on desktop and mobile devices.

## Technology Stack

-   **Framework**: Laravel
-   **Frontend**: Livewire, Tailwind CSS
-   **Database**: MySQL
-   **API Integration**: Google Cloud's Gemini API for AI-powered analysis

## Getting Started

### Prerequisites

-   PHP >= 8.1
-   Composer
-   MySQL
-   Node.js and NPM

### Installation

1. Clone the repository:

    ```
    git clone https://github.com/yourusername/cv-analyzer.git
    ```

2. Install PHP dependencies:

    ```
    composer install
    ```

3. Install and compile frontend dependencies:

    ```
    npm install && npm run dev
    ```

4. Copy the `.env.example` file to `.env` and configure your environment variables, including database settings and Gemini API key.

5. Generate application key:

    ```
    php artisan key:generate
    ```

6. Run database migrations:

    ```
    php artisan migrate
    ```

7. Start the development server:
    ```
    php artisan serve
    ```

## Usage

After setting up the project, you can:

1. Register a new account or log in.
2. Navigate to the dashboard to start analyzing CVs.
3. Upload a CV document and wait for the analysis results.
4. View your analysis history in the Generate History section.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contact

Ahdirmai - [GitHub Profile](https://github.com/ahdirmai)

Project Link: [https://github.com/ahdirmai/laravel-livewire-cv-analyz](https://github.com/ahdirmai/laravel-livewire-cv-analyz)
