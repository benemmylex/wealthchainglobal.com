<?php include "header.php"; ?>
<title>Claim bonus</title>
<main class="py-5 mt-5" id="content">
    <div class="container pt-5">
        <h4 class="text-center fw-bold mb-3">Claim Bonus</h4>
        <div class="border-bottom py-3">
                <div class="me-auto ms-auto" align="center">
                    <img src="../../assets/images/bonus.png" loading="lazy" class="img-fluid" width="140">
                </div>
                <div>
                    <h4 class="fw-bold">Claim Bonus</h4>
                    <p class="">Claim bonus for APR up to <span class="text-success">5%</span></p>
                </div>
                <?php
                    $mem_id = $_SESSION['mem_id'];
                    $stat = 0;
		            $set = $db_conn->prepare("SELECT * FROM dtdbonus WHERE mem_id = :mem_id AND status = :status");
		            $set->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
		            $set->bindParam(":status", $stat, PDO::PARAM_STR);
		            $set->execute();
		            if($set->rowCount() > 0){
		                $row = $set->fetch(PDO::FETCH_ASSOC);
		        ?>
                <div align="center">
                    <p>You have received <b><?= $_SESSION['symbol']; ?><?= number_format($row['amount'], 2)." worth of ".ucfirst($row['asset']); ?></b> </p>
                    <p class="alert text-start" id="errorshow"></p>
                    <button class="btn btn-md btn-outline-primary" id="dtdBtn" onclick="claimdtd('<?= $row['main_id']; ?>', '<?= $row['mem_id']; ?>', '<?= $row['amount']; ?>')">Claim Bonus</button>
                </div>
                <!-- Modal -->
    			<div class="modal fade" id="dtdModal" tabindex="-1" aria-labelledby="dtdModal" aria-hidden="true">
    			    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    			        <div class="modal-content text-center">
    			        	<div class="modal-header justify-content-center">
    						    <h3 class="fw-bold"><span class="fas fa-exclamation-circle"></span> information</h3>
    						    <button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'></button>
    						</div>
    						<div class="modal-body py-4">
    							<p class="alert alert-primary" id="errorComm"></p>
    							<div id="message">
    							    <p class="fw-bold text-center">Select an option</p>
    							    <div class="mt-2">
    								    <a href='./chart' class='btn btn-rounded btn-md btn-outline-warning'>Re-invest</a>
    								    <a href='./withdrawal' class='btn btn-rounded btn-md btn-outline-success'>Withdraw</a>
    								</div>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    			<!--Modal: process-->
                <?php }else{ ?>
                <p class='text-center fw-bolder'>You do not have any bonus to claim</p>
                <?php } ?>
                <div class="card border border-1 border-primary mt-3">
                    <div class="card-header py-3">
                        <h5 class="fw-bold text-uppercase text-center">Claim History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            <table class="table align-middle hoverable table-striped table-hover" id="claimTable">
                                <thead class="">
                                    <tr class="text-nowrap">
                                        <th scope="col" class="">S/N</th>
                                        <th scope="col" class="">Date</th>
                                        <th scope="col" class="">Asset</th>
                                        <th scope="col" class="">Amount</th>
                                        <th scope="col" class="">Status</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql2 = $db_conn->prepare("SELECT * FROM dtdbonus WHERE mem_id = :mem_id ORDER BY main_id DESC");
                                $sql2->bindParam(':mem_id', $mem_id, PDO::PARAM_STR);
                                $sql2->execute();
                                $r = 1;
                                ?>
                                <tbody>
                                    <?php
                                    if ($sql2->rowCount() < 1) { ?>
                                        <tr>
                                            <td class='text-center' colspan='7'>No history available to show</td>
                                        </tr>
                                        <?php } else {
                                        while ($row2 = $sql2->fetch(PDO::FETCH_ASSOC)) :
                                        ?>
                                            <tr class="text-nowrap">
                                                <td class="text-start"><?= $r; ?></td>
                                                <td class="text-start"><?= $row2['date_added']; ?></td>
                                                <td class="text-start"><?= $row2['asset']; ?></td>
                                                <td class="text-start"><?= $_SESSION['symbol'] . number_format($row2['amount'], 2); ?></td>
                                                <td class="text-start">
                                                    <?php if ($row2['status'] == 1) {
                                                        echo "<span class='text-success'>Claimed</span>";
                                                    } elseif ($row2['status'] == 0) {
                                                        echo "<span class='text-warning'>Pending</span>";
                                                    } ?>
                                                </td>
                                        <?php $r++;
                                        endwhile;
                                    } ?>
                                            </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</main>
<?php include "footer.php"; ?>
<script>
	$(document).ready(function(){
	    $("#errorshow").hide();
	    
	});
	
	<?php if ($sql2->rowCount() > 0) { ?>
        var two = $('#claimTable').DataTable({
            "pagingType": 'simple_numbers',
            "lengthChange": true,
            "pageLength": 10,
            dom: 'Bfrtip'
        });
    <?php } ?>
	
	function claimdtd(main_id, mem_id, amount) {
	    $.ajax({
		    url: '../../ops/users',
		    type: 'POST',
		    data: {request: 'claimdtd', mem_id, amount, main_id},
		    beforeSend:function(){
				$('#errorshow').html("Claiming bonus, Please wait <span class='fas fa-spinner fa-spin'></span>").show();
			},
			success: function (data) {
			    var resp = $.parseJSON(data);
			    if(resp.status == "success"){
			        $("#errorComm").html(resp.message).show();
			        $("#dtdBtn").prop('disabled', true);
			        $('#dtdModal').modal('show');
			    }else{
			        $("#errorshow").html(resp.message).show();
			    }
			},
			error:function(){
				$('#errorshow').html("<span class='fas fa-exclamation-triangle'></span> An error has occured!!").show();
			}
		});
	}
</script>