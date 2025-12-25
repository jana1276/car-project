<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php';
?>
<?php
require_once 'db.php';
// This script validates input and inserts a reservation into the DB.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();
    
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $car = htmlspecialchars($_POST['car']);
    $pickup_date = $_POST['pickup_date'];
    $dropoff_date = $_POST['dropoff_date'];
    
    // Validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    if (!preg_match('/^[0-9\-\+\(\) ]{10,}$/', $phone)) {
        $errors[] = "Invalid phone number.";
    }
    
    if (strtotime($pickup_date) === false) {
        $errors[] = "Invalid pickup date.";
    }
    
    if (strtotime($dropoff_date) === false) {
        $errors[] = "Invalid dropoff date.";
    }
    
    if (!empty($pickup_date) && !empty($dropoff_date)) {
        if (strtotime($dropoff_date) <= strtotime($pickup_date)) {
            $errors[] = "Dropoff date must be after pickup date.";
        }
    }
    
    // Display errors or confirmation
    if (!empty($errors)) {
        echo "<div class='error'>";
        echo "<h2>Error in Reservation</h2>";
        foreach ($errors as $error) {
            echo "<p>• " . $error . "</p>";
        }
        echo "</div>";
        echo "<div class='button-group'>";
        echo "<a href='Reservations.html'><button>Back to Form</button></a>";
        echo "<a href='myReservations.html'><button class='secondary-btn'>View Reservations</button></a>";
        echo "</div>";
    } else {
        // Insert reservation into database using prepared statement
        $sql = "INSERT INTO reservations (full_name, email, phone, car_type, pickup_date, dropoff_date, status) 
                VALUES (?, ?, ?, ?, ?, ?, 'confirmed')";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ssssss", $name, $email, $phone, $car, $pickup_date, $dropoff_date);
            
            if ($stmt->execute()) {
                // Redirect to the reservations listing after successful save
                header("Location: myReservations.html");
                exit;
            } else {
                echo "<div class='error'>";
                echo "<h2>Error Saving Reservation</h2>";
                echo "<p>• An error occurred while saving your reservation: " . htmlspecialchars($stmt->error) . "</p>";
                echo "</div>";
                echo "<div class='button-group'>";
                echo "<a href='Reservations.html'><button>Back to Form</button></a>";
                echo "<a href='myReservations.html'><button class='secondary-btn'>View Reservations</button></a>";
                echo "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='error'>";
            echo "<h2>Error Saving Reservation</h2>";
            echo "<p>• Database error: " . htmlspecialchars($conn->error) . "</p>";
            echo "</div>";
            echo "<div class='button-group'>";
            echo "<a href='Reservations.html'><button>Back to Form</button></a>";
            echo "<a href='myReservations.html'><button class='secondary-btn'>View Reservations</button></a>";
            echo "</div>";
        }
    }
}
?>