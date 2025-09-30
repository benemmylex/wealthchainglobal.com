<?php include "header.php"; 
if (isset($_GET['nftid'])) {
	$nftid = $_GET['nftid'];
}else{
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

$getNft = $db_conn->prepare("SELECT * FROM nfts WHERE nftid = :nftid");
$getNft->bindParam(":nftid", $nftid, PDO::PARAM_STR);
$getNft->execute();
$row = $getNft->fetch(PDO::FETCH_ASSOC);
if ($getNft->rowCount() < 1) { 
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}
?>
<title>Edit NFTs | <?= SITE_NAME; ?></title>
<main class="my-5 pt-5" id="content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center py-3"> Edit Nfts</h4>
                <form class="md-form" id="editnft" enctype="multipart/form-data">
					<div class="form-outline mb-4">
						<i class="fab fa-ethereum trailing"></i>
						<input type="text" id="nftname" value="<?=  $row['nftname'] ?>" name="nftname" class="form-control form-icon-trailing">
						<label for="nftname" class="form-label">NFT Name</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-cubes trailing"></i>
						<input type="text" id="nftprice" value="<?=  $row['nftprice'] ?>" name="nftprice" class="form-control form-icon-trailing">
						<label for="nftprice" class="form-label">NFT Price in USD</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-chart-line trailing"></i>
						<input type="text" id="nftstandard" value="<?=  $row['nftstandard'] ?>" name="nftstandard" class="form-control form-icon-trailing">
						<label for="nftstandard" class="form-label">NFT Standard</label>
					</div>
					<div class="form-group mb-4" id="nfttype">
						<select class="browser-default form-control" name="type" id="type">
							<option disabled selected>--Select Option</option>
							<option value="image" <?= $row['nfttype'] == "image" ? "selected" : "" ?>>Image</option>
							<option value="video" <?= $row['nfttype'] == "video" ? "selected" : "" ?>>Video</option>
						</select>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-wallet trailing"></i>
						<input type="text" id="nftaddr" value="<?=  $row['nftaddr'] ?>" name="nftaddr" class="form-control form-icon-trailing">
						<label for="nftaddr" class="form-label">NFT Address</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fab fa-ethereum trailing"></i>
						<input type="text" id="nftblockchain" value="<?=  $row['nftblockchain'] ?>" name="nftblockchain" class="form-control form-icon-trailing">
						<label for="nftblockchain" class="form-label">NFT Blockchain</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-cube trailing"></i>
						<input type="text" id="nftroi" value="<?=  $row['nftroi'] ?>" name="nftroi" class="form-control form-icon-trailing">
						<label for="nftroi" class="form-label">NFT Max ROI</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-book trailing"></i>
						<textarea class="form-control form-icon-trailing" name="nftdesc" id="nftdesc"><?= $row['nftdesc'] ?></textarea>
						<label for="nftdesc" class="form-label">NFT Desc</label>
					</div>
					<div class="md-form">
						<label class="form-label" for="photo"> Upload Image <span class="fas fa-cloud-upload-alt"></span></label>
						<input type="file" id="photo" class="form-control" name="photo">
					</div>
					<div class="md-form">
						<label class="form-label" for="file"> Upload video file (only when you are upload a video nft) <span class="fas fa-cloud-upload-alt"></span></label>
						<input type="file" id="file" class="form-control" name="file">
					</div>
					<div class="form-group mt-3" align="center">
						<p class="alert" id="errorshow1"></p>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-md btn-primary">Edit NFT</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</main>
<?php include "footer.php"; ?>
<script>
    $(document).ready(function(){
  		$("#errorshow1").hide();
   	});

    $("form#editnft").submit(function(e) {
    	if ($("#type") == null) {
    		$('#errorshow1').html("Please select an nft type").show();
    	}else{
		    e.preventDefault();    
		    var formData = new FormData(this);
		    var request = "editNft";
		    formData.append('request', request);
		    formData.append('photos', "<?= $row['nftimage'] ?>");
		    formData.append('files', "<?= $row['nftfile'] ?>");
		    formData.append('nftid', "<?= $row['nftid'] ?>");
		    $.ajax({
			    url: '../../ops/adminauth',
			    type: 'POST',
			    data: formData,
			    beforeSend:function(){
					$('#errorshow1').html("Updating NFT <span class='fas fa-spinner fa-pulse'></span>").show();
				},
				success: function (data) {
					if (data == "success") {
					    $("#errorshow1").html("NFT Updated successfully. <span class='fas fa-check-circle'></span>").show();
					    setTimeout(' window.location.reload(); ', 4000);
					}else{
						$("#errorshow1").html("<span class='fas fa-exclamation-triangle'></span> " + data).show();
					}   
				},
				cache: false,
				error:function(err){
					$('#errorshow1').html("<span class='fas fa-exclamation-triangle'></span> An error has occured!!" + err).show();
				},
				contentType: false,
				processData: false
			});
		}
	});
</script>