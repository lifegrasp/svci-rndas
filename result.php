<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'components/connections.php';

if (empty($_SESSION['id'])):
    header('Location: user-signin.php');
endif;

$search_results = '';

if (isset($_POST['search'])) {
    $search_term = $_POST['search'];

    $sql = "SELECT `id`, `title`, `abstract`, `author`, `department`, `program`, `year`, `date`, `uploaded_by`, `file_name` FROM `uploaded_thesis` WHERE title LIKE '%$search_term%' OR author LIKE '%$search_term%' OR department LIKE '%$search_term%' OR program LIKE '%$search_term%' OR year LIKE '%$search_term%' OR date LIKE '%$search_term%' OR uploaded_by LIKE '%$search_term%';";

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $file_name = $row['file_name'];
            $search_results .= '<div class="result-item">';
            $search_results .= '<h3 class="result-title">Title: ' . $row['title'] . '</h3>';
            $search_results .= '<p class="result-author">Author: ' . $row['author'] . '</p>';
            $search_results .= '<p class="result-abstract">Abstract: ' . $row['abstract'] . '</p>';
            if (isset($file_name)) {
                $search_results .= '<a href="admin-forms\uploads/' . $file_name . '" target="_blank">View PDF</a>';
            } else {
                $search_results .= '<p>No PDF available</p>';
            }
            $search_results .= '</div>';
        }
    } else {
        $search_results = "<p>No results found</p>";
    }

    mysqli_close($con);
}


?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/067d14b27b.js" crossorigin="anonymous"></script>

    <link rel="shortcut icon" href="img/svci_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/result.css">

    <title>SVCI Research and Development Archiving System | Search Results</title>


</head>

<body>
    <nav class="nav-options nav-wrapper white">
        <div class="container">
            <a href="" class=""><img src="img/svci_logo.png" alt="urslogo" class="hide-on-med-and-down urslogo"></a>
            <a href="" class="brand-logo black-text">SVCI Research and Development Archiving System</a>
            <a href="#" class="sidenav-trigger" data-target="mobile-links">
                <i class="material-icons black-text">menu</i>
            </a>
            <ul class="navbutton right hide-on-med-and-down" id="navbutton">
                <li id="home">
                    <a href="index.php" class="home-btn btn-large white waves-effect waves-dark z-depth-0">
                        <span>Home</span>
                    </a>
                </li>

                <li id="program">
                    <a href="# " data-target="dropdown"
                        class="courses-btn dropdown-trigger btn-large white waves-effect waves-dark z-depth-0">
                        <span>Programs</span>
                        <i class="material-icons right arrow-icon">arrow_drop_down</i>
                    </a>
                    <ul class="dropdown-content dropdown-program" id="dropdown">
                        <li><a href="#">BSA</a></li>
                        <li><a href="#">BSAIS</a></li>
                        <li><a href="#">BSBA Major in Financial Management</a></li>
                        <li><a href="#">BSBA Major in Human Resource Management</a></li>
                        <li><a href="#">BSBA Major in Marketing Management</a></li>
                        <li><a href="#">BSBA Major in Marketing Management</a></li>
                        <li><a href="#">BSIT</a></li>
                        <li><a href="#">BSCS</a></li>
                        <li><a href="#">BSCE</a></li>
                        <li><a href="#">BSIT</a></li>
                        <li><a href="#">BSCS</a></li>
                        <li><a href="#">BSCE</a></li>
                        <li><a href="#">BSIT</a></li>
                        <li><a href="#">BSCS</a></li>
                        <li><a href="#">BSOA</a></li>
                        <li><a href="#">BSHM</a></li>
                        <li><a href="#">BSTM</a></li>
                        <li><a href="#">BEEd</a></li>
                        <li><a href="#">BPEd</a></li>
                        <li><a href="#">BSNEd</a></li>
                        <li><a href="#">BSEd Major in Religious Education</a></li>
                        <li><a href="#">BSEd Major in Major in English</a></li>
                        <li><a href="#">BSEd Major in Religious Major in Filipino</a></li>
                        <li><a href="#">BSEd Major in Mathematics</a></li>
                        <li><a href="#">BAPS</a></li>
                        <li><a href="#">BAPhilo</a></li>
                        <li><a href="#">BSCrim</a></li>
                        <li><a href="#">ABM</a></li>
                        <li><a href="#">STEM</a></li>
                        <li><a href="#">HUMMS</a></li>
                        <li><a href="#">GAS</a></li>
                        <li><a href="#">MAEd</a></li>
                        <li><a href="#">MPM</a></li>
                        <li><a href="#">MBA</a></li>
                        <li><a href="#">ME Major in English</a></li>
                        <li><a href="#">ME Major in Filipino</a></li>
                        <li><a href="#">ME Major in Mathematics</a></li>
                        <li><a href="#">ME Major in Physical Education</a></li>
                        <li><a href="#">ME Major in Science</a></li>
                        <li><a href="#">ME Major in Social Studies</a></li>
                        <li><a href="#">DEM</a></li>
                    </ul>
                </li>

                <li id="about">
                    <a href="about.php" class="about-btn btn-large white waves-effect waves-dark z-depth-0">
                        <span>About</span>
                    </a>
                </li>
                <li id="login" class="right">
                    <a href="# " data-target="dropdown-account"
                        class="login-btn dropdown-account btn-large white waves-effect waves-dark z-depth-0">
                        <span>
                            <?php
                            echo $_SESSION['id'];
                            ?>
                        </span>
                        <i class="material-icons left blue-text text-darken-4 ">person</i>
                        <i class="material-icons right arrow-icon">arrow_drop_down</i>
                    </a>
                    <ul class="dropdown-content dropdown-content-account" id="dropdown-account">
                        <li>
                            <a href="#">
                                <span class="center">My Account</span>
                                <i class="material-icons left green-text text-darken-3">account_circle</i>
                            </a>
                        </li>
                        <li>
                            <a href="components/logout.php">
                                <span class="center">Logout</span>
                                <i class="material-icons left red-text text-darken-3">logout</i>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <form action="result.php" method="post" class="search-form">
        <div class="search-container">
            <input type="text" class="search-input" name="search" placeholder="Search...">
        </div>
    </form>
    <div class="results-container">
        <?php echo $search_results; ?>
    </div>

    <div class="footer-panel">
        <footer class="page-footer white">
            <hr>
            <p class="footer-text black-text">&copy; 2023 <strong>ALEMANSUM:</strong> <a href="devs.php">Group 7</a> -
                SVCI Research and Development Archiving System</p>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js "></script>
    <script src="scripts/main.js "></script>

</body>

</html>