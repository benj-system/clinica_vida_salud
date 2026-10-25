/**
 * dashboard_medico.js - Interactividad del Dashboard del Médico
 * Maneja filtros, búsqueda y acciones en la tabla de citas
 */

document.addEventListener('DOMContentLoaded', function () {
    inicializar();
});

/**
 * Inicializar componentes y listeners
 */
function inicializar() {
    configurarMenuLateral();
    configurarBotonesCitas();
}

/**
 * Configurar navegación del menú lateral
 */
function configurarMenuLateral() {
    const enlaces = document.querySelectorAll('.enlace-menu');

    enlaces.forEach(enlace => {
        enlace.addEventListener('click', function (e) {
            e.preventDefault();
            const seccion = this.dataset.seccion;

            // Actualizar clase activa
            enlaces.forEach(e => e.classList.remove('activo'));
            this.classList.add('activo');

            // Aquí iría la lógica para cargar diferentes secciones
            // Por ahora solo mostramos la agenda
            console.log('Navegando a:', seccion);
        });
    });
}

/**
 * Configurar botones de acciones en la tabla de citas
 */
function configurarBotonesCitas() {
    const botonesVer = document.querySelectorAll('.boton-ver');
    const botonesEditar = document.querySelectorAll('.boton-editar');
    const botonesCancelar = document.querySelectorAll('.boton-cancelar');

    botonesVer.forEach(btn => {
        btn.addEventListener('click', function () {
            const fila = this.closest('tr');
            const paciente = fila.querySelector('.celda-paciente strong').textContent;
            const fecha = fila.querySelector('.celda-fecha').textContent;
            const hora = fila.querySelector('.celda-hora').textContent;

            alert(`Detalles de la cita:\n\nPaciente: ${paciente}\nFecha: ${fecha}\nHora: ${hora}`);
            // Aquí se podría abrir un modal con más detalles
        });
    });

    botonesEditar.forEach(btn => {
        btn.addEventListener('click', function () {
            const fila = this.closest('tr');
            const estado = fila.querySelector('.badge-estado').textContent;

            if (estado.includes('Atendida') || estado.includes('Cancelada')) {
                alert('No puedes editar una cita que ya ha sido atendida o cancelada.');
                return;
            }

            alert('Funcionalidad de edición en desarrollo...');
            // Aquí se podría abrir un formulario de edición
        });
    });

    botonesCancelar.forEach(btn => {
        btn.addEventListener('click', function () {
            const fila = this.closest('tr');
            const paciente = fila.querySelector('.celda-paciente strong').textContent;
            const estado = fila.querySelector('.badge-estado').textContent;

            if (estado.includes('Cancelada')) {
                alert('Esta cita ya está cancelada.');
                return;
            }

            if (confirm(`¿Deseas cancelar la cita de ${paciente}?`)) {
                alert('Cita cancelada exitosamente. (Funcionalidad en desarrollo)');
                // Aquí se haría la petición AJAX para cancelar
            }
        });
    });
}

/**
 * Buscar citas por nombre de paciente
 * Puedes activar con: filtro.buscar('Juan')
 */
const filtro = {
    buscar: function (termino) {
        const filas = document.querySelectorAll('.fila-cita');
        let resultados = 0;

        filas.forEach(fila => {
            const paciente = fila.querySelector('.celda-paciente').textContent.toLowerCase();

            if (paciente.includes(termino.toLowerCase())) {
                fila.style.display = '';
                resultados++;
            } else {
                fila.style.display = 'none';
            }
        });

        console.log(`Se encontraron ${resultados} cita(s) para "${termino}"`);
        return resultados;
    },

    filtrarPorEstado: function (estado) {
        const filas = document.querySelectorAll('.fila-cita');
        let resultados = 0;

        filas.forEach(fila => {
            const badgeEstado = fila.querySelector('.badge-estado').textContent;

            if (badgeEstado.toLowerCase().includes(estado.toLowerCase())) {
                fila.style.display = '';
                resultados++;
            } else {
                fila.style.display = 'none';
            }
        });

        console.log(`Se encontraron ${resultados} cita(s) en estado "${estado}"`);
        return resultados;
    },

    mostrarTodas: function () {
        const filas = document.querySelectorAll('.fila-cita');
        filas.forEach(fila => {
            fila.style.display = '';
        });
        console.log('Se muestran todas las citas');
    }
};

/**
 * Exportar filtro para uso en consola/global
 */
window.filtro = filtro;
