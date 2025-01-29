<?php
session_start();

// Define quiz questions and options
$questions = [
    "What is the capital of France?" => ["Paris", "London", "Berlin", "Madrid"],
    "Which language is used for web development?" => ["Python", "C++", "PHP", "Java"],
    "What is 5 + 3?" => ["5", "8", "10", "15"],
    "Which planet is known as the Red Planet?" => ["Earth", "Mars", "Jupiter", "Venus"]
];

// Correct answers (must match question order)
$correct_answers = ["Paris", "PHP", "8", "Mars"];

// Initialize session variables
if (!isset($_SESSION['question_index'])) {
    $_SESSION['question_index'] = 0;
    $_SESSION['score'] = 0;
}

// Get current question index
$index = $_SESSION['question_index'];

// Check if quiz is finished
if ($index >= count($questions)) {
    echo "<h2>Quiz Completed!</h2>";
    echo "<p>Your final score: {$_SESSION['score']} out of " . count($questions) . "</p>";
    session_destroy(); // Reset quiz
    echo "<br><a href='quiz_app.php'>Restart Quiz</a>";
    exit;
}

// ✅ Check if the request method is set before using it
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answer']) && $_POST['answer'] == $correct_answers[$index]) {
        $_SESSION['score']++; // Increase score if correct
    }
    $_SESSION['question_index']++; // Move to next question
    header("Location: quiz_app.php"); // Refresh page
    exit;
}

// Display current question
$question_text = array_keys($questions)[$index];
$options = $questions[$question_text];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Quiz</title>
</head>
<body>

    <h2>Question <?php echo $index + 1; ?>:</h2>
    <p><?php echo $question_text; ?></p>

    <form method="post">
        <?php foreach ($options as $option) { ?>
            <input type="radio" name="answer" value="<?php echo $option; ?>" required> <?php echo $option; ?><br>
        <?php } ?>
        <br>
        <input type="submit" value="Next">
    </form>

</body>
</html>
