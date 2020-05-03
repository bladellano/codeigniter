	<!-- Header -->
	<header>
		<div class="container">
			<div class="slider-container">
				<div class="intro-text">
					<div class="intro-lead-in">Aprenda com profissionais qualificados</div>
					<div class="intro-heading">ALFAHELIX TREINAMENTOS</div>
					<a href="#about" class="page-scroll btn btn-xl">CONHEÇA NOSSOS CURSOS</a>
				</div>
			</div>
		</div>
	</header>
	<section id="about" class="light-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="section-title">
						<h2>SOBRE</h2>
						<p>A creative agency based on Candy Land, ready to boost your business with some beautifull templates. Lattes Agency is one of the best in town see more you will be amazed.</p>
					</div>
				</div>
			</div>

		</div>
		<!-- /.container -->
	</section>

	<section class="overlay-dark bg-img1 dark-bg short-section">
		<div class="container text-center">
			<div class="row">
				<div class="col-md-offset-3 col-md-3 mb-sm-30">
					<div class="counter-item">

						<a class="page-scroll" href="#courses">
							<h6>Cursos</h6>
						</a>
					</div>
				</div>

				<div class="col-md-3 mb-sm-30">
					<div class="counter-item">

						<a class="page-scroll" href="#team">
							<h6>Equipe</h6>
						</a>
					</div>
				</div>

			</div>
		</div>
	</section>
	<section id="courses" class="light-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="section-title">
						<h2>CURSOS</h2>
						<p>Conheça nossa lista de cursos.</p>
					</div>
				</div>
			</div>
			<div class="row">
			<?php if (!empty($courses)):
			  foreach ($courses as $course):
					?>
					<!-- start portfolio item -->
					<div class="col-md-4">
						<div class="ot-portfolio-item">
							<figure class="effect-bubba">
								<img src="<?php echo base_url().$course["course_img"] ?>" alt="img02" class="img-responsive center" />
								<figcaption>
									
									<a href="#" data-toggle="modal" data-target="#course_<?=$course["course_id"]?>">View more</a>
								</figcaption>
							</figure>
						</div>
					</div>
					<!-- Modal dos Cursos -->
					<div class="modal fade" id="course_<?=$course["course_id"]?>" tabindex="-1" role="dialog" aria-labelledby="Modal-label-1">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								
						    	<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="Modal-label-1"><?=$course["course_name"]?></h4>
								</div>

								<div class="modal-body">
									<img src="<?php echo base_url().$course["course_img"]?>" alt="img01" class="img-responsive center" />
									<div class="modal-works"><span>Duração: <?= intval($course["course_duration"]) ?> (h)</span>
									</div>
									<p><?=$course["course_description"]?></p>
								</div>
								
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>

			    <?php endforeach;
				endif;
				?>
			</div><!--row-->		
		
		</div><!-- end container -->
	</section>

	<section id="team" class="light-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="section-title">
						<h2>NOSSA EQUIPE</h2>
						<p>Conheça nossa equipe.</p>
					</div>
				</div>
			</div>


			<div class="row">



			<?php if (!empty($members)):
			  foreach ($members as $member): ?>
				<!-- team member item -->
				<div class="col-md-3">
					<div class="team-item">
						<div class="team-image">
							<img src="<?php echo base_url().$member["member_photo"]?>" class="img-responsive" alt="author">
						</div>
						<div class="team-text">
							<h3><?=$member["member_name"]?></h3>
							<!-- <div class="team-location">Sydney, Australia</div> -->
							<!-- <div class="team-position">– CEO & Web Design –</div> -->
							<p><?=$member["member_description"]?></p>
						</div>
					</div>
				</div>
				<?php

				endforeach;
				endif;
				?>
			</div><!--row-->
		</div>
	</section>
	<section id="contact">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<div class="section-title">
						<h2>CONTATO<h2>
								<p>Entre em contato conosco por aqui.<br>Tentaremos responder o mais rápido possível.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<h3>Our Business Office</h3>
					<p>3422 Street, Barcelona 432, Spain, New Building North, 15th Floor</p>
					<p><i class="fa fa-phone"></i> +101 377 655 22125</p>
					<p><i class="fa fa-envelope"></i> mail@yourcompany.com</p>
				</div>
				<div class="col-md-3">
					<h3>Business Hours</h3>
					<p><i class="fa fa-clock-o"></i> <span class="day">Weekdays:</span><span>9am to 8pm</span></p>
					<p><i class="fa fa-clock-o"></i> <span class="day">Saturday:</span><span>9am to 2pm</span></p>
					<p><i class="fa fa-clock-o"></i> <span class="day">Sunday:</span><span>Closed</span></p>
				</div>
				<div class="col-md-6">
					<form name="sentMessage" id="contactForm" novalidate="">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Your Name *" id="name" required="" data-validation-required-message="Please enter your name.">
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="email" class="form-control" placeholder="Your Email *" id="email" required="" data-validation-required-message="Please enter your email address.">
									<p class="help-block text-danger"></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<textarea class="form-control" placeholder="Your Message *" id="message" required="" data-validation-required-message="Please enter a message."></textarea>
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="row">
							<div class="col-lg-12 text-center">
								<div id="success"></div>
								<button type="submit" class="btn">Send Message</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<p id="back-top">
		<a href="#top"><i class="fa fa-angle-up"></i></a>
	</p>