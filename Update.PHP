<?php
require_once __DIR__ . '/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die('Invalid booking ID.');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $insurance = trim($_POST['insurance'] ?? '');
    $startDate = $_POST['start_date'] ?? '';

    if ($name === '' || $email === '' || $phone === '' || $insurance === '' || $startDate === '') {
        $error = 'Please complete every field.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $statement = $conn->prepare(
            'UPDATE bookings
             SET name = ?, email = ?, phone = ?, insurance = ?, start_date = ?
             WHERE id = ?'
        );

        $statement->bind_param('sssssi', $name, $email, $phone, $insurance, $startDate, $id);

        if ($statement->execute()) {
            $statement->close();
            header('Location: view.php?success=updated');
            exit;
        }

        $error = 'The booking could not be updated.';
        $statement->close();
    }
}

$statement = $conn->prepare(
    'SELECT id, name, email, phone, insurance, start_date
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

$plans = [
    'Motor Insurance',
    'Health Insurance',
    'Life Insurance',
    'Travel Insurance',
    'Home Insurance',
    'Business Insurance'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking | ICEA LION</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="container">
    <h1>Update Insurance Booking</h1>

    <?php if ($error !== ''): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="Update.php?id=<?php echo (int) $booking['id']; ?>" method="post">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name"
               value="<?php echo htmlspecialchars($booking['name']); ?>" required>

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email"
               value="<?php echo htmlspecialchars($booking['email']); ?>" required>

        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone"
               value="<?php echo htmlspecialchars($booking['phone']); ?>" required>

        <label for="insurance">Insurance Plan</label>
        <select id="insurance" name="insurance" required>
            <?php foreach ($plans as $plan): ?>
                <option
                    value="<?php echo htmlspecialchars($plan); ?>"
                    <?php echo ($booking['insurance'] === $plan) ? 'selected' : ''; ?>
                >
                    <?php echo htmlspecialchars($plan); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="start_date">Preferred Policy Start Date</label>
        <input type="date" id="start_date" name="start_date"
               value="<?php echo htmlspecialchars($booking['start_date']); ?>" required>

        <button type="submit">Save Changes</button>
    </form>

    <p><a href="view.php">Back to bookings</a></p>
</main>

</body>
</html>

<?php
$statement->close();
$conn->close();
?>