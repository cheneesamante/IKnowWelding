<div id="site_content">
    <section class="container">
        <div class="heading">
            <!-- Heading -->
            <h2><?php echo (isset($title) ? $title : ''); ?></h2>
        </div>
        <!-- insert the page content here -->
        <div class="row">
                <div class="featured-box col-md-9">
                    <p><?php echo (isset($body) ? $body : ''); ?></p>
                </div>
                <?php 
                if(!isset($this->session->userdata('info')['first_name'])){
                    $this->load->view('login_box');
                }
                ?>
        </div>
    </section>
</div>
<script>
$(document).ready(function() {
   $("table").addClass("table-striped dataTable"); 
});

</script>

