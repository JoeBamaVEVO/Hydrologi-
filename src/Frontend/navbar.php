
<nav class="">
    <a class="" href="../Frontend/index.php">Hjem</a>
        <?php if(isset($_SESSION["idusers"])): ?>
          <a class="nav-link active" aria-current="page" href="../Frontend/MineProsjekter.php">Mine Prosjekter</a>
          <a class="nav-link" href="../Auth/logout.php">Logout</a>
        <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="../Auth/login.php">Login</a>
        </li>
        <?php endif; ?>
      </ul>
</nav>

