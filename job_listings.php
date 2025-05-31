<?php
session_start();
$userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : 'Guest';

// Define job skills (example for 50 jobs)
$skillsList = ["PHP", "JavaScript", "Python", "Java", "C++", "HTML/CSS", "SQL", "Node.js", "React", "Laravel"];

// Generate sample job data (50 jobs)
$jobs = [];
for ($i = 1; $i <= 50; $i++) {
    $jobs[] = [
        'id' => $i,
        'title' => "Software Engineer Level $i",
        'company' => "TechCorp Inc.",
        'location' => "City " . $i,
        'description' => "Join our team as a Software Engineer Level $i. We're looking for talented individuals with passion for technology and problem-solving skills.",
        'skills' => $skillsList[$i % count($skillsList)],
        'salary' => '$' . (80000 + ($i * 2000)) . ' - $' . (100000 + ($i * 3000)),
        'type' => ($i % 3 == 0) ? 'Remote' : (($i % 3 == 1) ? 'Hybrid' : 'On-site'),
        'posted' => date('M j, Y', strtotime("-".($i % 30)." days")),
        'urgent' => ($i % 5 == 0) // Every 5th job is marked as urgent
    ];
}

// Search logic
$search = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
if (!empty($search)) {
    $jobs = array_filter($jobs, function ($job) use ($search) {
        return strpos(strtolower($job['title']), $search) !== false ||
               strpos(strtolower($job['location']), $search) !== false ||
               strpos(strtolower($job['description']), $search) !== false ||
               strpos(strtolower($job['skills']), $search) !== false ||
               strpos(strtolower($job['type']), $search) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-light: #6366F1;
            --primary-dark: #4338CA;
            --secondary: #10B981;
            --accent: #F59E0B;
            --danger: #EF4444;
            --light: #F9FAFB;
            --dark: #111827;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-500: #6B7280;
            --gray-700: #374151;
            --gray-900: #1F2937;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --radius-sm: 0.25rem;
            --radius: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        header {
            background-color: white;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .logo-icon {
            color: var(--primary-light);
        }
        
        .user-nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .welcome-message {
            font-size: 0.875rem;
            color: var(--gray-700);
        }
        
        .welcome-message strong {
            color: var(--primary-dark);
            font-weight: 600;
        }
        
        .main-content {
            padding: 2.5rem 0;
        }
        
        .page-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .page-description {
            color: var(--gray-500);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .search-container {
            background-color: white;
            border-radius: var(--radius-md);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }
        
        .search-container:hover {
            box-shadow: var(--shadow-md);
        }
        
        .search-form {
            display: flex;
            gap: 1rem;
        }
        
        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            background-color: var(--light);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background-color: white;
        }
        
        .search-button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            cursor: pointer;
            font-size: 0.9375rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .search-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }
        
        .search-button:active {
            transform: translateY(0);
        }
        
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .filter-btn {
            padding: 0.5rem 1rem;
            background-color: var(--gray-100);
            color: var(--gray-700);
            border: none;
            border-radius: var(--radius-lg);
            font-size: 0.8125rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .filter-btn:hover {
            background-color: var(--gray-200);
        }
        
        .filter-btn.active {
            background-color: var(--primary);
            color: white;
        }
        
        .job-count {
            font-size: 0.875rem;
            color: var(--gray-500);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .job-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 1.5rem;
        }
        
        .job-card {
            background-color: white;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 1px solid var(--gray-200);
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }
        
        .job-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-light);
        }
        
        .job-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            position: relative;
        }
        
        .job-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
            transition: color 0.2s ease;
        }
        
        .job-card:hover .job-title {
            color: var(--primary);
        }
        
        .job-company {
            color: var(--primary);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .job-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1rem;
            font-size: 0.8125rem;
        }
        
        .job-meta-item {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-500);
        }
        
        .job-meta-item i {
            color: var(--gray-400);
        }
        
        .job-card-body {
            padding: 1.5rem;
        }
        
        .job-description {
            color: var(--gray-700);
            margin-bottom: 1rem;
            font-size: 0.9375rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .job-skills {
            margin-bottom: 1.25rem;
        }
        
        .skill-tag {
            display: inline-flex;
            align-items: center;
            background-color: var(--gray-100);
            color: var(--gray-700);
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-lg);
            font-size: 0.75rem;
            font-weight: 500;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .skill-tag:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-1px);
        }
        
        .job-card-footer {
            padding: 1rem 1.5rem;
            background-color: var(--gray-50);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--gray-100);
        }
        
        .job-posted {
            font-size: 0.75rem;
            color: var(--gray-500);
        }
        
        .apply-button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            cursor: pointer;
            font-size: 0.8125rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.2s ease;
        }
        
        .apply-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }
        
        .apply-button:active {
            transform: translateY(0);
        }
        
        .job-type {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: var(--gray-100);
            color: var(--gray-700);
            padding: 0.25rem 0.5rem;
            border-radius: var(--radius);
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .job-type.remote {
            background-color: #ECFDF5;
            color: var(--secondary);
        }
        
        .job-type.hybrid {
            background-color: #FEF3C7;
            color: var(--accent);
        }
        
        .urgent-badge {
            position: absolute;
            top: 0;
            left: 0;
            background-color: var(--danger);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0 0 var(--radius) 0;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .no-jobs {
            text-align: center;
            padding: 3rem;
            color: var(--gray-500);
            grid-column: 1 / -1;
        }
        
        .no-jobs-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--gray-300);
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
        
        /* Utility classes */
        .flex {
            display: flex;
        }
        
        .items-center {
            align-items: center;
        }
        
        .gap-2 {
            gap: 0.5rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .user-nav {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .search-form {
                flex-direction: column;
            }
            
            .job-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="#" class="logo">
                    <i class="fas fa-briefcase logo-icon"></i>
                    <span>JobConnect</span>
                </a>
                <div class="user-nav">
                    <div class="welcome-message">Welcome back, <strong><?php echo htmlspecialchars($userName); ?></strong></div>
                </div>
            </div>
        </div>
    </header>
    
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Find Your Dream Job</h1>
                <p class="page-description">Browse through our latest job openings and find the perfect match for your skills and experience.</p>
            </div>
            
            <div class="search-container">
                <form method="GET" action="" class="search-form">
                    <input type="text" name="search" placeholder="Search by job title, company, or location" 
                           value="<?php echo htmlspecialchars($search); ?>" class="search-input">
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>
            
            <div class="filters">
                <button class="filter-btn active">All Jobs</button>
                <button class="filter-btn">Remote</button>
                <button class="filter-btn">Full-time</button>
                <button class="filter-btn">Part-time</button>
                <button class="filter-btn">Internship</button>
            </div>
            
            <div class="job-count">
                <i class="fas fa-filter"></i>
                <?php echo count($jobs); ?> job<?php echo count($jobs) !== 1 ? 's' : ''; ?> found
            </div>
            
            <?php if (empty($jobs)): ?>
                <div class="no-jobs">
                    <div class="no-jobs-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3>No jobs found</h3>
                    <p>Try adjusting your search criteria or filters</p>
                </div>
            <?php else: ?>
                <div class="job-list">
                    <?php foreach ($jobs as $index => $job): ?>
                        <div class="job-card" style="animation-delay: <?php echo $index * 0.05; ?>s">
                            <?php if ($job['urgent']): ?>
                                <div class="urgent-badge">Urgent</div>
                            <?php endif; ?>
                            <div class="job-card-header">
                                <h3 class="job-title"><?php echo htmlspecialchars($job['title']); ?></h3>
                                <div class="job-company">
                                    <i class="fas fa-building"></i>
                                    <?php echo htmlspecialchars($job['company']); ?>
                                </div>
                                <div class="job-meta">
                                    <span class="job-meta-item">
                                        <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($job['location']); ?>
                                    </span>
                                    <span class="job-meta-item">
                                        <i class="fas fa-dollar-sign"></i> <?php echo htmlspecialchars($job['salary']); ?>
                                    </span>
                                </div>
                                <div class="job-type <?php echo strtolower($job['type']); ?>">
                                    <?php echo $job['type']; ?>
                                </div>
                            </div>
                            <div class="job-card-body">
                                <p class="job-description"><?php echo htmlspecialchars($job['description']); ?></p>
                                <div class="job-skills">
                                    <span class="skill-tag">
                                        <i class="fas fa-code"></i> <?php echo htmlspecialchars($job['skills']); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="job-card-footer">
                                <span class="job-posted">Posted <?php echo $job['posted']; ?></span>
                                <a href="apply_job.php?id=<?php echo $job['id']; ?>" class="apply-button">
                                    Apply Now <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jobCards = document.querySelectorAll('.job-card');
            
            // Scroll reveal animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            jobCards.forEach(card => {
                observer.observe(card);
            });
            
            // Filter buttons functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    // Here you would typically filter the jobs
                });
            });
            
            // Add hover effect to job cards
            jobCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-4px)';
                    card.style.boxShadow = 'var(--shadow-md)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                    card.style.boxShadow = 'var(--shadow-sm)';
                });
            });
        });
    </script>
</body>
</html>