<?php include "header.php"; ?>
<title>Buy NFTs | <?= SITE_NAME; ?></title>
<link rel="stylesheet" href="../../assets/css/tiny-slider.css" />
<style>
    .tns-nav {
        display: none;
    }
</style>
<main class="mt-5 pt-5" id="content">
    <div class="container pt-5">
        <h4 class="fw-bold">Premium NFTs on <?= SITE_NAME; ?></h4>
        <div class="col-md-4 ms-auto mb-3">
            <form id="searchForm" method="POST" enctype="multipart/form-data">
                <span class="small text-danger mt-4 mb-0" id="searchError"></span>
                <div class="form-outline form-outline d-flex" data-mdb-input-init>
                    <input type="text" placeholder="search gifts" id="searchText" name="searchText" class="form-control" />
                    <label for="searchText" class="form-label">Search</label>
                    <button class="btn btn-sm btn-primary" id="btnSearch"><span class="fas fa-search"></span></button>
                </div>
            </form>
        </div>
        <div class="row" id="visiblenft">
            <div class="col-lg-12 mt-4 pt-2">
                <div class="tiny-three-item tiny-timeline">
                    <?php
                    $status = 1;
                    $getnft = $db_conn->prepare("SELECT * FROM nfts WHERE nftstatus = :status");
                    $getnft->bindParam(":status", $status, PDO::PARAM_STR);
                    $getnft->execute();
                    if ($getnft->rowCount() > 0) {
                        while ($rownft = $getnft->fetch(PDO::FETCH_ASSOC)) :
                    ?>
                            <div class="tiny-slide">
                                <div class="card shadow-3 rounded-3">
                                    <div class="card-body border border-primary border-1">
                                        <img src="../../assets/nft/images/<?= $rownft['nftimage'] ?>" loading="lazy" class="card-img-top" alt="<?= $rownft['nftname'] ?>" />
                                        <div class="card-body">
                                            <h4 class="card-title fw-bold border-bottom border-1"><?= $rownft['nftname'] ?></h4>
                                            <div class="d-flex justify-content-between border-bottom my-2">
                                                <div>
                                                    <p class="card-text"><span class="fw-bold text-primary"><?= $_SESSION['symbol'] . number_format($rownft['nftprice'], 2) ?></span><br><span class="small"><?= substr($rownft['nftdesc'], 0, 70) ?>...</span></p>
                                                </div>
                                            </div>
                                            <center><a href="nft?nftid=<?= $rownft['nftid'] ?>" class="btn btn-outline-primary btn-rounded">View/Buy</a></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                    } else { ?>
                        <h5 class="text-uppercase fw-bold text-white">There are no available nfts to show</h5>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="card border border-1 border-primary mt-3">
            <div class="card-body p-2">
                <div class="border-bottom border-2 pb-1 mb-3">
                    <h5 class="fw-bold text-center">NFT Purchase History</h5>
                </div>
                <div class="table-wrapper table-responsive">
                    <table class="table align-middle hoverable table-striped table-hover" id="depTable">
                        <thead class="">
                            <tr class="text-nowrap">
                                <th scope="col" class="">ID</th>
                                <th scope="col" class="">Date</th>
                                <th scope="col" class="">Method</th>
                                <th scope="col" class="">Type</th>
                                <th scope="col" class="">Amount</th>
                                <th scope="col" class="">Status</th>
                                <th scope="col" class="">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $sql2 = $db_conn->prepare("SELECT * FROM nfthistory WHERE mem_id = :mem_id ORDER BY main_id DESC");
                        $sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                        $sql2->execute();
                        $b = 1;
                        ?>
                        <tbody>
                            <?php if ($sql2->rowCount() < 1) { ?>
                                <tr class="text-center">
                                    <td class='text-center' colspan='7'>No transactions available to show</td>
                                </tr>
                                <?php
                            } else {
                                while ($row = $sql2->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr class="text-nowrap">
                                        <td class="text-start">#<?= $row['transc_id']; ?></td>
                                        <td class="text-start"><?= $row['addeddate']; ?></td>
                                        <td class="text-start"><?= $row['method']; ?></td>
                                        <td class="text-start"><?= "NFT Purchase"; ?></td>
                                        <td class="text-start"><?= $_SESSION['symbol'] . number_format($row['amount'], 2); ?></td>
                                        <td class="text-start">
                                            <?php
                                            if ($row['status'] == 1) {
                                                echo "<span class='text-success'>Success</span>";
                                            } elseif ($row['status'] == 0) {
                                                echo "<span class='text-warning'>Pending</span>";
                                            } elseif ($row['status'] == 2) {
                                                echo "<span class='text-danger'>Failed</span>";
                                            }
                                            ?>
                                        </td>
                                        <td><a href="./details?type=nft&transcid=<?= $row['transc_id']; ?>" class="btn btn-sm btn-primary"><span class="">View</span></a></td>
                                <?php $b++;
                                endwhile;
                            } ?>
                                    </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-fullscreen" role="document">
            <div class="modal-content text-center">
                <div class="modal-header justify-content-center indigo">
                    <h3 class="font-weight-bold"><span class="fas fa-search"></span> Search Results <span id="searchCount"></span></h3>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3 text-start">
                    <div class="" id="searchResult">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-primary btn-rounded" onclick="$('#searchModal').modal('hide');">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>
<script src="../../assets/js/tiny-slider.js"></script>
<script>
    if (document.getElementsByClassName('tiny-three-item').length > 0) {
        var slider = tns({
            container: '.tiny-three-item',
            controls: false,
            mouseDrag: true,
            loop: true,
            rewind: true,
            autoplay: true,
            autoplayButtonOutput: false,
            autoplayTimeout: 2000,
            navPosition: "top",
            speed: 400,
            gutter: 12,
            responsive: {
                992: {
                    items: 3
                },

                767: {
                    items: 2
                },

                320: {
                    items: 1
                },
            },
        });
    };

    $(document).ready(() => {
        $('#searchModal').modal('hide');
    });

    $("form#searchForm").submit(function(e) {
        let searchRes = [];
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('request', 'searchNft');
        if ($('#searchText').val() == null || $('#searchText').val() == "") {
            $('#searchError').html('Please enter a text in the search box').show();
            setTimeout(function() {
                $('#searchError').html("").hide();
            }, 5000);
        } else if ($('#searchText').val().length < 3) {
            $('#searchError').html('Search text length is less than 4 characters').show();
            setTimeout(function() {
                $('#searchError').html("").hide();
            }, 5000);
        } else {
            $.ajax({
                url: '../../ops/users',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#btnSearch').html("<span class='fas fa-spinner fa-spin'></span>");
                    setTimeout(() => {
                        $('#btnSearch').html("<span class='fas fa-search'></span>");
                    }, 5000);
                },
                success: function(data) {
                    var result = $.parseJSON(data);
                    if (result.status == "success") {
                        $('#searchModal').modal('show');
                        $("#searchResult").html(result.message).show();
                        searchRes = result.result;
                        $('#searchCount').html(`(${searchRes.length})`);
                        let div = "";
                        let symbol = "$";
                        for (var i = 0; i < searchRes.length; i++) {
                            div += `<div class="col-md-4 mb-3">
	                		<div class="card bg-primary bg-gradient shadow-3">
	                			<div class="card-body">
    	                			<div class="card shadow-3 rounded-3">
        								<div class="card-body border border-primary border-1">
        								    <img src="../../assets/nft/images/${searchRes[i]['nftimage']}" loading="lazy" class="card-img-top" alt="${searchRes[i]['nftname']}"/>
            								<div class="card-body">
            									<h4 class="card-title fw-bold border-bottom border-1">${searchRes[i]['nftname']}</h4>
            									<div class="d-flex justify-content-between border-bottom my-2">
            										<div><p class="card-text"><span class="fw-bold text-primary">$${searchRes[i]['nftprice']}</span><br><span class="small">${searchRes[i]['nftdesc']}...</span></p></div>
            									</div>
            									<center><a href="nft?nftid=${searchRes[i]['nftid']}" class="btn btn-outline-primary btn-rounded">View/Buy</a></center>
            								</div>
        								</div>
        							</div>
                                </div>
							</div>
	                	</div>`;
                        }
                        let div1 = document.createElement('div');
                        div1.className = 'row';
                        div1.innerHTML = div;
                        // console.log
                        $('#searchResult').html(div1);
                    } else {
                        $('#searchError').html(result.message).show();
                        setTimeout(function() {
                            $('#searchError').html("").hide();
                        }, 5000);
                    }
                },
                cache: false,
                error: function() {
                    $('#searchError').html("An error occured").show();
                    setTimeout(function() {
                        $('#searchError').html("").hide();
                    }, 5000);
                },
                contentType: false,
                processData: false
            });
        }
    });
</script>