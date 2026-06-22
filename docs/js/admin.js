$(document).ready(function() {
        let datosTablaCompleta = []; // Almacenar datos completos para filtrado
        let laboratoriosUnicos = new Set(); // Laboratorios únicos para el select
        let horariosUnicos = new Set(); // Horarios únicos para el select
        
        // 1. READ: Cargar la tabla al entrar a la página
        function cargarTabla() {
            $.ajax({
                url: '../docs/php/crud_leer.php',
                type: 'GET',
                success: function(respuesta) {
                    $('#tbodyAlumnos').html(respuesta);
                    extraerDatosDeTabla();
                    llenarSelectsFiltros();
                    aplicarFiltros();
                    actualizarEstadisticas();
                }
            });
        }
        
        // Función para actualizar estadísticas
        function actualizarEstadisticas() {
            // Total de alumnos
            const totalAlumnos = datosTablaCompleta.length;
            $('#estadisticaTotal').text(totalAlumnos);
            
            // Cantidad de laboratorios únicos
            const cantLabs = laboratoriosUnicos.size;
            $('#estadisticaLabs').text(cantLabs);
            
            // Cantidad de horarios únicos
            const cantHorarios = horariosUnicos.size;
            $('#estadisticaHorarios').text(cantHorarios);
            
            // Llenar detalles en el modal
            llenarDetallesEstadisticas();
        }
        
        // Función para llenar los detalles en el modal
        function llenarDetallesEstadisticas() {
            const capacidadMax = 30; // Capacidad máxima de cada laboratorio-horario
            
            // Crear una estructura agrupada: laboratorio -> horarios con conteos
            const labAgrupados = {};
            
            datosTablaCompleta.forEach(fila => {
                if(fila.laboratorio && fila.horario) {
                    if(!labAgrupados[fila.laboratorio]) {
                        labAgrupados[fila.laboratorio] = {};
                    }
                    labAgrupados[fila.laboratorio][fila.horario] = (labAgrupados[fila.laboratorio][fila.horario] || 0) + 1;
                }
            });
            
            // Renderizar agrupado por laboratorio
            let htmlCombinaciones = '';
            
            if(Object.keys(labAgrupados).length > 0) {
                Object.keys(labAgrupados).sort().forEach(laboratorio => {
                    const horarios = labAgrupados[laboratorio];
                    let htmlHorarios = '';
                    
                    Object.keys(horarios).sort().forEach(horario => {
                        const cant = horarios[horario];
                        const porcentaje = ((cant / capacidadMax) * 100).toFixed(1);
                        const ocupacion = cant >= capacidadMax ? 'bg-danger' : cant >= 24 ? 'bg-warning' : 'bg-primary';
                        
                        htmlHorarios += `
                            <div class="ps-3 pb-2">
                                <small class="text-muted d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-clock-history me-1"></i>${horario}</span>
                                    <span class="badge ${ocupacion}">${cant}/30 alumnos (${porcentaje}%)</span>
                                </small>
                            </div>
                        `;
                    });
                    
                    htmlCombinaciones += `
                        <div class="list-group-item py-3">
                            <div class="fw-bold text-guinda mb-3"><i class="bi bi-building me-1"></i>${laboratorio}</div>
                            ${htmlHorarios}
                        </div>
                    `;
                });
            } else {
                htmlCombinaciones = '<div class="list-group-item text-center text-muted py-4">Sin datos disponibles</div>';
            }
            
            $('#detallesLaboratoriosHorarios').html(htmlCombinaciones);
        }
        
        // Función para extraer datos de las filas de la tabla
        function extraerDatosDeTabla() {
            datosTablaCompleta = [];
            laboratoriosUnicos.clear();
            horariosUnicos.clear();
            
            $('#tbodyAlumnos tr').each(function() {
                const celdas = $(this).find('td');
                const fila = {
                    boleta: celdas.eq(0).text().trim(),
                    nombre: celdas.eq(1).text().trim(),
                    escuela: celdas.eq(2).text().trim(),
                    promedio: celdas.eq(3).text().trim(),
                    laboratorio: celdas.eq(4).text().trim(),
                    horario: celdas.eq(5).text().trim(),
                    html: $(this).html()
                };
                datosTablaCompleta.push(fila);
                laboratoriosUnicos.add(fila.laboratorio);
                horariosUnicos.add(fila.horario);
            });
        }
        
        // Función para llenar los selects de filtro con valores únicos
        function llenarSelectsFiltros() {
            const laboratorios = Array.from(laboratoriosUnicos).sort();
            const horarios = Array.from(horariosUnicos).sort();
            
            const selectLab = $('#filtroLaboratorio');
            const selectHor = $('#filtroHorario');
            
            // Guardar opción inicial
            const valorLab = selectLab.val();
            const valorHor = selectHor.val();
            
            // Limpiar opciones excepto la primera
            selectLab.find('option:not(:first)').remove();
            selectHor.find('option:not(:first)').remove();
            
            // Agregar opciones
            laboratorios.forEach(lab => {
                if(lab) selectLab.append(`<option value="${lab}">${lab}</option>`);
            });
            horarios.forEach(hor => {
                if(hor) selectHor.append(`<option value="${hor}">${hor}</option>`);
            });
            
            // Restaurar valores si existe
            selectLab.val(valorLab);
            selectHor.val(valorHor);
        }
        
        // Función para aplicar filtros
        function aplicarFiltros() {
            const textoBusqueda = $('#inputBuscar').val().toLowerCase();
            const laboratorioFiltro = $('#filtroLaboratorio').val();
            const horarioFiltro = $('#filtroHorario').val();
            
            let filasVisibles = 0;
            let htmlFilasVisibles = '';
            
            datosTablaCompleta.forEach((fila, index) => {
                const cumpleBusqueda = !textoBusqueda || 
                    fila.boleta.toLowerCase().includes(textoBusqueda) ||
                    fila.nombre.toLowerCase().includes(textoBusqueda) ||
                    fila.escuela.toLowerCase().includes(textoBusqueda);
                
                const cumpleLaboratorio = !laboratorioFiltro || fila.laboratorio === laboratorioFiltro;
                const cumpleHorario = !horarioFiltro || fila.horario === horarioFiltro;
                
                const debeVisualizar = cumpleBusqueda && cumpleLaboratorio && cumpleHorario;
                
                if(debeVisualizar) {
                    htmlFilasVisibles += '<tr>' + fila.html + '</tr>';
                    filasVisibles++;
                }
            });
            
            $('#conteoResultados').text(filasVisibles);
            
            // Mostrar mensaje si no hay resultados o reconstruir tabla
            if(filasVisibles === 0 && datosTablaCompleta.length > 0) {
                $('#tbodyAlumnos').html(`<tr id="mensajeNoResultados"><td colspan="7" class="text-center text-muted py-4"><i class="bi bi-search me-2"></i>No se encontraron resultados que coincidan con los filtros.</td></tr>`);
            } else {
                $('#tbodyAlumnos').html(htmlFilasVisibles);
            }
        }
        
        // Eventos de los filtros
        $('#inputBuscar').on('keyup', aplicarFiltros);
        $('#filtroLaboratorio').on('change', aplicarFiltros);
        $('#filtroHorario').on('change', aplicarFiltros);
        
        // Botón limpiar filtros
        $('#btnLimpiarFiltros').on('click', function() {
            $('#inputBuscar').val('');
            $('#filtroLaboratorio').val('');
            $('#filtroHorario').val('');
            aplicarFiltros();
        });
        
        cargarTabla(); // Ejecutamos la función apenas cargue la página

// --- Combos Dinamicos
        function cargarLaboratorios(boleta, idLabSeleccionado = null) {
            $.ajax({
                url: '../docs/php/lab_admin.php',
                type: 'POST',
                data: { boleta: boleta },
                success: function(opcionesHTML) {
                    $('#laboratorio').html('<option value="" disabled selected>Selecciona laboratorio</option>' + opcionesHTML);
                    if(idLabSeleccionado) {
                        $('#laboratorio').val(idLabSeleccionado);
                    }
                }
            });
        }

        function cargarHorarios(id_lab, boleta, idHorarioSeleccionado = null) {
            if(!id_lab) {
                $('#horario').html('<option value="" disabled selected>Esperando laboratorio...</option>');
                return;
            }
            $.ajax({
                url: '../docs/php/horarios_admin.php',
                type: 'POST',
                data: { id_lab: id_lab, boleta: boleta },
                success: function(opcionesHTML) {
                    $('#horario').html('<option value="" disabled selected>Selecciona horario</option>' + opcionesHTML);
                    if(idHorarioSeleccionado) {
                        $('#horario').val(idHorarioSeleccionado);
                    }
                }
            });
        }

        // EVENTOS DE LOS CAMPOS DINÁMICOS 
        $('#escuelaProcedencia').change(function() {
            if($(this).val() === 'Otro') {
                $('#nombreEscuela').prop('disabled', false).prop('required', true);
            } else {
                $('#nombreEscuela').prop('disabled', true).prop('required', false).val('');
            }
        });

        $('#laboratorio').change(function() {
            let id_lab = $(this).val();
            let boleta = $('#accionCrud').val() === 'editar' ? $('#boleta').val() : ''; 
            cargarHorarios(id_lab, boleta, null);
        });

        // --- 3. BOTÓN NUEVO ALUMNO ---
        $('#btnNuevoAlumno').click(function() {
            $('#frmCrudAlumno')[0].reset();
            $('#accionCrud').val('crear');
            $('input[name="boleta"]').prop('readonly', false);
            $('#nombreEscuela').prop('disabled', true); 
            
            $('#seccionCuenta').show();
            $('#correo, #contrasena').prop('required', true);
            
            $('.modal-title').html('<i class="bi bi-person-plus me-2"></i>Registrar Nuevo Alumno');

            // Limpiamos horarios y disparamos la carga de laboratorios libres
            $('#horario').html('<option value="" disabled selected>Esperando laboratorio...</option>');
            cargarLaboratorios(''); 
        });

        // --- 4. BOTÓN EDITAR ---
        $(document).on('click', '.btn-editar', function() {
            let boleta = $(this).data('boleta');
            
            $('#frmCrudAlumno')[0].reset();
            $('#accionCrud').val('editar');
            $('input[name="boleta"]').prop('readonly', true);
            
            $('#seccionCuenta').hide();
            $('#correo, #contrasena').prop('required', false).val('');
            
            $('.modal-title').html('<i class="bi bi-pencil-square me-2"></i>Actualizar Expediente Completo');

            $.ajax({
                url: '../docs/php/crud_obtener.php',
                type: 'POST',
                data: { boleta: boleta },
                dataType: 'json', 
                success: function(datos) {
                    if(!datos.error) {
                        $('input[name="boleta"]').val(datos.boleta);
                        $('input[name="nombre"]').val(datos.nombre);
                        $('input[name="pat"]').val(datos.pat);
                        $('input[name="mat"]').val(datos.mat);
                        $('input[name="curp"]').val(datos.curp);
                        $('input[name="tel"]').val(datos.tel);
                        $('input[name="fecha_nac"]').val(datos.fecha_nac);
                        $('select[name="genero"]').val(datos.gen);
                        $('select[name="ent_pro"]').val(datos.ent_pro);
                        $('input[name="prom"]').val(datos.prom);
                        
                        if ($('#escuelaProcedencia option[value="' + datos.esc_pro + '"]').length > 0) {
                            $('#escuelaProcedencia').val(datos.esc_pro);
                            $('#nombreEscuela').prop('disabled', true).val('');
                        } else {
                            $('#escuelaProcedencia').val('Otro');
                            $('#nombreEscuela').prop('disabled', false).val(datos.esc_pro);
                        }

                        // Disparamos la carga de laboratorios y horarios respetando el cupo del propio alumno
                        cargarLaboratorios(datos.boleta, datos.id_lab);
                        cargarHorarios(datos.id_lab, datos.boleta, datos.id_horario);

                    } else {
                        alert(datos.error);
                    }
                }
            });
        });

        // 5 DELETE: Botón de eliminar en la tabla
        $(document).on('click', '.btn-eliminar', function() {
            let boleta = $(this).data('boleta');
            
            if(confirm('¿Estás seguro de eliminar la boleta ' + boleta + '? Se borrará su cuenta y asignación de examen.')) {
                $.ajax({
                    url: '../docs/php/crud_eliminar.php',
                    type: 'POST',
                    data: { boleta: boleta },
                    success: function(respuesta) {
                        if(respuesta.trim() === "success") {
                            alert('Registro eliminado correctamente.');
                            cargarTabla(); // Recarga los datos y aplica filtros
                        } else {
                            alert(respuesta);
                        }
                    }
                });
            }
        });

        // 6. CREATE / UPDATE: Botón de Guardar en el Modal
    $('#frmCrudAlumno').submit(function(e) {
    e.preventDefault();
    
    if(!validarBoleta()){ alert('Boleta inválida. Debe tener 10 dígitos o formato PE/PP.'); return; }
    if(!validarNombre()){ alert('Nombre inválido. Solo usa letras.'); return; }
    if(!validarApellidoPaterno()){ alert('Apellido paterno inválido.'); return; }
    if(!validarApellidoMaterno()){ alert('Apellido materno inválido.'); return; }
    if(!validarCurp()){ alert('CURP inválida. Revisa el formato de 18 caracteres.'); return; }
    if(!validarTelefono()){ alert('Teléfono inválido. Deben ser 10 dígitos numéricos.'); return; }
    if(!validarFechaNacimiento()){ alert('Fecha de nacimiento inválida.'); return; }
    if(!validarPromedio()){ alert('Promedio inválido. Usa un valor entre 6.0 y 10.0'); return; }
    if(!validarNombreEscuela()){ alert('Nombre de la escuela inválido.'); return; }
    
    // --- NUEVO: Validamos cuenta solo si estamos creando un alumno nuevo ---
    if($('#accionCrud').val() === 'crear') {
        if(!validarCorreo()){ alert('Correo inválido. Debe contener terminación @alumno.ipn.mx o @ipn.mx'); return; }
        if(!validarContra()){ alert('La contraseña debe contener al menos una mayúscula, una minúscula, un dígito y un carácter especial.'); return; }
    }
    
    $.ajax({
        url: '../docs/php/crud_guardar.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(respuesta) {
            if(respuesta.trim() === "success") {
                alert('Operación realizada con éxito en la base de datos.');
                $('#modalCrudAlumno').modal('hide');
                cargarTabla(); // Recarga los datos y aplica filtros
            } else {
                alert(respuesta);
            }
        },
        error: function() {
            alert("Error al conectar con el servidor.");
        }
    });
    });

    const anioActual = new Date().getFullYear();
    
    const anioMax = anioActual - 16;
    
    const anioMin = anioActual - 100;

    const fechaMax = `${anioMax}-12-31`; 
    const fechaMin = `${anioMin}-01-01`;

    const $inputFecha = $("#fechaNacimiento");
    $inputFecha.attr("max", fechaMax);
    $inputFecha.attr("min", fechaMin);

});