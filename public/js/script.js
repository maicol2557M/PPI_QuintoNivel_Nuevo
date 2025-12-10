// =====================
// JS UNIFICADO PARA FORMULARIOS Y TABLAS DINÁMICAS
// =====================

// Configuración por módulo: define los campos y el orden de columnas para cada tabla
const tableConfigs = {
    clientes: {
        formId: 'userForm',
        tableBodyId: 'userTableBody',
        fields: ['cedula', 'nombre', 'direccion', 'telefono', 'email', 'numero_proceso', 'estado'],
        actionCol: true
    },
    responsables: {
        formId: 'userForm',
        tableBodyId: 'userTableBody',
        fields: ['numero', 'nombre', 'area', 'contacto'],
        actionCol: true
    }
    // Agrega aquí más módulos si es necesario
};

let currentModule = null;
let editingRow = null;

function setModule(moduleName) {
    currentModule = tableConfigs[moduleName];
}

function openModal() {
    const modal = document.getElementById('userModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeModal() {
    const modal = document.getElementById('userModal');
    if (modal) {
        modal.style.display = 'none';
    }
    editingRow = null;
}

function openAlert(message, action, button) {
    const alertMessage = document.getElementById('alertMessage');
    const alertModal = document.getElementById('alertModal');

    if (alertMessage && alertModal) {
        alertMessage.textContent = message;
        currentAction = action;
        currentButton = button;
        alertModal.style.display = 'flex';
    }
}

function closeAlert() {
    const alertModal = document.getElementById('alertModal');
    if (alertModal) {
        alertModal.style.display = 'none';
    }
}

function confirmAction(action, button) {
    const message = action === 'delete' ? '¿Está seguro de que desea eliminar este registro?' : '¿Está seguro de que desea editar este registro?';
    openAlert(message, action, button);
}

// Verificar si el elemento existe antes de asignar el evento
const alertConfirmElement = document.getElementById('alertConfirm');
if (alertConfirmElement) {
    alertConfirmElement.onclick = function () {
        if (window.currentAction === 'delete') {
            const row = window.currentButton.closest('tr');
            row.remove();
            updateSerialNumbers();
        } else if (window.currentAction === 'edit') {
            const row = window.currentButton.closest('tr');
            const cells = row.querySelectorAll('td');
            // Rellenar los datos en el formulario según la configuración del módulo
            currentModule.fields.forEach((field, idx) => {
                document.getElementById(field).value = cells[idx + 1].textContent;
            });
            editingRow = row;
            openModal();
        }
        closeAlert();
    };
}

// Manejo del formulario modal (agregar o editar)
const userFormElement = document.getElementById('userForm');
if (userFormElement) {
    userFormElement.onsubmit = function (event) {
        event.preventDefault();
        const errorDiv = document.getElementById('error');
        if (errorDiv) errorDiv.textContent = '';
        // Obtener valores según el módulo
        const values = currentModule.fields.map(field => document.getElementById(field).value.trim());
        if (values.some(v => !v)) {
            if (errorDiv) errorDiv.textContent = 'Por favor, complete todos los campos.';
            return;
        }
        const tableBody = document.getElementById(currentModule.tableBodyId);
        if (editingRow) {
            // Actualizar la fila existente
            const cells = editingRow.querySelectorAll('td');
            currentModule.fields.forEach((field, idx) => {
                cells[idx + 1].textContent = values[idx];
            });
            editingRow = null;
        } else {
            // Crear nueva fila
            const newRow = document.createElement('tr');
            let rowHtml = '<td class="table-cell"></td>';
            values.forEach(val => {
                rowHtml += `<td class="table-cell">${val}</td>`;
            });
            if (currentModule.actionCol) {
                rowHtml += `<td class="action-buttons">
                    <button class="btn btn-success edit" onclick="confirmAction('edit', this)">Editar</button>
                    <button class="btn btn-danger delete" onclick="confirmAction('delete', this)">Eliminar</button>
                </td>`;
            }
            newRow.innerHTML = rowHtml;
            tableBody.appendChild(newRow);
        }
        updateSerialNumbers();
        document.getElementById(currentModule.formId).reset();
        closeModal();
    };
}

function updateSerialNumbers() {
    const tableBody = document.getElementById("userTableBody");
    if (!tableBody) return; // Salir si no existe el elemento

    const rows = tableBody.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const serialCell = rows[i].getElementsByTagName("td")[0];
        if (serialCell) {
            serialCell.textContent = i + 1;
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Detecta el módulo automáticamente según la tabla presente
    if (document.getElementById('numero') && document.getElementById('area')) {
        setModule('responsables');
    } else if (document.getElementById('cedula') && document.getElementById('numero_proceso')) {
        setModule('clientes');
    }
    updateSerialNumbers();
});

//Funcion de busqueda
function searchTable() {
    const input = document.getElementById("searchInput");
    if (!input) return; // Salir si no existe el elemento

    const filter = input.value.toUpperCase();
    const table = document.querySelector("table");
    if (!table) return; // Salir si no existe la tabla

    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {  // Start from 1 to skip the header row
        let cells = rows[i].getElementsByTagName("td");
        let match = false;

        // Iterate through all columns in each row
        for (let j = 0; j < cells.length - 1; j++) {  // -1 to exclude the action buttons column
            let cell = cells[j];
            if (cell) {
                let textValue = cell.textContent || cell.innerText;
                if (textValue.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;  // Stop searching in other cells if one matches
                }
            }
        }

        // Show or hide the row based on the match
        if (match) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

//Funcion de numero serial
function updateSerialNumbers() {
    const tableBody = document.getElementById("userTableBody");
    if (!tableBody) return; // Salir si no existe el elemento

    const rows = tableBody.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const serialCell = rows[i].getElementsByTagName("td")[0];
        if (serialCell) {
            serialCell.textContent = i + 1;
        }
    }
}

document.addEventListener("DOMContentLoaded", updateSerialNumbers);

//funciones del selector de columnas
function showRows() {
    const rowLimit = document.getElementById("rowLimit");
    if (!rowLimit) return; // Salir si no existe el elemento

    const selectedValue = rowLimit.value; // Obtener el valor seleccionado
    const tableBody = document.getElementById("userTableBody");
    if (!tableBody) return; // Salir si no existe el elemento

    const rows = tableBody.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        // Mostrar u ocultar las filas según el valor seleccionado
        if (selectedValue === "all" || i < selectedValue) {
            rows[i].style.display = ""; // Mostrar la fila
        } else {
            rows[i].style.display = "none"; // Ocultar la fila
        }
    }
}
// Mostrar todas las filas al cargar la página
document.addEventListener("DOMContentLoaded", () => showRows());

//Manejo de la paginacion

let rowsPerPage = "all"; // Mostrar todas las filas por defecto
let currentPage = 1;
let rows = [];
let totalPages = 0;

document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById("userTableBody");
    if (!tableBody) return; // Salir si no existe el elemento

    rows = Array.from(document.querySelectorAll("#userTableBody tr"));
    totalPages = Math.ceil(rows.length / rowsPerPage);

    // Mostrar todas las filas si se selecciona 'all'
    function displayPage(page) {
        // Ocultar todas las filas
        rows.forEach(row => row.style.display = 'none');

        if (rowsPerPage === 'all') {
            // Si se selecciona 'Todas', mostrar todas las filas sin paginación
            rows.forEach(row => row.style.display = '');
            totalPages = 1;  // Solo hay una página
        } else {
            // Calcular el rango de filas para mostrar en la página actual
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // Mostrar las filas correspondientes a la página actual
            for (let i = start; i < end && i < rows.length; i++) {
                rows[i].style.display = '';
            }
        }

        updatePagination(page);
    }

    // Actualizar botones de paginación
    function updatePagination(page) {
        const pageLinks = document.querySelectorAll('#pagination .page-item a');
        if (pageLinks.length === 0) return; // Salir si no existen los elementos

        pageLinks.forEach(link => {
            const pageNumber = parseInt(link.textContent);
            if (pageNumber === page) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });

        const firstPageLink = document.querySelector('#pagination .page-item:first-child a');
        const lastPageLink = document.querySelector('#pagination .page-item:last-child a');

        if (firstPageLink) {
            firstPageLink.classList.toggle('disabled', page === 1);
        }
        if (lastPageLink) {
            lastPageLink.classList.toggle('disabled', page === totalPages);
        }
    }

    // Cambiar página
    function changePage(page) {
        if (page === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (page === 'next' && currentPage < totalPages) {
            currentPage++;
        } else if (typeof page === 'number' && page >= 1 && page <= totalPages) {
            currentPage = page;
        }
        displayPage(currentPage);
    }

    // Función que actualiza el número de filas por página según la selección
    function updateRowsPerPage() {
        const rowLimitElement = document.getElementById('rowLimit');
        if (!rowLimitElement) return; // Salir si no existe el elemento

        const selectedValue = rowLimitElement.value;
        rowsPerPage = selectedValue;  // Guardar el valor de filas seleccionadas

        if (rowsPerPage === 'all') {
            totalPages = 1;  // Solo una página cuando se muestran todas las filas
            currentPage = 1;  // Reiniciar a la primera página
        } else {
            rowsPerPage = parseInt(rowsPerPage);  // Establecer filas por página
            totalPages = Math.ceil(rows.length / rowsPerPage);  // Calcular el número de páginas
        }

        displayPage(currentPage);  // Mostrar la página actual
    }

    // Inicializar la tabla con la primera página
    displayPage(currentPage);

    // Exponer funciones para cambiar de página
    window.changePage = changePage;
    window.updateRowsPerPage = updateRowsPerPage;
});

//FORMULARIO DE RESPONSABLES
function openModal() {
    const modal = document.getElementById('userModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeModal() {
    const modal = document.getElementById('userModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function openAlert(message, action, button) {
    const alertMessage = document.getElementById('alertMessage');
    const alertModal = document.getElementById('alertModal');

    if (alertMessage && alertModal) {
        alertMessage.textContent = message;
        currentAction = action;
        currentButton = button;
        alertModal.style.display = 'flex';
    }
}

function closeAlert() {
    const alertModal = document.getElementById('alertModal');
    if (alertModal) {
        alertModal.style.display = 'none';
    }
}

function confirmAction(action, button) {
    const message = action === 'delete' ?
        '¿Está seguro de que desea eliminar este registro?' :
        '¿Está seguro de que desea editar este registro?';
    openAlert(message, action, button);
}

const alertConfirmBtn = document.getElementById('alertConfirm');
if (alertConfirmBtn) {
    alertConfirmBtn.addEventListener('click', function () {
        if (currentAction === 'delete') {
            const row = currentButton.closest('tr');
            row.remove();
        } else if (currentAction === 'edit') {
            const row = currentButton.closest('tr');
            const cells = row.querySelectorAll('td');

            // Detectar si estamos en la página de Asesoría en Derecho Tributario
            if (document.getElementById('cedula') && document.getElementById('numero_proceso')) {
                // Formulario de clientes/procesos (Asesoría en Derecho Tributario)
                document.getElementById('cedula').value = cells[1].textContent;
                document.getElementById('nombre').value = cells[2].textContent;
                document.getElementById('direccion').value = cells[3].textContent;
                document.getElementById('telefono').value = cells[4].textContent;
                document.getElementById('email').value = cells[5].textContent;
                document.getElementById('numero_proceso').value = cells[6].textContent;
                document.getElementById('estado').value = cells[7].textContent;

                // Guardar referencia de la fila que se está editando
                window.editingRow = row;
            } else if (document.getElementById('numero') && document.getElementById('area')) {
                // Formulario de responsables
                document.getElementById('numero').value = cells[1].textContent;
                document.getElementById('nombre').value = cells[2].textContent;
                document.getElementById('area').value = cells[3].textContent;
                document.getElementById('contacto').value = cells[4].textContent;

                // Guardar referencia de la fila que se está editando
                window.editingRow = row;
            }

            openModal();
        }

        closeAlert();
        updateSerialNumbers();
    });
}

// Manejo del formulario
const userForm = document.getElementById('userForm');
if (userForm) {
    userForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const errorDiv = document.getElementById('error');
        errorDiv.textContent = ''; // Limpiar errores anteriores

        const cedula = document.getElementById('numero').value.trim();
        const nombre = document.getElementById('nombre').value.trim();
        const area = document.getElementById('area').value.trim();
        const contacto = document.getElementById('contacto').value.trim();

        if (!cedula || !nombre || !area || !contacto) {
            errorDiv.textContent = 'Por favor, complete todos los campos.';
            return;
        }

        const tableBody = document.getElementById('userTableBody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>${tableBody.children.length + 1}</td>
            <td>${cedula}</td>
            <td>${nombre}</td>
            <td>${area}</td>
            <td>${contacto}</td>
            <td style="text-align: center;">
                <button class="btn btn-success edit" onclick="confirmAction('edit', this)">Editar</button>
                <button class="btn btn-danger delete" onclick="confirmAction('delete', this)">Eliminar</button>
            </td>
        `;

        tableBody.appendChild(newRow);

        // Limpiar el formulario
        document.getElementById('userForm').reset();
        closeModal();
        updateSerialNumbers();
    });
}

// Actualizar los números de serie
function updateSerialNumbers() {
    const rows = document.querySelectorAll('#userTableBody tr');
    rows.forEach((row, index) => {
        row.children[0].textContent = index + 1;
    });
}

// === FUNCIONALIDAD PARA FORMULARIO MODAL DE PROCESOS/CLIENTES ===
// Asume que el formulario tiene los siguientes IDs: cedula, nombre, direccion, telefono, email, numero_proceso, estado
// Y la tabla tiene el tbody con id="userTableBody"

// Elimina listeners duplicados previos
if (userForm) {
    // Remover event listener anterior si existe
    userForm.removeEventListener('submit', userForm._submitHandler);

    userForm._submitHandler = function (event) {
        event.preventDefault();
        const errorDiv = document.getElementById('error');
        if (errorDiv) errorDiv.textContent = '';

        // Detectar si estamos en la página de Asesoría en Derecho Tributario
        if (document.getElementById('cedula') && document.getElementById('numero_proceso')) {
            // Formulario de clientes/procesos (Asesoría en Derecho Tributario)
            const cedula = document.getElementById('cedula')?.value.trim();
            const nombre = document.getElementById('nombre')?.value.trim();
            const direccion = document.getElementById('direccion')?.value.trim();
            const telefono = document.getElementById('telefono')?.value.trim();
            const email = document.getElementById('email')?.value.trim();
            const numero_proceso = document.getElementById('numero_proceso')?.value.trim();
            const estado = document.getElementById('estado')?.value;

            // Validar campos obligatorios
            if (!cedula || !nombre || !direccion || !telefono || !email || !numero_proceso || !estado) {
                if (errorDiv) errorDiv.textContent = 'Por favor, complete todos los campos obligatorios.';
                return;
            }

            const tableBody = document.getElementById('userTableBody');

            // Si estamos editando una fila existente
            if (window.editingRow) {
                // Actualizar la fila existente
                const cells = window.editingRow.querySelectorAll('td');
                cells[1].textContent = cedula;
                cells[2].textContent = nombre;
                cells[3].textContent = direccion;
                cells[4].textContent = telefono;
                cells[5].textContent = email;
                cells[6].textContent = numero_proceso;
                cells[7].textContent = estado;
                window.editingRow = null;
            } else {
                // Crear nueva fila
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="table-cell"></td> <!-- # -->
                    <td class="table-cell">${cedula}</td>
                    <td class="table-cell">${nombre}</td>
                    <td class="table-cell">${direccion}</td>
                    <td class="table-cell">${telefono}</td>
                    <td class="table-cell">${email}</td>
                    <td class="table-cell">${numero_proceso}</td>
                    <td class="table-cell">${estado}</td>
                    <td class="action-buttons">
                        <button class="btn btn-success edit" onclick="confirmAction('edit', this)">Editar</button>
                        <button class="btn btn-danger delete" onclick="confirmAction('delete', this)">Eliminar</button>
                    </td>
                `;
                tableBody.appendChild(newRow);
            }

            updateSerialNumbers();
            userForm.reset();
            closeModal();
        } else if (document.getElementById('numero') && document.getElementById('area')) {
            // Formulario de responsables
            const cedula = document.getElementById('numero')?.value.trim();
            const nombre = document.getElementById('nombre')?.value.trim();
            const area = document.getElementById('area')?.value.trim();
            const contacto = document.getElementById('contacto')?.value.trim();

            if (!cedula || !nombre || !area || !contacto) {
                if (errorDiv) errorDiv.textContent = 'Por favor, complete todos los campos.';
                return;
            }

            const tableBody = document.getElementById('userTableBody');

            // Si estamos editando una fila existente
            if (window.editingRow) {
                // Actualizar la fila existente
                const cells = window.editingRow.querySelectorAll('td');
                cells[1].textContent = cedula;
                cells[2].textContent = nombre;
                cells[3].textContent = area;
                cells[4].textContent = contacto;
                window.editingRow = null;
            } else {
                // Crear nueva fila
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${tableBody.children.length + 1}</td>
                    <td>${cedula}</td>
                    <td>${nombre}</td>
                    <td>${area}</td>
                    <td>${contacto}</td>
                    <td style="text-align: center;">
                        <button class="btn btn-success edit" onclick="confirmAction('edit', this)">Editar</button>
                        <button class="btn btn-danger delete" onclick="confirmAction('delete', this)">Eliminar</button>
                    </td>
                `;
                tableBody.appendChild(newRow);
            }

            updateSerialNumbers();
            userForm.reset();
            closeModal();
        }
    };

    userForm.addEventListener('submit', userForm._submitHandler);
}

// Actualiza los números de serie en la primera columna
function updateSerialNumbers() {
    const rows = document.querySelectorAll('#userTableBody tr');
    rows.forEach((row, index) => {
        row.children[0].textContent = index + 1;
    });
}

// === FUNCIONALIDAD AJAX PARA TODOS LOS PROCESOS ===
if (window.location.pathname.includes('/procesos/')) {
    const form = document.getElementById('userForm');
    const tableBody = document.getElementById('userTableBody');
    let editingId = null;

    // Cargar procesos existentes al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        // Si no hay datos en la tabla, agregar ejemplos
        if (tableBody.children.length === 0) {
            addProcesosExamples();
        } else {
            fetchProcesos();
        }
    });

    function addProcesosExamples() {
        const examples = [
            { control_activos: 'ACT-001', fecha_adquisicion: '2024-01-15', depreciacion: 15000, fecha_ultimo_mantenimiento: '2024-12-01', fecha_proximo_mantenimiento: '2025-06-01', proveedor_mantenimiento: 'Mantenimiento Pro S.A.', valor_mantenimiento: 2500, id_tipos: 1, id_cedula: 1 },
            { control_activos: 'ACT-002', fecha_adquisicion: '2024-02-20', depreciacion: 22000, fecha_ultimo_mantenimiento: '2024-11-15', fecha_proximo_mantenimiento: '2025-05-15', proveedor_mantenimiento: 'Servicios Técnicos Ltda.', valor_mantenimiento: 3200, id_tipos: 2, id_cedula: 2 },
            { control_activos: 'ACT-003', fecha_adquisicion: '2024-03-10', depreciacion: 18000, fecha_ultimo_mantenimiento: '2024-10-30', fecha_proximo_mantenimiento: '2025-04-30', proveedor_mantenimiento: 'Equipos y Más', valor_mantenimiento: 2100, id_tipos: 1, id_cedula: 3 },
            { control_activos: 'ACT-004', fecha_adquisicion: '2024-04-05', depreciacion: 30000, fecha_ultimo_mantenimiento: '2024-12-10', fecha_proximo_mantenimiento: '2025-06-10', proveedor_mantenimiento: 'Mantenimiento Integral', valor_mantenimiento: 4500, id_tipos: 3, id_cedula: 4 },
            { control_activos: 'ACT-005', fecha_adquisicion: '2024-05-12', depreciacion: 12000, fecha_ultimo_mantenimiento: '2024-11-20', fecha_proximo_mantenimiento: '2025-05-20', proveedor_mantenimiento: 'Técnicos Especializados', valor_mantenimiento: 1800, id_tipos: 2, id_cedula: 5 },
            { control_activos: 'ACT-006', fecha_adquisicion: '2024-06-18', depreciacion: 25000, fecha_ultimo_mantenimiento: '2024-12-05', fecha_proximo_mantenimiento: '2025-06-05', proveedor_mantenimiento: 'Servicios Profesionales', valor_mantenimiento: 3800, id_tipos: 1, id_cedula: 6 },
            { control_activos: 'ACT-007', fecha_adquisicion: '2024-07-25', depreciacion: 16000, fecha_ultimo_mantenimiento: '2024-10-15', fecha_proximo_mantenimiento: '2025-04-15', proveedor_mantenimiento: 'Mantenimiento Express', valor_mantenimiento: 2200, id_tipos: 2, id_cedula: 7 },
            { control_activos: 'ACT-008', fecha_adquisicion: '2024-08-30', depreciacion: 28000, fecha_ultimo_mantenimiento: '2024-11-25', fecha_proximo_mantenimiento: '2025-05-25', proveedor_mantenimiento: 'Técnicos Calificados', valor_mantenimiento: 4200, id_tipos: 3, id_cedula: 8 },
            { control_activos: 'ACT-009', fecha_adquisicion: '2024-09-14', depreciacion: 14000, fecha_ultimo_mantenimiento: '2024-12-20', fecha_proximo_mantenimiento: '2025-06-20', proveedor_mantenimiento: 'Servicios Rápidos', valor_mantenimiento: 1900, id_tipos: 1, id_cedula: 9 },
            { control_activos: 'ACT-010', fecha_adquisicion: '2024-10-22', depreciacion: 32000, fecha_ultimo_mantenimiento: '2024-11-10', fecha_proximo_mantenimiento: '2025-05-10', proveedor_mantenimiento: 'Mantenimiento Premium', valor_mantenimiento: 5200, id_tipos: 3, id_cedula: 10 }
        ];

        examples.forEach((proceso, idx) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="table-cell">${idx + 1}</td>
                <td class="table-cell">${proceso.control_activos}</td>
                <td class="table-cell">${proceso.fecha_adquisicion}</td>
                <td class="table-cell">${proceso.depreciacion}</td>
                <td class="table-cell">${proceso.fecha_ultimo_mantenimiento}</td>
                <td class="table-cell">${proceso.fecha_proximo_mantenimiento}</td>
                <td class="table-cell">${proceso.proveedor_mantenimiento}</td>
                <td class="table-cell">${proceso.valor_mantenimiento}</td>
                <td class="table-cell">${proceso.id_tipos}</td>
                <td class="table-cell">${proceso.id_cedula}</td>
                <td class="table-cell action-buttons">
                    <button class="btn btn-success" onclick="editProceso(${idx + 1}, this)">Editar</button>
                    <button class="btn btn-danger" onclick="deleteProceso(${idx + 1}, this)">Eliminar</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function fetchProcesos() {
        fetch('/api/procesos')
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = '';
                data.forEach((proceso, idx) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class=\"table-cell\">${idx + 1}</td>
                        <td class=\"table-cell\">${proceso.control_activos}</td>
                        <td class=\"table-cell\">${proceso.fecha_adquisicion}</td>
                        <td class=\"table-cell\">${proceso.depreciacion}</td>
                        <td class=\"table-cell\">${proceso.fecha_ultimo_mantenimiento}</td>
                        <td class=\"table-cell\">${proceso.fecha_proximo_mantenimiento}</td>
                        <td class=\"table-cell\">${proceso.proveedor_mantenimiento}</td>
                        <td class=\"table-cell\">${proceso.valor_mantenimiento}</td>
                        <td class=\"table-cell\">${proceso.id_tipos}</td>
                        <td class=\"table-cell\">${proceso.id_cedula}</td>
                        <td class=\"table-cell action-buttons\">
                            <button class=\"btn btn-success\" onclick=\"editProceso(${proceso.id_procesos}, this)\">Editar</button>
                            <button class=\"btn btn-danger\" onclick=\"deleteProceso(${proceso.id_procesos}, this)\">Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }

    // Guardar o actualizar proceso
    form.onsubmit = function(e) {
        e.preventDefault();
        const errorDiv = document.getElementById('error');
        errorDiv.textContent = '';

        // Validar campos
        const control_activos = form.control_activos.value.trim();
        const fecha_adquisicion = form.fecha_adquisicion.value;
        const depreciacion = form.depreciacion.value;
        const fecha_ultimo_mantenimiento = form.fecha_ultimo_mantenimiento.value;
        const fecha_proximo_mantenimiento = form.fecha_proximo_mantenimiento.value;
        const proveedor_mantenimiento = form.proveedor_mantenimiento.value.trim();
        const valor_mantenimiento = form.valor_mantenimiento.value;
        const id_tipos = form.id_tipos.value;
        const id_cedula = form.id_cedula.value;

        if (!control_activos || !fecha_adquisicion || !depreciacion || !fecha_ultimo_mantenimiento ||
            !fecha_proximo_mantenimiento || !proveedor_mantenimiento || !valor_mantenimiento || !id_tipos || !id_cedula) {
            errorDiv.textContent = 'Por favor, complete todos los campos.';
            return;
        }

        // Si estamos editando una fila existente
        if (window.editingRow) {
            // Actualizar la fila existente
            const cells = window.editingRow.querySelectorAll('td');
            cells[1].textContent = control_activos;
            cells[2].textContent = fecha_adquisicion;
            cells[3].textContent = depreciacion;
            cells[4].textContent = fecha_ultimo_mantenimiento;
            cells[5].textContent = fecha_proximo_mantenimiento;
            cells[6].textContent = proveedor_mantenimiento;
            cells[7].textContent = valor_mantenimiento;
            cells[8].textContent = id_tipos;
            cells[9].textContent = id_cedula;
            window.editingRow = null;
        } else {
            // Crear nueva fila
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="table-cell">${tableBody.children.length + 1}</td>
                <td class="table-cell">${control_activos}</td>
                <td class="table-cell">${fecha_adquisicion}</td>
                <td class="table-cell">${depreciacion}</td>
                <td class="table-cell">${fecha_ultimo_mantenimiento}</td>
                <td class="table-cell">${fecha_proximo_mantenimiento}</td>
                <td class="table-cell">${proveedor_mantenimiento}</td>
                <td class="table-cell">${valor_mantenimiento}</td>
                <td class="table-cell">${id_tipos}</td>
                <td class="table-cell">${id_cedula}</td>
                <td class="table-cell action-buttons">
                    <button class="btn btn-success" onclick="editProceso(${tableBody.children.length + 1}, this)">Editar</button>
                    <button class="btn btn-danger" onclick="deleteProceso(${tableBody.children.length + 1}, this)">Eliminar</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        }

        updateSerialNumbers();
        form.reset();
        closeModal();
        editingId = null;
    };

    // Editar proceso
    window.editProceso = function(id, btn) {
        const row = btn.closest('tr');
        const cells = row.querySelectorAll('td');

        // Llenar el formulario con los datos de la fila
        form.control_activos.value = cells[1].textContent;
        form.fecha_adquisicion.value = cells[2].textContent;
        form.depreciacion.value = cells[3].textContent;
        form.fecha_ultimo_mantenimiento.value = cells[4].textContent;
        form.fecha_proximo_mantenimiento.value = cells[5].textContent;
        form.proveedor_mantenimiento.value = cells[6].textContent;
        form.valor_mantenimiento.value = cells[7].textContent;
        form.id_tipos.value = cells[8].textContent;
        form.id_cedula.value = cells[9].textContent;

        // Guardar referencia de la fila que se está editando
        window.editingRow = row;
        editingId = id;
        openModal();
    };

    // Eliminar proceso
    window.deleteProceso = function(id, btn) {
        if (!confirm('¿Está seguro de eliminar este proceso?')) return;
        const row = btn.closest('tr');
        row.remove();
        updateSerialNumbers();
    };
}

// === FUNCIONALIDAD AJAX PARA RESPONSABLES ===
if (window.location.pathname.includes('/usuarios/responsables')) {
    const form = document.getElementById('userForm');
    const tableBody = document.getElementById('userTableBody');
    let editingId = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Si no hay datos en la tabla, agregar ejemplos
        if (tableBody.children.length === 0) {
            addResponsablesExamples();
        } else {
            fetchResponsables();
        }
    });

    function addResponsablesExamples() {
        const examples = [
            { id_cedula: '0912345678', administrador: 'Dr. Carlos Mendoza' },
            { id_cedula: '0923456789', administrador: 'Dra. Ana González' },
            { id_cedula: '0934567890', administrador: 'Dr. Roberto Silva' },
            { id_cedula: '0945678901', administrador: 'Dra. Patricia Torres' },
            { id_cedula: '0956789012', administrador: 'Dr. Fernando Herrera' },
            { id_cedula: '0967890123', administrador: 'Dra. Carmen Vega' },
            { id_cedula: '0978901234', administrador: 'Dr. Luis Morales' },
            { id_cedula: '0989012345', administrador: 'Dra. María Rodríguez' },
            { id_cedula: '0990123456', administrador: 'Dr. Juan Pérez' },
            { id_cedula: '0991234567', administrador: 'Dra. Isabel López' }
        ];

        examples.forEach((responsable, idx) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${idx + 1}</td>
                <td>${responsable.id_cedula}</td>
                <td>${responsable.administrador}</td>
                <td>Fiscal</td>
                <td>${responsable.id_cedula}@asesoria.com</td>
                <td class='table-cell action-buttons'>
                    <button class='btn btn-success' onclick='editResponsable(${idx + 1}, this)'>Editar</button>
                    <button class='btn btn-danger' onclick='deleteResponsable(${idx + 1}, this)'>Eliminar</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function fetchResponsables() {
        fetch('/api/responsables')
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = '';
                data.forEach((responsable, idx) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${idx + 1}</td>
                        <td>${responsable.id_cedula}</td>
                        <td>${responsable.administrador}</td>
                        <td></td>
                        <td></td>
                        <td class='table-cell action-buttons'>
                            <button class='btn btn-success' onclick='editResponsable(${responsable.id_responsables}, this)'>Editar</button>
                            <button class='btn btn-danger' onclick='deleteResponsable(${responsable.id_responsables}, this)'>Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }

    form.onsubmit = function(e) {
        e.preventDefault();
        const errorDiv = document.getElementById('error');
        errorDiv.textContent = '';

        const administrador = form.administrador.value.trim();
        const id_cedula = form.id_cedula.value.trim();

        if (!administrador || !id_cedula) {
            errorDiv.textContent = 'Por favor, complete todos los campos.';
            return;
        }

        // Si estamos editando una fila existente
        if (window.editingRow) {
            // Actualizar la fila existente
            const cells = window.editingRow.querySelectorAll('td');
            cells[1].textContent = id_cedula;
            cells[2].textContent = administrador;
            window.editingRow = null;
        } else {
            // Crear nueva fila
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${tableBody.children.length + 1}</td>
                <td>${id_cedula}</td>
                <td>${administrador}</td>
                <td>Fiscal</td>
                <td>${id_cedula}@asesoria.com</td>
                <td class='table-cell action-buttons'>
                    <button class='btn btn-success' onclick='editResponsable(${tableBody.children.length + 1}, this)'>Editar</button>
                    <button class='btn btn-danger' onclick='deleteResponsable(${tableBody.children.length + 1}, this)'>Eliminar</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        }

        updateSerialNumbers();
        form.reset();
        closeModal();
        editingId = null;
    };

    window.editResponsable = function(id, btn) {
        const row = btn.closest('tr');
        const cells = row.querySelectorAll('td');

        // Llenar el formulario con los datos de la fila
        form.administrador.value = cells[2].textContent;
        form.id_cedula.value = cells[1].textContent;

        // Guardar referencia de la fila que se está editando
        window.editingRow = row;
        editingId = id;
        openModal();
    };

    window.deleteResponsable = function(id, btn) {
        if (!confirm('¿Está seguro de eliminar este responsable?')) return;
        const row = btn.closest('tr');
        row.remove();
        updateSerialNumbers();
    };
}

// === FUNCIONALIDAD AJAX PARA PERSONAL ===
if (window.location.pathname.includes('/usuarios/registro_personal')) {
    const form = document.getElementById('userForm');
    const tableBody = document.getElementById('userTableBody');
    let editingId = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Si no hay datos en la tabla, agregar ejemplos
        if (tableBody.children.length === 0) {
            addPersonalExamples();
        } else {
            fetchPersonal();
        }
    });

    function addPersonalExamples() {
        const examples = [
            { cedula: '0912345678', nombres: 'Carlos', apellidos: 'Mendoza López', telefono: '0961488328', cargo: 'Abogado Fiscal' },
            { cedula: '0923456789', nombres: 'Ana', apellidos: 'González Torres', telefono: '0967362845', cargo: 'Contadora Senior' },
            { cedula: '0934567890', nombres: 'Roberto', apellidos: 'Silva Herrera', telefono: '0987654321', cargo: 'Asesor Tributario' },
            { cedula: '0945678901', nombres: 'Patricia', apellidos: 'Torres Vega', telefono: '0976543210', cargo: 'Auditor Fiscal' },
            { cedula: '0956789012', nombres: 'Fernando', apellidos: 'Herrera Morales', telefono: '0965432109', cargo: 'Consultor Jurídico' },
            { cedula: '0967890123', nombres: 'Carmen', apellidos: 'Vega Rodríguez', telefono: '0954321098', cargo: 'Especialista en Impuestos' },
            { cedula: '0978901234', nombres: 'Luis', apellidos: 'Morales Pérez', telefono: '0943210987', cargo: 'Analista Fiscal' },
            { cedula: '0989012345', nombres: 'María', apellidos: 'Rodríguez López', telefono: '0932109876', cargo: 'Asistente Legal' },
            { cedula: '0990123456', nombres: 'Juan', apellidos: 'Pérez González', telefono: '0921098765', cargo: 'Técnico Tributario' },
            { cedula: '0991234567', nombres: 'Isabel', apellidos: 'López Silva', telefono: '0910987654', cargo: 'Coordinador Fiscal' }
        ];

        examples.forEach((personal, idx) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${idx + 1}</td>
                <td>${personal.cedula}</td>
                <td>${personal.nombres}</td>
                <td>${personal.apellidos}</td>
                <td>${personal.telefono}</td>
                <td>${personal.cargo}</td>
                <td class='table-cell action-buttons'>
                    <button class='btn btn-success' onclick='editPersonal(${idx + 1}, this)'>Editar</button>
                    <button class='btn btn-danger' onclick='deletePersonal(${idx + 1}, this)'>Eliminar</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function fetchPersonal() {
        fetch('/api/personal')
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = '';
                data.forEach((personal, idx) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${idx + 1}</td>
                        <td>${personal.cedula}</td>
                        <td>${personal.nombres}</td>
                        <td>${personal.apellidos}</td>
                        <td>${personal.telefono || ''}</td>
                        <td>${personal.cargo || ''}</td>
                        <td class='table-cell action-buttons'>
                            <button class='btn btn-success' onclick='editPersonal(${personal.id_personal}, this)'>Editar</button>
                            <button class='btn btn-danger' onclick='deletePersonal(${personal.id_personal}, this)'>Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }

    form.onsubmit = function(e) {
        e.preventDefault();
        const errorDiv = document.getElementById('error');
        errorDiv.textContent = '';

        const cedula = form.cedula.value.trim();
        const nombres = form.nombres.value.trim();
        const apellidos = form.apellidos.value.trim();
        const telefono = form.telefono.value.trim();
        const cargo = form.cargo.value.trim();

        if (!cedula || !nombres || !apellidos || !telefono || !cargo) {
            errorDiv.textContent = 'Por favor, complete todos los campos.';
            return;
        }

        // Si estamos editando una fila existente
        if (window.editingRow) {
            // Actualizar la fila existente
            const cells = window.editingRow.querySelectorAll('td');
            cells[1].textContent = cedula;
            cells[2].textContent = nombres;
            cells[3].textContent = apellidos;
            cells[4].textContent = telefono;
            cells[5].textContent = cargo;
            window.editingRow = null;
        } else {
            // Crear nueva fila
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${tableBody.children.length + 1}</td>
                <td>${cedula}</td>
                <td>${nombres}</td>
                <td>${apellidos}</td>
                <td>${telefono}</td>
                <td>${cargo}</td>
                <td class='table-cell action-buttons'>
                    <button class='btn btn-success' onclick='editPersonal(${tableBody.children.length + 1}, this)'>Editar</button>
                    <button class='btn btn-danger' onclick='deletePersonal(${tableBody.children.length + 1}, this)'>Eliminar</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        }

        updateSerialNumbers();
        form.reset();
        closeModal();
        editingId = null;
    };

    window.editPersonal = function(id, btn) {
        const row = btn.closest('tr');
        const cells = row.querySelectorAll('td');

        // Llenar el formulario con los datos de la fila
        form.cedula.value = cells[1].textContent;
        form.nombres.value = cells[2].textContent;
        form.apellidos.value = cells[3].textContent;
        form.telefono.value = cells[4].textContent;
        form.cargo.value = cells[5].textContent;

        // Guardar referencia de la fila que se está editando
        window.editingRow = row;
        editingId = id;
        openModal();
    };

    window.deletePersonal = function(id, btn) {
        if (!confirm('¿Está seguro de eliminar este personal?')) return;
        const row = btn.closest('tr');
        row.remove();
        updateSerialNumbers();
    };
}

// === FUNCIONALIDAD AJAX PARA USUARIOS ===
if (window.location.pathname.includes('/usuarios/registro_usuario')) {
    const form = document.getElementById('userForm');
    const tableBody = document.getElementById('userTableBody');
    let editingId = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Si no hay datos en la tabla, agregar ejemplos
        if (tableBody.children.length === 0) {
            addUsuariosExamples();
        } else {
            fetchUsuarios();
        }
    });

    function addUsuariosExamples() {
        const examples = [
            { id_cedula: '0912345678', nombre: 'Carlos', apellidos: 'Mendoza López', numero_telefonico: '0961488328', cargo: 'Administrador' },
            { id_cedula: '0923456789', nombre: 'Ana', apellidos: 'González Torres', numero_telefonico: '0967362845', cargo: 'Secretaria' },
            { id_cedula: '0934567890', nombre: 'Roberto', apellidos: 'Silva Herrera', numero_telefonico: '0987654321', cargo: 'Recepcionista' },
            { id_cedula: '0945678901', nombre: 'Patricia', apellidos: 'Torres Vega', numero_telefonico: '0976543210', cargo: 'Asistente' },
            { id_cedula: '0956789012', nombre: 'Fernando', apellidos: 'Herrera Morales', numero_telefonico: '0965432109', cargo: 'Coordinador' },
            { id_cedula: '0967890123', nombre: 'Carmen', apellidos: 'Vega Rodríguez', numero_telefonico: '0954321098', cargo: 'Supervisor' },
            { id_cedula: '0978901234', nombre: 'Luis', apellidos: 'Morales Pérez', numero_telefonico: '0943210987', cargo: 'Analista' },
            { id_cedula: '0989012345', nombre: 'María', apellidos: 'Rodríguez López', numero_telefonico: '0932109876', cargo: 'Técnico' },
            { id_cedula: '0990123456', nombre: 'Juan', apellidos: 'Pérez González', numero_telefonico: '0921098765', cargo: 'Operador' },
            { id_cedula: '0991234567', nombre: 'Isabel', apellidos: 'López Silva', numero_telefonico: '0910987654', cargo: 'Auxiliar' }
        ];

        examples.forEach((usuario, idx) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${idx + 1}</td>
                <td>${usuario.id_cedula}</td>
                <td>${usuario.nombre}</td>
                <td>${usuario.apellidos}</td>
                <td>${usuario.numero_telefonico}</td>
                <td>${usuario.cargo}</td>
                <td class='table-cell action-buttons'>
                    <button class='btn btn-success' onclick='editUsuario(${idx + 1}, this)'>Editar</button>
                    <button class='btn btn-danger' onclick='deleteUsuario(${idx + 1}, this)'>Eliminar</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function fetchUsuarios() {
        fetch('/api/usuarios')
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = '';
                data.forEach((usuario, idx) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${idx + 1}</td>
                        <td>${usuario.id_cedula}</td>
                        <td>${usuario.nombre}</td>
                        <td>${usuario.apellidos || ''}</td>
                        <td>${usuario.numero_telefonico || ''}</td>
                        <td>${usuario.cargo || ''}</td>
                        <td class='table-cell action-buttons'>
                            <button class='btn btn-success' onclick='editUsuario(${usuario.id_cedula}, this)'>Editar</button>
                            <button class='btn btn-danger' onclick='deleteUsuario(${usuario.id_cedula}, this)'>Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }

    form.onsubmit = function(e) {
        e.preventDefault();
        const errorDiv = document.getElementById('error');
        errorDiv.textContent = '';

        const id_cedula = form.cedula.value.trim();
        const nombre = form.nombres.value.trim();
        const apellidos = form.apellidos ? form.apellidos.value.trim() : '';
        const numero_telefonico = form.telefono ? form.telefono.value.trim() : '';
        const cargo = form.cargo ? form.cargo.value.trim() : '';

        if (!id_cedula || !nombre) {
            errorDiv.textContent = 'Por favor, complete los campos obligatorios.';
            return;
        }

        // Si estamos editando una fila existente
        if (window.editingRow) {
            // Actualizar la fila existente
            const cells = window.editingRow.querySelectorAll('td');
            cells[1].textContent = id_cedula;
            cells[2].textContent = nombre;
            cells[3].textContent = apellidos;
            cells[4].textContent = numero_telefonico;
            cells[5].textContent = cargo;
            window.editingRow = null;
        } else {
            // Crear nueva fila
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${tableBody.children.length + 1}</td>
                <td>${id_cedula}</td>
                <td>${nombre}</td>
                <td>${apellidos}</td>
                <td>${numero_telefonico}</td>
                <td>${cargo}</td>
                <td class='table-cell action-buttons'>
                    <button class='btn btn-success' onclick='editUsuario(${tableBody.children.length + 1}, this)'>Editar</button>
                    <button class='btn btn-danger' onclick='deleteUsuario(${tableBody.children.length + 1}, this)'>Eliminar</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        }

        updateSerialNumbers();
        form.reset();
        closeModal();
        editingId = null;
    };

    window.editUsuario = function(id, btn) {
        const row = btn.closest('tr');
        const cells = row.querySelectorAll('td');

        // Llenar el formulario con los datos de la fila
        form.cedula.value = cells[1].textContent;
        form.nombres.value = cells[2].textContent;
        if(form.apellidos) form.apellidos.value = cells[3].textContent;
        if(form.telefono) form.telefono.value = cells[4].textContent;
        if(form.cargo) form.cargo.value = cells[5].textContent;

        // Guardar referencia de la fila que se está editando
        window.editingRow = row;
        editingId = id;
        openModal();
    };

    window.deleteUsuario = function(id, btn) {
        if (!confirm('¿Está seguro de eliminar este usuario?')) return;
        const row = btn.closest('tr');
        row.remove();
        updateSerialNumbers();
    };
}
