<?php
session_start();
require_once 'db.php';


// Handle delete request
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
	$reservation_id = intval($_POST['id']);
	$delete_sql = "DELETE FROM reservations WHERE id = ?";
	$stmt = $conn->prepare($delete_sql);
	$stmt->bind_param("i", $reservation_id);
	if ($stmt->execute()) {
		// deleted successfully; frontend fetch will show updated list
	}
	$stmt->close();
}

// Fetch reservations from database
$sql = "SELECT id, full_name, email, phone, car_type, pickup_date, dropoff_date, status FROM reservations ORDER BY created_at DESC";
$result = $conn->query($sql);

// Display reservations
if ($result && $result->num_rows > 0) {
	while ($reservation = $result->fetch_assoc()) {
		$status_class = strtolower($reservation['status']);
		echo "<tr>";
		echo "<td>" . htmlspecialchars($reservation['id']) . "</td>";
		echo "<td>" . htmlspecialchars($reservation['full_name']) . "</td>";
		echo "<td>" . htmlspecialchars($reservation['email']) . "</td>";
		echo "<td>" . htmlspecialchars($reservation['phone']) . "</td>";
		echo "<td>" . htmlspecialchars($reservation['car_type']) . "</td>";
		echo "<td>" . htmlspecialchars($reservation['pickup_date']) . "</td>";
		echo "<td>" . htmlspecialchars($reservation['dropoff_date']) . "</td>";
		echo "<td><span class='status " . $status_class . "'>" . ucfirst($reservation['status']) . "</span></td>";
		echo "<td>";
		echo "<button class='action-btn' onclick='editReservation(\"" . htmlspecialchars($reservation['id']) . "\")'>Edit</button>";
		echo "<form style='display:inline' method='POST' onsubmit='return confirm(\"Delete this reservation?\");'>";
		echo "<input type='hidden' name='action' value='delete'/>";
		echo "<input type='hidden' name='id' value='" . htmlspecialchars($reservation['id']) . "'/>";
		echo "<button type='submit' class='action-btn delete'>Delete</button>";
		echo "</form>";
		echo "</td>";
		echo "</tr>";
	}
} else {
	echo "<tr>";
	echo "<td colspan='9' class='no-data'>No reservations found.</td>";
	echo "</tr>";
}

?>
