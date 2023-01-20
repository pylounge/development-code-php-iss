<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список товаров</title>
	 <?php include_once 'display.php'; ?>
    <!-- <link rel="stylesheet" href="./css/style.css"> -->
	<style>
		h1 {
			text-align: center;
		}
		.container{
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			margin: 5px;
		}
		img{
			max-width: 150px;
			height: auto;
		}
		.item{
			max-width:800px;
		}
	</style>
  </head>
  <body>
    <header>
      <h1>Список товаров</h1>
    </header>
    <main>
		<div class="container">
			<?php 
				$products = getAllProducts();
				foreach($products as $item) {
					echo '<div class="item">';
					echo '<h3>'.$item['title'].'</h3>';
					echo '<p>'.$item['description'].'</p>';
					echo '<p><b>Цена:</b>'.$item['price'].'</p>';
					echo '<img src="'.$item['img'].'"/>';
					echo '</div>';
					echo '<hr>';
				}
			?>
		</div>
		</form>
    </main>
  </body>
</html>

<!-- http://localhost/development-code/display/index.php -->