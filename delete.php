<?php
session_start();
require_once 'database.php';

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errorMessage = 'CSRF token mismatch. Operation aborted.';
    } elseif (isset($_POST['id'])) {
        $id = $_POST['id'];

        // It's good practice to unset the token once it's been used
        // However, ensure it's only unset after successful validation for the current request.
        // If validation itself fails, the token might be needed for a retry if the user goes back and resubmits.
        // For this flow, unsetting after successful validation is fine.
        // A more robust approach might involve regenerating it on the form page each time.
        // For now, let's keep it simple: unset if valid.
        if (isset($_SESSION['csrf_token'])) { // Check if it exists before unsetting
             unset($_SESSION['csrf_token']);
        }

        $sql = "DELETE FROM students WHERE id = :id";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: index.php?status=deleted_successfully'); // More specific status
            exit;
        } else {
            // Log detailed error: errorInfo() or errorCode() from $stmt
            error_log("Delete failed for student ID {$id}: " . implode(";", $stmt->errorInfo()));
            $errorMessage = 'ลบข้อมูลไม่สำเร็จ (Delete failed). Please try again.';
        }
    } else {
        $errorMessage = 'Student ID not provided for deletion.';
    }
} else {
    // Not a POST request
    $errorMessage = 'Invalid request method. This action requires a POST request.';
}

// If we are here, something went wrong or it wasn't a direct successful delete redirect
if (!empty($errorMessage)) {
    // Redirect to index.php with an error message, or display a dedicated error page.
    // Storing error in session and displaying on index.php might be cleaner than alert.
    $_SESSION['error_message'] = $errorMessage;
    header('Location: index.php');
    exit;
}
?>
