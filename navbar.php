<style>
    body {
        background-color: #1d1d1d;
        color: white;
        font-family: Arial, sans-serif;
    }

    .sticky {   
        position: sticky;
        top: 0;
        z-index: 999;
    }

    .navbar {
        background-color: black;
    }

    .navbar-dark .navbar-nav .nav-link {
        color: yellow;
    }

    .navbar-dark .navbar-toggler {
        border-color: yellow;
    }

    .navbar-dark .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    .navbar-brand img {
        height: 50px;
        /* adjust the height as needed */
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-black sticky">
        <div class="container-fluid">
            <a class="navbar-brand" href="./"><img src="logo.svg" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="./">Strona Główna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search">Katalog</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Konto</a>
                        <?php
                        if (!$loggedIn) {
                            echo '<ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="login">Login</a></li>
                                <li><a class="dropdown-item" href="register">Register</a></li>
                              </ul>';
                        } else {
                            echo '<ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="userSite">' . $login . '</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="logout">Wyloguj</a></li>
                                </ul>';
                        }
                        ?>
                    </li>
                </ul>
                <form class="d-flex" method="POST" action="search">
                    <input class="form-control me-2" type="search" placeholder="Szukaj..." name="filterValue" aria-label="Search">
                </form>
            </div>
        </div>
    </nav>