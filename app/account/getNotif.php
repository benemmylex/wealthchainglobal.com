<?php
include("../../ops/connect.php");
$per_page = 10;
if ($_GET) {
    $page = $_GET['page'];
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
$start = ($page - 1) * $per_page;
$mem_id = $_SESSION['mem_id'];
$getN = $db_conn->prepare("SELECT * FROM notifications WHERE mem_id = :mem_id ORDER BY main_id DESC LIMIT $start, $per_page");
$getN->bindParam(":mem_id", $mem_id, PDO::PARAM_STR);
$getN->execute();

?>

<?php
while ($row = $getN->fetch(PDO::FETCH_ASSOC)) :
?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6 class="<?= $row['status'] == 0 ? 'fw-bold' : ''; ?> text-start"><?= strtoupper($row['title']); ?></h6>
            <p class="<?= $row['status'] == 0 ? 'fw-bold' : ''; ?> small"><?= $row['message']; ?> </p>
        </div>
        <div>
            <span onclick="markRead('<?= $row['main_id']; ?>', '<?= $row['mem_id']; ?>')" style="cursor:pointer;" class="fas fa-check-circle text-success"></span>
        </div>
    </div>
<?php
endwhile;
?>