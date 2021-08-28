	
		
				<a  href="index.php">Početna</a>
				<a  href="o_autor.php">O autoru</a>
				<?php if(isset($_SESSION["id"])) {?>

				   <a  href="profil.php">Profil</a> 
				<?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] == 0 || $_SESSION["tip"] == 1) { ?>
					<a  href="planine.php">Planine</a>
                    
				<?php }?>
                <?php if(isset($_SESSION["tip"]) && $_SESSION["tip"] == 0) { ?>
					<a  href="admin.php">Admin</a>
				<?php }?>
			<?php } ?>
			<?php if(!isset($_SESSION["id"])) { ?>
				<a href="prijava.php">Prijava</a>
				<?php }else{ ?>
				<a href="prijava.php?odjava=1">Odjava</a>
			<?php } ?>



