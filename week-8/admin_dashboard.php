<?php
include 'service/config.php';
session_start();

// Restrict access to admins only
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch all categories and courses
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$courses = $pdo->query("SELECT courses.*, categories.name AS category_name 
                        FROM courses 
                        JOIN categories ON courses.category_id = categories.id")
                        ->fetchAll(PDO::FETCH_ASSOC);

// Fetch all users and their enrolled courses
$users = $pdo->query("SELECT users.id, users.full_name, users.email, users.gender, GROUP_CONCAT(courses.title) AS enrolled_courses 
                      FROM users 
                      LEFT JOIN enrollments ON users.id = enrollments.user_id
                      LEFT JOIN courses ON enrollments.course_id = courses.id
                      WHERE users.role = 'user'
                      GROUP BY users.id")
                      ->fetchAll(PDO::FETCH_ASSOC);

// Handle Category Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_category'])) {
    if ($_POST['action_category'] == 'add') {
        $name = $_POST['name'];
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
    } elseif ($_POST['action_category'] == 'edit') {
        $name = $_POST['name'];
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
    } elseif ($_POST['action_category'] == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Handle Course Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_course'])) {
    if ($_POST['action_course'] == 'add') {
        $title = $_POST['title'];
        $level = $_POST['level'];
        $trainer = $_POST['trainer'];
        $category_id = $_POST['category_id'];
        $stmt = $pdo->prepare("INSERT INTO courses (title, level, trainer, category_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $level, $trainer, $category_id]);
    } elseif ($_POST['action_course'] == 'edit') {
        $title = $_POST['title'];
        $level = $_POST['level'];
        $trainer = $_POST['trainer'];
        $category_id = $_POST['category_id'];
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE courses SET title = ?, level = ?, trainer = ?, category_id = ? WHERE id = ?");
        $stmt->execute([$title, $level, $trainer, $category_id, $id]);
    } elseif ($_POST['action_course'] == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Fetch all categories and courses
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$courses = $pdo->query("SELECT courses.*, categories.name AS category_name 
                        FROM courses 
                        JOIN categories ON courses.category_id = categories.id")
                        ->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@100;300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="images/icon-browser.ico" type="image/x-icon">
</head>
<body>
    <div class="admin-dashboard">
        <h1>Admin Dashboard</h1>

        <!-- Categories Section -->
        <h2>Categories</h2>
        <form method="POST" action="">
            <input type="hidden" name="action_category" value="add">
            <label>Name: <input type="text" name="name" required></label>
            <button type="submit">Add Category</button>
        </form>

        <table>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td class="action-buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="action_category" value="edit">
                            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($category['name']); ?>">
                            <button type="submit" class="edit-btn">Save</button>
                        </form>
                        <form method="POST" action="">
                            <input type="hidden" name="action_category" value="delete">
                            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Courses Section -->
        <h2>Courses</h2>
        <form method="POST" action="">
            <input type="hidden" name="action_course" value="add">
            <label>Title: <input type="text" name="title" required></label>
            <label>Level: <input type="text" name="level" required></label>
            <label>Trainer: <input type="text" name="trainer" required></label>
            <label>Category:
                <select name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit">Add Course</button>
        </form>

        <table>
            <tr>
                <th>Title</th>
                <th>Level</th>
                <th>Trainer</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                    <td><?php echo htmlspecialchars($course['level']); ?></td>
                    <td><?php echo htmlspecialchars($course['trainer']); ?></td>
                    <td><?php echo htmlspecialchars($course['category_name']); ?></td>
                    <td class="action-buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="action_course" value="edit">
                            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
                            <input type="text" name="title" value="<?php echo htmlspecialchars($course['title']); ?>">
                            <input type="text" name="level" value="<?php echo htmlspecialchars($course['level']); ?>">
                            <input type="text" name="trainer" value="<?php echo htmlspecialchars($course['trainer']); ?>">
                            <select name="category_id">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $course['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="edit-btn">Save</button>
                        </form>
                        <form method="POST" action="">
                            <input type="hidden" name="action_course" value="delete">
                            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Users and Enrolled Courses Section -->
        <h2>Users and Enrolled Courses</h2>
        <table>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Enrolled Courses</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['gender']); ?></td>
                    <td><?php echo htmlspecialchars($user['enrolled_courses']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>