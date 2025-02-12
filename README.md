## Restaurant Food Ordering System API

This is a restaurant food ordering system API built with Laravel 10.

### Features

- User authentication (login, register, forget password)
- Restaurant management dashboard (view orders, reject orders)
- Admin management dashboard (ban/approve restaurant)
- Payment (payment gateway integration)
- Queue (using Laravel queue)

### Technology Stack

- Laravel 10
- Tailwind CSS
- Alpine JS
- Alpine AXIOS
- Stripe API
- Mobypay API

### Installation

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Run `php artisan migrate`
5. Run `php artisan db:seed`
6. Run `php artisan serve`
7. Run `npm run dev`
8. Run `php artisan queue:work`

### API Collection

You can find the api collection in the `Restaurant API.postman_collection.json` file. You can import this file into Postman to test the API endpoints.


### Architecture

This project follows the MVC (Model-View-Controller) architectural pattern. Here is a brief overview of the components:

- **Models**: The models represent the data structure of the application. They are responsible for defining the database schema and the relationships between the models.

- **Controllers**: The controllers handle the business logic of the application. They receive the HTTP requests, process the data, and return the appropriate responses.

- **Views**: The views are responsible for rendering the HTML templates. They are used to display the data sent by the controllers.

- **Routes**: The routes define the URL patterns and the corresponding controller actions to handle the HTTP requests.

- **Requests**: The requests are used to validate and sanitize the incoming data. They are created to handle the validation rules for each route.

- **Jobs**: The jobs are used for processing the tasks asynchronously using Laravel's queue system. They are responsible for performing the heavy tasks like sending emails or processing payments.

- **API Collection**: The API collection is a JSON file that contains the documentation of all the API endpoints. It can be imported into tools like Postman to test the API endpoints.

- **Service Providers**: The service providers are used to register the various components of the application. They are responsible for binding the dependencies, configuring the middleware, and registering the routes.

- **Middleware**: The middleware are used to perform actions before or after the request is processed by the application. They can be used to authenticate the users, validate the requests, or log the requests.

- **Eloquent ORM**: Laravel comes with Eloquent ORM which is an elegant and simple ActiveRecord implementation. It provides a convenient way to interact with the database.

- **Factories and Seeders**: The factories are used to create fake data for testing purposes. The seeders are responsible for populating the database with the initial data.


### API Endpoints

The following are the available API endpoints for this application:

- `GET /api/restaurants`: Returns a list of all restaurants.
- `GET /api/restaurants/{id}`: Returns a single restaurant by ID.
- `POST /api/orders`: Creates a new order.
- `POST /api/payments`: Processes a payment.
- `GET /api/orders`: Returns a list of all orders.
- `PUT /api/orders/{id}/reject`: Rejects an order by ID.
- `GET /api/sales`: Returns a list of all sales.
- `PUT /api/restaurants/{id}/approve`: Approves a restaurant by ID.
- `PUT /api/restaurants/{id}/ban`: Bans a restaurant by ID.

### Notes

- The payment gateway is intended to be integrated with Stripe. However due to insufficient time I didnt enough time to completely done it. Thus, I chose MobyPay which
    the payment gateway that I currently working on because it is easier. Please find me to get the dev environment key and secret as it is not appropriate for me to include in this repo. Sorry for the inconvenience. Integration with Stripe will be done soon.
- To test card payment please visit https://uat-mpgs.mobycheckout.com/hosted_session to view sample cards.
- The queue is integrated with Laravel queue and you can test the queue process by making orders.

### Assumptions

- The api is to serve as microservice for other application that might have food ordering features.

### Improvements

- Implement caching using Redis or Memcached to improve the performance of the application.
- Enhance the user interface by using a more visually appealing template.
- Integrate multiple payment gateways such as Stripe, PayPal, or Razorpay to provide more payment options.
- Implement a delivery management system to manage the delivery process.
- Implement multi-tenancy to support multiple restaurants using the same application.
- Create a customer page for food ordering that displays available restaurants and their menu items.
- Containerize the application using Docker to improve portability and scalability.
- Set up CI/CD using GitHub Actions to automatically build, test, and deploy the application.
- Utilize the Spatie Laravel-Activitylog package to log user activities.
- Implement Laravel Horizon to manage the queue and provide insights into the queue processing.


### Contributing

Contributions are welcome! Please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

### License

[MIT](https://choosealicense.com/licenses/mit/)



