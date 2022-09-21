<script src="<?php echo assets_url(); ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo assets_url(); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo assets_url(); ?>/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="<?php echo assets_url(); ?>/plugins/select2/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo assets_url(); ?>/js/accounting.min.js"></script>
<script src="<?php echo assets_url(); ?>/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<?php echo assets_url(); ?>/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function() {
        var currentDate = new Date();
        if ($('.date_time[type="text"]').length) {
            $('.date_time[type="text"]').datetimepicker({
                defaultDate: new Date(),
                format: "YYYY-MM-DD H:m:s A"
            });
        }
        if ($('.date[type="text"]').length) {
            $('.date[type="text"]').datetimepicker({
                defaultDate: new Date(),
                format: "YYYY-MM-DD"
            });
        }
        if ($('.date_to_first[type="text"]').length) {
            $('.date_to_first[type="text"]').datetimepicker({
                defaultDate: "<?php echo date("Y-m-01") ?>",
                format: "YYYY-MM-DD"
            });
        }
        if ($('.date_time_to_first[type="text"]').length) {
            $('.date_time_to_first[type="text"]').datetimepicker({
                defaultDate: "<?php echo date("Y-m-01 H:i") ?>",
                format: "YYYY-MM-DD H:m A"
            });
        }
    });

    function convertToAmount(val) {
        var disval = val; //+'.00'; //.toFixed(val);
        return accounting.formatMoney(disval, "", 2, ",", "."); // €4.999,99 
    }

    function convertToAmount2Des(val) {
        var disval = val; //+'.00'; //.toFixed(val);
        return accounting.formatMoney(disval, "", 2, "", "."); // €4.999,99 
    }

    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0,
                v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
    toastr.options = {
        "closeButton": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>