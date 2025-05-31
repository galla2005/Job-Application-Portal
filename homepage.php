<?php
session_start();
$userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Online Job Portal</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #ffffff; /* White background */
      color: #333;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 60px 20px;
      text-align: center;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    h1 {
      color: #1e3c72;
      font-size: 3em;
      margin-bottom: 10px;
      width: 100%;
    }

    p {
      font-size: 1.2em;
      color: #555;
      margin-bottom: 40px;
      width: 100%;
    }

    .btn {
      display: inline-block;
      padding: 15px 35px;
      font-size: 17px;
      background: linear-gradient(to right, #1e90ff, #007bff);
      color: white;
      text-decoration: none;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 123, 255, 0.4);
    }

    .section {
      background-color: #ffffff;
      padding: 35px;
      width: 48%;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
      box-sizing: border-box;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: 2px solid #e0e0e0;
    }

    .section:hover {
      transform: translateY(-7px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      border-color: #1e90ff;
    }

    .section img {
      border-radius: 50%;
      margin-bottom: 20px;
      width: 130px;
      height: 130px;
      object-fit: cover;
    }

    .section h3 {
      font-size: 1.8em;
      margin: 15px 0;
      color: #1e3c72;
    }

    .section p {
      color: #6c757d;
      font-size: 1.1em;
    }

    .footer {
      background-color: #1e3c72;
      color: white;
      padding: 25px 0;
      text-align: center;
    }

    .footer a {
      color: #cce5ff;
      text-decoration: none;
      margin: 0 10px;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .section {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Welcome to the Online Job Portal</h1>
    <p>Hello, <?php echo $userName; ?>! Find your dream job or update your profile to improve your chances.</p>

    <!-- Profile Update Section -->
    <div class="section">
      <h3>Update Your Profile</h3>
      <p>Make sure your profile is up to date with your latest skills and experience.</p>
      <a href="profile.php" class="btn">Edit Profile</a>
    </div>

    <!-- Job Listings Section -->
    <div class="section">
      <h3>Browse Job Listings</h3>
      <p>Explore a variety of job opportunities and apply for your next job!</p>
      <a href="job_listings.php" class="btn">View Job Listings</a>
    </div>
  </div>

</body>
</html>
