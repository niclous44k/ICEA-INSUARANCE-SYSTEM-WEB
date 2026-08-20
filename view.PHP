<?php
require_once __DIR__ . '/db.php';

$result = $conn->query(
    'SELECT id, name, email, phone, insurance, start_date
     FROM bookings
     ORDER BY id DESC'
);

$success = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Bookings | ICEA LION</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="container">
    <h1>Insurance Bookings</h1>

    <?php if ($success === 'added'): ?>
        <p class="success-message">Insurance booking saved successfully.</p>
    <?php elseif ($success === 'updated'): ?>
        <p class="success-message">Insurance booking updated successfully.</p>
    <?php elseif ($success === 'deleted'): ?>
        <p class="success-message">Insurance booking deleted successfully.</p>
    <?php endif; ?>

    <p><a href="add_booking.php">+ Add a new booking</a></p>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Insurance Plan</th>
                    <th>Start Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($booking = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo (int) $booking['id']; ?></td>
                            <td><?php echo htmlspecialchars($booking['name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['email']); ?></td>
                            <td><?php echo htmlspecialchars($booking['phone']); ?></td>
                            <td><?php echo htmlspecialchars($booking['insurance']); ?></td>
                            <td><?php echo htmlspecialchars($booking['start_date']); ?></td>
                            <td>
                                <a href="Update.php?id=<?php echo (int) $booking['id']; ?>">
                                    Update
                                </a>
                                |
                                <a href="deleting.php?id=<?php echo (int) $booking['id']; ?>">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No insurance bookings have been submitted yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>

<?php
$conn->close();
?>