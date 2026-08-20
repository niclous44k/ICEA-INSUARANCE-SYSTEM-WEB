<?php
require_once __DIR__ . '/db.php';

$message = '';
$error = '';

$selectedInsurance = $_GET['insurance'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $insurance = trim($_POST['insurance'] ?? '');
    $startDate = $_POST['start_date'] ?? '';

    if ($name === '' || $email === '' || $phone === '' || $insurance === '' || $startDate === '') {
        $error = 'Please complete all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $statement = $conn->prepare(
            'INSERT INTO bookings (name, email, phone, insurance, start_date)
             VALUES (?, ?, ?, ?, ?)'
        );

        $statement->bind_param(
            'sssss',
            $name,
            $email,
            $phone,
            $insurance,
            $startDate
        );

        if ($statement->execute()) {
            $message = 'Thank you, ' . $name . '. Your insurance booking was saved successfully.';
        } else {
            $error = 'Your booking could not be saved. Please try again.';
        }

        $statement->close();
    }

    $selectedInsurance = $insurance;
}

$plans = [
    'Life Insurance',
    'Health Insurance',
    'Motor Insurance',
    'Home Insurance',
    'Travel Insurance',
    'Business Insurance'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Insurance | ICEA LION</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Book Insurance</h1>

    <?php if ($message !== ''): ?>
        <div class="success">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <p><a href="view.PHP">View all bookings</a></p>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="add_booking.PHP">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name"
               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
               placeholder="Enter your full name" required>

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email"
               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
               placeholder="Enter your email" required>

        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone"
               value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
               placeholder="Enter your phone number" required>

        <label for="insurance">Insurance Type</label>
        <select id="insurance" name="insurance" required>
            <option value="">-- Select Insurance --</option>

            <?php foreach ($plans as $plan): ?>
                <option value="<?php echo htmlspecialchars($plan); ?>"
                    <?php echo ($selectedInsurance === $plan) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($plan); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="start_date">Policy Start Date</label>
        <input type="date" id="start_date" name="start_date"
               value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>"
               required>

        <button type="submit">Book Insurance</button>
    </form>

    <p><a href="insuarance plan.HTML">Back to insurance plans</a></p>
</div>

</body>
</html>

<?php
$conn->close();
?>