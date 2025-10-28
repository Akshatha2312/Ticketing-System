<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'STAFF') {
    header('Location: ../../login.php');
    exit();
}
include '../../config/db.php';
include '../../includes/header.php';
include '../../dashboard/staff/post_announcements_form.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Get file path if exists
    $stmt = $conn->prepare("SELECT file_path FROM announcements WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (!empty($row['file_path'])) {
            $file = "../../uploads/" . $row['file_path'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
    $stmt->close();

    // Delete announcement
    $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to same page (dashboard.php)
    header("Location: dashboard.php");
    exit();
}
?>

<!-- Announcements Table -->
<div class="center-box" style="max-width: 900px; margin-top: 30px;">
    <h3>Your Posted Announcements</h3>
    <table class="table table-bordered">
        <thead style="background-color: #1b5e20; color: #fff;">
            <tr>
                <th>Title</th>
                <th>Message</th>
                <th>File</th>
                <th>Posted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $staff = $_SESSION['username'];
            $stmt = $conn->prepare("SELECT * FROM announcements WHERE posted_by = ? ORDER BY created_at DESC");
            $stmt->bind_param("s", $staff);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . nl2br(htmlspecialchars($row['message'])) . "</td>";
                    echo "<td>";
                    if (!empty($row['file_path'])) {
                        echo "<a href='../../uploads/{$row['file_path']}' target='_blank'>View File</a>";
                    } else {
                        echo "None";
                    }
                    echo "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td><a href='?delete={$row['id']}' onclick=\"return confirm('Delete this announcement?');\">Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No announcements posted yet.</td></tr>";
            }
            $stmt->close();
            ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
