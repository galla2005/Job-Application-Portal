<?php
session_start();

$userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : '';
$jobId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Sample job data - In real use, this would be fetched from a DB
$jobTitle = "Software Engineer Level $jobId";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?php echo htmlspecialchars($jobTitle); ?></title>
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
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
            padding: 0;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            animation: fadeIn 0.5s ease-out;
        }
        
        .application-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .application-header h2 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .application-header h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }
        
        .application-header p {
            color: var(--gray);
            font-size: 1.1rem;
        }
        
        .application-form {
            background-color: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .application-form:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
            animation: slideUp 0.5s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--light-gray);
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-control:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
            background-color: var(--light-gray);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            background-color: #e2e6ea;
        }
        
        .file-upload-label span {
            color: var(--gray);
        }
        
        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .submit-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            text-align: center;
            width: 100%;
        }
        
        .submit-btn:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        
        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
        }
        
        .back-link:hover {
            color: var(--secondary);
            transform: translateX(-5px);
        }
        
        .back-link i {
            margin-right: 8px;
            transition: all 0.3s ease;
        }
        
        .back-link:hover i {
            transform: translateX(-3px);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .application-form {
                padding: 25px;
            }
            
            .application-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="application-header">
            <h2>Apply for <?php echo htmlspecialchars($jobTitle); ?></h2>
            <p>Complete the form below to submit your application</p>
        </div>
        
        <form class="application-form" action="submit_application.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="job_id" value="<?php echo $jobId; ?>">
            
            <div class="form-group" style="animation-delay: 0.1s">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" 
                       value="<?php echo htmlspecialchars($userName); ?>" required>
            </div>
            
            <div class="form-group" style="animation-delay: 0.2s">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group" style="animation-delay: 0.3s">
                <label for="cover_letter">Cover Letter</label>
                <textarea id="cover_letter" name="cover_letter" class="form-control" required></textarea>
            </div>
            
            <div class="form-group" style="animation-delay: 0.4s">
                <label>Upload Resume (PDF, DOC, DOCX - Max 5MB)</label>
                <div class="file-upload">
                    <label class="file-upload-label">
                        <span id="file-name">Choose a file...</span>
                        <i class="fas fa-cloud-upload-alt"></i>
                    </label>
                    <input type="file" name="resume" class="file-upload-input" id="resume" 
                           accept=".pdf,.doc,.docx" onchange="updateFileName(this)">
                </div>
            </div>
            
            <div class="form-group" style="animation-delay: 0.5s">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Submit Application
                </button>
            </div>
        </form>
        
        <a href="job_listings.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Job Listings
        </a>
    </div>

    <script>
        // Add animation to form elements when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            
            formGroups.forEach((group, index) => {
                // Set different delay for each form group
                group.style.animationDelay = `${0.1 + (index * 0.1)}s`;
            });
            
            // File name display
            window.updateFileName = function(input) {
                const fileName = input.files[0] ? input.files[0].name : 'Choose a file...';
                document.getElementById('file-name').textContent = fileName;
            };
            
            // Add hover effect to submit button
            const submitBtn = document.querySelector('.submit-btn');
            if (submitBtn) {
                submitBtn.addEventListener('mouseenter', () => {
                    submitBtn.style.transform = 'translateY(-2px)';
                });
                submitBtn.addEventListener('mouseleave', () => {
                    submitBtn.style.transform = 'translateY(0)';
                });
            }
        });
    </script>
</body>
</html>