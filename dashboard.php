<?php 
include ('authentication.php'); 
$page_title = "Dashboard"; 
include('includes/header.register.php'); 
include('includes/navbar.php'); 
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-header">
                        <h4>User Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <h4>Accessed when you are logged in</h4>
                    </div>
                </div>               
            </div>
        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>
