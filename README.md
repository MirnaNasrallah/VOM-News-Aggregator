# Started at 10:15am, Sunday 12/01/25
# Ended at 5:00pm, Monday 13/01/25
# News Aggregator Application

## Setup Instructions

### Back-End (Laravel)

### Running the Application

1. Clone the repository to your local machine.
2. Navigate to the Laravel project directory : VomNewsAggregator
3. Install dependencies by running ##composer install.
4. Create a mysql database (using phpMyAdmin) with the name : `vom_news_aggregator`
5. Create your .env file with your db credentials and api keys for (NYT news, The guardian and NewsApi)
==> You can use .env.example file
6. Generate an application key using ##php artisan key:generate.
7. Migrate the database by running ##php artisan migrate. Alternatively, you can import the provided SQL file to set up the database.
8. Start the Laravel development server with ##php artisan serve.

### Running the PHPTestUnit:
1. Open a separate terminal in the project directory.
2. Run the command ##php artisan test tests/Feature/ArticleControllerTest.php

### Running the scheduler

Steps:
1.Open a separate terminal in the project directory.
2.Run the command ##php artisan schedule:work to start the Laravel scheduler.
3.The scheduler will now execute the scheduled jobs as defined in the routes/console.php.
4.You can run the command directly ##php artisan fetch:articles to load the articles manually.

### Running the Vue Application
Steps:
1. Navigate to the Vue project directory (same directory: VomNewsAggregator).
2. Install dependencies by running ##npm install. install swiper, router as well.
3. Start the development server with ##npm run dev.
4. The Vue.js application will be available at the specified local host URL.


### API Endpoint
-- There's a provided postman collection `vom_task.postman` with all the api requests
- `GET http://127.0.0.1:8000/api/articles`: Fetch the list of tasks.
- `GET http://127.0.0.1:8000/api/articles/{id}`: Fetch a single article
- `GET http://127.0.0.1:8000/api/featured`: Fetch latest 5 articles
-  The Three test apis for the three sources.


## Project Structure and Components
### Laravel Backend:
=> Controllers: Found in App\Http\Controllers. They handle the logic for various routes.
=> Commands: Custom Artisan commands are located in App\Console\Commands. The command for fetching news articles is a key component.
=> Scheduler: The schedule for running tasks is defined in routes\Console.php.
=> Vue Frontend:
=> Main Component: The Main App component in resources/js/components/MainPage.vue handles the display of articles.
=> API Interaction: Managed through Axios in the Swiper component to fetch articles from the Laravel API.
=> The frontend design is 100% vue components, with a simple design without the use of templates

