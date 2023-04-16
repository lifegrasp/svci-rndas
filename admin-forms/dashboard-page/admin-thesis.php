<?php
session_start();
include '../components/connections.php'; // eto yung binago ko 10:36AM. kapag ayaw gumana, ilagay sa admin-forms yong connections

if (empty($_SESSION['admin_id'])):
    header('Location: ../admin-signin.php');
endif;

if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $abstract = $_POST['abstract'];
    $author = $_POST['author'];
    $department = $_POST['select_department'];
    $program = $_POST['select_program'];
    $year = $_POST['year'];
    $date = $_POST['date'];
    $uploaded_by = $_SESSION['admin_id'];

    $sqladmin = "SELECT title FROM uploaded_thesis WHERE title = '$title' OR abstract = '$abstract'";
    $result = $con->query($sqladmin);
    if ($result->num_rows > 0) {
        echo "<script>
                        alert('Some information already existing!')
                        window.location.replace('admin-thesis.php');
                    </script>";
    } else {
        $sqladmin_query = "INSERT INTO uploaded_thesis (title, abstract, author, department, program, year, date, uploaded_by) VALUES ('$title', '$abstract', '$author',' $department',' $program', '$year', '$date', '$uploaded_by')";
        $result = $con->query($sqladmin_query);

        echo "<script>
                    alert('Record successfully uploaded!')
                    window.location.replace('admin-thesis.php');
                </script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_query = "DELETE FROM uploaded_thesis WHERE id = '$id'";
    $delete = $con->query($delete_query);

}
?>

<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/067d14b27b.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="../styles/dashboard-styles/header.css">
    <link rel="stylesheet" href="../styles/dashboard-styles/left-nav.css">
    <link rel="stylesheet" href="../styles/dashboard-styles/thesis-table.css">


    <link rel="icon" type="image/x-icon" href="../img/svci_logo.png">

    <title>SVCI Research and Development Archiving System | Uploaded Thesis</title>

</head>

<body>

    <nav>
        <div class="header-nav">
            <div class="left-section">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <div class="right-section">
                <div class="user-info-container" id="showHide-btn" onclick="showDiv()">
                    <div class="user-icon-container">
                        <i class="fa-solid fa-user-gear fa-lg fa-inverse"></i>
                    </div>
                    <div class="user-accountid">
                        <?php
                        echo $_SESSION['admin_id'];
                        ?>
                    </div>
                    <div class="dropdown-content" id="dropDown-div">
                        <div class="user-accountid-dropdown">
                            <i class="fa-solid fa-id-badge"></i>
                            <?php
                            echo $_SESSION['admin_id'];
                            ?>
                        </div>
                        <button class="myaccount-btn">
                            <i class="fa-solid fa-circle-user"></i>
                            My Account
                        </button>

                        <a href='../components/logout.php'>
                            <button class="logout-btn">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                Logout
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </nav>

    <div class="left-nav ">
        <div class="logo-title-container ">
            <img src="../img/svci_logo.png" alt=" " class="svcilogo ">
            <p class="title ">ADMINISTRATOR</p>
        </div>

        <a href="admin-dashboard.php" class="general-link ">
            <div class="dashboard-container ">
                <i class="fa-solid fa-gauge fa-lg dashboard-icon "></i>
                <p class="dashboard-button ">Dashboard
                    <i class="fa-solid fa-angle-right arrow-icon "></i>
                </p>
            </div>
        </a>

        <a href="admin-thesis.php" class="general-link ">
            <div class="list-container ">
                <i class="fa-solid fa-list-check fa-lg "></i>
                <p class="list-button ">Uploaded Thesis
                    <i class="fa-solid fa-angle-right arrow-icon "></i>
                </p>
            </div>
        </a>

        <a href="admin-accounts.php" class="general-link ">
            <div class="account-container">
                <i class="fa-solid fa-user-pen fa-lg"></i>
                <p class="account-button">Accounts
                    <i class="fa-solid fa-angle-right arrow-icon "></i>
                </p>
            </div>
        </a>

        <a href="#" class="general-link ">
            <div class="log-container">
                <i class="fa-solid fa-clock fa-lg"></i>
                <p class="log-button">Log Manager
                    <i class="fa-solid fa-angle-right arrow-icon "></i>
                </p>
            </div>
        </a>
    </div>

    <div class="top-section">
        <div class="action-container">
            <a href="#form-div" class="action-parent">
                <button class="add-record" id="add-record" onclick="showForm()">
                    CREATE
                </button>
            </a>
        </div>
    </div>


    <div class="thesis-label">UPLOADED THESIS</div>
    <div class="thesis-table-container">
        <table class="theses-table">
            <tr>
                <th class="id_header">ID</th>
                <th class="title_header">Title</th>
                <th class="abstract_header">Abstract</th>
                <th class="author_header">Author</th>
                <th class="department_header">Department</th>
                <th class="program-header">Program</th>
                <th class="year_header">Year of Publication</th>
                <th class="date_header">Date Uploaded</th>
                <th class="uploadedby_header">Uploaded By</th>
                <th class="action_header">Actions</th>
            </tr>

            <?php
            $sql = "SELECT id, title, abstract, author, department, program, year, date, uploaded_by from uploaded_thesis";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo
                        "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["title"] . "</td>
                                <td>" . $row["abstract"] . "</td>
                                <td>" . $row["author"] . "</td>
                                <td>" . $row["department"] . "</td>
                                <td>" . $row["program"] . "</td>
                                <td>" . $row["year"] . "</td>
                                <td>" . $row["date"] . "</td>
                                <td>" . $row["uploaded_by"] . "</td>
                                <td>" . "<a href='#' class = 'edit_button' onclick='showForm()'><i class='fa-solid fa-pen-to-square'></i></a>" .
                        "<a href='admin-thesis.php?id=" . $row["id"] . "' class = 'delete_button'><i class='fa-solid fa-trash'></i></a>" . "</td>
                            </tr>";
                }
                echo "</table>";
            } else {
                echo "No results.";
            }

            ?>
        </table>
    </div>

    <div class="form-label" id="label-div">CREATE NEW / MODIFY RECORD</div>
    <div class="form-container" id="form-div">
        <form action="" method="post">
            <input type="hidden" class="data-input" name="id" placeholder="ID" required>

            <div class="title-parent-container">
                <div class="title-container">
                    <div class="label">TITLE OF THE STUDY</div>
                    <div class="data-input-container">
                        <input type="text" class="data-input" id="title" name="title" placeholder="Title of the study"
                            required>
                    </div>
                </div>
            </div>

            <div class="abstract-parent-container">
                <div class="abstract-container">
                    <div class="label">ABSTRACT</div>
                    <div class="data-input-container">
                        <input type="text" class="data-input" id="abstract" name="abstract" placeholder="Abstract"
                            required>
                    </div>
                </div>
            </div>

            <div class="author-parent-container">
                <div class="author-container">
                    <div class="label">AUTHOR</div>
                    <div class="data-input-container">
                        <input type="text" class="data-input" name="author" placeholder="Author" required>
                    </div>
                </div>
            </div>

            <div class="dept-program-parent-container">
                <div class="department-container">
                    <div class="label">DEPARTMENT</div>
                    <div class="data-input-container">
                        <select name="select_department" id="select_department" class="data-input" required>
                            <option value="SELECTION">Select department</option>
                            <option value="AED">Accounting Education Department</option>
                            <option value="BMD">Business and Management Department</option>
                            <option value="CSD">Computer Studies Department</option>
                            <option value="ED">Engineering Department</option>
                            <option value="IHMD">International Hospitality Management Department</option>
                            <option value="TED">Teacher Education Department</option>
                            <option value="ASD">Arts and Science Department</option>
                            <option value="CCJE">College of Criminal Justice Education</option>
                            <option value="SHS">Senior High School</option>
                            <option value="GRAD">Graduate</option>
                            <option value="POST">Post Graduate</option>
                        </select>
                    </div>
                </div>

                <div class="program-container">
                    <div class="label">PROGRAM</div>
                    <div class="data-input-container">
                        <select name="select_program" id="select_program" class="data-input" disabled required>
                            <option data-value="SELECTION" value="">Select program</option>
                            <option data-value="AED" value="BSA">BSA</option>
                            <option data-value="AED" value="BSAS">BSAIS</option>
                            <option data-value="BMD" value="BSBA Major in Financial Management">BSBA Major in Financial Management</option>
                            <option data-value="BMD" value="BSBA Major in Human Resource Management">BSBA Major in Human Resource Management</option>
                            <option data-value="BMD" value="BSBA Major in Marketing Management">BSBA Major in Marketing Management</option>
                            <option data-value="BMD" value="BSBA Major in Marketing Management">BSBA Major in Marketing Management</option>
                            <option data-value="CSD" value="BSIT">BSIT</option>
                            <option data-value="CSD" value="BSCS">BSCS</option>
                            <option data-value="ED" value="BSCE">BSCE</option>
                            <option data-value="IHMD" value="BSOA">BSOA</option>
                            <option data-value="IHMD" value="BSHM">BSHM</option>
                            <option data-value="IHMD" value="BSTM">BSTM</option>
                            <option data-value="TED" value="BEEd">BEEd</option>
                            <option data-value="TED" value="BPEd">BPEd</option>
                            <option data-value="TED" value="BSNEd">BSNEd</option>
                            <option data-value="TED" value="BSEd Major in Religious Education">BSEd Major in Religious Education</option>
                            <option data-value="TED" value="BSEd Major in Major in English">BSEd Major in Major in English</option>
                            <option data-value="TED" value="BSEd Major in Major in Filipino">BSEd Major in Religious Major in Filipino</option>
                            <option data-value="TED" value="BSEd Major in Major in Mathematics">BSEd Major in Mathematics</option>
                            <option data-value="ASD" value="BAPS">BAPS</option>
                            <option data-value="ASD" value="BAPhilo">BAPhilo</option>
                            <option data-value="CCJE" value="BSCrim">BSCrim</option>
                            <option data-value="SHS" value="ABM">ABM</option>
                            <option data-value="SHS" value="STEM">STEM</option>
                            <option data-value="SHS" value="HUMMS">HUMMS</option>
                            <option data-value="SHS" value="GAS">GAS</option>
                            <option data-value="GRAD" value="MAEd">MAEd</option>
                            <option data-value="GRAD" value="MPM">MPM</option>
                            <option data-value="GRAD" value="MBA">MBA</option>
                            <option data-value="GRAD" value="ME Major in English">ME Major in English</option>
                            <option data-value="GRAD" value="ME Major in English">ME Major in Filipino</option>
                            <option data-value="GRAD" value="ME Major in English">ME Major in Mathematics</option>
                            <option data-value="GRAD" value="ME Major in English">ME Major in Physical Education</option>
                            <option data-value="GRAD" value="ME Major in English">ME Major in Science</option>
                            <option data-value="GRAD" value="ME Major in English">ME Major in Social Studies</option>
                            <option data-value="POST" value="DEM">DEM</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="year-date-parent-container">
                <div class="year-container">
                    <div class="label">YEAR OF PUBLICATION</div>
                    <div class="data-input-container">
                        <input type="number" class="data-input" name="year" placeholder="Year of publication" required>
                    </div>
                </div>
                <div class="date-container">
                    <div class="label">DATE UPLOADED</div>
                    <div class="data-input-container">
                        <input type="text" class="data-input" id="date" name="date" readonly="readonly" required>
                    </div>
                </div>
            </div>


            <div class="author-parent-container">
                <div class="author-container">
                    <div class="label">UPLOAD FILE</div>
                    <div class="data-input-container">
                        <input type="file" class="data-input" name="file">
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button class="save-button" type="submit" name="save">
                    SAVE
                </button>

                <button class="cancel-button" onclick="showForm()">
                    CANCEL
                </button>
            </div>
        </form>

    </div>

    <script src="../scripts/dashboard.js"></script>


</body>