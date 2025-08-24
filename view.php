<?php 
include "header.php"; 

// Ensure user session or ID is available
if ($active_log == 0) {
    echo "<script>alert('Please log in to view this page.'); window.location.href='login.php';</script>";
    exit;
}

// Escape ID to avoid SQL injection
$id = mysqli_real_escape_string($con, $_GET['id']);

// Get training info
$sql = "SELECT t.*, u.name AS instructor_name, u.photo AS instructor_photo
        FROM {$siteprefix}training t
        LEFT JOIN {$siteprefix}instructors u ON t.instructors = u.s
        WHERE t.training_id = '$id' AND t.status = 'approved'
        LIMIT 1";

$result = mysqli_query($con, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Training not found";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Format details
$format = ucfirst($row['delivery_format']);
$details = '';

if ($format === 'Physical') {
    $fields = [
        'physical_address' => 'Address',
        'physical_state' => 'State',
        'physical_lga' => 'LGA',
        'physical_country' => 'Country',
        'foreign_address' => 'Foreign Address'
    ];
} elseif ($format === 'Hybrid') {
    $fields = [
        'hybrid_physical_address' => 'Physical Address',
        'hybrid_web_address' => 'Web Address',
        'hybrid_state' => 'State',
        'hybrid_lga' => 'LGA',
        'hybrid_country' => 'Country',
        'hybrid_foreign_address' => 'Foreign Address'
    ];
} elseif ($format === 'Online') {
    $fields = ['web_address' => 'Link to Join'];
}

foreach ($fields as $col => $label) {
    if (!empty($row[$col])) {
        $value = htmlspecialchars($row[$col]);
        $details .= "<li><strong>$label:</strong> ";
        $details .= filter_var($value, FILTER_VALIDATE_URL) ? "<a href='$value' target='_blank'>$value</a>" : $value;
        $details .= "</li>";
    }
}
?>

<section id="best-sellers" class="best-sellers section">
    <div class="container mt-4">
        <h2><?= htmlspecialchars($row['title']); ?></h2>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="courseTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview">Overview</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#videos">Videos</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#text">Text Modules</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#format">Format Details</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#quizTab">Quiz</button></li>
        </ul>

        <div class="tab-content p-3 border border-top-0">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview">
                <p><?= nl2br(htmlspecialchars($row['course_description'])); ?></p>
                <p><strong>Instructor:</strong> <?= htmlspecialchars($row['instructor_name'] ?? ''); ?></p>
                <?php if (!empty($row['instructor_photo'])): ?>
                    <img src="uploads/<?= htmlspecialchars($row['instructor_photo']); ?>" width="100" />
                <?php endif; ?>
                <p><strong>Language:</strong> <?= htmlspecialchars($row['Language'] ?? ''); ?></p>
                <p><strong>Level:</strong> <?= htmlspecialchars($row['level'] ?? ''); ?></p>
            </div>

            <!-- Videos Tab -->
            <div class="tab-pane fade" id="videos">
                <h5>Promo & Trailer Videos</h5>
                <?php
                $videos = mysqli_query($con, "SELECT video_type, video_path FROM {$siteprefix}training_videos WHERE training_id = '$id'");
                while ($v = mysqli_fetch_assoc($videos)) {
                    $label = ucfirst($v['video_type']);
                    $videoPath = htmlspecialchars($v['video_path']);
                    echo "<p><strong>$label:</strong></p>";
                    echo "<video controls width='100%' src='uploads/{$videoPath}'></video><hr>";
                }

                echo "<h5>Video Lessons</h5>";
                $lessons = mysqli_query($con, "SELECT file_path, video_url FROM {$siteprefix}training_video_lessons WHERE training_id = '$id'");
                while ($l = mysqli_fetch_assoc($lessons)) {
                    $filePath = htmlspecialchars($l['file_path']);
                    $videoUrl = htmlspecialchars($l['video_url']);
                    if (!empty($videoUrl)) {
                        echo "<p><iframe width='100%' height='315' src='{$videoUrl}' frameborder='0' allowfullscreen></iframe></p>";
                    } elseif (!empty($filePath)) {
                        echo "<p><video controls width='100%' src='documents/{$filePath}'></video></p>";
                    }
                }

                // 3️⃣ Fetch from NEW training_video_modules
    echo "<h5>Video Modules</h5>";
    $stmt = $con->prepare("SELECT module_number, title, description, duration, file_path, video_link, video_quality, subtitles
                           FROM {$siteprefix}training_video_modules 
                           WHERE training_id = ?
                           ORDER BY module_number ASC");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $modules = $stmt->get_result();

    if ($modules->num_rows > 0) {
        while ($m = $modules->fetch_assoc()) {
            $title       = htmlspecialchars($m['title']);
            $desc        = nl2br(htmlspecialchars($m['description']));
            $duration    = htmlspecialchars($m['duration']);
            $videoLink   = htmlspecialchars($m['video_link']);
            $qualities   = htmlspecialchars($m['video_quality']);
            $subtitles   = htmlspecialchars($m['subtitles']);
            $filePath    = htmlspecialchars($m['file_path']);

            echo "<div class='mb-4 p-3 border rounded'>";
            echo "<h6>🎬 {$title}</h6>";
            if (!empty($duration)) {
                echo "<p><strong>Duration:</strong> {$duration} mins</p>";
            }
            if (!empty($desc)) {
                echo "<p>{$desc}</p>";
            }
            if (!empty($videoLink)) {
                echo "<p><iframe width='100%' height='315' src='{$videoLink}' frameborder='0' allowfullscreen></iframe></p>";
            } elseif (!empty($filePath)) {
                echo "<p><video controls width='100%' src='documents/{$filePath}'></video></p>";
            }
            if (!empty($qualities)) {
                echo "<p><strong>Available Qualities:</strong> {$qualities}</p>";
            }
            if (!empty($subtitles)) {
                echo "<p><strong>Subtitles:</strong> {$subtitles}</p>";
            }
            echo "</div>";
        }
    } else {
        echo "<p>No video modules uploaded yet.</p>";
    }
                ?>
            </div>

            <!-- Text Modules Tab -->
       <div class="tab-pane fade" id="text">
    <h5>Downloadable PDFs / Docs</h5>
    <?php
    // 1️⃣ Fetch from training_text_modules
    $texts1 = mysqli_query($con, "SELECT file_path FROM {$siteprefix}training_text_modules WHERE training_id = '$id'");
    while ($t = mysqli_fetch_assoc($texts1)) {
        $fileName = htmlspecialchars(basename($t['file_path']));
        $filePath = htmlspecialchars($t['file_path']);
        echo "<p><a href='documents/{$filePath}' target='_blank'>📄 {$fileName}</a></p>";
    }

    // 2️⃣ Fetch from training_texts_modules (with title, description, reading time)
    $stmt = $con->prepare("
        SELECT title, description, reading_time, file_path 
        FROM {$siteprefix}training_texts_modules 
        WHERE training_id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($t = $result->fetch_assoc()) {
        $title       = htmlspecialchars($t['title']);
        $description = $t['description'];
        $readingTime = $t['reading_time'];
        $fileName    = $t['file_path'];
        $filePath    = $t['file_path'];

        echo "<div class='mb-3'>";
        if (!empty($title)) {
            echo "<h6>📄 {$title}</h6>";
        }
        if ($readingTime > 0) {
            echo "<p><strong>Reading time:</strong> {$readingTime} mins</p>";
        }
        if (!empty($description)) {
            echo "<p>{$description}</p>";
        }
        if (!empty($filePath)) {
            echo "<p><a href='documents/{$filePath}' target='_blank'>Download</a></p>";
        }
        echo "</div>";
    }

    if (mysqli_num_rows($texts1) === 0 && $result->num_rows === 0) {
        echo "<p>No downloadable files available.</p>";
    }
    ?>
</div>


            <!-- Format Tab -->
            <div class="tab-pane fade" id="format">
                <ul>
                    <?= $details ?: "<li>No delivery information provided.</li>"; ?>
                </ul>
            </div>

            <!-- Quiz Tab -->
            <div class="tab-pane fade" id="quizTab">
                <?php
                $quiz_check_sql = "SELECT qa.score 
                                   FROM {$siteprefix}quiz_answers qa 
                                   INNER JOIN {$siteprefix}training_quizzes tq 
                                       ON qa.quiz_id = tq.s
                                   WHERE qa.user_id = '$user_id' AND tq.training_id = '$id' 
                                   LIMIT 1";
                $quiz_check_result = mysqli_query($con, $quiz_check_sql);

                if (mysqli_num_rows($quiz_check_result) > 0) {
                    $quiz_score_row = mysqli_fetch_assoc($quiz_check_result);
                    $score = $quiz_score_row['score'];

                    echo "<div class='alert alert-info'>";
                    echo "<h5>✅ You’ve already submitted this quiz.</h5>";

                    if ($score === null || $score === '') {
                        echo "<p><strong>Status:</strong> You’ve not been given a score yet.</p>";
                    } else {
                        echo "<p><strong>Your Score:</strong> $score</p>";
                    }

                    echo "</div>";
                } else {
                    include "quiz-tab.php"; // Show quiz form if not yet submitted
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
