<?php
session_start();
include('db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the note ID from the URL
if (isset($_GET['id'])) {
    $note_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Fetch the note from the database
    $sql = "SELECT * FROM notes WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $note_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if note exists
    if ($result->num_rows == 0) {
        echo "Note not found.";
        exit();
    }

    // Fetch note details
    $note = $result->fetch_assoc();
} else {
    echo "No note ID provided.";
    exit();
}

// Handle form submission to update the note
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Update the note in the database
    $sql = "UPDATE notes SET title = ?, description = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $title, $description, $note_id, $user_id);

    if ($stmt->execute()) {
        header('Location: home.php');
        exit();
    } else {
        echo "Error updating note: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Update Note</title>
</head>
<body>
<div class="update-note-page">
    <h1>Update Note</h1>
    <form method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($note['title']); ?>" required><br><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50"><?php echo htmlspecialchars($note['description']); ?></textarea><br><br>
        
        <input type="submit" value="Update Note">
    </form>
    <a href="home.php">Back to Home</a>
</div>
    
</body>
</html>
