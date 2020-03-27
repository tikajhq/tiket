<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= PRODUCT_NAME ?> | <?= $title ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    
    <style>
        .loader {
            position: fixed;
            width: 100%;
            height: 100%;
            padding-top: 18%;
            z-index: 9999;
            display: block;
            background-color: white;
            opacity: 5;
            text-align: center;
            vertical-align: middle;
        }

        .loader img {
            width: 120px;
        }
    </style>
 <script>
        var BASE_URL = "<?= BASE_URL ?>";
    </script>


    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/img/favicon.ico">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendor/toastr/toastr.min.css">

        <!-- <script src="https://cdn.ckeditor.com/4.12.1/basic/ckeditor.js"></script> -->
<!--    <script src="https://code.jquery.com/jquery-3.4.1.min.js"-->
<!--            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>-->
    <script src="<?= BASE_URL ?>assets/js/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
   

    <script src="<?= BASE_URL ?>assets/js/plugins/datatables/datatables.min.js"></script>
    <!-- <script src="<?= BASE_URL ?>assets/js/plugins/alpaca/alpaca.min.js"></script> -->
    <link href="<?= BASE_URL ?>assets/js/plugins/alpaca/alpaca.min.css" rel="stylesheet" type="text/css">
    
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>

    <script src="<?= BASE_URL ?>assets/vendor/alpacajs/alpaca.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link href="<?= BASE_URL ?>assets/css/select2.min.css" rel="stylesheet" />
    <script src="<?= BASE_URL ?>assets/js/select2.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/tabler.js"></script>

    <!-- Toastr -->
    <script src="<?= BASE_URL ?>assets/vendor/toastr/toastr.min.js"></script>

    <!-- Chartjs -->
    <script src="<?= BASE_URL ?>assets/vendor/chart.js/Chart.min.js"></script>

    

    <script type="text/javascript">
        $(document).ready(function(){
            $('.side-navbar ul li a').each(function () {
                var url = window.location.href;
                var $this = $(this);
                if ($this.attr('href').trim() === url) {
                    var current = $this.parent();
                    var current_parent = $this.parent().parent().siblings('a').parent();
                    current.addClass('nav-active');
                    current_parent.addClass('nav-active');
                }
            })
        });

        $(function() {
            $(".loader").fadeIn();
        });

        setTimeout(function () {
            $('.event-notification').fadeOut('fast');
        }, 5000); // <-- time in milliseconds
    </script>

</head>
<body>
<div class="loader"></div>

<div class="page">
    <!-- Main Navbar-->
    <header class="header">
        <nav class="navbar">
            <!-- Search Box-->
            <div class="search-box">
                <button class="dismiss"><i class="icon-close"></i></button>
                <form id="searchForm" action="#" role="search">
                    <input type="search" placeholder="What are you looking for..." class="form-control">
                </form>
            </div>

            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <!-- Navbar Header-->
                    <div class="navbar-header">
                        <!-- Navbar Brand --><a href="<?= BASE_URL ?>user/dashboard" class="navbar-brand d-none d-sm-inline-block">
                            <div class="brand-text d-none d-lg-inline-block"><?= PRODUCT_NAME ?></div>
                            <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>TIKAJ</strong></div>
                        </a>
                        <!-- Toggle Button--><a id="toggle-btn" href="#"
                                                class="menu-btn active"><span></span><span></span><span></span></a>
                    </div>
                    <!-- Navbar Menu -->
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <li class="dotted-add-button"><a href="<?= BASE_URL ?>tickets/create_new"><i
                                        class="fa fa-plus-square"></i> New ticket</a></li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle sidebar-header d-flex align-items-center" href="#"
                               id="navbarDropdown"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="current-user-avatar" data-username="<?= $this->Session->getLoggedDetails()['username']?>"></div>
                                <div class="title pl-2">
                                    <?= $this->Session->getLoggedDetails()['username']?>
                                </div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?= BASE_URL ?>user/profile"><i
                                            class="fa fa-user bg-info"></i> Profile</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>user/change_password""><i
                                        class="fa fa-lock bg-orange"></i> Change password</a>
                                <div class="dropdown-divider"></div>
                                <!-- Logout -->
                                <a class="dropdown-item" href="<?= BASE_URL ?>auth/logout"><i
                                            class="fa fa-sign-out bg-red"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
    </header>
    <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar">
            <!-- Sidebar Navidation Menus-->
            <ul class="list-unstyled">
                <!-- TODO: Change below session data fetching !-->
                <?php 
                // print_r($this->session->userdata);
                // die();
                include_once "menus/" . $this->session->userdata('sessions_details')['type'] . ".php"; ?>
            </ul>

        </nav>
        <div class="content-inner">
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-bottom: 0rem">
        <p>
            <strong>Hey!</strong> You can automatically create a ticket by sending an email to helpdesk@ticket.tik.co. You can also reply to any ticket thread from the notification email thread itself !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </p>
            <hr>
  <p class="mb-0">Note: Email notifications have been disabled in this demo version.</p>
        </div>
            <!-- Page Header-->
            <header class="page-header">
                <div class="container-fluid">
                    <h2 class="no-margin-bottom"><?= $title ?></h2>
                </div>
            </header>
