<?php include('../../ops/connect.php');

$mem_id = $_SESSION['mem_id'];

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$mys = 0;

$getNotif = $db_conn->prepare("SELECT * FROM notifications WHERE status = :status AND mem_id = :mem_id");
$getNotif->bindParam(":status", $mys, PDO::PARAM_STR);
$getNotif->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
$getNotif->execute();

$notifCount = $getNotif->rowCount();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" href="../../assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/style.min.css">
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Public+Sans:wght@500;600;700;800&amp;display=swap' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/toastr.css" />
    <script src="../../assets/js/jquery-3.6.0.min.js"></script>

</head>
<style>
    body {
        font-family: 'Inter' !important;
        /* font-size: 13.8px; */
    }

    button.btn {
        border-radius: 8px !important;
    }

    .pos {
        z-index: 100;
        position: fixed !important;
        top: 48px;
    }
</style>

<body class="" data-mdb-theme="light">
    <header>
        <!-- Navbar -->
        <nav id="main-navbar" class="navbar bg-body-tertiary navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a href="./" class="navbar-brand" style="font-size: .84em !important;"><span class="fw-bold"><?= SITE_NAME; ?></span></a>
                <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle d-flex align-items-center" id="navbarDropdownMenuAvatar" data-mdb-toggle="dropdown" role="button" aria-expanded="false" href="#">
                            <img class="rounded-circle" height="25" src="../../assets/images/user/<?= $_SESSION['photo'] == NULL ? 'user.png' : $_SESSION['photo']; ?>" loading="lazy" />
                            <small class="ps-2"><?= $_SESSION['fullname']; ?></small>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                            <li>
                                <a class="dropdown-item" href="./notifications">Notifications <span class="badge badge-primary"><?= $notifCount; ?></span></a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./profile">My profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./logout">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <title>ID Verification - <?= SITE_NAME; ?></title>
    <main class="mt-5 pt-3 pb-3" id="content">
        <div class="container">
            <div class="card border border-1 border-primary">
                <div class="card-body">
                    <!--<p>Account access is restricted until verification is complete.</p>-->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <h4 class="font-weight-bold text-primary">KYC Verification</h4>
                        </div>
                        <!--<div class="">-->
                        <!--    <button id="btnSkip" class="btn btn-primary btn-rounded btn-sm">skip</button>-->
                        <!--</div>-->
                    </div>
                    <?php if ($_SESSION['identity'] == 0) { ?>
                        <p class="lh-base">Verify your account by providing us with a vaild document (ID card), Drivers Licence, Valid Work ID Card, Passport, etc are accepted. Please do not try to upload a fake document as our support team reviews every document uploaded.</p>
                        <p class="lh-base">Detected fake documents will lead to immediate suspension of account! Once Uploaded, Our support team reviews your document and gets back to you within 24 Hours. The uploaded documents are for verification purposes only and are deleted once confirmed.</p>
                        <p class="lh-base">You will be notified via email once your document has been verified. Choose your document and click on the verify button.</p>
                        <form class="" id="verify" enctype="multipart/form-data">
                            <div class="select-wrapper mb-3">
                                <select class="select" name="type" id="type" required="" searchable="">
                                    <option disabled selected>--Select Identity Document--</option>
                                    <option>Identity Card (ID)</option>
                                    <option>International Passport</option>
                                    <option>Drivers Licence</option>
                                    <option>Others</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="frontpage"> Front Page <span class="fas fa-cloud-upload-alt"></span></label>
                                    <div class="form-outline mb-5">
                                        <input type="file" id="frontpage" class="form-control" name="frontpage" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="backpage"> Back Page <span class="fas fa-cloud-upload-alt"></span></label>
                                    <div class="form-outline mb-5">
                                        <input type="file" id="backpage" class="form-control" name="backpage" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4" align="center">
                                <p class="alert alert-primary" id="errorshow"></p>
                            </div>
                            <center>
                                <div class="">
                                    <button type="submit" id="btnDep" class="btn btn-md btn-primary">Verify</button>
                                </div>
                            </center>
                        </form>
                    <?php } elseif ($_SESSION['identity'] == 1) { ?>
                        <p class='pt-5 text-center lh-base'>We are currently reviewing your submitted documents, as soon as verification is completed, we will activate your account. Please check back later.</p>
                    <?php } elseif ($_SESSION['identity'] == 2) { ?>
                        <p class='pt-5 text-center lh-base'>Your account verification was not successful. You will be able to verify your account in the next 24 hours.</p>
                    <?php } elseif ($_SESSION['identity'] == 3) { ?>
                        <p class='pt-5 text-center lh-base'>Your account has been verified successfully. <span class="fas fa-check-circle text-success"></span></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
    <a class="floating mdark" id="switcher">
        <span id="sback" class="fas fa-moon"></span>
    </a>
    <footer class="mt-1 py-2 border-top" style="background: linear-gradient(179deg, #724fe5 6.25%);">
        <div class="pt-2 container px-3">
            <div class="text-center">
                <h6>&copy; 2012 - <?= date('Y') . ' ' . SITE_NAME; ?></h6>
            </div>
        </div>
    </footer>
    <script src="../../assets/js/mdb.min.js"></script>
    <script src="../../assets/js/switchtheme.js"></script>
    <script src="../../assets/js/jquery-redirect.js"></script>
    <script src="../../assets/js/toastr.js"></script>
    <script>
        $(document).ready(function() {
            $("#errorshow").fadeOut();
        });

        $("#switcher").click(function() {
            const ttt = localStorage.getItem('theme') === 'dark' ? 'light' : 'dark';
            setTheme(ttt);
        });

        if (localStorage.getItem("hidebal") == "shown" || !localStorage.getItem("hidebal")) {
            $('#showBal11').hide();
            $('#showBal13').hide();
            $('#slashOnes').hide();
            $('#slashTwos').hide();

            $('#showBal1').show();
            $('#showBal12').show();
            $('#slashOne').show();
            $('#slashTwo').show();
        } else {
            if (localStorage.getItem("hidebal") == "hidden") {
                $('#showBal11').show();
                $('#showBal13').show();
                $('#slashOne').show();
                $('#slashTwo').show();

                $('#showBal1').hide();
                $('#showBal12').hide();
                $('#slashOnes').hide();
                $('#slashTwos').hide();
            }
        }

        function hideBal() {
            localStorage.setItem("hidebal", "hidden");
            $('#showBal11').show();
            $('#showBal13').show();
            $('#slashOne').show();
            $('#slashTwo').show();

            $('#showBal1').hide();
            $('#showBal12').hide();
            $('#slashOnes').hide();
            $('#slashTwos').hide();
        }

        function showBal() {
            localStorage.setItem("hidebal", "shown");
            $('#showBal11').hide();
            $('#showBal13').hide();
            $('#slashOne').hide();
            $('#slashTwo').hide();

            $('#showBal1').show();
            $('#showBal12').show();
            $('#slashOnes').show();
            $('#slashTwos').show();
        }

        function redir(link, params) {
            $.redirect(link, params);
        }

        $(document).ready(function() {
            if (window.innerWidth <= 700) {
                slimInstance.hide();
                $("#sidenav-1").attr("data-mdb-mode", "over");
            } else if (window.innerWidth > 700) {
                slimInstance.show();
                $("#sidenav-1").attr("data-mdb-mode", "side");
                $("#sidenav-1").attr("data-mdb-close-on-esc", "false");
            }

        });

        window.addEventListener('resize', () => {
            // Toggle on mobile
            if (window.innerWidth <= 700) {
                slimInstance.hide();
                $("#sidenav-1").attr("data-mdb-mode", "over");
            } else if (window.innerWidth > 700) {
                slimInstance.show();
                $("#sidenav-1").attr("data-mdb-mode", "side");
                $("#sidenav-1").attr("data-mdb-close-on-esc", "false");
            }
        });

        $("form#verify").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            let request = "verifyId";
            formData.append('request', request);
            if ($("#type").val() == null) {
                $('#errorshow').html("Select a document type to upload").fadeIn();
            } else {
                $.ajax({
                    url: '../../ops/users',
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#errorshow').html("Uploading Document. Please wait <span class='fas fa-spinner fa-spin'></span>").fadeIn();
                    },
                    success: function(data) {
                        let response = $.parseJSON(data);
                        if (response.status == 'success') {
                            $("#errorshow").html(response.message).fadeIn();
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            $("#errorshow").html(response.message).fadeIn();
                        }
                    },
                    cache: false,
                    error: function(err) {
                        $('#errorshow').html(err.statusText).fadeIn();
                    },
                    contentType: false,
                    processData: false
                });
            }
        });

        $("#btnSkip").click(function() {
            var mem_id = "<?= $_SESSION['mem_id']; ?>";
            $.ajax({
                url: '../../ops/users',
                type: 'POST',
                data: {
                    request: 'skipVer',
                    mem_id: mem_id
                },
                beforeSend: function() {
                    $('#btnSkip').html("Please wait <span class='far fa-1x fa-spinner fa-spin'></span>").fadeIn();
                },
                success: function(data) {
                    let res = $.parseJSON(data);
                    if (res.status == 'success') {
                        $("#btnSkip").html("KYC skipped").fadeIn();
                        setTimeout(' window.location.href = "./"; ', 2000);
                    } else {
                        $("#btnSkip").html("<span class='far fa-exclamation-triangle'></span> " + res.response).fadeIn();
                    }
                },
                error: function(err) {
                    $('#btnSkip').html("<span class='far fa-exclamation-triangle'></span> An error has occured! " + err).fadeIn();
                }
            });
        });
    </script>