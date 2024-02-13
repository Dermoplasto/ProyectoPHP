<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

include ('clases/usuario.php');
$usuarioObj = unserialize($_SESSION['usuario']);


include 'config.php';
try{
    $con = new PDO($dsn,$usuario,$contrasena);
} catch (PDOException $e){

}

try {
    $sql = "SELECT * FROM productos ORDER BY fecalta DESC LIMIT 4";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los productos: " . $e->getMessage());
}


?>

<!DOCTYPE html>
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
						<a class="site-branding" href="indexAdmin.php">
							<img src="images/nh.jpg"/>	
						</a><!-- .site-branding -->
					</div>
					<div class="col-2-3">
						<!-- Menu-main -->
						<div id='cssmenu' class="align-right">
							<ul>
								<!-- Linkis del back -->							   
								
							   <li class="active"><a href='index.html'><span>Inicio</span></a></li>
							   <li><a href='slides.php'><span>Formulario Slides</span></a></li>
							   <li ><a href='categorias.php'><span>Mantenimiento de categorias</span></a></li>
							   <li ><a href='productos.php'><span>Mantenimiento de productos</span></a></li>
							   <li ><a href='salir.php'><span>Cerrar sesión</span></a></li>
                     
                           
							</ul>
						</div>
					</div>
				</div>
			</div>

			<?php echo "te has identificado como " . $usuarioObj->nombre;
            echo '<img src="' . $usuarioObj->imagen . '" width="50" height="50">';	
			?>
		
		</header>
		
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
							
						</div>
					</div>
				</section>
				
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
				
				<!-----------------content-box-5-------------------->
				<section class="content-box box-5 box-style-3">
					<div class="row wrap-box"><!--Start Box-->
						<div class="col-full">
							<div class="box-text">
								<div class="heading">
									<h2>Contact Me</h2>
									<span class="intro">Get subscriber only insights & news delivered by John Doe</span>
								</div>
								<div class="content">
									<p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming<br> id quod mazim placerat facer possim assum. </p>
									<div class="subscribe-form">
										<form name="form1" id="subs_form" method="post" action="contact.php">
											<label class="row">
												<div class="col-2-3">
													<div class="wrap-col">
														<input type="text" name="name" id="name" placeholder="Enter Your Email" required="required" />
													</div>
												</div>
												<div class="col-1-3">
													<div class="wrap-col">
														<input class="button button-skin button-subscribe" type="submit" name="Submit" value="Subscribe">
													</div>
												</div>
											</label>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</section>


	
		
		<!--////////////////////////////////////Footer-->
		<footer>
			<div class="zerogrid">
				<div class="wrap-footer">
					<div class="row">
						<div class="col-1-3 col-footer-1">
							<div class="wrap-col">
							<h3 class="widget-title">¿Quienes somos?</h3>
								<p>Somos una empresa estadounidense con más de 9.000 empleados y tenemos presencia en una gran diversidad de paises de Amercia y recientemente estamos expandiendonos en España, tenemos gran experiencia en el sector con cerca de 15 años de experiencia y formamos parte de uno de las mayores empresas en wargames del globo</p>
							</div>
						</div>
						<div class="col-1-3 col-footer-2">
							<div class="wrap-col">
								<h3 class="widget-title"><h3>Últimos articulos</h3>
								<ul>
									
								
								<!--Últimos articulos-->			

								
                                 <?php foreach ($productos as $producto): ?>
                                 <div>
                                 <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                                 <p><?= htmlspecialchars($producto['detalle']) ?></p>
                                 <p>Precio: <?= htmlspecialchars($producto['precio']) ?></p>
                                 </div>
                                 <?php endforeach; ?>
							
								</ul>
							</div>
						</div>
						<div class="col-1-3 col-footer-3">
							<div class="wrap-col">
								<h3 class="widget-title">¿Donde encontrarnos?</h3>
								<div class="row">
									<address>
										<strong>Madrid</strong>
										<br>
										Barcelona
										<br>
										Valencia
										<br>
										Murcia
									</address><br>
									<p>
										<strong>Nuestros horarios de apetura:</strong>
										<br>
										Lunes a Viernes: 9:00 - 21:00
										<br>
										Sabados, Domingos y festivos: 9:00 - 2:00
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="bottom-footer">
					<div class="bottom-social">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-instagram"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-google-plus"></i></a>
						<a href="#"><i class="fa fa-pinterest"></i></a>
						<a href="#"><i class="fa fa-vimeo"></i></a>
						<a href="#"><i class="fa fa-linkedin"></i></a>
						<a href="#"><i class="fa fa-youtube"></i></a>
					</div>
					<div class="copyright">
						Copyright @ - Designed by <a href="https://www.zerotheme.com">ZEROTHEME</a>
					</div>
				</div>
			</div>
		</footer>
		
	</div>
	
	
	<!-- Owl Carusel JavaScript -->
	<script src="owlcarousel/owl.carousel.js"></script>
	<script>
	$(document).ready(function() {
	  $("#owl-travel").owlCarousel({
		autoplay:true,
		autoplayTimeout:3000,
		loop:true,
		items : 1,
		nav:true,
		navText: ['<i class="fa fa-chevron-left fa-2x"></i>', '<i class="fa fa-chevron-right fa-2x"></i>'],
		pagination:false
	  });
	});
	</script>
	
</body>
</html>