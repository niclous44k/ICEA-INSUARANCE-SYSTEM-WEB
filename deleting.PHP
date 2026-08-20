<?php
require_once __DIR__ . '/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die('Invalid booking ID.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statement = $conn->prepare('DELETE FROM bookings WHERE id = ?');
    $statement->bind_param('i', $id);

    if ($statement->execute()) {
        $statement->close();
        $conn->close();

        header('Location: view.php?success=deleted');
        exit;
    }

    die('The booking could not be deleted.');
}

$statement = $conn->prepare(
    'SELECT id, name, insurance
     FROM bookings
     WHERE id = ?'
);

$statement->bind_param('i', $id);
$statement->execute();
$result = $statement->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die('Booking not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Booking | ICEA LION</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="container">
    <h1>Delete Insurance Booking</h1>

    <p>
        Are you sure you want to delete the booking for
        <strong><?php echo htmlspecialchars($booking['name']); ?></strong>
        (<?php echo htmlspecialchars($booking['insurance']); ?>)?
    </p>

    <form action="deleting.php?id=<?php echo (int) $booking['id']; ?>" method="post">
        <button type="submit">Yes, Delete Booking</button>
        <a href="view.php">Cancel</a>
    </form>
</main>

</body>
</html>

<?php
$statement->close();
$conn->close();
?>