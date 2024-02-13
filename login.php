<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    include ('clases/usuario.php');
    
    if ($username == 'Francis' && $password == 'Oscar6') {
        $usuario = new Usuario($username, 'images/fotoperfil.jpeg');
        $_SESSION['usuario'] = serialize($usuario);
        header('Location: indexAdmin.php');
        exit;
    } else {
        echo 'Nombre de usuario o contraseña incorrectos';
        
    }
}
?>

<body>
    <form action="login.php" method="post">
        <label for="username"> Inserte su nombre de usuario:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Iniciar sesión">
    </form>

    <!DOCTYPE html>
	<html lang="en">
		<title> Inicio login</title>


<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

    <!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>zShop</title>
	<meta name="description" content="Free Responsive Html5 Css3 Templates | Zerotheme.com">
	<meta name="author" content="http://www.Zerotheme.com">
	
    <!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <!-- CSS
	================================================== -->
  	<link rel="stylesheet" href="css/zerogrid.css">
	<link rel="stylesheet" href="css/style.css">
	
	<!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	
	<link rel="stylesheet" href="css/menu.css">
	<!-- jQuery Core Javascript -->
	<script src="js/jquery.min.js"></script>
	<script src="js/script.js"></script>
	
	<!-- Owl Stylesheets -->
    <link rel="stylesheet" href="owlcarousel/assets/owl.carousel.min.css">
	
	<!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/Items/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
    <!--[if lt IE 9]>
		<script src="js/html5.js"></script>
		<script src="js/css3-mediaqueries.js"></script>
	<![endif]-->
	
</head>

<body class="home-page">
	<div class="wrap-body">
		
		<header class="main-header">
			<div class="zerogrid">
				<div class="row">
					<div class="col-1-3">
						<a class="site-branding" href="index.html">
							<img src="images/logo.png"/>	
						</a><!-- .site-branding -->
					</div>
					<div class="col-2-3">
						
		<!--////////////////////////////////////Container-->
		<section id="container" class="zerogrid">
			<div class="wrap-container">
				
				<!-----------------content-box-1-------------------->
				<section class="content-box box-1">
					<div class="wrap-box"><!--Start Box-->
						<div id="owl-travel" class="owl-carousel">
							<?php
							
							try{
							//2- montar la consulta 
							$sql="SELECT nombre, imagen from slides";
							$stmt=$con->prepare($sql);
							if	($stmt->execute()){
								while	($fila=$stmt->fetch()){
									echo "<div class='item'>";
									echo "<img src='".$fila['imagen']."'/>";	
									echo "</div>";
								}	
							}
							} catch (PDOException $e){
								die ("Error al mostrar datos");
							} catch (Exception $e){
								die ("Error de acceso");
							}
							?>

							
						</div>
					</div>
				</section>
				
				<!-----------------content-box-2-------------------->
				<section class="content-box box-2">
					<div class="wrap-box"><!--Start Box-->
						<div class="row">
							<?php
						try{
							//2- montar la consulta 
							$sql="SELECT id,nombre, imagen from categorias";
							$stmt=$con->prepare($sql);
							if	($stmt->execute()){
								$stilos=array("col-2-5 box-item","col-3-5 box-item","col-3-5 box-item","col-2-5 box-item","col-1-2 box-item","col-1-2 box-item");
								$cont=0;
								while	($fila=$stmt->fetch()){
									?>
									<div class="<?=$stilos[$cont++]?>">
										<a class="box-item-inner" href="single.html">
											<div class="box-item-image gradient-1" style="background-image: url('<?=$fila['imagen']?>')"></div>
											<h3 class="sub-title"><?=$fila['id']?></h3>
											<div class="box-item-detail">
												<h2 class="title"><strong>#</strong><?=$fila['nombre']?></h2>
												<p><strong>25</strong> Productos</p>
											</div>
										</a>
									</div>
									<?php
								}	
							}
							} catch (PDOException $e){
								die ("Error al mostrar datos");
							} catch (Exception $e){
								die ("Error de acceso");
							}
							?>
							<div class="col-3-5 box-item">
								<a class="box-item-inner" href="single.html">
									<div class="box-item-image gradient-2" style="background-image: url('images/2.jpg')"></div>
									<h3 class="sub-title">02.</h3>
									<div class="box-item-detail">
										<h2 class="title"><strong>#</strong> Blouses</h2>
										<p><strong>13</strong> Products</p>
									</div>
								</a>
							</div>
							<div class="col-3-5 box-item">
								<a class="box-item-inner" href="single.html">
									<div class="box-item-image gradient-3" style="background-image: url('images/3.jpg')"></div>
									<h3 class="sub-title">03.</h3>
									<div class="box-item-detail">
										<h2 class="title"><strong>#</strong> Dresses</h2>
										<p><strong>8</strong> Products</p>
									</div>
								</a>
							</div>
							<div class="col-2-5 box-item">
								<a class="box-item-inner" href="single.html">
									<div class="box-item-image gradient-4" style="background-image: url('images/4.jpg')"></div>
									<h3 class="sub-title">04.</h3>
									<div class="box-item-detail">
										<h2 class="title"><strong>#</strong> Hoodies</h2>
										<p><strong>15</strong> Products</p>
									</div>
								</a>
							</div>
							<div class="col-1-2 box-item">
								<a class="box-item-inner" href="single.html">
									<div class="box-item-image gradient-5" style="background-image: url('images/5.jpg')"></div>
									<h3 class="sub-title">05.</h3>
									<div class="box-item-detail">
										<h2 class="title"><strong>#</strong> Leggings</h2>
										<p><strong>15</strong> Products</p>
									</div>
								</a>
							</div>
							<div class="col-1-2 box-item">
								<a class="box-item-inner" href="single.html">
									<div class="box-item-image gradient-6" style="background-image: url('images/6.jpg')"></div>
									<h3 class="sub-title">06.</h3>
									<div class="box-item-detail">
										<h2 class="title"><strong>#</strong> Sleepwear</h2>
										<p><strong>10</strong> Products</p>
									</div>
								</a>
							</div>
						</div>
					</div>
				</section>
			
				<!-----------------FORMULARIO PARA LA SESIÓN-------------------->


				<div id="formulario1">
			<form method="post">
				Login: <input type="text" name="username" required><br />
				Password: <input type="password" name="" required><br /><br />
				<input type="submit" name="Enviar" value="Enviar">
			</form>
		    </div>
				
				<!-----------------content-box-3-------------------->
				<section class="content-box box-3 box-style-1">
					<div class="row wrap-box"><!--Start Box-->
						<div class="col-1-2">
							<div class="wrap-col">
								<div class="box-text">
									<h1>Travis Johnson</h1>
									<p class="lead">Massive Dynamic has over 10 years of experience in Design. We take pride in delivering Intelligent Designs and Engaging Experiences for clients all over the World. I thrive on problem solving and working with clients to seek out the best possible design solution.</p>
									<a class="button button-skin">Read More</a>
								</div>
							</div>
						</div>
						
					</div>
				</section>
				
				<!-----------------content-box-4-------------------->
				<section class="content-box box-4">
					<div class="row wrap-box"><!--Start Box-->
						<div class="col-full">
							<div class="col-1-4 portfolio-box">
								<a class="" href="#">
									<div class="portfolio-caption">
										<div class="portfolio-image"><img src="images/brand.png"/></div>
										<div class="portfolio-title">Branding Title</div>
									</div>
								</a>
							</div>
							<div class="col-1-4 portfolio-box">
								<a class="" href="#">
									<div class="portfolio-caption">
										<div class="portfolio-image"><img src="images/brand.png"/></div>
										<div class="portfolio-title">Branding Title</div>
									</div>
								</a>
							</div>
							<div class="col-1-4 portfolio-box">
								<a class="" href="#">
									<div class="portfolio-caption">
										<div class="portfolio-image"><img src="images/brand.png"/></div>
										<div class="portfolio-title">Branding Title</div>
									</div>
								</a>
							</div>
							<div class="col-1-4 portfolio-box">
								<a class="" href="#">
									<div class="portfolio-caption">
										<div class="portfolio-image"><img src="images/brand.png"/></div>
										<div class="portfolio-title">Branding Title</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</section>
				
</body>
</html>




