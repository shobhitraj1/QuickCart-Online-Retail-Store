

<div class="container mt-3">
    <h2 class="text-center">About Me</h2>
    <h5 class="w-50 m-auto my-4"> Name: <?php echo "$agent_name"; ?></h5>
    <h5 class="w-50 m-auto my-4"> Phone No: <?php echo "$phone"; ?></h5>
    <h5 class="w-50 m-auto my-4"> Email ID: <?php echo "$email"; ?></h5>
    <h5 class="w-50 m-auto my-4"> DOB: <?php echo "$dob"; ?></h5>
    <h5 class="w-50 m-auto my-4"> Your Total Earning: <?php echo "₹$earning_total"; ?></h5>
    <form action='profile_page.php?agent_id=<?php echo "$agent_id"; ?>&edit_profile' method="post">
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="edit_profile" class="btn btn-info mb-3 px-3" value="Edit Profile">
        </div>
    </form>
</div>
