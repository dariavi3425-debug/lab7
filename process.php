<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $genre = htmlspecialchars(trim($_POST['genre'] ?? ''));
    $format = htmlspecialchars(trim($_POST['format'] ?? ''));
    $feedback = htmlspecialchars(trim($_POST['feedback'] ?? ''));

    if (empty($name) || empty($email)) {
        echo json_encode([
            "status" => "error", 
            "message" => "Будь ласка, заповніть усі обов'язкові поля."
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $dateTime = date("Y-m-d H:i:s");
    $fileTimestamp = date("Y-m-d_H-i-s");

    $surveyData = [
        "submitted_at" => $dateTime,
        "respondent" => [
            "name" => $name,
            "email" => $email
        ],
        "answers" => [
            "favorite_genre" => $genre,
            "reading_format" => $format,
            "feedback" => $feedback
        ]
    ];

    $dir = __DIR__ . '/survey';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $filename = $dir . '/survey_' . $fileTimestamp . '.json';
    file_put_contents($filename, json_encode($surveyData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    echo json_encode([
        "status" => "success",
        "message" => "Дякуємо, " . $name . "! Вашу відповідь успішно збережено.",
        "dateTime" => $dateTime
    ], JSON_UNESCAPED_UNICODE);
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>