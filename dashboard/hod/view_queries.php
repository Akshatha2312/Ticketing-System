<?php
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'HOD') {
//     header('Location: ../../login.php');
//     exit();
// }

include '../../config/db.php';
// include '../../includes/header.php';

$department = $_SESSION['department'];
?>

<div style="max-width: 1200px; margin: 40px auto; padding: 20px 10px;">
    <h2 style="color: #1b5e20; margin-bottom: 20px; text-align: center;">
        <?= htmlspecialchars($department) ?> Department - Your Submitted Issues
    </h2>

    <table style="width: 100%; border-collapse: collapse; background-color: white;">
        <thead style="background-color: #1b5e20; color: #fff;">
            <tr>
                <th style="padding: 10px; border: 1px solid #ccc;">Subject</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Message</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Attachment</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Status</th>
                <th style="padding: 10px; border: 1px solid #ccc;">COE Reply</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $conn->prepare("SELECT * FROM issues WHERE from_role = 'HOD' AND from_dept = ? ORDER BY created_at DESC");
            $stmt->bind_param("s", $department);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['subject']) . "</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['message']) . "</td>";

                    if (!empty($row['attachment'])) {
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'><a href='../../uploads/" . urlencode($row['attachment']) . "' target='_blank'>View</a></td>";
                    } else {
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'>No Attachment</td>";
                    }

                    echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['status']) . "</td>";

                    if (!empty($row['reply'])) {
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['reply']);
                        if (!empty($row['reply_attachment'])) {
                            echo "<br><a href='../../uploads/" . urlencode($row['reply_attachment']) . "' target='_blank'>View Reply File</a>";
                        }
                        echo "</td>";
                    } else {
                        echo "<td style='padding: 10px; border: 1px solid #ccc; color: #888;'>No response yet</td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center; padding: 20px; color: #888;'>No issues submitted yet.</td></tr>";
            }

            $stmt->close();
            ?>
        </tbody>
    </table>
</div>

<!--  include '../../includes/footer.php'; ?> -->
