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
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                One of three columns
                </div>
                <div class="col-sm">
                One of three columns
                </div>
                <div class="col-sm">
                One of three columns
                </div>
            </div>
        </div>
<?php
    }
?>