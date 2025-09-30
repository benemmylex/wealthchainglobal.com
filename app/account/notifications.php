<?php include "header.php"; ?>
<link rel="stylesheet" href="../../assets/css/toastr.css" />
<title>Notifications - <?= SITE_NAME; ?></title>
<main class="py-5 mt-5" id="content">
    <div class="container pt-5">
        <div class="card border border-1 border-primary">
            <div class="card-header py-3">
                <h5 class="fw-bold text-uppercase text-center">Notifications <span class="badge badge-primary"><?= $notifCount; ?></span></h5>
            </div>
            <div class="card-body">
                <?php
                $per_page = 10;
                $getN = $db_conn->prepare("SELECT * FROM notifications WHERE mem_id = :mem_id ORDER BY main_id DESC LIMIT $per_page");
                $getN->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
                $getN->execute();
                $count = $getN->rowCount();
                $pages = ceil($count / $per_page);
                if ($count < 1) {
                ?>
                    <p class="text-center text-muted">
                        No notifications to show
                    </p>
                <?php } else { ?>
                    <div id="notifs"></div>
                    <?php if ($pages > 1) { ?>
                        <hr class="mt-1 mb-3">
                        <nav aria-label="..." id="pagination">
                            <ul class="pagination">
                                <?php
                                //Pagination Numbers
                                for ($i = 1; $i <= $pages; $i++) {
                                    echo '<li class="page-item" id="' . $i . '"><a href="javascript:void(0);" class="page-link">' . $i . '</a></li>';
                                }
                                ?>
                            </ul>
                            <p class="small mb-0">Total pages: <?= $pages; ?></p>
                        </nav>
                    <?php } ?>
                <?php
                } ?>
            </div>
        </div>
    </div>
</main>
<?php include "footer.php"; ?>
<script>
    const listEl = document.querySelector(".pagination");

    $(document).ready(() => {
        $("#pagination li:first").addClass('active');

        $("#notifs").load("getNotif?page=1", hide_load());

        $("#pagination li").click(function() {
            updateActive(this.id);
            var pageNum = this.id;
            $("#notifs").load("getNotif?page=" + pageNum, hide_load());
        });
    });

    function hide_load() {
        $("#errorshow").fadeOut();
    }

    function updateActive(current) {
        Array.from(listEl.children)
            .forEach((item, idx) => {
                if (current > idx) {
                    removeActive();
                    item.classList.add("active");
                }

            });
    }

    function removeActive() {
        Array.from(listEl.children)
            .forEach(item => {
                item.classList.remove("active");
            });
    }
    
    function markRead(main_id, mem_id){
        let request = "markRead";
        $.ajax({
            url: '../../ops/users',
            type: 'POST',
            data: {
                request: request,
                main_id,
                mem_id
            },
            success: function(data) {
                var response = $.parseJSON(data);
                if(response.status == "success"){
                    toastr.info(response.message);
                }else{
                    toastr.info(response.message);
                }
            },
            error: function(err) {
                toastr.info(err);
            }
        });
    }
</script>