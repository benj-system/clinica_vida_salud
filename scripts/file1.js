/**
 * FILE1.JS - Interactividad del Dashboard del Recepcionista
 * Maneja citas, pacientes, búsquedas y acciones en recepción
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
    configurarBotonNuevaCita();
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

            console.log('Navegando a sección:', seccion);
            // Aquí iría la lógica para cargar diferentes secciones
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
            const paciente = fila.querySelector('.celda-paciente').textContent;
            const hora = fila.querySelector('.celda-hora').textContent;
            const medico = fila.querySelector('.celda-medico')?.textContent || 'Sin asignar';

            abrirModalDetalles({
                paciente: paciente,
                hora: hora,
                medico: medico
            });
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
            const paciente = fila.querySelector('.celda-paciente').textContent;
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
 * Configurar botón de nueva cita
 */
function configurarBotonNuevaCita() {
    const btnNuevaCita = document.querySelector('.btn-nueva-cita');

    if (btnNuevaCita) {
        btnNuevaCita.addEventListener('click', function () {
            abrirFormularioNuevaCita();
        });
    }
}

/**
 * Abrir modal con detalles de cita
 */
function abrirModalDetalles(datos) {
    const mensaje = `
Detalles de la Cita:
─────────────────
Paciente: ${datos.paciente}
Hora: ${datos.hora}
Médico: ${datos.medico}

(Modal en desarrollo)
    `;
    alert(mensaje);
}

/**
 * Abrir formulario para nueva cita
 */
function abrirFormularioNuevaCita() {
    alert(`
Formulario para Nueva Cita:
──────────────────────────
1. Seleccionar Paciente
2. Seleccionar Médico
3. Seleccionar Fecha y Hora
4. Guardar Cita

(Funcionalidad en desarrollo)
    `);
}

/**
 * Objeto para búsqueda y filtrado de citas
 */
const utilidades = {
    /**
     * Buscar citas por nombre de paciente
     */
    buscarCitas: function (termino) {
        const filas = document.querySelectorAll('.fila-cita-recepcion');
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

    /**
     * Filtrar citas por estado
     */
    filtrarPorEstado: function (estado) {
        const filas = document.querySelectorAll('.fila-cita-recepcion');
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

    /**
     * Filtrar citas por médico
     */
    filtrarPorMedico: function (nombreMedico) {
        const filas = document.querySelectorAll('.fila-cita-recepcion');
        let resultados = 0;

        filas.forEach(fila => {
            const medico = fila.querySelector('.celda-medico')?.textContent || '';

            if (medico.toLowerCase().includes(nombreMedico.toLowerCase())) {
                fila.style.display = '';
                resultados++;
            } else {
                fila.style.display = 'none';
            }
        });

        console.log(`Se encontraron ${resultados} cita(s) del médico "${nombreMedico}"`);
        return resultados;
    },

    /**
     * Mostrar todas las citas
     */
    mostrarTodasLasCitas: function () {
        const filas = document.querySelectorAll('.fila-cita-recepcion');
        filas.forEach(fila => {
            fila.style.display = '';
        });
        console.log('Se muestran todas las citas');
    },

    /**
     * Obtener citas filtradas por hora
     */
    citasEntreLasHoras: function (horaInicio, horaFin) {
        const filas = document.querySelectorAll('.fila-cita-recepcion');
        let resultados = 0;

        filas.forEach(fila => {
            const hora = fila.querySelector('.celda-hora').textContent.trim();

            if (hora >= horaInicio && hora <= horaFin) {
                fila.style.display = '';
                resultados++;
            } else {
                fila.style.display = 'none';
            }
        });

        console.log(`Se encontraron ${resultados} cita(s) entre ${horaInicio} y ${horaFin}`);
        return resultados;
    }
};

/**
 * Exportar utilidades para uso en consola/global
 * Uso: utilidades.buscarCitas('Juan')
 *      utilidades.filtrarPorEstado('Programada')
 *      utilidades.mostrarTodasLasCitas()
 */
window.utilidades = utilidades;
