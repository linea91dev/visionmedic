    <!--<script>
        $('aside').toggleClass('side-nav-small');
        $('.contentWrapper').toggleClass('side-nav-small');
    </script>
 
    <script>
        $('.mCustomScrollbar').perfectScrollbar();
    </script>-->
    <?php if($page_name == 'appointment'):?>
    <script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
    <?php endif;?>

    <script src="<?php echo base_url();?>public/assets/theme/js/moment.min.js"></script>

    <script src="<?php echo base_url();?>public/assets/theme/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/datepicker.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/popper.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/perfect-scrollbar-config.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap-tour-standalone.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap-tour-config.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/colorPick.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/colorpicker.js"></script>

    <script>
$(function() {
    console.log('app')
    $('[data-toggle="tooltip"]').tooltip()
})
$(document).ready(function() {
    $('#mainTable').DataTable();
});
    </script>
    <?php if ($this->session->flashdata('flash_message') != ""):?>
    <script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 5000
});
Toast.fire({
    type: 'success',
    title: '<?php echo $this->session->flashdata("flash_message");?>'
})
    </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('error_message') != ""):?>
    <script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 5000
});
Toast.fire({
    type: 'error',
    title: '<?php echo $this->session->flashdata("error_message");?>'
})
    </script>
    <?php endif;?>

    <script src="<?php echo base_url();?>public/assets/appointments/js/reservation_wizard_func.js"></script>
    <script src="<?php echo base_url();?>public/assets/appointments/js/common_scripts.js"></script>
    <script src="<?php echo base_url();?>public/assets/appointments/js/velocity.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/appointments/js/main.js"></script>
    <script src="<?php echo base_url();?>public/assets/appointments/js/functions.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/script.js"></script>