<?php
// Incluir las clases
require_once '../classes/Database.php';
require_once '../classes/Reservas.php';
require_once '../classes/Horarios.php';
require_once '../classes/User.php';
require_once '../classes/Servicios.php';
require_once '../classes/Token.php';

$reserva = new Reservas();
$servicio = new Servicios();
$token = new Token();

// Obtener el id de la reserva y el token de la URL
$id_reserva = $_GET['id_reserva'];
$token_value = $_GET['token'];

// Verificar si el token es válido
if ($token->isValid($id_reserva, $token_value) === false) {
  header("Location: index");
  exit();
}

// Obtener información de la reserva
$info_reserva = $reserva->GetInfoById($id_reserva);

// Informacion del servicio
$id_servicio = $info_reserva['id_servicio'];
$servicio_info = $servicio->GetInfoFromServicioId($id_servicio);

// Informacion del usuario
$id_usuario = $info_reserva['id_usuario'];
$usuario = User::GetUserById($id_usuario);

$horarioData = Horarios::GetInfoFromDay($info_reserva['id_horario']);

$horarioFormated = date('H:i', strtotime($horarioData['hora_inicio']));

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <base href="../" />
  <title>Barber Duck - Reserva tu cita en nuestra barbería</title>
  <meta charset="utf-8" />
  <meta name="description" content="Reserva tu cita en Barber Duck, la mejor barbería de la ciudad. Contamos con una amplia variedad de servicios para satisfacer todas tus necesidades." />
  <meta name="keywords" content="Barber Duck, reserva, cita, barbería, servicios, peluquería, cuidado personal, barbero, estilista, afeitado, grooming" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta property="og:locale" content="es_ES" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="Barber Duck - Reserva tu cita en nuestra barbería" />
  <meta property="og:url" content="https://afagundez.shop" />
  <meta property="og:site_name" content="Barber Duck" />
  <meta name="apple-mobile-web-app-title" content="Barber Duck">
  <meta name="theme-color" content="#000000">
  <meta name="robots" content="index, follow">
  <meta name="author" content="Barber Duck">
  <meta name="format-detection" content="telephone=no">
  <link rel="canonical" href="https://afagundez.shop" />
  <link rel="shortcut icon" href="assets/media/logos/barbershop.png" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
  <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body id="kt_body" data-kt-app-header-stacked="true" data-kt-app-header-primary-enabled="true" data-kt-app-header-secondary-enabled="false" data-kt-app-toolbar-enabled="false" class="print-content-only app-default">
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
                <button class="d-lg-none btn btn-icon btn-flex btn-color-gray-600 btn-active-color-primary w-35px h-35px ms-n2 me-2" id="kt_app_header_menu_toggle">
                  <i class="ki-outline ki-abstract-14 fs-2"></i>
                </button>
                <a href="https://afagundez.shop/" class="d-flex align-items-center me-lg-20 me-5">
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
                <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
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
              <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                  <i class="ki-duotone ki-element-4 fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                  </i>
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Tu reserva fue procesada correctamente! 😃</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                      <li class="breadcrumb-item text-muted">
                        <a class="text-muted text-hover-primary mt-2">Tu ID único de Reserva:
                          <?php
                          echo '<span class="badge badge-light-success"> ' . $id_reserva . '</span>';
                          ?></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="card">
                  <div class="card-body p-lg-20">
                    <div class="d-flex flex-column flex-xl-row">
                      <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                        <div class="mt-n1">
                          <div class="m-0">
                            <div class="fw-bold fs-3 text-gray-800 mb-8">Reserva número #<?php echo $id_reserva; ?></div>
                            <div class="row g-5 mb-11">
                              <div class="col-sm-6">
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Fecha de emisión:</div>
                                <div class="fw-bold fs-6 text-gray-800">
                                  <?php
                                  echo $info_reserva['reserva_creada'];
                                  ?></div>
                              </div>
                            </div>
                            <div class="row g-5 mb-12">
                              <div class="col-sm-6">
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Detalles del cliente:</div>
                                <div class="fw-semibold fs-7 text-gray-600">Nombre y Apellido: <?php echo str_pad(substr($usuario['nombre'], 2), strlen($usuario['nombre']) - 2, "*", STR_PAD_LEFT) . " " . str_pad(substr($usuario['apellido'], 3), strlen($usuario['apellido']) - 3, "*", STR_PAD_LEFT) ?><br />
                                  <div class="fw-semibold fs-7 text-gray-600">Telefono: <?php echo str_pad(substr($usuario['telefono'], -4), strlen($usuario['telefono']), "*", STR_PAD_LEFT)  ?></div>
                                  <div class="fw-semibold fs-7 text-gray-600">Correo electronico: <?php echo str_pad(substr($usuario['email'], 0, 1), strpos($usuario['email'], "@") - 1, "*", STR_PAD_RIGHT) . substr($usuario['email'], strpos($usuario['email'], "@"))  ?></div>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">Emitida por:</div>
                                <div class="fw-bold fs-6 text-gray-800">Barber Duck.</div>
                                <div class="fw-semibold fs-7 text-gray-600">Av. Gral. José Garibaldi 2407.
                                  <br />Montevideo, Uruguay
                                </div>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <div class="table-responsive border-bottom mb-9">
                                <table class="table mb-3">
                                  <thead>
                                    <tr class="border-bottom fs-6 fw-bold text-muted">
                                      <th class="min-w-175px pb-2">Servicio elegido</th>
                                      <th class="min-w-100px text-end pb-2">Costo</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr class="fw-bold text-gray-700 fs-5 text-end">
                                      <td class="d-flex align-items-center pt-6">
                                        <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                        <?php
                                        echo $servicio_info['nombre_servicio']
                                        ?>
                                      </td>
                                      <td class="pt-6 text-dark fw-bolder">
                                        <?php
                                        echo '$ ' . $servicio_info['precio'] . '';
                                        ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <?php
                              if ($info_reserva['payment_method'] === 'Tarjeta de Debito') {
                                $precioDebito = $servicio_info['precio'] + 10;
                                echo '
                                <div class="d-flex justify-content-end">
                                <div class="mw-300px">
                                  <div class="d-flex flex-stack mb-3">
                                    <div class="fw-bold pe-10 text-gray-600 fs-7">Subtotal:</div>
                                    <div class="text-end fw-bolder fs-6 text-gray-800">$' . $servicio_info['precio'] . '
                                    </div>
                                  </div>
                                  <div class="d-flex flex-stack mb-3">
                                    <div class="fw-bold pe-10 text-gray-600 fs-7">Pago con debito:</div>
                                    <div class="text-end fw-bolder fs-6 text-gray-800">$' . $precioDebito . '
                                    </div>
                                  </div>
                                  <div class="d-flex flex-stack">
                                    <div class="fw-bold pe-10 text-gray-600 fs-7">Total:</div>
                                    <div class="text-end fw-bolder fs-6 text-gray-800">$' . $precioDebito . '
                                    </div>
                                  </div>
                                </div>
                                ';
                              } else
                                echo '
                                <div class="d-flex justify-content-end">
                                <div class="mw-300px">
                                  <div class="d-flex flex-stack mb-3">
                                    <div class="fw-bold pe-10 text-gray-600 fs-7">Subtotal:</div>
                                    <div class="text-end fw-bolder fs-6 text-gray-800">$' . $servicio_info['precio'] . '
                                    </div>
                                  </div>
                                  <div class="d-flex flex-stack">
                                    <div class="fw-bold pe-10 text-gray-600 fs-7">Total:</div>
                                    <div class="text-end fw-bolder fs-6 text-gray-800">$' . $servicio_info['precio'] . '
                                    </div>
                                  </div>
                                </div>
                                ';
                              ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="m-0">
                      <div class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">
                        <div class="mb-8">
                          <?php
                          echo Reservas::GetConfirmadaStatus($info_reserva['id_reserva']);
                          ?></div>
                        <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">DETALLES ADICIONALES</h6>
                        <div class="mb-6">
                          <div class="fw-semibold text-gray-600 fs-7">Método de Pago
                            <div class="fw-bolder text-gray-800 fs-6">
                              <?php if ($info_reserva['payment_method'] === 'Tarjeta de Debito') {
                                echo '<span class="badge badge-light-warning me-2"> Tarjeta de Débito + $10 </span>';
                              } else {
                                echo '<span class="badge badge-light-primary me-2">' . $info_reserva['payment_method'] . '</span>';
                              }
                              ?></div>
                          </div>
                        </div>
                        <div class="mb-6">
                          <div class="fw-semibold text-gray-600 fs-7">Turno elegido</div>
                          <div class="fw-bold text-gray-800 fs-6">
                            <?php
                            echo '<span class="badge badge-light-primary me-2">' .  $info_reserva['fecha_reservada'] . ' - ' . $horarioFormated . '</span>';
                            ?></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center">
              <a href="https://afagundez.shop" class="btn btn-light-primary me-2 mb-2">
                <i class="bi bi-arrow-clockwise fs-3"></i>
                Realizar otra reserva
              </a>
            </div>

          </div>
          <div id="kt_app_footer" class="app-footer align-items-center justify-content-center justify-content-md-between flex-column flex-md-row py-3 py-lg-6">
            <div class="text-dark order-2 order-md-1">
              <span class="text-muted fw-semibold me-1">2023©</span>
              <a href="#" target="_blank" class="text-gray-800 text-hover-primary">Barber Duck</a>
            </div>
            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1 align-items-center mb-3 mb-md-0">
              <li class="menu-item">
                <a href="https://afagundez.shop/" target="_blank" class="menu-link px-3">
                  <img alt="Barber Duck Website" src="assets/media/svg/brand-logos/dribbble-2.svg" class="w-20px">
                </a>
              </li>
              <li class="menu-item">
                <a href="https://www.instagram.com/barber_duck13/" target="_blank" class="menu-link px-3">
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
  <script src="assets/plugins/global/plugins.bundle.js"></script>
  <script src="assets/js/scripts.bundle.js"></script>
</body>

</html>