const euroFormatter = new Intl.NumberFormat("es-ES", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
});

const clampNumber = (value) => {
    const parsed = Number(value);
    if (!Number.isFinite(parsed) || parsed < 0) {
        return 0;
    }

    return parsed;
};

document.addEventListener("DOMContentLoaded", () => {
    const root = document.querySelector("[data-albaran-form]");
    if (!root) {
        return;
    }

    const descripcionInput = document.getElementById("linea_descripcion");
    const cantidadInput = document.getElementById("linea_cantidad");
    const precioInput = document.getElementById("linea_precio");
    const addButton = document.getElementById("btnAddLinea");
    const editButton = document.getElementById("btnEditLinea");
    const deleteButton = document.getElementById("btnDeleteLinea");
    const tableBody = document.getElementById("lineasBody");
    const totalElement = document.getElementById("albaranTotalValue");
    const lineasJsonInput = document.getElementById("lineasJson");

    if (!descripcionInput || !cantidadInput || !precioInput || !addButton || !tableBody || !totalElement || !lineasJsonInput) {
        return;
    }

    const parseLineas = (raw) => {
        if (!raw || typeof raw !== "string") {
            return [];
        }

        try {
            const decoded = JSON.parse(raw);
            if (!Array.isArray(decoded)) {
                return [];
            }

            return decoded
                .filter((linea) => linea && typeof linea === "object")
                .map((linea) => ({
                    descripcion: String(linea.descripcion ?? "").trim(),
                    cantidad: clampNumber(linea.cantidad),
                    precio: clampNumber(linea.precio),
                }))
                .filter((linea) => linea.descripcion !== "");
        } catch (error) {
            return [];
        }
    };

    const lineasFromInput = parseLineas(lineasJsonInput.value);
    const lineasFromDataset = parseLineas(root.dataset.initialLineas ?? "[]");

    let lineas = lineasFromInput.length > 0 ? lineasFromInput : lineasFromDataset;
    let selectedIndex = -1;

    const resetInputs = () => {
        descripcionInput.value = "";
        cantidadInput.value = "1";
        precioInput.value = "0";
        descripcionInput.focus();
    };

    const syncHiddenField = () => {
        lineasJsonInput.value = JSON.stringify(lineas);
    };

    const updateTotal = () => {
        const total = lineas.reduce((acc, linea) => acc + (linea.cantidad * linea.precio), 0);
        totalElement.textContent = `${euroFormatter.format(total)} €`;
    };

    const setSideButtonsState = () => {
        const hasSelection = selectedIndex >= 0 && selectedIndex < lineas.length;

        if (editButton) {
            editButton.disabled = !hasSelection;
        }

        if (deleteButton) {
            deleteButton.disabled = !hasSelection;
        }
    };

    const renderRows = () => {
        if (lineas.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="6" class="lineas-empty">No hay lineas añadidas.</td></tr>';
            selectedIndex = -1;
            setSideButtonsState();
            syncHiddenField();
            updateTotal();
            return;
        }

        const rowsHtml = lineas
            .map((linea, index) => {
                const isSelected = index === selectedIndex;
                const totalLinea = linea.cantidad * linea.precio;

                return `
                    <tr data-index="${index}"${isSelected ? ' class="is-selected"' : ""}>
                        <td>${index + 1}</td>
                        <td>${linea.descripcion}</td>
                        <td>${euroFormatter.format(linea.cantidad)}</td>
                        <td>${euroFormatter.format(linea.precio)} €</td>
                        <td class="linea-total">${euroFormatter.format(totalLinea)} €</td>
                        <td>
                            <button type="button" class="linea-btn linea-edit" data-action="edit" data-index="${index}" title="Editar linea">
                                <i class="far fa-edit"></i>
                            </button>
                            <button type="button" class="linea-btn linea-delete" data-action="delete" data-index="${index}" title="Eliminar linea">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            })
            .join("");

        tableBody.innerHTML = rowsHtml;
        setSideButtonsState();
        syncHiddenField();
        updateTotal();
    };

    const saveCurrentInputs = () => {
        const descripcion = descripcionInput.value.trim();
        const cantidad = clampNumber(cantidadInput.value);
        const precio = clampNumber(precioInput.value);

        if (!descripcion) {
            descripcionInput.focus();
            return;
        }

        const payload = {
            descripcion,
            cantidad,
            precio,
        };

        if (selectedIndex >= 0 && selectedIndex < lineas.length) {
            lineas[selectedIndex] = payload;
            selectedIndex = -1;
            addButton.innerHTML = '<i class="fas fa-plus"></i> Agregar';
        } else {
            lineas.push(payload);
        }

        resetInputs();
        renderRows();
    };

    addButton.addEventListener("click", saveCurrentInputs);

    [descripcionInput, cantidadInput, precioInput].forEach((input) => {
        input.addEventListener("keydown", (event) => {
            if (event.key === "Enter") {
                event.preventDefault();
                saveCurrentInputs();
            }
        });
    });

    tableBody.addEventListener("click", (event) => {
        const target = event.target.closest("button[data-action]");
        const row = event.target.closest("tr[data-index]");

        if (row) {
            selectedIndex = Number(row.dataset.index);
        }

        if (target) {
            const index = Number(target.dataset.index);
            const action = target.dataset.action;

            if (action === "delete") {
                lineas.splice(index, 1);
                selectedIndex = -1;
                renderRows();
                return;
            }

            if (action === "edit") {
                const linea = lineas[index];
                if (!linea) {
                    return;
                }

                selectedIndex = index;
                descripcionInput.value = linea.descripcion;
                cantidadInput.value = String(linea.cantidad);
                precioInput.value = String(linea.precio);
                addButton.innerHTML = '<i class="far fa-save"></i> Aplicar';
                renderRows();
                descripcionInput.focus();
                return;
            }
        }

        renderRows();
    });

    if (editButton) {
        editButton.addEventListener("click", () => {
            if (selectedIndex < 0 || selectedIndex >= lineas.length) {
                return;
            }

            const linea = lineas[selectedIndex];
            descripcionInput.value = linea.descripcion;
            cantidadInput.value = String(linea.cantidad);
            precioInput.value = String(linea.precio);
            addButton.innerHTML = '<i class="far fa-save"></i> Aplicar';
            descripcionInput.focus();
        });
    }

    if (deleteButton) {
        deleteButton.addEventListener("click", () => {
            if (selectedIndex < 0 || selectedIndex >= lineas.length) {
                return;
            }

            lineas.splice(selectedIndex, 1);
            selectedIndex = -1;
            renderRows();
        });
    }

    renderRows();
});
