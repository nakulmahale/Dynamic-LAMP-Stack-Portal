<?php
$host = 'localhost';
$db   = 'app_db';$user = 'app_user';
$pass = 'StrongPassword123!';$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$dbConnected = false;
$errorMessage = '';$users = [];

try {
     $pdo = new PDO($dsn, $user,$pass, $options);$dbConnected = true;
     $stmt =$pdo->query('SELECT id, name, email, created_at FROM users ORDER BY id ASC');
     $users =$stmt->fetchAll();
} catch (\PDOException $e) {$dbConnected = false;
     $errorMessage =$e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAMP Stack Web Portal - RHEL 10</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success-bg: #dcfce7;
            --success-text: #15803d;
            --error-bg: #fee2e2;
            --error-text: #b91c1c;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 900px;
        }

        /* Header Styling */
        header {
            margin-bottom: 24px;
        }

        .badge {
            display: inline-block;
            background: #e0e7ff;
            color: #3730a3;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        p.subtitle {
            color: var(--text-muted);
            font-size: 15px;
        }

        /* Card Container */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            padding: 24px;
            margin-bottom: 24px;
        }

        /* Connection Status Alert */
        .status-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .status-alert.success {
            background-color: var(--success-bg);
            color: var(--success-text);
        }

        .status-alert.error {
            background-color: var(--error-bg);
            color: var(--error-text);
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: currentColor;
            display: inline-block;
        }

        /* Interactive Controls */
        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-box {
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
            max-width: 280px;
            outline: none;
            transition: border-color 0.2s;
        }

        .search-box:focus {
            border-color: var(--primary);
        }

        .record-count {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f1f5f9;
            color: var(--text-muted);
            font-weight: 600;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text-main);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        /* Footer Tech Stack Labels */
        .tech-stack {
            display: flex;
            gap: 8px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        .tech-pill {
            background: #f1f5f9;
            border: 1px solid var(--border);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <span class="badge">Linux Systems Practical</span>
        <h1>Dynamic LAMP Stack Portal</h1>
        <p class="subtitle">Deploying PHP & MariaDB on Red Hat Enterprise Linux 10</p>
    </header>

    <div class="card">
        <!-- DB Connection Status -->
        <?php if ($dbConnected): ?>
            <div class="status-alert success">
                <span class="status-dot"></span>
                <span><strong>Database Connected:</strong> Successfully connected to MariaDB (`app_db`) via PDO.</span>
            </div>
        <?php else: ?>
            <div class="status-alert error">
                <span class="status-dot"></span>
                <span><strong>Connection Failed:</strong> <?php echo htmlspecialchars($errorMessage); ?></span>
            </div>
        <?php endif; ?>

        <!-- Table Controls & Search (JavaScript) -->
        <div class="controls">
            <input type="text" id="searchInput" class="search-box" placeholder="Search records by name or email..." onkeyup="filterTable()">
            <span class="record-count" id="recordCount">Total Records: <?php echo count($users); ?></span>
        </div>

        <!-- Dynamic Data Table -->
        <div class="table-responsive">
            <table id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as$row): ?>
                            <tr>
                                <td><strong>#<?php echo htmlspecialchars($row['id']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted);">No records found in database.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tech Stack Tags -->
        <div class="tech-stack">
            <span class="tech-pill">🐧 RHEL 10</span>
            <span class="tech-pill">🚀 Apache 2.4</span>
            <span class="tech-pill">🐬 MariaDB 10</span>
            <span class="tech-pill">🐘 PHP 8.x PDO</span>
        </div>
    </div>
</div>

<!-- JavaScript for Client-Side Table Filtering -->
<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('dataTable');
    const tr = table.getElementsByTagName('tr');
    let visibleCount = 0;

    for (let i = 1; i < tr.length; i++) {
        let nameCol = tr[i].getElementsByTagName('td')[1];
        let emailCol = tr[i].getElementsByTagName('td')[2];
        
        if (nameCol || emailCol) {
            let nameValue = nameCol.textContent || nameCol.innerText;
            let emailValue = emailCol.textContent || emailCol.innerText;
            
            if (nameValue.toLowerCase().indexOf(filter) > -1 || emailValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                visibleCount++;
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    
    document.getElementById('recordCount').innerText = `Showing Records: ${visibleCount}`;
}
</script>

</body>
</html>
