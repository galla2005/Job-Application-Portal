<?php
include 'database.php';

$error_message = '';
$success_message = '';

if (isset($_GET['email'])) {
    $email = htmlspecialchars(trim($_GET['email']));

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Handle password reset
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate passwords match
            if ($new_password !== $confirm_password) {
                $error_message = "Passwords do not match.";
            } else {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                $stmt->execute([$hashed_password, $email]);

                // Success message
                $success_message = "Your password has been successfully updated. Redirecting to login page...";

                // Redirect to login page after a short delay
                header("Refresh: 3; url=login.php");
            }
        }
    } else {
        $error_message = "Invalid or expired link.";
    }
} else {
    $error_message = "No email address found in the link.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Job Application Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a6bff;
            --secondary-color: #f8f9fa;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --light-text: #6c757d;
            --border-radius: 8px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
    font-family: 'Poppins', sans-serif;
    background: white;
    color: var(--text-color);
    line-height: 1.6;
    padding: 20px;
}

        
        .container {
            max-width: 500px;
            margin: 60px auto;
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        h1 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .description {
            text-align: center;
            color: var(--light-text);
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: border 0.3s ease;
        }
        
        input[type="password"]:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
        }
        
        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 12px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .success-message {
            color: #28a745;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 12px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            text-align: center;
        }
        
        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            width: 100%;
            font-weight: 500;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        
        button:hover {
            background-color: #3a56e0;
        }
        
        .password-requirements {
            font-size: 14px;
            color: var(--light-text);
            margin-top: 5px;
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-login a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-login a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 30px;
                margin: 30px auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reset Your Password</h1>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        
        <?php if (isset($user) && empty($success_message)): ?>
            <p class="description">Please enter your new password below.</p>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" required placeholder="Enter new password">
                    <p class="password-requirements">Use at least 8 characters with a mix of letters and numbers.</p>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" required placeholder="Confirm new password">
                </div>
                
                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
        
        <div class="back-to-login">
            <a href="login.php">← Back to login</a>
        </div>
    </div>
</body>
</html>