<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container">
        <a class="navbar-brand text-light" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-light active" aria-current="page" href="./registration.php">Registration</a>
                <a class="nav-link text-light" href="./login.php">Login</a>
                <a class="nav-link text-light" href="./logout.php">Logout</a>
                
                <a class="nav-link text-light" href="#"><?php echo (isset($_SESSION["login_user"]) ? $_SESSION["login_user"] : "") ?></a>
            </div>
        </div>
    </div>
</nav><!--*** End of navBar-->