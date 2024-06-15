<?php

include_once 'includes/classes.php';

$database = new Database();
$horarios = new Horarios();
$reservas = new Reservas();
$servicios = new Servicios();
$token = new Token();

$tokenGenerado = $token->GenerateToken();

Discord::SendWebhook("Nuevo Ingreso a la Web de Barber Duck", "IP: `" . IP::GetIP() . "` (`" . IP::GetLocationFromIP(IP::GetIP()) . "`) ");
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<base href="" />
	<title>Barber Duck - Reserva tu cita en nuestra barbería</title>
	<meta charset="utf-8" />
	<meta name="description" content="Reserva tu turno en Barber Duck, la mejor barbería de Montevideo. Contamos con una amplia variedad de servicios para satisfacer todas tus necesidades." />
	<meta name="keywords" content="Barber Duck, reserva, cita, barbería, servicios, peluquería, cuidado personal, barbero, estilista, afeitado, grooming" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="copyright" content='Barber Duck'>
	<meta name="url" content="https://afagundez.shop">
	<meta name="identifier-URL" content="https://afagundez.shop">
	<meta name="rating" content="General">
	<meta property="og:locale" content="es_ES" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="Barber Duck - Reserva tu cita en nuestra barbería" />
	<meta property="og:url" content="https://afagundez.shop" />
	<meta property="og:site_name" content="Barber Duck" />
	<meta name="og:description" content='Reserva tu turno en Barber Duck, la mejor barbería de Montevideo. Contamos con una amplia variedad de servicios para satisfacer todas tus necesidades.'>
	<meta name="apple-mobile-web-app-title" content="Barber Duck">
	<meta name="theme-color" content="#000000">
	<meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
	<meta name="author" content="Barber Duck">
	<meta name="publisher" content="Barber Duck">
	<meta name="format-detection" content="telephone=no">
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="Barber Duck - Reserva tu cita en nuestra barbería" />
	<meta name="twitter:description" content="Reserva tu cita en Barber Duck, la mejor barbería de la ciudad. Contamos con una amplia variedad de servicios para satisfacer todas tus necesidades." />
	<meta name="twitter:image" content="https://afagundez.shop/assets/media/logos/barbershop.png" />
	<meta name="twitter:url" content="https://afagundez.shop" />
	<meta name="twitter:site" content="@Barber Duck" />
	<meta name="twitter:creator" content="@Barber Duck" />
	<meta name="twitter:domain" content="Barber Duck.shop" />
	<meta name="twitter:label1" content="Reserva tu cita en Barber Duck" />
	<meta name="twitter:data1" content="Reserva tu cita en Barber Duck, la mejor barbería de la ciudad. Contamos con una amplia variedad de servicios para satisfacer todas tus necesidades." />
	<link rel="canonical" href="https://afagundez.shop" />
	<link rel="img_src" href="https://afagundez.shop/assets/media/logos/barbershop.png" />
	<link rel="shortcut icon" href="assets/media/logos/barbershop.png" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body id="kt_body" data-kt-app-header-stacked="true" data-kt-app-header-primary-enabled="true" data-kt-app-header-secondary-enabled="false" data-kt-app-toolbar-enabled="false" class="app-default">
	<script>
		var modoTemaPorDefecto = "light";
		var modoTema = document.documentElement?.getAttribute("data-bs-theme-mode") || localStorage.getItem("data-bs-theme") || modoTemaPorDefecto;
		if (modoTema === "system") {
			modoTema = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
		}
		document.documentElement.setAttribute("data-bs-theme", modoTema);
	</script>
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<div id="kt_app_header" class="app-header">
				<div class="app-header-primary" data-kt-sticky="true" data-kt-sticky-name="app-header-primary-sticky" data-kt-sticky-offset="{default: 'false', lg: '300px'}">
					<div class="app-container container-xxl d-flex align-items-stretch justify-content-between">
						<div class="d-flex flex-grow-1 flex-lg-grow-0">
							<div class="d-flex align-items-center me-7" id="kt_app_header_logo_wrapper">
								<a title="Barber Duck" class="d-flex align-items-center me-lg-20 me-5">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-20px h-lg-25px theme-light-show d-none d-sm-inline icon icon-tabler icon-tabler-scissors" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<path d="M6 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
										<path d="M6 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
										<path d="M8.6 8.6l10.4 10.4"></path>
										<path d="M8.6 15.4l10.4 -10.4"></path>
									</svg>
									<svg xmlns="http://www.w3.org/2000/svg" class="h-20px h-lg-25px theme-dark-show d-none d-sm-inline icon icon-tabler icon-tabler-scissors" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<path d="M6 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
										<path d="M6 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
										<path d="M8.6 8.6l10.4 10.4"></path>
										<path d="M8.6 15.4l10.4 -10.4"></path>
									</svg>
									<span class="mt-1 ms-2 fw-bolder fs-3">Barber Duck</span>
								</a>
							</div>
						</div>
						<div class="app-navbar flex-shrink-0">
							<div class="app-navbar-item ms-1 ms-md-3">
								<a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-p…" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<i class="ki-duotone ki-night-day theme-light-show fs-2 fs-lg-1">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
										<span class="path5"></span>
										<span class="path6"></span>
										<span class="path7"></span>
										<span class="path8"></span>
										<span class="path9"></span>
										<span class="path10"></span>
									</i>
									<i class="ki-duotone ki-moon theme-dark-show fs-2 fs-lg-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</a>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
											<span class="menu-icon" data-kt-element="icon">
												<i class="ki-duotone ki-night-day fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
													<span class="path5"></span>
													<span class="path6"></span>
													<span class="path7"></span>
													<span class="path8"></span>
													<span class="path9"></span>
													<span class="path10"></span>
												</i>
											</span>
											<span class="menu-title">Tema claro</span>
										</a>
									</div>
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
											<span class="menu-icon" data-kt-element="icon">
												<i class="ki-duotone ki-moon fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
											<span class="menu-title">Tema oscuro</span>
										</a>
									</div>
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
											<span class="menu-icon" data-kt-element="icon">
												<i class="ki-duotone ki-screen fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
												</i>
											</span>
											<span class="menu-title">Según tu sistema</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				<div class="app-container container-xxl d-flex flex-row flex-column-fluid">
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<div class="d-flex flex-column flex-column-fluid">
							<div id="kt_app_toolbar" class="app-toolbar d-flex flex-stack py-4 py-lg-8">
								<div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Crea tu reserva</h1>
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-6 my-0 pt-1">
											<li class="breadcrumb-item text-muted">
												<a class="text-muted text-hover-primary">Rellena el siguiente formulario con los datos necesarios para crear tu orden</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div class="card">
									<div class="card-body">
										<div class="card-px text-center pt-15 pb-15">
											<span id="typed_titulo" class="fs-2x fw-bold mb-0"></span> <br> <br>
											<span id="typed_subtitulo" class="text-gray-600 fs-4 fw-semibold py-7"></span> <br> <br>
											<a href="#" class="btn btn-sm btn-light-twitter me-5" data-bs-toggle="modal" data-bs-target="#kt_modal_create_api_key"> Comenzar </a>
										</div>
										<div class="text-center px-5">
											<img src="assets/media/form-img.webp" alt="Imagen de formulario" class="mw-100 h-sm-400px">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="py-4 d-flex flex-lg-column py-6" id="kt_footer">
							<div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
								<div class="text-dark order-2 order-md-1">
									<span class="text-muted fw-semibold me-1">
										2024©
									</span>
									<a href="index" title="Inicio" target="_blank" class="text-gray-800 text-hover-primary">Barber Duck</a>
								</div>
								<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1 align-items-center mb-3 mb-md-0">
									<li class="menu-item">
										<a href="index" target="_blank" class="menu-link px-3">
											<img alt="Barber Duck Website" src="assets/media/svg/brand-logos/dribbble-2.svg" style="filter: brightness(0.35); " class="w-20px">
										</a>
									</li>
									<li class="menu-item">
										<a href="https://www.instagram.com/barber_duck13/" title="Instagram" target="_blank" class="menu-link px-3">
											<img alt="Barber Duck Instagram" src="assets/media/svg/brand-logos/instagram-2-1.svg" class="w-20px">
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<i class="ki-outline ki-arrow-up"></i>
	</div>
	<div class="modal fade" id="kt_modal_create_api_key" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered mw-650px">
			<div class="modal-content">
				<div class="modal-header pb-0 border-0 justify-content-end">
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-outline ki-cross fs-1"></i>
					</div>
				</div>
				<form class="form" action="./api/procesar" method="post" id="kt_modal_create_api_key_form">
					<div class="modal-body py-10 px-lg-17">
						<div class="mb-13 text-center">
							<h1 class="mb-3">Detalles de tu reserva</h1>
							<div class="text-muted fw-semibold fs-5">Por favor, rellena los siguientes campos para crear tu orden. </div>
						</div>
						<div class="fw-semibold text-gray-800 text-hover-primary fs-5 mb-7">Información de contacto</div>
						<div class="scroll-y me-n7 pe-7" id="kt_modal_create_api_key_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_create_api_key_header" data-kt-scroll-wrappers="#kt_modal_create_api_key_scroll" data-kt-scroll-offset="300px">
							<div class="row mb-5">
								<div class="col-md-6 fv-row fv-plugins-icon-container">
									<label class="required fs-5 fw-semibold mb-2">Nombre</label>
									<input type="text" class="form-control form-control-solid" placeholder="Ingrese su nombre" name="nombre" required>
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
								<div class="col-md-6 fv-row fv-plugins-icon-container">
									<label class="required fs-5 fw-semibold mb-2">Apellido</label>
									<input type="text" class="form-control form-control-solid" placeholder="Ingrese su apellido" name="apellido" required>
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
							</div>
							<div class="fv-row mb-7">
								<label class="fs-6 fw-bold mb-2">
									<span class="required">Email</span>
									<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Se enviará la confirmación por mail."></i>
								</label>
								<input type="email" class="form-control form-control-solid" placeholder="Ingrese su correo electrónico" name="correo" id="correo" required />
							</div>
							<div class="fv-row mb-7">
								<label class="fs-6 fw-bold mb-2">
									<span class="required">Teléfono</span>
									<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Se usará como medio de contacto."></i>
								</label>
								<input type="tel" class="form-control form-control-solid" placeholder="Ingrese su número de teléfono" name="telefono" id="telefono" maxlength="9" required onkeypress="return validarNumero(event)">
							</div>
							<div class="separator d-flex flex-center mb-8">
								<span class="text-uppercase bg-body fs-7 fw-semibold text-muted px-3"></span>
							</div>
							<div class="fw-semibold text-gray-800 text-hover-primary fs-5 mb-7">Información de la reserva</div>
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="fs-6 fw-bold mb-2">Elija su día <span class="required text-gray-600 fs-7"></label>
								<p class="text-gray-600 fs-7 mb-2">Nota: Los días anteriores a hoy serán programados para la próxima semana.</p>
								<div class="input-group input-group-solid">
									<span class="input-group-text"><i class="bi bi-calendar3 fs-4"></i></span>
									<div class="flex-grow-1">
										<select class="form-select form-select-solid rounded-start-0 border-start" data-hide-search="true" data-control="select2" id="dia" name="dia" data-placeholder="Seleccione un día" data-url="./api/horarios-disponibles" required>
											<option value=""></option>
											<option value="Lunes">Lunes</option>
											<option value="Martes">Martes</option>
											<option value="Miercoles">Miércoles</option>
											<option value="Jueves">Jueves</option>
											<option value="Viernes">Viernes</option>
											<option value="Sabado">Sábado</option>
										</select>
									</div>
								</div>
							</div>
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="required fs-6 fw-bold mb-2">Elija su horario</label>
								<div class="input-group input-group-solid">
									<span class="input-group-text"><i class="bi bi-alarm fs-4"></i></span>
									<div class="flex-grow-1">
										<select class="form-select form-select-solid rounded-start-0 border-start" id="horario" name="horario" data-hide-search="true" data-control="select2" data-placeholder="Seleccione un horario" required>
										</select>
									</div>
								</div>
							</div>
							<?php
							$servicios = Servicios::GetServicios();
							$serviciosHtml = '';
							foreach ($servicios as $servicio) {
								$serviciosHtml .= '<option value="' . $servicio['id_servicio'] . '" ' . ($servicio['checked'] === 1 ? 'selected' : '') . '>' . $servicio['nombre_servicio'] . ' ($' . $servicio['precio'] . ')</option>';
							}
							?>
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="required fs-6 fw-bold mb-2">Elija su servicio</label>
								<div class="input-group input-group-solid">
									<span class="input-group-text"><i class="bi bi-scissors fs-4"></i></span>
									<div class="flex-grow-1">
										<select class="form-select form-select-solid rounded-start-0 border-start" data-hide-search="true" data-control="select2" data-placeholder="Seleccione el servicio" id="servicio" name="servicio">
											<option></option>
											<?php echo $serviciosHtml; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="required fs-6 fw-bold mb-2">Método de pago</label>
								<div class="input-group input-group-solid">
									<span class="input-group-text"><i class="bi bi-credit-card fs-4"></i></span>
									<div class="flex-grow-1">
										<select id="metodo_pago" name="metodo_pago" class="form-select form-select-solid rounded-start-0 border-start" data-hide-search="true" data-control="select2" data-placeholder="Seleccione un metodo de pago" required>
											<option></option>
											<option value="Efectivo">Efectivo</option>
											<option value="Debito">Tarjeta de débito</option>
										</select>
										<input type="hidden" id="token" name="token" value="<?php echo $tokenGenerado; ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer flex-center">
						<button type="reset" id="kt_modal_create_api_key_cancel" class="btn btn-sm btn-light me-3" data-bs-dismiss="modal">Regresar</button>
						<button type="submit" class="btn btn-sm btn-primary" name="submit">Enviar</button>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<script src="assets/js/widgets.bundle.js"></script>
	<script type="text/javascript">
		function validarNumero(evt) {
			var charCode = (evt.which) ? evt.which : event.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				toastr.error('Solo se permiten números.', 'Error', {
					closeButton: true,
					progressBar: true,
					timeOut: 2500,
					showMethod: "slideDown",
					hideMethod: "fadeOut",
				});
				return false;
			}
			return true;
		}
	</script>
	<script type="text/javascript">
		$(function() {
			// Seleccionar el día actual si no es domingo
			const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
			let diaActual = dias[new Date().getDay()];

			// Si hoy es domingo, selecciona el lunes por defecto
			if (diaActual === 'Domingo') {
				diaActual = 'Lunes'; // Asumiendo que el lunes es el próximo día hábil
			}

			// Establecer el día actual como seleccionado en el <select>
			$(`select[name="dia"] option[value="${diaActual}"]`).prop('selected', true).trigger('change');

			// Cargar horarios disponibles al cambiar el día seleccionado
			$('#dia').change(() => {
				const diaSeleccionado = $('#dia').val();
				$.get(`./api/horarios-disponibles?dia=${diaSeleccionado}`)
					.done((response) => $('#horario').html(response.options))
					.fail(() => {
						alert('Ocurrió un error al obtener los horarios disponibles.');
						location.reload();
					});
			});

			// Animación de texto con Typed.js
			const opcionesTyped = {
				typeSpeed: 50,
				fadeOut: true,
				loop: true,
				showCursor: true,
				cursorChar: "|"
			};

			new Typed("#typed_titulo", {
				...opcionesTyped,
				strings: ["Bienvenido/a 👋", "a nuestra agenda Web", "aquí podrás realizar tu reserva de forma automática."]
			});

			new Typed("#typed_subtitulo", {
				...opcionesTyped,
				strings: ["Reserva tu cita", "de forma automática", "y sin esperas"]
			});
		});
	</script>
</body>

</html>