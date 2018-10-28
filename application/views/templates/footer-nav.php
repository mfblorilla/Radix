

<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>Copyright &copy; 2018 <img src="<?php echo base_url('assets/img/IBM-security.png'); ?>" style="width: 7%;height: 7%;"></small>
        </div>
    </div>
</footer>

<!-- Scroll to Top Button -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>

<!-- Logout Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Select "Logout" below if you are ready to end your current session.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <?php echo form_open('User_Authentication/logout') ?>
                <!--            <a class="btn btn-primary" href="login.html">Logout</a>-->
                <input type="submit" name="submit" value="Logout" class="btn btn-dark">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>






<!-- Bootstrap core JavaScript -->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for this template -->
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/moment/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sb-admin.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/incident_artifact.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>


<script type="text/javascript">

//    $(function () {
//        console.log('<?php echo current_url(); ?>');
//    });



    $('#form-save').submit(function (e) {

        e.preventDefault();
        $('#save-load').show();
        setTimeout(hideMe, 3000);


        var me = $(this);
        // perform ajax
        $.ajax({
            url: me.attr('action'),
            type: 'post',
            data: me.serialize(),
            dataType: 'json',
            success: function (response) {
                $('#save-load').hide();
                console.log(response);

                if (response.success == true) {
                    $('#updateMe').show();
                    setTimeout(hideMe2, 3000);

                    $('.form-group').removeClass('has-error')
                            .removeClass('has-success');
                    $('.text-danger').remove();

                    setTimeout(function () {
                        document.location.href = response.redirect;
                    }, 1000);


                } else {
                    $.each(response.messages, function (key, value) {
                        var element = $('#' + key);


                        element.closest('div.form-group')
                                .removeClass('invalid')
                                .addClass(value.length > 0 ? 'invalid' : 'valid')
                                .find('.text-danger').remove();
                        element.after(value);

                        $('#error').show();
                        setTimeout(hideError, 2000);

                    });
                }


            }
        });





    });

    function hideMe() {
        $('#save-load').hide();

    }

    function hideMe2() {
        $('#updateMe').hide();
    }

    function hideError() {
        $("#error").hide();
    }

<?php if ($nav == 'System_Settings/SLA_View' || $nav == 'System_Settings/SLA_View/2'): ?>
        var sla_id = 0;
        $(".delete-sla").on("click", function () {
            var value = $(this).attr('id');
            $("#sla_content").html(value);
            var val_split = value.split(" - ");
            sla_id = val_split[0];

     

        });

        $("#confirm_delete_sla").on("click", function () {
            var csrf_token = $("input[name=csrf_token_radix]").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $base_url . 'index.php/System_Settings/delete_sla'; ?>',
                data: {'sla_id': sla_id, 'csrf_token_radix': csrf_token},
                success: function (status) {
                    window.location.replace("<?php echo $base_url . 'index.php/System_Settings/SLA_View/2'; ?>");
                    console.log(status);
                }
            });
        });

<?php endif; ?>
</script>







</body>

</html>