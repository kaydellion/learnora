<?php
/*


$db_username = "root"; 
$db_pass = ""; 
$db_name = "learnora";
$db_host = "localhost";
$db_username = "projectr_learnorastore"; 
$db_pass = "Y34GgwK(]h82Yg"; 
$db_name = "projectr_learn";
*/

$db_host = "localhost";
$db_username = "learnora_learn"; 
$db_pass = "7Ums6HDNrg)03*"; 
$db_name = "learnora_learnorastore";

/*
$db_username = "root"; 
$db_pass = ""; 
$db_name = "learnora_learnorastore";
$db_host = "localhost";*/

$conn = mysqli_connect ("$db_host","$db_username","$db_pass","$db_name");


$default_keywords = "Professional Training in Nigeria | Online Courses in Nigeria | Skill Development Programs in Nigeria | Corporate Training in Nigeria | Vocational Training in Nigeria";
$meta_keywords = $default_keywords;
$meta_description = "Learnora offers professional training, online courses, corporate programs, skill development and vocational training across Nigeria.";
$page_title = "Learnora";

// ✅ Dynamic category pages
if (isset($_GET['slugs']) || isset($_GET['slug'])) {
    $raw_slug = isset($_GET['slug']) ? $_GET['slug'] : $_GET['slugs'];
    $title_like = str_replace('-', ' ', $raw_slug);
    $category_name = mysqli_real_escape_string($conn, ucwords($title_like));
    $page_title = $category_name;

    // Category-specific keywords (from your mapping)
    $category_keywords = [
        "academic" => "Academic training programs Nigeria | University preparatory courses Nigeria | Online academic tutorials Nigeria | Educational workshops Nigeria | Academic skill development Nigeria",
        "business-professional" => "Business training courses Nigeria | Corporate leadership programs Nigeria | Professional development Nigeria | Entrepreneurship training Nigeria | Management training workshops Nigeria",
        "personal-development" => "Personal growth courses Nigeria | Self improvement training Nigeria | Emotional intelligence training Nigeria | Confidence building workshops Nigeria | Life coaching Nigeria",
        "vocational-technical-skills" => "Vocational training centers Nigeria | Technical skills training Nigeria | Trade certification programs Nigeria | Skilled jobs training Nigeria | Handwork and craft training Nigeria",
        "languages-communication" => "English language training Nigeria | French classes Nigeria | Business communication courses Nigeria | Public speaking training Nigeria | IELTS/TOEFL prep Nigeria",
        "sports-physical" => "Sports training academies Nigeria | Fitness coaching programs Nigeria | Football training camps Nigeria | Physical education courses Nigeria | Health and wellness training Nigeria",
        "creative-artistic" => "Creative arts training Nigeria | Music and dance classes Nigeria | Photography training Nigeria | Fashion design courses Nigeria | Acting and drama workshops Nigeria",
        "technology-it" => "IT training courses Nigeria | Coding and programming classes Nigeria | Cybersecurity training Nigeria | Data science training Nigeria | Digital skills development Nigeria",
        "certifications-exams" => "Professional certification courses Nigeria | Online exam prep Nigeria | PMP certification Nigeria | Accounting and finance certification Nigeria | Global exam preparation Nigeria",
    ];

    $slug_key = strtolower(str_replace(' ', '-', $raw_slug));
    if (array_key_exists($slug_key, $category_keywords)) {
        $meta_keywords = $category_keywords[$slug_key];
        $meta_description = "Explore " . $category_name . " training programs and courses in Nigeria with Learnora.";
    } else {
        $meta_keywords = $category_name . " Training in Nigeria | " . $default_keywords;
        $meta_description = "Explore " . $category_name . " training programs and online courses in Nigeria with Learnora.";
    }

// ✅ Static pages mapping
} else {
    $current_page = $_SERVER['REQUEST_URI'];

    $static_pages = [
        "/" => ["Learnora - Professional Training & Online Courses in Nigeria", $default_keywords],
        "/about" => ["About Us - Learnora", $default_keywords],
        "/contact" => ["Contact Us - Learnora", $default_keywords],
        "/privacy-policy" => ["Privacy Policy - Learnora", $default_keywords],
        "/cookie-policy" => ["Cookie Policy - Learnora", $default_keywords],
        "/terms" => ["Terms & Conditions - Learnora", $default_keywords],
        "/why-us" => ["Why Choose Us - Learnora", $default_keywords],
        "/disclaimer" => ["Disclaimer - Learnora", $default_keywords],
        "/blog" => ["Learnora Blog - Training & Education in Nigeria", "Training and education blog in Nigeria | Skill development blog | Professional Training in Nigeria | Online Courses in Nigeria | Skill Development Programs in Nigeria | Corporate Training in Nigeria | Vocational Training in Nigeria"],
        "/trainers" => ["Our Trainers - Learnora", $default_keywords],
        "/events-by-state" => ["Events by State - Learnora", $default_keywords],
        "/events-by-month" => ["Events by Month - Learnora", $default_keywords],
        "/events-by-country" => ["Events by Country - Learnora", $default_keywords],
        "/events-by-format" => ["Events by Format - Learnora", $default_keywords],
    ];

    foreach ($static_pages as $path => $data) {
        if (strpos($current_page, $path) !== false) {
            $page_title = $data[0];
            $meta_keywords = $data[1];
            $meta_description = $data[0] . " at Learnora.";
            break;
        }
    }
}

?>