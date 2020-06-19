<style>
    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }
</style>
<?php
$query = "select * from posts";
$result = mysqli_query($con, $query);
// Toplam gönderi sayisi
$total_posts = mysqli_num_rows($result);
//Toplam sayfa sayısını bulma
$total_pages = ceil($total_posts / $per_page);
//İlk sayfaya gitme
echo "
	<center>
	<div class='pagination'>
	<a href='home.php?sayfa=1'>İlk Sayfa</a>
	";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='home.php?sayfa=$i'>$i</a>";
}
//Son sayfaya gitme
echo "<a href='home.php?sayfa=$total_pages'>Son Sayfa</a></center></div>";

?>