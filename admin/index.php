<?php 
    session_start();

    // Validación de sesión activa y rol de administrador (1)
    if(!isset($_SESSION["usuario"]) || $_SESSION["rol"] != "1"){
        header("Location: ../login.php");
        exit;
    }
    require_once("../docs/php/connection.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | ESCOM IPN</title>
    <link rel="shortcut icon" href="../docs/img/logoEquipo.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Source+Serif+4:wght@400;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="../docs/css/style.css" />
</head>

<body class="bg-light">

    <header>
        <nav class="navbar-institucional" aria-label="Navegación principal">
            <div class="navbar-banda-superior">
                <div class="container d-flex justify-content-between align-items-center">
                    <span class="text-institucional">
                        Instituto Politécnico Nacional — Escuela Superior de Cómputo
                    </span>
                    <span class="text-institucional d-none d-md-inline">
                        Sistema de Registro &mdash; Nuevo Ingreso 2026
                    </span>
                </div>
            </div>

            <div class="navbar-logos-block">
                <div class="container d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <a href="https://www.ipn.mx" target="_blank" aria-label="Inicio IPN">
                            <img src="../docs/img/logo-ipn-blanco.png" alt="Logotipo del Instituto Politécnico Nacional" class="navbar-logo-img" />
                        </a>
                        <div class="navbar-logo-divider d-none d-sm-block"></div>
                        <a href="https://www.escom.ipn.mx" target="_blank" aria-label="Inicio ESCOM">
                            <img src="../docs/img/logoEscom.png" alt="Logotipo de la Escuela Superior de Cómputo" class="navbar-logo-img" />
                        </a>
                    </div>

                    <div class="d-none d-lg-block text-end">
                        <div class="navbar-titulo">Panel de Administración</div>
                        <div class="navbar-subtitulo">Bienvenido <?= $_SESSION["usuario"] ?></div>
                    </div>

                    <div class="d-none d-md-flex align-items-center ms-3">
                        <img src="../docs/img/logoEquipo.png" alt="Logotipo del equipo de desarrollo" class="navbar-logo-img" style="height: 42px;" />
                    </div>
                </div>
            </div>

            <div class="navbar-nav-bar">
                <div class="container">
                    <nav class="navbar navbar-expand-md p-0" aria-label="Menú principal">
                        <button class="navbar-toggler ms-auto my-1" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="menuPrincipal">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="../index.php"><i class="bi bi-house-door me-1"></i>Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../docs/php/logout.php"><i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-12">
                
                <!-- Sección de Estadísticas -->
                <div class="row g-3 mb-5">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card text-center border-0 shadow-sm h-100" style="border-top: 4px solid var(--ipn-guinda);">
                            <div class="card-body">
                                <i class="bi bi-people-fill" style="font-size: 2rem; color: var(--ipn-guinda);"></i>
                                <h6 class="card-title text-muted mt-3 mb-2">Total de Alumnos</h6>
                                <h3 class="fw-bold text-guinda" id="estadisticaTotal">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card text-center border-0 shadow-sm h-100" style="border-top: 4px solid #17a2b8;">
                            <div class="card-body">
                                <i class="bi bi-building" style="font-size: 2rem; color: #17a2b8;"></i>
                                <h6 class="card-title text-muted mt-3 mb-2">Laboratorios</h6>
                                <h3 class="fw-bold" style="color: #17a2b8;" id="estadisticaLabs">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card text-center border-0 shadow-sm h-100" style="border-top: 4px solid #28a745;">
                            <div class="card-body">
                                <i class="bi bi-clock-fill" style="font-size: 2rem; color: #28a745;"></i>
                                <h6 class="card-title text-muted mt-3 mb-2">Horarios</h6>
                                <h3 class="fw-bold" style="color: #28a745;" id="estadisticaHorarios">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <button class="btn btn-sm btn-outline-primary w-100 h-100" data-bs-toggle="modal" data-bs-target="#modalDetalleEstadisticas" style="border: 2px dashed #6c757d; padding: 2rem 0;">
                            <i class="bi bi-bar-chart me-2"></i>Ver detalles
                        </button>
                    </div>
                </div>
                
                <div class="card mb-4 shadow-sm border-0" style="border-top: 4px solid var(--ipn-guinda) !important;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="mb-0 text-guinda fw-bold"><i class="bi bi-sliders me-2"></i>Consola Administrativa</h4>
                        <button class="btn btn-institucional btn-sm shadow-sm text-uppercase fw-bold" id="btnNuevoAlumno" data-bs-toggle="modal" data-bs-target="#modalCrudAlumno" style="background-color: var(--ipn-guinda); color: white;">
                            <i class="bi bi-plus-circle me-1"></i> Registrar Alumno
                        </button>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Barra de búsqueda y filtros -->
                        <div class="row g-3 mb-4 pb-3 border-bottom">
                            <div class="col-12 col-md-6">
                                <label for="inputBuscar" class="form-label fw-semibold text-muted"><i class="bi bi-search me-1"></i>Buscar</label>
                                <input type="text" class="form-control" id="inputBuscar" placeholder="Boleta, nombre o escuela...">
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="filtroLaboratorio" class="form-label fw-semibold text-muted"><i class="bi bi-building me-1"></i>Laboratorio</label>
                                <select class="form-select" id="filtroLaboratorio">
                                    <option value="">Todos los laboratorios</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="filtroHorario" class="form-label fw-semibold text-muted"><i class="bi bi-clock me-1"></i>Horario</label>
                                <select class="form-select" id="filtroHorario">
                                    <option value="">Todos los horarios</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">Mostrando <span id="conteoResultados">0</span> registro(s)</small>
                            <button class="btn btn-sm btn-outline-secondary" id="btnLimpiarFiltros">
                                <i class="bi bi-arrow-clockwise me-1"></i>Limpiar filtros
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead style="background-color: var(--ipn-guinda); color: white;">
                                    <tr>
                                        <th>Boleta</th>
                                        <th>Nombre Completo</th>
                                        <th>Escuela de Procedencia</th>
                                        <th>Promedio</th>
                                        <th>Laboratorio</th>
                                        <th>Horario Asignado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyAlumnos">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <!-- Modal de Detalles de Estadísticas -->
    <!-- Modal de Detalles de Estadísticas -->
    <div class="modal fade" id="modalDetalleEstadisticas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--ipn-guinda); color: white;">
                    <h5 class="modal-title fw-bold"><i class="bi bi-bar-chart me-2"></i>Detalles de Estadísticas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <h6 class="fw-bold text-guinda mb-3"><i class="bi bi-grid-3x3 me-2"></i>Alumnos por Laboratorio y Horario</h6>
                    <div id="detallesLaboratoriosHorarios" class="list-group list-group-flush">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCrudAlumno" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--ipn-guinda); color: white;">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-person-gear me-2"></i>Actualizar / Crear Registro de Alumno</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="frmCrudAlumno">
    <input type="hidden" id="accionCrud" name="accion" value="crear">

    <div class="modal-body p-4">
        <h6 class="text-guinda fw-bold mb-3"><i class="bi bi-person-badge-fill me-2"></i>Identificación del Aspirante</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="boleta" class="form-label fw-semibold text-muted">No. de Boleta</label>
                <input type="text" class="form-control" name="boleta" id="boleta" required maxlength="10">
            </div>
            <div class="col-md-4">
                <label for="nombre" class="form-label fw-semibold text-muted">Nombre(s)</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>
            <div class="col-md-4">
                <label for="appat" class="form-label fw-semibold text-muted">Apellido Paterno</label>
                <input type="text" class="form-control" name="pat" id="appat" required>
            </div>
            <div class="col-md-4">
                <label for="apmat" class="form-label fw-semibold text-muted">Apellido Materno</label>
                <input type="text" class="form-control" name="mat" id="apmat" required>
            </div>
            <div class="col-md-4">
                <label for="curp" class="form-label fw-semibold text-muted">CURP</label>
                <input type="text" class="form-control" name="curp" id="curp" required maxlength="18" style="text-transform: uppercase;">
            </div>
            <div class="col-md-4">
                <label for="telefono" class="form-label fw-semibold text-muted">Teléfono</label>
                <input type="tel" class="form-control" name="tel" id="telefono" required maxlength="10">
            </div>
        </div>

        <h6 class="text-guinda fw-bold mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Información Personal y Procedencia</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="fechaNacimiento" class="form-label fw-semibold text-muted">Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="fecha_nac" id="fechaNacimiento" required>
            </div>
            <div class="col-md-4">
                <label for="genero" class="form-label fw-semibold text-muted">Género</label>
                <select class="form-select" name="genero" id="genero" required>
                    <option value="" disabled selected>Selecciona...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="entidadFederativa" class="form-label fw-semibold text-muted">Entidad Federativa</label>
                <select class="form-select" name="ent_pro" id="entidadFederativa" required>
                    <option value="" selected disabled>Selecciona un estado...</option>
                    <option value="Aguascalientes">Aguascalientes</option>
                    <option value="Baja California">Baja California</option>
                    <option value="Baja California Sur">Baja California Sur</option>
                    <option value="Campeche">Campeche</option>
                    <option value="Chiapas">Chiapas</option>
                    <option value="Chihuahua">Chihuahua</option>
                    <option value="Ciudad de México">Ciudad de México</option>
                    <option value="Coahuila">Coahuila</option>
                    <option value="Colima">Colima</option>
                    <option value="Durango">Durango</option>
                    <option value="Estado de México">Estado de México</option>
                    <option value="Guanajuato">Guanajuato</option>
                    <option value="Guerrero">Guerrero</option>
                    <option value="Hidalgo">Hidalgo</option>
                    <option value="Jalisco">Jalisco</option>
                    <option value="Michoacán">Michoacán</option>
                    <option value="Morelos">Morelos</option>
                    <option value="Nayarit">Nayarit</option>
                    <option value="Nuevo León">Nuevo León</option>
                    <option value="Oaxaca">Oaxaca</option>
                    <option value="Puebla">Puebla</option>
                    <option value="Querétaro">Querétaro</option>
                    <option value="Quintana Roo">Quintana Roo</option>
                    <option value="San Luis Potosí">San Luis Potosí</option>
                    <option value="Sinaloa">Sinaloa</option>
                    <option value="Sonora">Sonora</option>
                    <option value="Tabasco">Tabasco</option>
                    <option value="Tamaulipas">Tamaulipas</option>
                    <option value="Tlaxcala">Tlaxcala</option>
                    <option value="Veracruz">Veracruz</option>
                    <option value="Yucatán">Yucatán</option>
                    <option value="Zacatecas">Zacatecas</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="escuelaProcedencia" class="form-label fw-semibold text-muted">Escuela de Procedencia</label>
                <select class="form-select" name="esc_pro" id="escuelaProcedencia" required>
                    <option value="" selected disabled>Selecciona...</option>
                    <option value="CECyT 1">CECyT 1 "Gonzalo Vázquez Vela"</option>
                    <option value="CECyT 2">CECyT 2 "Miguel Bernard"</option>
                    <option value="CECyT 3">CECyT 3 "Estanislao Ramírez Ruiz"</option>
                    <option value="CECyT 4">CECyT 4 "Lázaro Cárdenas"</option>
                    <option value="CECyT 5">CECyT 5 "Benito Juárez"</option>
                    <option value="CECyT 6">CECyT 6 "Miguel Othón de Mendizábal"</option>
                    <option value="CECyT 7">CECyT 7 "Cuauhtémoc"</option>
                    <option value="CECyT 8">CECyT 8 "Narciso Bassols"</option>
                    <option value="CECyT 9">CECyT 9 "Juan de Dios Bátiz"</option>
                    <option value="CECyT 10">CECyT 10 "Carlos Vallejo Márquez"</option>
                    <option value="CECyT 11">CECyT 11 "Wilfrido Massieu"</option>
                    <option value="CECyT 12">CECyT 12 "José María Morelos"</option>
                    <option value="CECyT 13">CECyT 13 "Ricardo Flores Magón"</option>
                    <option value="CECyT 14">CECyT 14 "Luis Enrique Erro"</option>
                    <option value="CECyT 15">CECyT 15 "Diódoro Antúnez Echegaray"</option>
                    <option value="CECyT 16">CECyT 16 "Hidalgo"</option>
                    <option value="CECyT 17">CECyT 17 "León, Guanajuato"</option>
                    <option value="CECyT 18">CECyT 18 "Zacatecas"</option>
                    <option value="CECyT 19">CECyT 19 "Leona Vicario"</option>
                    <option value="CECyT 20">CECyT 20 "Natalia Serdán Alatriste"</option>
                    <option value="CET 1">CET 1 "Walter Cross Buchanan"</option>
                    <option value="Otro">Otro (Especificar)</option>
                </select>
            </div>
            <div class="col-md-5">
                <label for="nombreEscuela" class="form-label fw-semibold text-muted">Nombre (si es "Otro")</label>
                <input type="text" class="form-control" id="nombreEscuela" name="nombreEscuela" disabled placeholder="Especificar escuela">
            </div>
            <div class="col-md-3">
                <label for="promedio" class="form-label fw-semibold text-muted">Promedio</label>
                <input type="number" step="0.01" class="form-control" name="prom" id="promedio" required min="6" max="10">
            </div>
        </div>

        <h6 class="text-guinda fw-bold mb-3"><i class="bi bi-calendar-check-fill me-2"></i>Asignación de Examen Diagnóstico</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="laboratorio" class="form-label fw-semibold text-muted">Laboratorio Destino</label>
                <select class="form-select" name="laboratorio" id="laboratorio" required>
                    
                </select>
            </div>
            <div class="col-md-6">
                <label for="horario" class="form-label fw-semibold text-muted">Horario Asignado</label>
                <select class="form-select" name="horario" id="horario" required>
                    
                </select>
            </div>
        </div>
        <div id="seccionCuenta">
            <h6 class="text-guinda fw-bold mb-3 mt-4"><i class="bi bi-shield-lock-fill me-2"></i>Datos de Cuenta de Acceso</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="correo" class="form-label fw-semibold text-muted">Correo Institucional</label>
                    <input type="email" class="form-control" name="correo" id="correo" placeholder="ejemplo@alumno.ipn.mx">
                </div>
                <div class="col-md-6">
                    <label for="contrasena" class="form-label fw-semibold text-muted">Contraseña Provisional</label>
                    <input type="text" class="form-control" name="contrasena" id="contrasena" placeholder="Mayúscula, minúscula, número y especial">
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-institucional-outline text-uppercase fw-bold" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-institucional text-uppercase fw-bold" style="background-color: var(--ipn-guinda); color: white;">Guardar Cambios</button>
    </div>
</form>
            </div>
        </div>
    </div>

    <footer class="footer-institucional" aria-label="Pie de página institucional">
        <div class="container">
            <div class="row g-4">

                <div class="col-12 col-md-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <a href="https://www.ipn.mx/" target="_blank" aria-label="Inicio IPN">
                            <img src="../docs/img/logo-ipn-blanco.png" alt="IPN" class="footer-logo-img" />
                        </a>
                        <a href="https://www.escom.ipn.mx/" target="_blank" aria-label="Inicio ESCOM">
                            <img src="../docs/img/logoEscom.png" alt="ESCOM" class="footer-logo-img" />
                        </a>
                    </div>
                    <p class="footer-texto">
                        Escuela Superior de Cómputo<br />
                        Instituto Politécnico Nacional<br />
                        Av. Juan de Dios Bátiz s/n, GAM, CDMX
                    </p>
                    <p class="footer-texto mt-2">
                        <i class="bi bi-telephone me-1"></i> (55) 5729-6000<br />
                        <i class="bi bi-envelope me-1"></i> info@escom.ipn.mx
                    </p>
                </div>

                <div class="col-6 col-md-2">
                    <h3 class="footer-titulo-col">Navegación</h3>
                    <ul class="footer-link-list">
                        <li><a href="../index.php"><i class="bi bi-chevron-right me-1"></i>Inicio</a></li>
                        <li><a href="../registro.php"><i class="bi bi-chevron-right me-1"></i>Registro</a></li>
                        <li><a href="../login.php"><i class="bi bi-chevron-right me-1"></i>Iniciar Sesión</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-3">
                    <h3 class="footer-titulo-col">Proceso de admisión</h3>
                    <ul class="footer-link-list">
                        <li><a href="../index.php#avisos"><i class="bi bi-chevron-right me-1"></i>Documentos requeridos</a></li>
                        <li><a href="../index.php#avisos"><i class="bi bi-chevron-right me-1"></i>Fechas importantes</a></li>
                        <li><a href="../index.php#avisos"><i class="bi bi-chevron-right me-1"></i>Preguntas frecuentes</a></li>
                    </ul>
                </div>

                <div class="col-12 col-md-3">
                    <h3 class="footer-titulo-col">Información</h3>
                    <p class="footer-texto">
                        U.A. Tecnologías para el Desarrollo de Aplicaciones Web.<br />
                        Proyecto desarrollado por estudiantes de la ESCOM para el
                        2do. departamental, ciclo 2026.
                    </p>
                    <div class="mt-3">
                        <img src="../docs/img/logoEquipo.png" alt="Logo del equipo de desarrollo"
                            style="height: 38px; object-fit: contain; filter: brightness(1.1);"/>
                    </div>
                </div>

            </div>

            <hr class="footer-divider" />
        </div>

        <div class="footer-copy">
            &copy; 2026 <span>ESCOM &mdash; Instituto Politécnico Nacional</span>.
            Todos los derechos reservados. &nbsp;|&nbsp;
            Sistema de Registro de Alumnos de Nuevo Ingreso.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../docs/js/validaciones.js"></script>
    
    <script>
    (function () {
        const currentPage = window.location.pathname.split('/').pop() || 'index.php';
        document.querySelectorAll('.navbar-nav-bar .nav-link').forEach(function (link) {
            const href = link.getAttribute('href');
            if (href === currentPage) {
                link.classList.add('active');
                link.setAttribute('aria-current', 'page');
            } else {
                link.classList.remove('active');
                link.removeAttribute('aria-current');
            }
        });
    })();
    </script>

<script src="../docs/js/admin.js"></script>
</body>

</html>
<?php mysqli_close($conexion); ?>