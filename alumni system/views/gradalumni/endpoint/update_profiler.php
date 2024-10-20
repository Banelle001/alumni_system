<?php
include ('connection.php');

$updateUserID = $_POST['id'];
$updateFirstName = $_POST['first_name'];
$updateLastName = $_POST['last_name'];
$updateContactNumber = $_POST['contact_number'];
$updateEmail = $_POST['email'];
$updateUsername = $_POST['username'];
$updatePassword = $_POST['password'];
$hashedPassword = password_hash($updatedpassword, PASSWORD_BCRYPT);

try {
    $stmt = $conn->prepare("SELECT `first_name`, `last_name` FROM `tbl_user` WHERE `first_name` = :first_name AND `last_name` = :last_name");
    $stmt->execute([
        'first_name' => $updateFirstName,
        'last_name'=> $updateLastName
    ]);
    $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($nameExist)) {
        $conn->beginTransaction();

        $updateStmt = $conn->prepare("UPDATE `tbl_user` SET `first_name` = :first_name, `last_name` = :last_name, `contact_number` = :contact_number, `email` = :email, `username` = :username, `password` = :password WHERE `id` = :userID");
        $updateStmt->bindParam(':first_name', $updateFirstName, PDO::PARAM_STR);
        $updateStmt->bindParam(':last_name', $updateLastName, PDO::PARAM_STR);
        $updateStmt->bindParam(':contact_number', $updateContactNumber, PDO::PARAM_INT);
        $updateStmt->bindParam(':email', $updateEmail, PDO::PARAM_STR);
        $updateStmt->bindParam(':username', $updateUsername, PDO::PARAM_STR);
        $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $updateStmt->bindParam(':userID', $updateUserID, PDO::PARAM_INT);
        $updateStmt->execute();

        echo "
        <script>
            alert('Updated Successfully');
            window.location.href = 'http://localhost/gradalumni/alumnilist.php';
        </script>
        ";

        $conn->commit();
    } else {
        echo "
        <script>
            alert('User Already Exist');
            window.location.href = 'http://localhost/gradalumni/alumnilist.php';
        </script>
        ";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



?>

