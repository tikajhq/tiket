</div>
</div>
</div>
<!-- Page Footer-->
<footer class="main-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p><?= DEV_COMPANY_NAME ?> &copy; 2019-2020</p>
            </div>
            <div class="col-sm-6 text-right">
                <p>Powered by &nbsp;<a href="<?= DEV_COMPANY_URL ?>" class="external powered-logo"><img
                                src="/assets/img/logo-white.png" width="65" alt="TIKAJ"></a></p>
                <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            </div>
        </div>
    </div>
</footer>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="<?= BASE_URL ?>assets/vendor/jquery.cookie/jquery.cookie.js"></script>
<script src="<?= BASE_URL ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script><!-- Main File-->
<script src="<?= BASE_URL ?>assets/js/front.js"></script>
<script src="<?= BASE_URL ?>assets/js/library.js"></script>
<script src="<?= BASE_URL ?>assets/js/tik-script.js"></script>
<script src="<?= BASE_URL ?>assets/js/main/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            // Animate loader off screen
            $(".loader").fadeOut(1000);
        })
    });

    function addBrAfterXWords(e, data) {
        let words = e;
        let text = data.split(" ");
        let newhtml = [];
        console.log("TEST text:" + text);

        for (var i = 0; i < text.length; i++) {

            if (i > 0 && (i % words) == 0)
                newhtml.push("<br />");

            newhtml.push(text[i]);
        }
        return newhtml.join(" ");
    }

   /*to get user icon*/
    $('.current-user-avatar').each(function(elem){
        console.log($(this).attr('data-username'));
        var username = $(this).attr('data-username');
        var name = username.split('.').map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
        console.log(name);
        $(this).append(getUserLabel(name, username))
    });
</script>
</body>
</html>