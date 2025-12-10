# Estado del Product Backlog - Proyecto Inventario Jurídico v2

## Resumen General
**Fecha:** 5 de Diciembre 2025  
**Estado Actual:** 1 de 10 PBI completados (10%)

---

## Análisis Detallado por PBI

### ✅ PBI-01: Crear Expediente (DONE)
**Prioridad:** Alta | **Estimación:** M | **Estado:** COMPLETADO

**Implementado:**
- ✅ Controlador `ExpedienteController@store` con transacción
- ✅ Modelo `Expediente` con relaciones completas
- ✅ Validación `StoreExpedienteRequest` exhaustiva
- ✅ Modelos `Persona`, `PlazoActuacion`, `Documento` con relaciones
- ✅ Almacenamiento de documentos en storage
- ✅ Manejo de errores con rollback

**Criterios de Aceptación Met:**
- ✅ Expediente, Partes y Plazos guardan en transacción
- ✅ Validación estricta de datos

---

### 🔴 PBI-02: Login/Logout Seguro (TO DO)
**Prioridad:** Alta | **Estimación:** S | **Estado:** INCOMPLETO (60%)

**Implementado:**
- ✅ Rutas GET/POST de login definidas
- ✅ Controlador `LoginController` con métodos básicos
- ✅ Modelo `User` con relaciones
- ✅ Ruta de logout

**Falta Implementar:**
- ❌ Vista `auth.login` (Blade template)
- ❌ Validación de email vs identificación (campo alternativo)
- ❌ Manejo de errores de autenticación
- ❌ Recordar sesión (remember_me)
- ⚠️ Campo `identificacion` en modelo User (agregado pero sin migraciones)

**Criterios de Aceptación Pendientes:**
- ❌ Autenticación con email y contraseña
- ❌ Sesión activa y verificada

---

### 🔴 PBI-03: Autorización por Roles (TO DO)
**Prioridad:** Alta | **Estimación:** M | **Estado:** NO INICIADO (0%)

**Necesario Implementar:**
- ❌ Middleware personalizado `auth.role`
- ❌ Tabla `roles` y relaciones en BD
- ❌ Lógica de verificación por rol en controladores
- ❌ Protección de rutas destroy, update, create por rol

**Rutas Definidas pero SIN Middleware:**
```php
->middleware('auth.role:Administrador,Abogado') // ← No existe este middleware
```

**Criterios de Aceptación Pendientes:**
- ❌ Rutas create, store, destroy inaccesibles para Asistente

---

### 🔴 PBI-04: Reporte Plazos Críticos (TO DO)
**Prioridad:** Alta | **Estimación:** L | **Estado:** PARCIAL (40%)

**Implementado:**
- ✅ Método `ReporteController@plazosCriticos` con lógica
- ✅ Consulta que filtra por estado Pendiente y vencidos
- ✅ Ruta definida

**Falta Implementar:**
- ❌ Vista `reportes.plazos_criticos` (Blade template)
- ❌ Diseño de tabla con filtros
- ❌ Indicadores visuales (CSS para vencidos/pendientes)
- ❌ Información del responsable del plazo

**Criterios de Aceptación Pendientes:**
- ❌ Descripción, fecha límite, responsable y indicador visual

---

### 🔴 PBI-05: Reporte Carga de Casos (TO DO)
**Prioridad:** Alta | **Estimación:** M | **Estado:** PARCIAL (40%)

**Implementado:**
- ✅ Método `ReporteController@cargaCasosPorAbogado` (corregido a `User`)
- ✅ Consulta con withCount('expedientes')
- ✅ Ruta definida

**Falta Implementar:**
- ❌ Vista `reportes.carga_casos` (Blade template)
- ❌ Gráficos o visualización de carga
- ❌ Filtros por rango de fechas

**Criterios de Aceptación Pendientes:**
- ❌ Contar número total de expedientes por abogado

---

### 🔴 PBI-06: Upload de Documentos (TO DO)
**Prioridad:** Media | **Estimación:** L | **Estado:** PARCIAL (50%)

**Implementado:**
- ✅ Lógica de almacenamiento en `ExpedienteController@store`
- ✅ Validación de archivos en `StoreExpedienteRequest`
- ✅ Modelo `Documento` con relaciones

**Falta Implementar:**
- ❌ Ruta para descargar documentos (`DocumentoController@download`)
- ❌ Ruta para eliminar documentos
- ❌ Validación de tipos MIME permitidos
- ❌ Límite de tamaño de archivo configurado
- ❌ Vista de gestión de documentos

**Criterios de Aceptación Pendientes:**
- ❌ URL de archivo guardada en BD (está implementado pero sin acceso)

---

### 🔴 PBI-07: Listado de Expedientes (TO DO)
**Prioridad:** Media | **Estimación:** M | **Estado:** NO INICIADO (0%)

**Necesario Implementar:**
- ❌ Método `ExpedienteController@index` completo
- ❌ Búsqueda por N° Interno y Juzgado
- ❌ Ordenamiento de columnas
- ❌ Paginación
- ❌ Vista `expedientes.index` (Blade template)

**Criterios de Aceptación Pendientes:**
- ❌ Lista ordenable y paginable

---

### 🔴 PBI-08: Detalle de Expediente (TO DO)
**Prioridad:** Media | **Estimación:** M | **Estado:** NO INICIADO (0%)

**Necesario Implementar:**
- ❌ Método `ExpedienteController@show` completo
- ❌ Cargar relacionados: Partes, Plazos, Documentos, Auditoría
- ❌ Vista `expedientes.show` (Blade template)

**Criterios de Aceptación Pendientes:**
- ❌ Mostrar todas las partes, plazos e historial de auditoría

---

### 🔴 PBI-09: Editar Expediente (TO DO)
**Prioridad:** Media | **Estimación:** L | **Estado:** NO INICIADO (0%)

**Necesario Implementar:**
- ❌ Métodos `ExpedienteController@edit` y `update`
- ❌ Validación `UpdateExpedienteRequest` (archivo existe pero vacío)
- ❌ Lógica de actualización de Partes y Plazos
- ❌ Vista `expedientes.edit` (Blade template)
- ❌ Manejo de cambios de estado

**Criterios de Aceptación Pendientes:**
- ❌ Edición respeta las mismas reglas de validación

---

### 🔴 PBI-10: Exportar a PDF (TO DO)
**Prioridad:** Baja | **Estimación:** L | **Estado:** NO INICIADO (0%)

**Necesario Implementar:**
- ❌ Instalar librería (DomPDF o Laravel Excel)
- ❌ Métodos de exportación en controladores
- ❌ Plantillas PDF
- ❌ Rutas de exportación

**Criterios de Aceptación Pendientes:**
- ❌ Exportación de expedientes y reportes a PDF

---

## Próximas Acciones Recomendadas

### Inmediatas (Bloquean otros PBIs):
1. **PBI-02:** Crear vista de login y validar funcionamiento
2. **PBI-03:** Implementar middleware de roles (necesario para seguridad)

### Corto Plazo (Agregan valor):
3. **PBI-04 y PBI-05:** Crear vistas de reportes
4. **PBI-07 y PBI-08:** Implementar listado y detalle de expedientes

### Mediano Plazo:
5. **PBI-06:** Completar gestión de documentos
6. **PBI-09:** Implementar edición de expedientes

### Largo Plazo:
7. **PBI-10:** Exportación a PDF

---

## Checklist de Migraciones Pendientes

Verificar que existan las siguientes migraciones:
- ✅ `0001_01_01_000000_create_usuarios_table.php` (existe, revisar campos)
- ✅ `2025_12_05_084438_create_personas_table.php`
- ✅ `2025_12_05_084446_create_expedientes_table.php`
- ✅ `2025_12_05_084534_create_plazo_actuacions_table.php`
- ✅ `2025_12_05_084544_create_control_economicos_table.php`
- ✅ `2025_12_05_084552_create_auditoria_expedientes_table.php`
- ✅ `2025_12_05_084558_create_expedientes_partes_table.php`
- ✅ `2025_12_05_100628_create_documentos_table.php`

**⚠️ Necesario:** Verificar que la migración de usuarios tenga los campos:
- `id_cedula` (para identificación alternativa)
- `identificacion`
- `rol` (Administrador, Abogado, Asistente, Socio)
