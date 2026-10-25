# Estructura del Proyecto - Clínica Vida Salud
# ESTRUCTURA.md
Este documento describe la organización del proyecto siguiendo una arquitectura de **capas (MVC modificado)**.

## 📁 Estructura de Carpetas

```
clinica_vida_salud/
├── vistas/                          # Capa de Presentación (HTML)
│   ├── autenticacion/
│   │   └── login.html              # Formulario de login
│   ├── admin/
│   │   ├── menuadmin.html          # Menú del administrador
│   │   ├── usuarios.html           # Gestión de usuarios
│   │   ├── medicos.html            # Gestión de médicos
│   │   ├── especialidades.html     # Gestión de especialidades
│   │   └── horarios.html           # Configuración de horarios
│   ├── recepcionista/
│   │   ├── pacientes.html          # Gestión de pacientes
│   │   ├── citas.html              # Gestión de citas
│   │   └── agenda.html             # Agenda del día
│   ├── medico/
│   │   ├── agenda.html             # Mi agenda
│   │   ├── pacientes.html          # Mis pacientes
│   │   └── historial.html          # Historial de citas
│   └── paciente/
│       ├── perfil.html             # Mi perfil
│       ├── historial.html          # Mis citas
│       └── contacto.html           # Contacto de emergencia
│
├── estilos/                         # Capa de Presentación (CSS)
│   ├── login.css                   # Estilos de login
│   ├── dashboard.css               # Estilos generales de dashboards
│   ├── admin.css                   # Estilos específicos del admin (opcional)
│   ├── responsive.css              # Estilos responsivos (opcional)
│   └── variables.css               # Variables CSS (colores, fuentes, etc)
│
├── scripts/                         # Capa Cliente (JavaScript)
│   ├── dashboard.js                # Script principal de dashboards
│   ├── login.js                    # Validaciones de login
│   ├── formularios.js              # Validaciones generales
│   ├── api-cliente.js              # Cliente para llamadas AJAX
│   └── admin/
│       ├── usuarios.js             # Scripts específicos del admin
│       └── reportes.js
│
├── controladores/                   # Capa de Lógica de Negocio (PHP)
│   ├── autenticacion.php           # Login y validación
│   ├── logout.php                  # Cerrar sesión
│   ├── dashboard_admin.php         # Dashboard del admin
│   ├── dashboard_recepcionista.php # Dashboard de recepcionista
│   ├── dashboard_medico.php        # Dashboard del médico
│   ├── dashboard_paciente.php      # Dashboard del paciente
│   └── api/                        # Controladores de API
│       ├── admin/
│       │   ├── usuarios.php        # CRUD de usuarios
│       │   ├── medicos.php         # CRUD de médicos
│       │   ├── especialidades.php  # CRUD de especialidades
│       │   └── horarios.php        # Gestión de horarios
│       ├── recepcionista/
│       │   ├── pacientes.php       # CRUD de pacientes
│       │   ├── citas.php           # CRUD de citas
│       │   └── disponibilidad.php  # Verificar disponibilidad
│       ├── medico/
│       │   ├── agenda.php          # Mi agenda
│       │   └── pacientes.php       # Mis pacientes
│       └── paciente/
│           ├── perfil.php          # Mi perfil
│           └── historial.php       # Mi historial
│
├── modelos/                         # Capa de Acceso a Datos
│   ├── Usuario.php                 # Modelo de Usuario
│   ├── Paciente.php                # Modelo de Paciente
│   ├── Medico.php                  # Modelo de Médico
│   ├── Cita.php                    # Modelo de Cita
│   ├── Especialidad.php            # Modelo de Especialidad
│   ├── Horario.php                 # Modelo de Horario
│   └── BaseModelo.php              # Clase base para modelos
│
├── utilidades/                      # Funciones Compartidas
│   ├── funciones.php               # Funciones comunes
│   ├── validaciones.php            # Funciones de validación
│   ├── permisos.php                # Control de acceso por roles
│   └── base_datos.php              # Funciones de BD (opcional)
│
├── img/                            # Imágenes y Recursos
│   ├── logo.png
│   ├── iconos/
│   └── fondos/
│
├── logs/                           # Logs de Auditoría
│   ├── acciones.log
│   └── errores.log
│
├── docs/                           # Documentación
│   ├── API.md                      # Documentación de endpoints
│   ├── INSTALACION.md              # Guía de instalación
│   └── MANUAL_USUARIO.md           # Manual de usuario
│
├── conexion.php                    # Conexión a Base de Datos
├── config.local.php                # Configuración local (gitignored)
├── config.local.example.php        # Ejemplo de configuración
├── index.php                       # Punto de entrada (redirige a login)
├── ESTRUCTURA.md                   # Este archivo
├── README.md                       # Información del proyecto
└── .gitignore                      # Archivos a ignorar en Git
```

## 🏗️ Capas de la Arquitectura

### 1. Capa de Presentación (Vistas - HTML/CSS)
- **Ubicación:** `vistas/` y `estilos/`
- **Responsabilidad:** Mostrar la interfaz al usuario
- **Convención de nombres:** `nombre.html` para vistas, `nombre.css` para estilos
- **Ejemplo:** `vistas/admin/usuarios.html`, `estilos/dashboard.css`

### 2. Capa de Lógica de Negocio (Controladores - PHP)
- **Ubicación:** `controladores/` y `controladores/api/`
- **Responsabilidad:** Procesar datos, validar, orquestar la lógica
- **Convención de nombres:** `nombre.php` para controladores
- **Ejemplo:** `controladores/api/admin/usuarios.php`

### 3. Capa de Acceso a Datos (Modelos - PHP)
- **Ubicación:** `modelos/`
- **Responsabilidad:** Interactuar con la base de datos
- **Convención de nombres:** `NombreEntidad.php` (PascalCase)
- **Ejemplo:** `modelos/Usuario.php`, `modelos/Paciente.php`

### 4. Capa Cliente (JavaScript)
- **Ubicación:** `scripts/`
- **Responsabilidad:** Validaciones, interactividad, AJAX
- **Convención de nombres:** `nombre.js`
- **Ejemplo:** `scripts/dashboard.js`, `scripts/formularios.js`

### 5. Capa de Utilidades
- **Ubicación:** `utilidades/`
- **Responsabilidad:** Funciones compartidas reutilizables
- **Ejemplo:** `utilidades/funciones.php`, `utilidades/validaciones.php`

## 📋 Flujo de una Petición

```
1. Usuario ingresa URL / hace click → index.php
2. index.php redirige a → controladores/autenticacion.php
3. autenticacion.php valida y crea sesión
4. Usuario es redirigido a → dashboard_[rol].php
5. Dashboard carga dinámicamente secciones desde → controladores/api/[rol]/[seccion].php
6. Los controladores de API usan → modelos/[Entidad].php
7. Los modelos interactúan con → Base de Datos (PostgreSQL)
8. Respuesta se devuelve en JSON (vía AJAX) o HTML
9. JavaScript (dashboard.js) inserta el contenido en el DOM
10. CSS aplica estilos para presentación final
```

## 🔑 Patrones de Nombres

### Archivos HTML (Vistas)
```
vistas/[rol]/[funcionalidad].html
- vistas/admin/usuarios.html
- vistas/recepcionista/pacientes.html
- vistas/medico/agenda.html
```

### Archivos PHP (Controladores)
```
controladores/api/[rol]/[funcionalidad].php
- controladores/api/admin/usuarios.php
- controladores/api/recepcionista/citas.php
```

### Archivos CSS
```
estilos/[modulo].css
- estilos/login.css
- estilos/dashboard.css
- estilos/formularios.css
```

### Archivos JavaScript
```
scripts/[modulo].js
- scripts/dashboard.js
- scripts/formularios.js
- scripts/api-cliente.js
```

### Clases PHP (Modelos)
```
modelos/[NombreEntidad].php
- modelos/Usuario.php
- modelos/Paciente.php
- modelos/Cita.php
```

## 🔐 Control de Acceso

Cada rol tiene acceso a secciones específicas:

- **Administrador (id_rol = 1):** usuarios, médicos, especialidades, horarios, reportes
- **Recepcionista (id_rol = 2):** pacientes, citas, disponibilidad, agenda
- **Médico (id_rol = 3):** mi agenda, mis pacientes, historial
- **Paciente (id_rol = 4):** mi perfil, historial, contacto

Validación: `validar_rol($id_rol)` en `utilidades/funciones.php`

## 📝 Ejemplo de Desarrollo

### Para agregar una nueva funcionalidad "Generar Reporte de Citas":

1. **Crear vista HTML:**
   ```
   vistas/admin/reportes.html
   ```

2. **Crear controlador API:**
   ```
   controladores/api/admin/reportes.php
   ```

3. **Crear modelo (si es necesario):**
   ```
   modelos/Reporte.php
   ```

4. **Crear estilos (si es necesario):**
   ```
   estilos/reportes.css
   ```

5. **Crear scripts JavaScript (si es necesario):**
   ```
   scripts/reportes.js
   ```

## 🚀 Buenas Prácticas

- **Separación de responsabilidades:** Cada capa tiene una función clara
- **DRY (Don't Repeat Yourself):** Usar `utilidades/funciones.php` para código reutilizable
- **Validación dual:** Cliente (JavaScript) + Servidor (PHP)
- **Seguridad:** Usar PDO parametrizado, escapar salida con `htmlspecialchars()`
- **Logs:** Registrar acciones importantes en `logs/acciones.log`
- **Comentarios:** Documentar funciones complejas
- **Responsive:** CSS adaptable a diferentes pantallas

## 📚 Documentación Adicional

Ver archivos en `docs/`:
- `API.md` - Documentación de endpoints
- `INSTALACION.md` - Guía de setup
- `MANUAL_USUARIO.md` - Manual para usuarios finales
