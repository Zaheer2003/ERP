
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .timeline {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .timeline-item {
            display: flex;
            margin-bottom: 1.5rem;
            align-items: flex-start;
        }
        .timeline-item .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 1rem;
        }
        .timeline-item .timestamp {
            font-size: 0.9rem;
            color: #888;
        }
        .timeline-item .activity {
            background-color: #f9f9f9;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
        }
        .timeline-item .activity p {
            margin: 0;
        }
        .file-link {
            color: #007bff;
            text-decoration: none;
        }
        .team-members img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h3>Activity Timeline</h3>
        <ul class="timeline">
            <?php
            // Example data, you can replace this with a database fetch
            $activities = [
                [
                    'timestamp' => '12 min ago',
                    'title' => '12 Invoices have been paid',
                    'description' => 'Invoices have been paid to the company',
                    'type' => 'purple', // Color type for dot
                    'file' => 'invoices.pdf',
                    'team' => null
                ],
                [
                    'timestamp' => '45 min ago',
                    'title' => 'Client Meeting',
                    'description' => 'Project meeting with John @10:15am',
                    'type' => 'green',
                    'file' => null,
                    'team' => ['john.jpg', 'lester.jpg']
                ],
                [
                    'timestamp' => '2 Days Ago',
                    'title' => 'Create a new project for client',
                    'description' => '6 team members in a project',
                    'type' => 'blue',
                    'file' => null,
                    'team' => ['team1.jpg', 'team2.jpg', 'team3.jpg', 'team4.jpg']
                ]
            ];

            foreach ($activities as $activity) {
                echo '<li class="timeline-item">';
                echo '<div class="dot" style="background-color: '.$activity['type'].';"></div>';
                echo '<div class="activity">';
                echo '<p><strong>'.$activity['title'].'</strong></p>';
                echo '<p>'.$activity['description'].'</p>';
                if ($activity['file']) {
                    echo '<a href="#" class="file-link">Download '.$activity['file'].'</a>';
                }
                if ($activity['team']) {
                    echo '<div class="team-members">';
                    foreach ($activity['team'] as $member) {
                        echo '<img src="path_to_images/'.$member.'" alt="Team Member">';
                    }
                    if (count($activity['team']) > 3) {
                        echo '+'.(count($activity['team']) - 3);
                    }
                    echo '</div>';
                }
                echo '<div class="timestamp">'.$activity['timestamp'].'</div>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

