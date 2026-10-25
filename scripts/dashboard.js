/**
 * dashboard.js - Script principal para los dashboards
 * Maneja la carga dinámica de secciones y eventos generales
 */

document.addEventListener('DOMContentLoaded', function() {
    // Cargar la sección de inicio por defecto
    cargarSeccion('inicio');

    // Agregar event listeners a los enlaces del menú
    document.querySelectorAll('.enlace-menu').forEach(enlace => {
        enlace.addEventListener('click', function(e) {
            e.preventDefault();
            const seccion = this.getAttribute('data-seccion');
            cargarSeccion(seccion);

            // Actualizar menú activo
            document.querySelectorAll('.enlace-menu').forEach(link => {
                link.classList.remove('activo');
            });
            this.classList.add('activo');
        });
    });
});

/**
 * Cargar sección dinámicamente
 */
function cargarSeccion(seccion) {
    const contenedor = document.getElementById('contenido-dinamico');
    const url = `../../api/${rolActual}/${seccion}.php`;

    contenedor.innerHTML = '<div class="cargando">Cargando...</div>';

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar la sección');
            }
            return response.text();
        })
        .then(html => {
            contenedor.innerHTML = html;

            // Actualizar títulos
            actualizarTitulos(seccion);

            // Ejecutar scripts de la sección si existen
            const scripts = contenedor.querySelectorAll('script');
            scripts.forEach(script => {
                eval(script.textContent);
            });
        })
        .catch(error => {
            contenedor.innerHTML = `
                <div class="alerta alerta-error">
                    <strong>Error:</strong> No se pudo cargar la sección. ${error.message}
                </div>
            `;
            console.error('Error:', error);
        });
}

/**
 * Actualizar títulos según la sección
 */
function actualizarTitulos(seccion) {
    const titulos = {
        // Admin
        'inicio': 'Dashboard - Inicio',
        'usuarios': 'Gestión de Usuarios',
        'medicos': 'Gestión de Médicos',
        'especialidades': 'Gestión de Especialidades',
        'horarios': 'Configurar Horarios',
        'reportes': 'Reportes del Sistema',

        // Recepcionista
        'pacientes': 'Gestión de Pacientes',
        'citas': 'Gestión de Citas',
        'disponibilidad': 'Verificar Disponibilidad',
        'agenda': 'Agenda del Día',

        // Médico
        'historial': 'Historial de Pacientes',

        // Paciente
        'perfil': 'Mi Perfil',
        'contacto': 'Contacto de Emergencia'
    };

    const titulo = document.getElementById('titulo-seccion');
    const subtitulo = document.getElementById('subtitulo-seccion');

    if (titulo) {
        const nombreSeccion = titulos[seccion] || seccion;
        titulo.textContent = nombreSeccion;
    }

    if (subtitulo) {
        subtitulo.textContent = `Sección: ${seccion}`;
    }
}

/**
 * Mostrar mensaje de alerta
 */
function mostrarAlerta(tipo, mensaje) {
    const contenedor = document.getElementById('contenido-dinamico');
    const alerta = document.createElement('div');
    alerta.className = `alerta alerta-${tipo}`;
    alerta.textContent = mensaje;
    contenedor.insertBefore(alerta, contenedor.firstChild);

    // Auto-cerrar después de 5 segundos
    setTimeout(() => {
        alerta.remove();
    }, 5000);
}

/**
 * Hacer petición AJAX
 */
async function hacerPeticion(url, metodo = 'GET', datos = null) {
    const opciones = {
        method: metodo,
        headers: {
            'Content-Type': 'application/json'
        }
    };

    if (datos && metodo !== 'GET') {
        opciones.body = JSON.stringify(datos);
    }

    try {
        const response = await fetch(url, opciones);
        if (!response.ok) {
            throw new Error(`Error ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error en petición:', error);
        mostrarAlerta('error', 'Error en la comunicación con el servidor');
        throw error;
    }
}

/**
 * Validar formulario
 */
function validarFormulario(formulario) {
    let valido = true;
    const inputs = formulario.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('error');
            valido = false;
        } else {
            input.classList.remove('error');
        }
    });

    return valido;
}

/**
 * Mostrar modal de confirmación
 */
function confirmar(mensaje) {
    return confirm(mensaje);
}

/**
 * Formatear fecha a formato local
 */
function formatearFecha(fecha) {
    const dt = new Date(fecha);
    return dt.toLocaleDateString('es-ES');
}

/**
 * Formatear hora
 */
function formatearHora(hora) {
    return hora.substring(0, 5); // HH:mm
}
