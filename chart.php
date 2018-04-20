<?php include('inc/head.php'); ?>

<body>

<?php
	include('inc/js_scripts.php');
	include('Facebook/autoload.php');
	include('inc/database.php');

	$page		= $_POST['page'];
	$since 		= $_POST['since'];
	$until 		= $_POST['until'];

	$conn = db();
	foreach($conn->query("SELECT * FROM pages WHERE id = '".$page."' ") as $row) {
		$pageid 	= $row['page_id'];
		$pagetitle 	= $row['title'];
		$pageimg 	= $row['img'];
	}
?>

<div class="w-100 text-center mt">
	<div class="media text-left default-width">
  		<img class="align-self-center mr-3" src="img/<?= $pageimg ?>" alt="Logo" width="90">
  		<div class="media-body">
    		<div class="col-lg-12 text-left">
	    		Relatório de Mídias Sociais
	    		<div class="title">
	    			<?= $pagetitle ?>
	    		</div>
	    		<small class="mt-0 pt-0">
	    			<?= date('d/m/Y', strtotime($since)) ?> à <?= date('d/m/Y', strtotime($until)) ?>
	    		</small>
	    	</div>

    	</div>
	</div>
</div>

<?php include('model/AppModel.php'); ?>

<div class="container text-center">
	<?php
		create_chart('1', 'Impressões', 'page_impressions');
		create_chart('2', 'Alcance', 'page_impressions_unique');
		create_chart('3', 'Consumos', 'page_consumptions');
		create_chart('4', 'Reações & Likes', 'page_actions_post_reactions_like_total');
		create_chart('5', 'Compartilhamentos', 'page_positive_feedback_by_type');
		create_chart('6', 'Comentários', 'page_positive_feedback_by_type');
		create_chart('7', 'Likes na Page', 'page_fan_adds_by_paid_non_paid_unique');

		//file_put_contents('output.php', '</div></body></html>', FILE_APPEND);
	?>
</div>

<script language="javascript" type="text/javascript">
  /* <![CDATA[ */
    document.write('<a href="makepdf.php?url=' + encodeURIComponent(location.href) +'">');
    document.write('Create PDF file of this page');
    document.write('</a>');
  /* ]]> */
</script>

</body>
</html>