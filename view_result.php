<?php
include 'config/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_no = $_POST['regno'];
    $dob = $_POST['dob'];

    $student_sql = "SELECT * FROM students WHERE reg_no='$reg_no' AND dob='$dob'";
    $student_res = $conn->query($student_sql);

    if ($student_res->num_rows > 0) {
        $student = $student_res->fetch_assoc();
        $result_sql = "SELECT * FROM results WHERE reg_no='$reg_no' AND publish=1";
        $result_res = $conn->query($result_sql);

        if ($result_res->num_rows > 0) {
            $row = $result_res->fetch_assoc();
            $exam_month = $row['exam_month'];

            echo "
            <div class='page-wrapper'>
                <main class='content'>
                    <div class='center-box'>

                        <div class='logo-inside-box'>
                            <img src='assets/images/banner.png' alt='Banner'>
                        </div>

                        <div class='text-center'>
                            <h2>OFFICE OF CONTROLLER OF EXAMINATIONS</h2>
                            <h3>{$exam_month} RESULTS</h3>
                        </div>

                        <div class='student-info'>
                            <div class='info-row'>
                                <span><strong>Register Number:</strong> {$student['reg_no']}</span>
                                <span><strong>Name:</strong> {$student['name']}</span>
                                <span><strong>Date of Birth:</strong> {$student['dob']}</span>
                            </div>
                            <div class='info-row'>
                                <span><strong>Regulation:</strong> {$student['regulation']}</span>
                                <span><strong>Semester:</strong> {$student['semester']}</span>
                                <span><strong>Degree & Branch:</strong> {$student['degree']} - {$student['branch']}</span>
                            </div>
                        </div>

                        <div class='table-container'>
                            <table class='result-table'>
                                <thead>
                                    <tr>
                                        <th>SEM</th>
                                        <th>SUBJECT CODE</th>
                                        <th>SUBJECT NAME</th>
                                        <th>GRADE</th>
                                        <th>RESULT</th>
                                    </tr>
                                </thead>
                                <tbody>";

            // rewind and loop through results again
            $result_res->data_seek(0);
            while ($subject = $result_res->fetch_assoc()) {
                echo "<tr>
                        <td>{$subject['semester']}</td>
                        <td>{$subject['subject_code']}</td>
                        <td>{$subject['subject_name']}</td>
                        <td>{$subject['grade']}</td>
                        <td>{$subject['result_status']}</td>
                    </tr>";
            }

            echo "        </tbody>
                            </table>
                        </div>

                        <div class='legend-box'>
                            <p>
                                <b>RA*</b> - Absent |
                                <b>WH</b> - Withheld |
                                <b>WH1</b> - Fail due to Malpractice |
                                <b>RA</b> - Fail |
                                <b>NC</b> - No Change
                            </p>
                        </div>

                        <form action='result_check.php' method='POST'>
                            <button type='submit' class='logout-btn'>Logout</button>
                        </form>

                    </div>
                </main>
            </div>";
        } else {
            echo "<div class='page-wrapper'><div class='content center-box'><p style='color:red;'>Result not published yet.</p></div></div>";
        }
    } else {
        echo "<div class='page-wrapper'><div class='content center-box'><p style='color:red;'>Invalid Register Number or Date of Birth.</p></div></div>";
    }
} else {
    header('Location: result_check.php');
    exit;
}

include 'includes/footer.php';
?>
