
<?php
require_once __DIR__ . "/../vendor/autoload.php";

use MongoDB\Client;
use MongoDB\Driver\ServerApi;

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
// $dotenv->load();
// $mongoDbPassword = $_ENV['MONGO_DB_PASSWORD'];
// $mongoDbUserName = $_ENV['MONGO_DB_USERNAME'];

$mongoDbPassword = getenv('MONGO_DB_PASSWORD');
$mongoDbUserName = getenv('MONGO_DB_USERNAME');
$uri = "mongodb+srv://$mongoDbUserName:$mongoDbPassword@dts.ovcm0.mongodb.net/retryWrites=true&w=majority&appName=dts&connectTimeoutMS=60000&socketTimeoutMS=60000";

// Specify Stable API version 1
$apiVersion = new ServerApi(ServerApi::V1);
// Create a new client and connect to the server
$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

// Create a new client and connect to the server
// $client = new MongoDB\Client($uri);

try {
    // Send a ping to confirm a successful connection
    $client->selectDatabase('admin')->command(['ping' => 1]);
    // echo "Pinged your deployment. You successfully connected to MongoDB!\n";
} catch (Exception $e) {
    printf($e->getMessage());
}
?>