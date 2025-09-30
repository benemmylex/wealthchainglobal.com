<?php include('header.php'); ?>

<title>Markets - <?= SITE_NAME; ?></title>
<main class="my-5 pt-5" id="content">
    <div class="container pt-5">
        <div class="col-md-12 mb-5">
            <div class="">
                <!-- Tabs navs -->
                <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="ex2-tab-1" data-mdb-toggle="tab" href="#ex2-tabs-1" role="tab" aria-controls="ex2-tabs-1" aria-selected="true">Stocks</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex2-tab-2" data-mdb-toggle="tab" href="#ex2-tabs-2" role="tab" aria-controls="ex2-tabs-2" aria-selected="false">Crypto</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex2-tab-3" data-mdb-toggle="tab" href="#ex2-tabs-3" role="tab" aria-controls="ex2-tabs-3" aria-selected="false">Forex</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex2-tab-4" data-mdb-toggle="tab" href="#ex2-tabs-4" role="tab" aria-controls="ex2-tabs-4" aria-selected="false">Index</a>
                    </li>
                </ul>
                <!-- Tabs navs -->

                <!-- Tabs content -->
                <div class="tab-content" id="ex2-content">
                    <div class="tab-pane fade show active" id="ex2-tabs-1" role="tabpanel" aria-labelledby="ex2-tab-1">
                        <div class="card border border-1 border-primary">
                            <div class="card-body px-1" id="stocks">
                                <div class="d-flex justify-content-center align-items-center" style="height: 400px; width: 100%" id="stocksDiv">
                                    <span style="font-size: 65px !important;" class="fas fa-spinner fa-pulse fa-4x text-primary"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ex2-tabs-2" role="tabpanel" aria-labelledby="ex2-tab-2">
                        <div class="card border border-1 border-primary">
                            <div class="card-body px-1" id="crypto">
                                <div class="d-flex justify-content-center align-items-center" style="height: 400px; width: 100%" id="cryptoDiv">
                                    <span style="font-size: 65px !important;" class="fas fa-spinner fa-pulse fa-4x text-primary"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ex2-tabs-3" role="tabpanel" aria-labelledby="ex2-tab-3">
                        <div class="card border border-1 border-primary">
                            <div class="card-body px-1" id="forex">
                                <div class="d-flex justify-content-center align-items-center" style="height: 400px; width: 100%" id="forexDiv">
                                    <span style="font-size: 65px !important;" class="fas fa-spinner fa-pulse fa-4x text-primary"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ex2-tabs-4" role="tabpanel" aria-labelledby="ex2-tab-4">
                        <div class="card border border-1 border-primary">
                            <div class="card-body px-1" id="index">
                                <div class="d-flex justify-content-center align-items-center" style="height: 400px; width: 100%" id="indexDiv">
                                    <span style="font-size: 65px !important;" class="fas fa-spinner fa-pulse fa-4x text-primary"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tabs content -->
            </div>
        </div>
    </div>
</main>
<?php include('footer.php'); ?>
<script src="../../assets/js/assets.js"></script>
<script>
    $(document).ready(function() {
        getSeperate();
    });
</script>