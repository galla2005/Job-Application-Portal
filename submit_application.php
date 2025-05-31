<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = $_POST['job_id'];
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $cover = htmlspecialchars(trim($_POST['cover_letter']));

    // File upload handling (optional)
    $resumeName = '';
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === 0) {
        $resumeName = basename($_FILES['resume']['name']);
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        move_uploaded_file($_FILES['resume']['tmp_name'], $uploadDir . $resumeName);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --warning: #f72585;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --success-bg: #edf7ff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--success-bg);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .confirmation-container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
        }
        
        .confirmation-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .confirmation-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-top: 20px solid var(--primary);
        }
        
        .confirmation-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: bounce 1s ease infinite alternate;
        }
        
        .confirmation-body {
            padding: 40px;
        }
        
        .confirmation-message {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .confirmation-message h2 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.8rem;
        }
        
        .confirmation-message p {
            color: var(--gray);
            font-size: 1.1rem;
        }
        
        .application-details {
            background: var(--light);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 15px;
            animation: slideIn 0.5s ease forwards;
            opacity: 0;
        }
        
        .detail-item:last-child {
            margin-bottom: 0;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--primary);
            min-width: 120px;
        }
        
        .detail-value {
            flex: 1;
            color: var(--dark);
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: white;
            padding: 12px 25px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 20px;
            width: 100%;
            max-width: 250px;
            margin: 0 auto;
        }
        
        .back-link:hover {
            background: var(--secondary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .back-link i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }
        
        .back-link:hover i {
            transform: translateX(-5px);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes bounce {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-10px);
            }
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .confirmation-body {
                padding: 25px;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-header">
            <div class="confirmation-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Application Submitted!</h1>
        </div>
        
        <div class="confirmation-body">
            <div class="confirmation-message">
                <h2>Thank you, <?php echo $name; ?>!</h2>
                <p>Your application has been successfully submitted for Job ID: <?php echo $jobId; ?>.</p>
            </div>
            
            <div class="application-details">
                <div class="detail-item" style="animation-delay: 0.2s">
                    <span class="detail-label">Job ID:</span>
                    <span class="detail-value"><?php echo $jobId; ?></span>
                </div>
                
                <div class="detail-item" style="animation-delay: 0.3s">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value"><?php echo $name; ?></span>
                </div>
                
                <div class="detail-item" style="animation-delay: 0.4s">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value"><?php echo $email; ?></span>
                </div>
                
                <div class="detail-item" style="animation-delay: 0.5s">
                    <span class="detail-label">Cover Letter:</span>
                    <span class="detail-value"><?php echo $cover; ?></span>
                </div>
                
                <?php if ($resumeName): ?>
                <div class="detail-item" style="animation-delay: 0.6s">
                    <span class="detail-label">Resume:</span>
                    <span class="detail-value"><?php echo $resumeName; ?></span>
                </div>
                <?php endif; ?>
            </div>
            
            <div style="text-align: center;">
                <a href="job_listings.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to Job Listings
                </a>
            </div>
        </div>
    </div>

    <script>
        // Add staggered animations to detail items
        document.addEventListener('DOMContentLoaded', function() {
            const detailItems = document.querySelectorAll('.detail-item');
            
            detailItems.forEach((item, index) => {
                item.style.animationDelay = `${0.2 + (index * 0.1)}s`;
                item.style.animationFillMode = 'forwards';
            });
            
            // Add hover effect to back link
            const backLink = document.querySelector('.back-link');
            if (backLink) {
                backLink.addEventListener('mouseenter', () => {
                    backLink.style.transform = 'translateY(-3px)';
                });
                backLink.addEventListener('mouseleave', () => {
                    backLink.style.transform = 'translateY(0)';
                });
            }
        });
    </script>
</body>
</html>
<?php
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #212529;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        
        .error-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            animation: fadeIn 0.5s ease-out;
        }
        
        .error-icon {
            font-size: 3rem;
            color: #f72585;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #f72585;
            margin-bottom: 15px;
        }
        
        p {
            margin-bottom: 25px;
            color: #6c757d;
        }
        
        a {
            color: #4361ee;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        a:hover {
            color: #3f37c9;
            text-decoration: underline;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h1>Invalid Access</h1>
        <p>Please submit your application through the proper form.</p>
        <a href="job_listings.php">Return to Job Listings</a>
    </div>
</body>
</html>
<?php
}
?>