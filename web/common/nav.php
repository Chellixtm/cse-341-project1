  <a class="navbar-brand" href="/index.php">Rumbly Tumbly Recipes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarToggler">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
              <a class="nav-link" href="/index.php">Home</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/recipe/index.php?action=browse">Browse Recipes</a>
          </li>
          <?php 
            if(isset($_SESSION['loggedin'])) {
                echo <<<EOL
                <li class="nav-item">
                    <a class="nav-link" href="/recipe/index.php?action=createPage">Create Recipe</a>
                </li>
                EOL;
            }
          ?>
      </ul>
      <?php
      if(isset($_SESSION['loggedin']) && isset($cookieUserName)) {
        echo "<a class='text-light' href='/users/index.php?action=userDetails'>$cookieUserName</a>";
      } else {
        echo "<a class='text-light' href='/users/index.php?action=loginPage'>Login</a>";
      }
      ?>
  </div>