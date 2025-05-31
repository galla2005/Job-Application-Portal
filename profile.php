<?php
session_start();
include 'database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user exists
if (!$user) {
    echo "User not found.";
    exit();
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize it
    $name = htmlspecialchars(trim($_POST['name']));
    $location = htmlspecialchars(trim($_POST['location']));
    $contact_number = htmlspecialchars(trim($_POST['contact_number']));
    
    // Handle profile picture upload
    $profile_picture = $user['profile_picture'];  // Keep the existing picture if not updated
    if ($_FILES['profile_picture']['name']) {
        // Check if file is valid (e.g., check file type and size)
        $file_error = $_FILES['profile_picture']['error'];
        if ($file_error === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['profile_picture']['tmp_name'];
            $file_name = basename($_FILES['profile_picture']['name']);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Validate file extension (only allow image files)
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_ext, $allowed_extensions)) {
                // Validate file size (max 5MB)
                if ($_FILES['profile_picture']['size'] <= 5 * 1024 * 1024) {
                    // Ensure the uploads folder exists
                    $upload_dir = 'uploads/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);  // Create the directory if it doesn't exist
                    }

                    // Move the uploaded file to the server
                    $profile_picture = $upload_dir . uniqid() . '.' . $file_ext;  // Rename to prevent overwriting
                    move_uploaded_file($file_tmp, $profile_picture);
                } else {
                    $error_message = "File size exceeds the limit of 5MB.";
                }
            } else {
                $error_message = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        } else {
            $error_message = "File upload error.";
        }
    }

    if (!isset($error_message)) {
        // Update user details in the database
        $stmt = $conn->prepare("UPDATE users SET name = ?, location = ?, contact_number = ?, profile_picture = ? WHERE id = ?");
        $stmt->execute([$name, $location, $contact_number, $profile_picture, $user_id]);

        // Set success message and refresh user data
        $success_message = "Profile updated successfully!";
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Job Application Portal</title>
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
            background-color: #f5f7ff;
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 40px auto;
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
        
        .profile-section {
            display: flex;
            gap: 40px;
            margin-bottom: 30px;
        }
        
        .profile-picture-container {
            flex: 1;
            text-align: center;
        }
        
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin-bottom: 15px;
        }
        
        .profile-form {
            flex: 2;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: border 0.3s ease;
        }
        
        input[type="text"]:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
        }
        
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input-button {
            background-color: var(--secondary-color);
            color: var(--text-color);
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }
        
        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
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
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .profile-section {
                flex-direction: column;
                gap: 20px;
            }
            
            .container {
                padding: 30px;
                margin: 30px auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Your Profile</h1>
        
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <div class="profile-section">
            <div class="profile-picture-container">
                <?php if ($user['profile_picture']): ?>
                    <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-picture">
                <?php else: ?>
                    <div class="profile-picture" style="background-color: #eee; display: flex; align-items: center; justify-content: center;">
                        <span style="color: var(--light-text);">No Photo</span>
                    </div>
                <?php endif; ?>
                <p>Current Profile Picture</p>
            </div>
            
            <div class="profile-form">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" value="<?php echo htmlspecialchars($user['location']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" name="contact_number" value="<?php echo htmlspecialchars($user['contact_number']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_picture">Update Profile Picture</label>
                        <div class="file-input-wrapper">
                            <button type="button" class="file-input-button">Choose File</button>
                            <input type="file" name="profile_picture" accept="image/*">
                        </div>
                        <small style="color: var(--light-text); display: block; margin-top: 5px;">Max file size: 5MB (JPG, PNG, GIF)</small>
                    </div>
                    
                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>
        
        <div class="back-link">
            <a href="homepage.php">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>