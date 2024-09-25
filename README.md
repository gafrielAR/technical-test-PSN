<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>README</title>
</head>
<body>

<h1>Laravel API with Docker</h1>

<p>This project is a Laravel-based API application designed to manage customer information and includes Docker support.</p>

<h2>Prerequisites</h2>
<ul>
    <li>Docker</li>
    <li>Docker Compose</li>
</ul>

<h2>Installation</h2>
<ol>

    Clone the repository:
    git clone https://github.com/gafrielAR/technical-test-PSN.git

    Navigate into the project directory:
    cd technical-test-PSN

    Build and run the Docker containers:
    docker-compose up -d

    Access the application at:
    http://localhost:8000

    Run the database migrations (inside the container):
    docker-compose exec app php artisan migrate
</ol>

<h2>Environment Variables</h2>

<p>The application requires the following environment variables to be set. You can define these in the <code>.env</code> file:</p>

<ul>
    <li>DB_HOST=db</li>
    <li>DB_PORT=3306</li>
    <li>DB_DATABASE=customer_track</li>
    <li>DB_USERNAME=user</li>
    <li>DB_PASSWORD=password</li>
    <li>APP_ENV=local</li>
    <li>APP_DEBUG=true</li>
</ul>

<h2>Interacting with the API</h2>

<p>You can interact with the API using <strong>Postman</strong> or <strong>cURL</strong>.</p>

<h3>Create a Customer</h3>
<pre><code>POST http://localhost:8000/api/customers</code></pre>

<p>Body (JSON):</p>
<pre><code>{
  "name": "John Doe",
  "email": "john@example.com",
  "phone_number": "1234567890",
  "gender": "male"
}
</code></pre>

<h3>Fetch Customers</h3>
<pre><code>GET http://localhost:8000/api/customers?limit=10</code></pre>

<h2>Accessing phpMyAdmin</h2>

<p>phpMyAdmin is included in the Docker setup for easier database management. Access it at:</p>

<pre><code>http://localhost:8080</code></pre>

<p>Login using:</p>
<ul>
    <li><strong>Username:</strong> root</li>
    <li><strong>Password:</strong> root</li>
</ul>

<h2>Running Tests</h2>

<p>To run the provided unit tests, use the following command:</p>
<pre><code>docker-compose exec app php artisan test</code></pre>

<h2>Stopping the Application</h2>

<p>To stop the application and remove the containers, run:</p>
<pre><code>docker-compose down</code></pre>

<h2>License</h2>

<p>This project is licensed under the MIT License.</p>

</body>
</html>
