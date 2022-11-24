<?php
// Ensure a session is started on every page
$activePage = basename($_SERVER['PHP_SELF'], ".php");

session_start();
session_check();
// Mysqli Database Connection
$servername="localhost";
$username="";
$password="";
$dbname="";

// Create connection
$mysqli = mysqli_connect($servername, $username, $password, $dbname);

//Use the PDO connection
$pdo = pdo_con();



// Check Connection
if (!$mysqli) {
  die("Connection failed: " . mysqli_connect_error());
}

function pdo_con() {
  // Create the vars to use for the connection
  $servername="";
  $username="";
  $password="";
  $dbname="";

  //DB Connection
  try {
    return new PDO(
      'mysql:host=' . $servername .
      ';dbname=' . $dbname.
      ';charset=utf8' , $username, $password
    );
  }
  catch (PDOException $exception) {
    die('PDO Failed to connect to the database');
  }
}

// Create an output message array
$userResponses = [];

//getMyUrl function
function getMyUrl() {
  $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  $regex_pattern = '/(.*)\/.*\.php/';
  return 'https://' . preg_replace($regex_pattern, '$1', $url);
}


function template_admin_nav($activePage) {
  $active_page = array("","","","");
  $style = "has-background-info has-text-white";
  switch($activePage):
    case 'profile':
      $active_page[0] = $style;
    break;
    case 'polls':
      $active_page[1] = $style;
    break;
    case 'contacts':
      $active_page[2] = $style;
    break;
    case 'tickets':
      $active_page[3] = $style;
    break;
  endswitch;
  // <div class="columns">
  echo <<<EOT
  <!-- START LEFT NAV COLUMN-->
  <div class="column is-one-fifth">
      <aside class="menu">
          <p class="menu-label"> Admin Menu </p>
          <ul class="menu-list">
              <li><a class="$active_page[0]" href="profile.php"> Profile </a></li>
              <li><a class="$active_page[1]" href="polls.php"> Polls </a></li>
              <li><a class="$active_page[2]" href="contacts.php"> Contacts </a></li>
              <li><a class="$active_page[3]" href="tickets.php"> Tickets </a></li>
          </ul>
      </aside>
  </div>
  <!-- END LEFT NAV COLUMN-->
  EOT;
  // </div>
  }

//Password Protect this page and redirect the user to login page if not logged in.
function session_check() {
  global $activePage;
  if (!isset($_SESSION['loggedin']) & (($activePage != ('login' || 'contact-us')) )) {
    header('Location: login.php');
    }
  }

function template_header($title = "Page title") {

echo <<<EOT
 <!DOCTYPE html>
  <html>

    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>$title</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
     <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
     <script defer src="js/bulma.js"></script>
    </head>

  <body>
EOT;
}

function template_nav($siteTitle = "Site Title") {
//Log in/out
$profile = "Profile";
if (isset($_SESSION['loggedin'])){
if ($_SESSION['loggedin'] == TRUE) {
  $logIO = 'out';
  $profile = ucfirst($_SESSION['name']);
}
} else {
  $logIO = 'in';
}

echo <<<EOT
  <!-- START NAV -->
    <nav class="navbar is-light">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" href="index.php">
            <span class="icon is-large">
              <i class="fas fa-home"></i>
            </span>
            <span>$siteTitle</span>
          </a>
          <div class="navbar-burger burger" data-target="navMenu">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div id="navMenu" class="navbar-menu">
          <div class="navbar-start">
            <!-- navbar link go here -->
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a href="profile.php" class="button">
                  <span class="icon"><i class="fas fa-user"></i></span>
                  <span>$profile</span>
                </a>
<a href="contact-us.php" class="button">
    <span class="icon"><i class="fas fa-address-book"></i></span>
    <span>Contact Us</span>
</a>
<a href="log$logIO.php" class="button">
    <span class="icon"><i class="fas fa-sign-$logIO-alt"></i></span>
    <span>Log $logIO</span>
</a>
</div>
</div>
</div>
</div>
</div>
</nav>
<!-- END NAV -->

<!-- START MAIN -->
<section class="section">
    <div class="container">
EOT;
}

function template_footer()
{
echo <<<EOT
        </div>
    </section>
    <!-- END MAIN-->

    <!-- START FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>Footer content goes here</p>
        </div>
    </footer>
    <!-- END FOOTER -->
    </body>
  </html>
EOT;
}

?>
