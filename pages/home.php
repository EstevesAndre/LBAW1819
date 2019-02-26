<?php
    include_once('../templates/includes.php');

    draw_head();
    home_page();
    draw_footer();
?>

<?php
    function home_page()
    {
?>
        <div class="container text-center align-middle">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    signup form
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <img src="../assets/logo.png" class="img-fluid" max-width="100%" alt="Responsive image">
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    login form
                </div>
            </div>
        </div>
<?php
    }
?>