<?php
// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory and filename
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['csvFile']['name']);
        $targetFile = $uploadDir . $fileName;

        // Move the uploaded CSV file to the upload directory
        if (move_uploaded_file($_FILES['csvFile']['tmp_name'], $targetFile)) {
            // Initialize an array to store QR data for each row
            $qrData = array();

            if (($handle = fopen($targetFile, "r")) !== false) {
                // Skip the first row which contains column names
                fgetcsv($handle, 10000, ";");

                // Loop through each row in the CSV file
                while (($data = fgetcsv($handle, 10000, ";")) !== false) {
                    $name = isset($data[0]) ? $data[0] : ""; // Assign the "name" column value to $name
                    $content = isset($data[1]) ? $data[1] : ""; // Assign the "content" column value to $content
                    $link = isset($data[2]) ? $data[2] : ""; // Assign the "link" column value to $link

                    // Generate QR data for each row and add it to the array
                    $qrData[] = array(
                        'name' => $name,
                        'content' => $content,
                        'link' => $link
                    );
                }
                fclose($handle);

                // Send the QR data back to the client as JSON response
                header('Content-Type: application/json');
                echo json_encode($qrData);
                exit;
            } else {
                echo "Failed to read the CSV file.";
            }
        } else {
            echo "Failed to upload the file.";
        }
    } else {
        echo "Error uploading the file.";
    }
}
