<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "databasekic";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $moisture = $_POST['moisture'];
    $ph_level = $_POST['ph_level'];
    $texture = $_POST['texture'];
    $nitrogen_level = $_POST['nitrogen_level'];
    $organic_matter = $_POST['organic_matter'];

    if (
        $moisture >= 0 && $moisture <= 100 &&
        $ph_level >= 0 && $ph_level <= 14 &&
        $nitrogen_level >= 0 && $nitrogen_level <= 3 &&
        $organic_matter >= 0 && $organic_matter <= 10
    ) {
        $sql = "INSERT INTO soil_samples (moisture, ph_level, texture, nitrogen_level, organic_matter)
                VALUES ('$moisture', '$ph_level', '$texture', '$nitrogen_level', '$organic_matter')";

        if ($conn->query($sql) === TRUE) {
            $to = "ramdhanna551@gmail.com"; 
            $subject = "New Soil Sample Submission";
            $message = "A new soil sample has been submitted:\n\n" .
                       "Moisture: $moisture%\n" .
                       "pH Level: $ph_level\n" .
                       "Texture: $texture\n" .
                       "Nitrogen Level: $nitrogen_level%\n" .
                       "Organic Matter: $organic_matter%\n";

            // $headers = "From: no-reply@yourwebsite.com";
            // $headers = "From: prakash18052006@gmail.com";

            if (mail($to, $subject, $message)) {
                echo "New soil sample record created successfully. Email sent!";
            } else {
                echo "New soil sample record created, but email could not be sent.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid data provided! Please ensure all values are within the specified ranges.";
    }
}

$conn->close();
?>
