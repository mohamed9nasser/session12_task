<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $note_id = $_POST['note_id'];
    $sql = "DELETE FROM notes WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $note_id, $user_id);
    $stmt->execute();
}

$notes = [];
$sql = "SELECT * FROM notes WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $notes[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<div class="home-page">
    <h1>Welcome, User!</h1>
    <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
   
        <a href="add_note.php" class="add-note">Add Note</a><br><br>
        <h2>Your Notes</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th colspan="2">Actions</th>
            </tr>
            <?php foreach ($notes as $note): ?>
            <tr>
                <td><?php echo htmlspecialchars($note['title']); ?></td>
                <td><?php echo htmlspecialchars($note['description']); ?></td>
                <td>
                    <a href="update_note.php?id=<?php echo $note['id']; ?>">Edit</a>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>"> 
                       
                      <td><input type="submit" name="delete" value="Delete" class="delete-button"></td>
                    
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        
        
    
</body>
</html>