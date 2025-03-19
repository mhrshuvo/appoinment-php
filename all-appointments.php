<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// echo "Welcome, " . $_SESSION['email'];

require_once 'config/database.php';
require_once 'models/Appointment.php';

$database = new Database();
$db = $database->connect();

// Pagination settings
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Sorting settings
$valid_columns = ['id', 'name', 'email', 'phone', 'created_at']; // Allowed sorting columns
$sort_column = isset($_GET['sort']) && in_array($_GET['sort'], $valid_columns) ? $_GET['sort'] : 'id';
$sort_order = (isset($_GET['order']) && $_GET['order'] === 'asc') ? 'ASC' : 'DESC';

// Fetch total records
$totalRecords = $db->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
$totalPages = ceil($totalRecords / $limit);

// Fetch paginated and sorted appointments
$stmt = $db->prepare("SELECT * FROM appointments ORDER BY $sort_column $sort_order LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Toggle sorting order
$toggle_order = ($sort_order === 'ASC') ? 'desc' : 'asc';
$icons = [
    'asc' => '<i class="fa-solid fa-arrow-up"></i>',
    'desc' => '<i class="fa-solid fa-arrow-down"></i>'
];

$current_icon = isset($_GET['order']) && $_GET['order'] === 'asc' ? $icons['asc'] : $icons['desc'];

$default_sort = 'id';
$default_order = 'dssc';

// Check if 'sort' or 'order' is missing in the URL
if (!isset($_GET['sort']) || !isset($_GET['order'])) {
    $query_string = http_build_query([
        'sort'  => $_GET['sort'] ?? $default_sort,
        'order' => $_GET['order'] ?? $default_order
    ]);
    header("Location: all-appointments.php?$query_string");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Appointments</title>
    <link rel="stylesheet" href="./resources/css/index.css">
    <link rel="stylesheet" href="./resources/css/appoinment-table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <div class="landing-page">

        <?php include './view/components/header.php'; ?>
        <a href="logout.php">Logout</a>
        <div class="content">
            <div class="custom-container">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <a class="sort-link" href="?sort=id&order=<?= $toggle_order ?>">
                                    ID <?= ($_GET['sort'] == 'id' ? $current_icon : '') ?>
                                </a>
                            </th>
                            <th>
                                <a class="sort-link" href="?sort=name&order=<?= $toggle_order ?>">
                                    Name <?= ($_GET['sort'] == 'name' ? $current_icon : '') ?>
                                </a>
                            </th>
                            <th>
                                <a class="sort-link" href="?sort=email&order=<?= $toggle_order ?>">
                                    Email <?= ($_GET['sort'] == 'email' ? $current_icon : '') ?>
                                </a>
                            </th>
                            <th>
                                <a class="sort-link" href="?sort=phone&order=<?= $toggle_order ?>">
                                    Phone <?= ($_GET['sort'] == 'phone' ? $current_icon : '') ?>
                                </a>
                            </th>

                            <th>Contact Method</th>
                            <th>Available Days</th>
                            <th>Preferred Time</th>
                            <th>Notes</th>
                            <th><a class="sort-link" href="?sort=created_at&order=<?= $toggle_order ?>">Created At</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($appointments) > 0): ?>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td><?= htmlspecialchars($appointment['id']); ?></td>
                                    <td><?= htmlspecialchars($appointment['name']); ?></td>
                                    <td><?= htmlspecialchars($appointment['email']); ?></td>
                                    <td><?= htmlspecialchars($appointment['phone']); ?></td>
                                    <td><?= htmlspecialchars($appointment['contact_method']); ?></td>
                                    <td><?= htmlspecialchars($appointment['available_days']); ?></td>
                                    <td><?= htmlspecialchars($appointment['preferred_time']); ?></td>
                                    <td><?= htmlspecialchars($appointment['notes']); ?></td>
                                    <td><?= date("F j, Y, g:i A", strtotime($appointment['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center;">No appointments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>&sort=<?= $sort_column ?>&order=<?= $sort_order ?>">Prev</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>&sort=<?= $sort_column ?>&order=<?= $sort_order ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>&sort=<?= $sort_column ?>&order=<?= $sort_order ?>">Next</a>
                    <?php endif; ?>
                </div>


            </div>
        </div>

        <footer>
            <?php include './view/components/footer.php'; ?>
        </footer>
    </div>



</body>

</html>