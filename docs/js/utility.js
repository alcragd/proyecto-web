document.addEventListener('DOMContentLoaded', () => {
        const escuelaSelect = document.getElementById('escuelaProcedencia');
        const nombreEscuelaInput = document.getElementById('nombreEscuela');
        const labelNombreEscuela = document.querySelector('label[for="nombreEscuela"]');

        escuelaSelect.addEventListener('change', () => {
            if (escuelaSelect.value === 'Otro') {
                // Habilitar el campo y hacerlo obligatorio
                nombreEscuelaInput.disabled = false;
                nombreEscuelaInput.required = true;
                
                // Estilo visual para denotar que ya está activo
                labelNombreEscuela.classList.remove('text-muted');
            } else {
                // Deshabilitar el campo y quitar la obligatoriedad
                nombreEscuelaInput.disabled = true;
                nombreEscuelaInput.required = false;
                
                // Limpiar el texto si el usuario había escrito algo antes de cambiar de opción
                nombreEscuelaInput.value = '';
                
                // Regresar el estilo visual atenuado
                labelNombreEscuela.classList.add('text-muted');
            }
        });
    });