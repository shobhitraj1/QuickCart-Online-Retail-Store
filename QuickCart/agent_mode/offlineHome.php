<!-- second child -->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container-fluid">
        <!-- Welcome User -->
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <span class="nav-link active">Welcome
                    <?php echo $agent_name; ?>
                </span>
            </li>
            <!-- <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php?agent_id=<?php echo "$agent_id"; ?>">Home</a>
                        </li> -->
        </ul>

        <!-- Display Current Status -->
        <span class="navbar-text text-light mx-2">
            Current Status:
            <?php echo $current_status; ?>
        </span>


        <!-- Dropdown for Status -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Set Status
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <!-- don't need to do anything for busy status, as if busy, will never reach this page -->
                    <li>
                        <a class="dropdown-item <?php echo $current_status === 'Available' ? 'active' : ''; ?>"
                            href="index.php?agent_id=<?php echo "$agent_id"; ?>&takeToHome">Available</a>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo $current_status === 'Offline' ? 'active' : ''; ?>"
                            href="">Offline</a>
                    </li>
                    <!-- <li>
                                <a class="dropdown-item <?php echo $current_status === 'Busy' ? 'active' : ''; ?>"
                                    href="index.php?agent_id=<?php echo "$agent_id"; ?>&agent_busy">Busy</a>
                            </li> -->
                </ul>
            </li>
        </ul>

        <!-- Logout -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="../start.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>


<!-- Third child -->
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 text-center">
            <div class="alert alert-warning py-4" role="alert">
                <p class="mb-0">Set status to available to be able to take orders</p>
            </div>
        </div>
    </div>
</div>


<!-- fourth child -->
<?php
if (isset ($_GET['takeToHome'])) {
    include ('takeToHome.php');
}
if (isset ($_GET['takeToOffline'])) {
    include ('takeToOffline.php');
}
?>