<?php include 'header.php'; ?>

<title>My Account</title>
<main class="pt-5 mt-5" id="content">
    <div class="container pt-5">
        <div class="alert alert-primary mb-3">
            <h5>Account settings</h5>
            <p class="small">Edit account details</p>
        </div>
        <div class="p-3 col-md-9 me-auto ms-auto">
            <h6 class="text-center ">Referral Link</h6>
            <div class="form-outline d-flex">
                <input class="form-control" type="text" id="reflink" readonly="" name="reflink" placeholder="https://<?= SITE_URL; ?>/signup?ref=<?= $_SESSION['username']; ?>" value="https://<?= SITE_URL; ?>/signup?ref=<?= $_SESSION['username']; ?>">
                <span class='fas fa-clipboard text-white p-2 bg-primary' style='border-radius: 5px; cursor:pointer;' id='copy'></span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-6 col-md-12 mb-3">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="text-start">Change Profile Photo</h5>
                        <div class="text-center mb-3 cent">
                            <div class="circ">
                                <img id="imgPreview" src="../../assets/images/user/<?= $_SESSION['photo'] == null ? "user.png" : $_SESSION['photo'] ?>" alt="" class="img-fluid img-sc">
                            </div>
                        </div>
                        <form class="" id="updatephoto" enctype="multipart/form-data">
                            <div class="form-outline mb-3">
                                <i class="far text-primary fa-image trailing"></i>
                                <input type="file" id="photo" required="" name="photo" class="form-control form-icon-trailing">
                                <!-- <label for="photo" class="form-label">Image</label> -->
                            </div>
                            <p class="alert alert-primary my-2 text-center" id="errorphoto"></p>
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="text-center me-3">
                                    <button type="submit" id="btnEdit" class="btn btn-md btn-primary">Upload</button>
                                </div>
                                <div class="text-center">
                                    <button type="reset" onclick="resetPhoto()" class="btn btn-md btn-danger">Reset</button>
                                </div>
                            </div>
                            <p class="small text-center">Allowed JPG, GIF, HEIC or PNG. Max size of 2MB</p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h4 class="font-weight-bold">Balances</h4>
                        <hr>
                        <p class="h6"><b>Total Balance:</b> <?= $_SESSION['symbol'] . number_format($totalbal, 2); ?></p>
                        <hr>
                        <p class="h6"><b>Available Balance:</b> <?= $_SESSION['symbol'] . number_format($available, 2); ?></p>
                        <hr>
                        <p class="h6"><b>Profit Balance:</b> <?= $_SESSION['symbol'] . number_format($profit, 2); ?></p>
                        <hr>
                        <p class="h6"><b>Bonus Balance:</b> <?= $_SESSION['symbol'] . number_format($bonus, 2); ?></p>
                        <hr>
                        <p class="h6"><b>Pending Withdrawal:</b> <?= $_SESSION['symbol'] . number_format($pending, 2); ?></p>
                        <hr>
                        <div class="text-center">
                            <button type="reset" onclick="$('#swapModal').modal('show')" class="btn btn-md btn-primary">Swap Balance</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-6 col-md-12 mb-3">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="text-start">Personal details</h5>
                        <p class="grey-text text-left mt-1">Fill the form to edit your profile </p>
                        <form class="" id="editprofile" enctype="multipart/form-data">
                            <div class="form-outline mb-3">
                                <i class="far text-primary fa-user-plus trailing"></i>
                                <input type="text" disabled value="<?= $_SESSION['mem_id']; ?>" id="mem_id" required="" name="mem_id" class="form-control form-icon-trailing">
                                <label for="mem_id" class="form-label">User id</label>
                            </div>
                            <div class="form-outline mb-3">
                                <i class="far text-primary fa-user trailing"></i>
                                <input type="text" value="<?= $_SESSION['fullname']; ?>" id="fullname" required="" name="fullname" class="form-control form-icon-trailing">
                                <label for="fullname" class="form-label">Full name</label>
                            </div>
                            <div class="form-outline mb-3">
                                <i class="far text-primary fa-envelope trailing"></i>
                                <input type="email" value="<?= $_SESSION['email']; ?>" id="email" required="" name="email" class="form-control form-icon-trailing">
                                <label for="email" class="form-label">Email Address</label>
                            </div>
                            <div class="form-outline mb-3">
                                <i class="fas text-primary fa-phone-square trailing"></i>
                                <input type="text" id="phone" required="" value="<?= $_SESSION['phone']; ?>" name="phone" class="form-control form-icon-trailing">
                                <label for="phone" class="form-label">Phone Number</label>
                            </div>
                            <div class="form-group mb-3">
                                <select class="select" name="country" id="country" required="" data-mdb-filter="true">
                                    <option disabled selected>--Select Country--</option>
                                    <?php $sql = $db_conn->prepare("SELECT * FROM countries");
                                    $sql->execute();
                                    while ($rows = $sql->fetch(PDO::FETCH_ASSOC)) :
                                    ?>
                                        <option <?php if ($_SESSION['country'] == $rows['country_name']) {
                                                    echo "selected";
                                                } ?> value="<?= $rows['country_name']; ?>"><?= $rows['country_name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <p class="alert alert-primary my-2 text-center" id="erroredit"></p>
                            <center>
                                <div class="text-center mb-3">
                                    <button type="submit" id="btnEdit" class="btn btn-md btn-primary">Save Details</button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="text-start">Change Password</h5>
                        <p class="text-start mt-1">Fill form to change your password </p>
                        <form class="" method="POST" enctype="multipart/form-data" id="passForm">
                            <div class="form-outline mb-4">
                                <i onclick="showpass('password', 'showpass')" id="showpass" style="cursor: pointer; right: 10px; top: 8px; position: absolute; z-index: 1000;">
                                    <span class="far fa-eye"></span>
                                </i>
                                <input type="password" name="password" id="password" class="form-control form-icon-trailing" placeholder="Password">
                                <label for="password" class="form-label">Password</label>
                            </div>
                            <div class="form-outline mb-4">
                                <i onclick="showpass('newpassword', 'showpass2')" id="showpass2" style="cursor: pointer; right: 10px; top: 8px; position: absolute; z-index: 1000;">
                                    <span class="far fa-eye"></span>
                                </i>
                                <input type="password" name="newpassword" id="newpassword" class="form-control form-icon-trailing" placeholder="New Password">
                                <label for="newpassword" class="form-label">New Password</label>
                            </div>
                            <div class="form-outline mb-4">
                                <i onclick="showpass('conpassword', 'showpass3')" id="showpass3" style="cursor: pointer; right: 10px; top: 8px; position: absolute; z-index: 1000;">
                                    <span class="far fa-eye"></span>
                                </i>
                                <input type="password" name="conpassword" id="conpassword" class="form-control form-icon-trailing" placeholder="Confirm Password">
                                <label for="conpassword" class="form-label">Confirm Password</label>
                            </div>
                            <p class="alert alert-primary py-3 text-center" id="errorpass"></p>
                            <div class="my-4" align="center">
                                <button type="submit" id="chgPass" class="btn btn-md btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="text-center fw-bold">My referral list</h5>
                        <div class="table-wrapper table-responsive">
                            <table class="table align-middle hoverable table-striped table-hover" id="reftable">
                                <thead class="orange darken-2 white-text">
                                    <tr class="text-nowrap">
                                        <th scope="col">S/N</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Registered on</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <?php
                                $stl = $db_conn->prepare("SELECT * FROM referral WHERE referrer = :mem_id");
                                $stl->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                $stl->execute();
                                $sn = 1;
                                ?>
                                <tbody>
                                    <div class="text-center" align="center"><?php if ($stl->rowCount() < 1) {
                                                                                echo "<td class='text-center' colspan='4'>No data available to show</td>";
                                                                            } else {
                                                                                while ($row = $stl->fetch(PDO::FETCH_ASSOC)):
                                                                                    $user = $row['mem_id'];
                                                                                    $getu = $db_conn->prepare("SELECT username, regdate, account FROM members WHERE mem_id = :user");
                                                                                    $getu->bindParam(":user", $user, PDO::PARAM_STR);
                                                                                    $getu->execute();
                                                                                    $rowss = $getu->fetch(PDO::FETCH_ASSOC);
                                                                            ?></div>
                                    <tr class="text-nowrap font-weight-bold">
                                        <td class="text-start"><?= $sn; ?></td>
                                        <td class="text-start"><?= $rowss['username']; ?></td>
                                        <td class="text-start"><?= $rowss['regdate']; ?></td>
                                        <td class="text-start"><?= $rowss['account'] == 'live' ? "<span class='text-success'>Active</span>" : "<span class='text-success'>Inactive</span>"; ?></td>
                                <?php $sn++;
                                                                                endwhile;
                                                                            } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card border border-1 border-primary">
                    <div class="card-body">
                        <h5 class="text-start">Account Info</h5>
                        <hr />
                        <p><span class="fw-bold">Account Type:</span> <span class="fas fa-dot-circle text-success"></span> <?= ucfirst($_SESSION['account']); ?> Account</p>
                        <hr />
                        <p><span class="fw-bold">Account Status:</span> <?= $_SESSION['accStatus'] == 1 ? 'Active <span class="fas fa-check-circle text-success"></span>' : ($_SESSION['accStatus'] == 0 ? 'Inactive <span class="fas fa-times-circle text-danger"></span>' : ''); ?></p>
                        <hr />
                        <p><span class="fw-bold">Email verification:</span> <?= $_SESSION['emailVerif'] == 1 ? 'Verified <span class="fas fa-check-circle text-success"></span>' : ($_SESSION['emailVerif'] == 0 ? 'Not verified <span class="fas fa-times-circle text-danger"></span> <a href="javascript:void(0)" onclick="resendMail(' . $_SESSION['mem_id'] . ')">resend</a>' : ''); ?></p>
                        <hr />
                        <p><span class="fw-bold">KYC status:</span> <?= $_SESSION['identity'] == 3 ? 'Verified <span class="fas fa-check-circle text-success"></span>' : ($_SESSION['identity'] == 2 ? 'Failed <span class="fas fa-exclamation-triangle text-danger"></span>' : ($_SESSION['identity'] == 1 ? 'Under review <span class="fas fa-exclamation-circle text-info"></span>' : ($_SESSION['identity'] == 0 ? 'Not verified <span class="fas fa-times-circle text-warning"></span>' : ''))); ?></p>
                        <hr />
                        <p><span class="fw-bold">Level:</span> <?= ucfirst($_SESSION['userplan']); ?> <span class="fas fa-chart-pie text-info"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="swapModal" tabindex="-1" aria-labelledby="swapModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content text-center">
            <div class="modal-header justify-content-center">
                <h5 class=""><span class="fas fa-exchange"></span> Swap Balance</h5>
                <button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class="modal-body py-4 my-3">
                <p class="ps-4">Move funds from one account to another</p>
                <form class="container md-form" id="swap" enctype="multipart/form-data">
                    <div class="form-group" align="center">
                        <p class="alert alert-primary" id="errorshown"></p>
                    </div>
                    <p class="font-weight-bold">Total Balance: <?php echo $_SESSION['symbol'] . number_format($totalbal, 2); ?></p>
                    <div class="form-outline mb-3">
                        <i class="fas fa-dollar-sign trailing" style="font-size: 15px;"></i>
                        <input type="number" max="200000000" id="amount" name="amount" class="form-control form-icon-trailing">
                        <label for="amount" class="form-label">Amount to swap</label>
                    </div>
                    <div class="select-wrapper mb-3">
                        <select class="select" name="fromacc" id="fromacc" required="">
                            <option disabled selected>--Select from account--</option>
                            <option value="available">Trading Balance (<?php echo $_SESSION['symbol'] . number_format($available, 2); ?>)</option>
                            <option value="profit">Profit (<?php echo $_SESSION['symbol'] . number_format($profit, 2); ?>)</option>
                            <option value="bonus">Bonus Balance (<?php echo $_SESSION['symbol'] . number_format($bonus, 2); ?>)</option>
                        </select>
                    </div>
                    <div class="select-wrapper mb-3">
                        <select class="select" name="toacc" id="toacc" required="">
                            <option disabled selected>--Select from account--</option>
                            <option value="available">Trading Balance (<?php echo $_SESSION['symbol'] . number_format($available, 2); ?>)</option>
                            <option value="profit">Profit (<?php echo $_SESSION['symbol'] . number_format($profit, 2); ?>)</option>
                            <option value="bonus">Bonus Balance (<?php echo $_SESSION['symbol'] . number_format($bonus, 2); ?>)</option>
                        </select>
                    </div>
                    <center>
                        <div class="text-center mb-2">
                            <button type="submit" id="btnSwap" class="btn btn-md btn-primary">Swap</button>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal: process-->
<?php include 'footer.php'; ?>
<script>
    $(document).ready(() => {
        $("#errorphoto").fadeOut();
        $("#errorpass").fadeOut();
        $("#erroredit").fadeOut();
        $("#errorshown").fadeOut();

        const photoInp = $("#photo");
        let file;

        photoInp.change(function(e) {
            file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $("#imgPreview")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        <?php if ($stl->rowCount() > 0) { ?>
            $('#reftable').DataTable({
                "pagingType": 'simple_numbers',
                "lengthChange": true,
                "pageLength": 6,
                dom: 'Bfrtip'
            });
        <?php } ?>
    });

    $("#copy").click(function() {
        var text = document.getElementById("reflink");
        text.select();
        document.execCommand('copy');
        toastr.success('Referral Link copied');
    });

    const resetPhoto = () => {
        $("#imgPreview")
            .attr("src", '../../assets/images/user/<?= $_SESSION['photo'] == null ? "user.png" : $_SESSION['photo'] ?>');
        $('#phoho').val('');
    }

    $("form#updatephoto").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var request = "uploadphoto";
        formData.append('request', request);
        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $("#errorphoto").html("Uploading image <span class='fas fa-spinner fa-pulse fa-fw'></span>").fadeIn();
            },
            success: function(data) {
                var response = $.parseJSON(data);
                if (response.status == 'success') {
                    $("#errorphoto").html(response.message).fadeIn();
                    setTimeout(function() {
                        location.reload();
                    }, 7000);
                } else {
                    $("#errorphoto").html(response.message).fadeIn();
                    setTimeout(function() {
                        $("#errorphoto").fadeOut();
                    }, 8000);
                }
            },
            cache: false,
            error: function(err) {
                $("#errorphoto").html(err.statusText).fadeIn();
                setTimeout(function() {
                    $("#errorphoto").fadeOut();
                }, 8000);
            },
            contentType: false,
            processData: false
        });
    });

    $("form#passForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var request = "changepassword";
        formData.append('request', request);
        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $("#errorpass").html("Saving new password <span class='far fa-spinner fa-pulse fa-fw'></span>").fadeIn();
            },
            success: function(data) {
                var response = $.parseJSON(data);
                if (response.status == 'success') {
                    $("#errorpass").html(response.message).fadeIn();
                    setTimeout(function() {
                        location.reload();
                    }, 7000);
                } else {
                    $("#errorpass").html(response.message).fadeIn();
                    setTimeout(function() {
                        $("#errorpass").fadeOut();
                    }, 8000);
                }
            },
            cache: false,
            error: function(err) {
                $("#errorpass").html(err.statusText).fadeIn();
                setTimeout(function() {
                    $("#errorpass").fadeOut();
                }, 8000);
            },
            contentType: false,
            processData: false
        });
    });

    $("form#editprofile").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var request = "editprofile";
        formData.append('request', request);
        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $("#erroredit").html("Saving changes <span class='fas fa-spinner fa-pulse fa-fw'></span>").fadeIn();
            },
            success: function(data) {
                var response = $.parseJSON(data);
                if (response.status == 'success') {
                    $("#erroredit").html(response.message).fadeIn();
                    setTimeout(function() {
                        location.reload();
                    }, 4000);
                } else {
                    $("#erroredit").html(response.message).fadeIn();
                    setTimeout(function() {
                        $("#erroredit").hide();
                    }, 8000);
                }
            },
            cache: false,
            error: function(err) {
                $("#erroredit").html(err.statusText).fadeIn();
                setTimeout(function() {
                    $("#erroredit").fadeOut();
                }, 8000);
            },
            contentType: false,
            processData: false
        });
    });

    $("form#swap").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var request = "swapbalance";
        formData.append('request', request);
        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $("#errorshown").html("Processing <span class='fas fa-spinner'></span>").fadeIn();
            },
            success: function(data) {
                var response = $.parseJSON(data);
                if (response.status == 'success') {
                    $("#errorshown").html(response.message).fadeIn();
                    setTimeout(function() {
                        location.reload();
                    }, 4000);
                } else {
                    $("#errorshown").html(response.message).fadeIn();
                    setTimeout(function() {
                        $("#errorshown").hide();
                    }, 8000);
                }
            },
            cache: false,
            error: function(err) {
                $("#errorshown").html(err.statusText).fadeIn();
                setTimeout(function() {
                    $("#errorshown").fadeOut();
                }, 8000);
            },
            contentType: false,
            processData: false
        });
    });

    const resendMail = function(mem_id) {
        let request = "resendMail";
        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: {
                request,
                mem_id
            },
            beforeSend: function() {
                toastr.info("Processing <span class='fas fa-spinner'></span>").fadeIn();
            },
            success: function(data) {
                var response = $.parseJSON(data);
                if (response.status == 'success') {
                    toastr.info(response.message).fadeIn();
                    setTimeout(function() {
                        location.reload();
                    }, 4000);
                } else {
                    toastr.info(response.message).fadeIn();
                    setTimeout(function() {
                        $("#errorshown").hide();
                    }, 8000);
                }
            },
            error: function(err) {
                toastr.info(err.statusText).fadeIn();
                setTimeout(function() {
                    $("#errorshown").fadeOut();
                }, 8000);
            }
        });
    };
</script>