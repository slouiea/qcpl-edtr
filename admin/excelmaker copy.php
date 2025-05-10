<?php

//Usage:
//To preview the data: Access the script in your browser with parameters, e.g., http://localhost/admin/excelmaker.php?month=4&year=2025&employee_id=1.
//To download the CSV: Click the "Download as CSV" link or directly access http://localhost/admin/excelmaker.php?download=csv&month=4&year=2025&employee_id=1.
// Connect to your MySQL database
$mysqli = new mysqli("localhost", "root", "", "login_system");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get dynamic variables from query parameters
$month = isset($_GET['month']) ? (int)$_GET['month'] : 4; // Default to April
$year = isset($_GET['year']) ? (int)$_GET['year'] : 2025;  // Default to 2025
$employee_id = isset($_GET['employee_id']) ? (int)$_GET['employee_id'] : 1; // Default to employee ID 1

// Your SQL query
$query = "
SELECT
    d.day,
    e.employee_id,
    CONCAT(e.employee_firstname, ' ', IFNULL(e.employee_middlename, ''), ' ', e.employee_lastname) AS full_name,
    TIME_FORMAT(tr.time_in_morning, '%h:%i %p') AS arrived_am,
    TIME_FORMAT(tr.time_out_morning, '%h:%i %p') AS departure_am,
    TIME_FORMAT(tr.time_in_afternoon, '%h:%i %p') AS arrived_pm,
    TIME_FORMAT(tr.time_out_afternoon, '%h:%i %p') AS departure_pm,
    IF(
        tr.time_in_morning IS NOT NULL AND tr.time_out_morning IS NOT NULL AND
        tr.time_in_afternoon IS NOT NULL AND tr.time_out_afternoon IS NOT NULL,
        FLOOR((
            TIMESTAMPDIFF(MINUTE, tr.time_in_morning, tr.time_out_morning) +
            TIMESTAMPDIFF(MINUTE, tr.time_in_afternoon, tr.time_out_afternoon)
        ) / 60),
        NULL
    ) AS hours_rendered,
    IF(
        tr.time_in_morning IS NOT NULL AND tr.time_out_morning IS NOT NULL AND
        tr.time_in_afternoon IS NOT NULL AND tr.time_out_afternoon IS NOT NULL,
        (
            TIMESTAMPDIFF(MINUTE, tr.time_in_morning, tr.time_out_morning) +
            TIMESTAMPDIFF(MINUTE, tr.time_in_afternoon, tr.time_out_afternoon)
        ) % 60,
        NULL
    ) AS minutes_rendered
FROM
    employees e
JOIN (
    SELECT 1 AS day UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
    UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
    UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15
    UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20
    UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25
    UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30 UNION SELECT 31
) d ON 1=1
LEFT JOIN timerecords tr
    ON tr.employee_id = e.employee_id
    AND DAY(tr.date) = d.day
    AND MONTH(tr.date) = $month
    AND YEAR(tr.date) = $year
WHERE
    e.employee_id = $employee_id
ORDER BY
    e.employee_id, d.day
";

// Execute query
$result = $mysqli->query($query);

// Check if the user requested a CSV download
if (isset($_GET['download']) && $_GET['download'] === 'csv') {
    // Set headers to prompt download
    header('Content-Type: text/csv');
    header("Content-Disposition: attachment; filename=\"DTR_{$year}_{$month}_Employee_{$employee_id}.csv\"");

    // Open output stream
    $output = fopen('php://output', 'w');

    // Add column headers for CSV
    fputcsv($output, ['Day', 'Arrived AM', 'Departure AM', 'Arrived PM', 'Departure PM', 'Hours Rendered', 'Minutes Rendered']);

    // Fetch data from the query and write it into the CSV output
    while ($data = $result->fetch_assoc()) {
        fputcsv($output, [
            $data['day'],
            $data['arrived_am'],
            $data['departure_am'],
            $data['arrived_pm'],
            $data['departure_pm'],
            $data['hours_rendered'],
            $data['minutes_rendered']
        ]);
    }

    // Close the output stream
    fclose($output);
} else {
    // Display data in an HTML table
    echo "<table border='1'>";
    echo "<tr>
            <th>Day</th>
            <th>Arrived AM</th>
            <th>Departure AM</th>
            <th>Arrived PM</th>
            <th>Departure PM</th>
            <th>Hours Rendered</th>
            <th>Minutes Rendered</th>
          </tr>";

    while ($data = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$data['day']}</td>
                <td>{$data['arrived_am']}</td>
                <td>{$data['departure_am']}</td>
                <td>{$data['arrived_pm']}</td>
                <td>{$data['departure_pm']}</td>
                <td>{$data['hours_rendered']}</td>
                <td>{$data['minutes_rendered']}</td>
              </tr>";
    }

    echo "</table>";
    echo "<a href=\"?download=csv&month=$month&year=$year&employee_id=$employee_id\">Download as CSV</a>";
}

// Close the connection
$mysqli->close();
?>
