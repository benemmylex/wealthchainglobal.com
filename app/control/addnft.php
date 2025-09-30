<?php include "header.php"; ?>
<title>Add NFTs | <?= SITE_NAME; ?></title>
<main class="my-5 pt-5" id="content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center py-3"> Add Nfts</h4>
                <form class="md-form" id="addnft" enctype="multipart/form-data">
					<div class="form-outline mb-4">
						<i class="fab fa-ethereum trailing"></i>
						<input type="text" id="nftname" name="nftname" class="form-control form-icon-trailing">
						<label for="nftname" class="form-label">NFT Name</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-cubes trailing"></i>
						<input type="text" id="nftprice" name="nftprice" class="form-control form-icon-trailing">
						<label for="nftprice" class="form-label">NFT Price in USD</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-chart-line trailing"></i>
						<input type="text" id="nftstandard" name="nftstandard" class="form-control form-icon-trailing">
						<label for="nftstandard" class="form-label">NFT Standard</label>
					</div>
					<div class="form-group mb-4" id="nfttype">
						<select class="browser-default form-control" name="type" id="type">
							<option disabled selected>--Select Option</option>
							<option value="image">Image</option>
							<option value="video">Video</option>
						</select>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-wallet trailing"></i>
						<input type="text" id="nftaddr" name="nftaddr" class="form-control form-icon-trailing">
						<label for="nftaddr" class="form-label">NFT Address</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fab fa-ethereum trailing"></i>
						<input type="text" id="nftblockchain" name="nftblockchain" class="form-control form-icon-trailing">
						<label for="nftblockchain" class="form-label">NFT Blockchain</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-cube trailing"></i>
						<input type="text" id="nftroi" name="nftroi" class="form-control form-icon-trailing">
						<label for="nftroi" class="form-label">NFT Max ROI</label>
					</div>
					<div class="form-outline mb-4">
						<i class="fas fa-book trailing"></i>
						<textarea class="form-control form-icon-trailing" name="nftdesc" id="nftdesc"></textarea>
						<label for="nftdesc" class="form-label">NFT Desc</label>
					</div>
					<div class="md-form">
						<label class="form-label" for="photo"> Upload Image <span class="fas fa-cloud-upload-alt"></span></label>
						<input type="file" id="photo" class="form-control" name="photo" required="">
					</div>
					<div class="md-form">
						<label class="form-label" for="file"> Upload video file (only when you are upload a video nft) <span class="fas fa-cloud-upload-alt"></span></label>
						<input type="file" id="file" class="form-control" name="file">
					</div>
					<div class="form-group mt-3" align="center">
						<p class="alert" id="errorshow1"></p>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-md btn-primary">Add NFT</button>
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
    
    $("form#addnft").submit(function(e) {
    	if ($("#type") == null) {
    		$('#errorshow1').html("Please select an nft type").show();
    	}else{
		    e.preventDefault();    
		    var formData = new FormData(this);
		    var request = "addNft";
		    formData.append('request', request);
		    $.ajax({
			    url: '../../ops/adminauth',
			    type: 'POST',
			    data: formData,
			    beforeSend:function(){
					$('#errorshow1').html("Adding NFT <span class='fas fa-spinner fa-pulse'></span>").show();
				},
				success: function (data) {
					if (data == "success") {
					    $("#errorshow1").html("New NFT added uccessfully. <span class='fas fa-check-circle'></span>").show();
					    setTimeout(' window.location.reload(); ', 4000);
					}else{
						$("#errorshow1").html("<span class='fas fa-exclamation-triangle'></span> " + data).show();
						setTimeout(function(){
							$("#errorshow1").hide();
						}, 4000);
					}   
				},
				cache: false,
				error:function(err){
					$('#errorshow1').html("<span class='fas fa-exclamation-triangle'></span> An error has occured!!" + err).show();
					setTimeout(function(){
						$("#errorshow1").hide();
					}, 4000);
				},
				contentType: false,
				processData: false
			});
		}
	});
</script>