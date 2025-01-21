<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../menu/menu.css">
	<link rel="stylesheet" href="../css/listar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/ffd415cb1c.js" crossorigin="anonymous"></script>
	<title>Bios Informatica</title>
</head>

<body>
	<nav>
		<?php include "../menu/menu.php"; ?>
	</nav>
	<div class="container">
		<h1 class="title">Listado de Reparaciones</h1>
		<button type="submit" class="btn btn-insertar" onclick="insertar()"><i class="fa-solid fa-bug"></i>Nueva
			Reparacion</button>
		<div class="content">
			<table id="listadoReparaciones">
				<thead>
					<tr>
						<th>
							<h4>Cliente</h4>
						</th>
						<th>
							<h4>Tipo Equipo</h4>
						</th>
						<th>
							<h4>Fecha</h4>
						</th>
						<th>
							<h4>Detalle</h4>
						</th>
						<th>
							<h4>Opciones</h4>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($listadoReparacion) {
						foreach ($listadoReparacion as $rep) {
							echo "<tr>
							<td>$rep->nombreApellido</td>
							<td>$rep->equipo</td>
							<td>$rep->fechaInicio</td>
							<td>$rep->detalle</td>
							<td class='opciones'>
								<input type='button' class='btn' value='Terminar' onclick='terminar($rep->idReparacion)'>
								<input type='button' class='btn' value='Editar' onclick='editar(`$rep->idReparacion`, `$rep->nombreApellido`, `$rep->idEquipo`, `$rep->fechaInicio`, `$rep->detalle`)'>
							</td>
						</tr>";
						}
					} else {
						echo "<tr><td>No existen reparaciones</td></tr>";
					}
					?>
				</tbody>
			</table>
		</div>
		<div id="pagination-controls"></div>
	</div>

	<div class="container-funciones" id="div-editar" style="display:none"> <!-- editar -->
		<div class="content-funciones">
			<div class="titulo-funciones">
				<h2>Editar Reparacion</h2>
			</div>
			<div class="inputs">
				<input type="text" id="idCliente-editar" list="dl-clientes" placeholder="Cliente">
				<datalist id="dl-clientes">
					<?php foreach ($listadoClientes as $cliente) {
						echo "<option value='$cliente->nombreApellido' id='cliente-$cliente->idCliente'></option>";
					} ?>
				</datalist>
				<select name="idEquipo-editar" id="idEquipo-editar">
					<option value="" selected disabled>Tipo de Equipo</option>
					<?php foreach ($listadoEquipos as $equipo) {
						echo "<option value='$equipo->idEquipo'>$equipo->nombre</option>";
					} ?>
				</select>
				<input type="date" name="fecha-editar" id="fecha-editar" placeholder="Fecha">
				<textarea type="text" name="detalle-editar" id="detalle-editar" placeholder="Detalle"></textarea>

				<div class="buttons">
					<button class="btn" id="btn-editar">Guardar</button>
					<button class="btn" id="btn-cancelar-editar">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container-funciones" id="div-terminar" style="display:none"> <!-- terminar -->
		<div class="content-funciones">
			<div class="titulo-funciones">
				<h2>Terminar</h2>
			</div>

			<div class="inputs">
				<input type="number" name="precio" id="precio" placeholder="Precio">
			</div>

			<div class='buttons'>
				<button class="btn" id="btn-terminar">Guardar</button>
				<button class="btn" id="btn-cancelar-terminar">Cancelar</button>
			</div>
		</div>
	</div>

	<div class="container-funciones" id="div-insertar" style="display:none"> <!-- insertar -->
		<div class="content-funciones">
			<div class="titulo-funciones">
				<h2>Añadir Reparacion</h2>
			</div>
			<div class="inputs">
				<input type="text" id="idCliente-insertar" list="dl-clientes" placeholder="Cliente">
				<datalist id="dl-clientes">
					<?php foreach ($listadoClientes as $cliente) {
						echo "<option value='$cliente->nombreApellido' id='cliente-$cliente->idCliente'></option>";
					} ?>
				</datalist>
				<select name="idEquipo-insertar" id="idEquipo-insertar">
					<option value="" selected disabled>Tipo de Equipo</option>
					<?php foreach ($listadoEquipos as $equipo) {
						echo "<option value='$equipo->idEquipo'>$equipo->nombre</option>";
					} ?>
				</select>
				<input type="date" name="fecha-insertar" id="fechaInicio-insertar">
				<textarea type="text" name="detalle-insertar" id="detalle-insertar" placeholder="Detalle"></textarea>
			</div>

			<div class='buttons'>
				<button class="btn" id="btn-insertar" value="insertar">Añadir</button>
				<button class="btn" id="btn-cancelar-insertar">Cancelar</button>
			</div>
		</div>
	</div>

	<script>

		<?php
		$cant = count($listadoClientes);
		$counter = 0;
		$clientes = "[";
		foreach ($listadoClientes as $cliente) {
			$clientes .= $cliente->idCliente;
			if (++$counter < $cant) {
				$clientes .= ",";
			}
		}
		$clientes .= "]";
		?>

		let clientes = <?php echo $clientes ?>;

		function terminar(id) {
			let containerTerminar = document.getElementById("div-terminar");
			containerTerminar.style.display = "flex";
			document.getElementById("precio").focus();

			document.getElementById("btn-terminar").addEventListener("click", () => {
				let precio = document.getElementById("precio").value;
				if (precio) {
					let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/reparacionControlador.php?action=terminar&idReparacion=${id}&precio=${precio}`, 'popupWindow', 'width=60,height=40');

					window.addEventListener("message", (e) => {
						if (e.data === "consultaCompleta") {
							location.reload();
						}
					});
				} else alert("Ingresa un precio");
			});

			document.getElementById("btn-cancelar-terminar").addEventListener("click", () => {
				containerTerminar.style.display = "none";
			});
		}

		function editar(id, cliente, idEquipo, fecha, detalle) {
    let containerEditar = document.getElementById("div-editar");

    document.getElementById("idCliente-editar").value = cliente;
    document.getElementById("idEquipo-editar").value = idEquipo;
    document.getElementById("fecha-editar").value = fecha;
    document.getElementById("detalle-editar").value = detalle;
    containerEditar.style.display = "flex";

    document.getElementById("btn-editar").addEventListener("click", () => {
        let clienteNombre = document.getElementById("idCliente-editar").value;
        let idEquipo = document.getElementById("idEquipo-editar").value;
        let fecha = document.getElementById("fecha-editar").value;
        let detalle = document.getElementById("detalle-editar").value;

        let datalist = document.getElementById("dl-clientes");
        let options = datalist.getElementsByTagName("option");
        let idCliente = null;

        for (let i = 0; i < options.length; i++) {
            if (options[i].value === clienteNombre) {
                idCliente = options[i].id.replace("cliente-", "");
                break;
            }
        }

        if (!idCliente) {
            alert("¡Ese usuario no existe!");
        } else if (idCliente && idEquipo && fecha && detalle) {
            let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/reparacionControlador.php?action=editar&idReparacion=${id}&idCliente=${idCliente}&idEquipo=${idEquipo}&fecha=${fecha}&detalle=${detalle}`, 'popupWindow', 'width=60,height=40');

            window.addEventListener("message", (e) => {
                if (e.data === "consultaCompleta") {
                    location.reload();
                }
            });
        } else {
            alert("Ingrese todos los datos");
        }
    });

    document.getElementById("btn-cancelar-editar").addEventListener("click", () => {
        containerEditar.style.display = "none";
    });
}


		function insertar() {
    let containerInsertar = document.getElementById("div-insertar");
    containerInsertar.style.display = "flex";

    document.getElementById("btn-insertar").addEventListener("click", () => {
        let clienteNombre = document.getElementById("idCliente-insertar").value;
        let idEquipo = document.getElementById("idEquipo-insertar").value;
        let fecha = document.getElementById("fechaInicio-insertar").value;
        let detalle = document.getElementById("detalle-insertar").value;

        let datalist = document.getElementById("dl-clientes");
        let options = datalist.getElementsByTagName("option");
        let idCliente = null;

        for (let i = 0; i < options.length; i++) {
            if (options[i].value === clienteNombre) {
                idCliente = options[i].id.replace("cliente-", "");
                break;
            }
        }

        if (!idCliente) {
            alert("¡Ese usuario no existe!");
        } else if (idCliente && idEquipo && fecha && detalle) {
            let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/reparacionControlador.php?action=insertar&idCliente=${idCliente}&idEquipo=${idEquipo}&fechaInicio=${fecha}&detalle=${detalle}`, 'popupWindow', 'width=60,height=40');

            window.addEventListener("message", (e) => {
                if (e.data === "consultaCompleta") {
                    location.reload();
                }
            });
        } else {
            alert("Ingrese todos los datos");
        }
    });

    document.getElementById("btn-cancelar-insertar").addEventListener("click", () => {
        containerInsertar.style.display = "none";
    });
}



		const rowsPerPage = 5; // Cantidad de filas por página
		let currentPage = 1; // Página actual

		function setupPagination() {
			const table = document.getElementById("listadoReparaciones");
			const rows = table.querySelectorAll("tbody tr");
			const totalPages = Math.ceil(rows.length / rowsPerPage);
			const paginationControls = document.getElementById("pagination-controls");

			// Generar controles de paginación con flechas
			paginationControls.innerHTML = `
						<button id="prev-page">&laquo;</button>
						${Array.from({ length: totalPages }, (_, i) => `<button class="page-btn" data-page="${i + 1}">${i + 1}</button>`).join('')}
						<button id="next-page">&raquo;</button>
				`;

			// Actualizar eventos de los botones
			document.getElementById("prev-page").addEventListener("click", () => changePage(currentPage - 1, totalPages));
			document.getElementById("next-page").addEventListener("click", () => changePage(currentPage + 1, totalPages));
			document.querySelectorAll(".page-btn").forEach(button =>
				button.addEventListener("click", () => changePage(Number(button.dataset.page), totalPages))
			);

			// Mostrar la primera página al cargar
			displayTable(rows);
			updatePaginationButtons(totalPages);
		}

		function changePage(page, totalPages) {
			const table = document.getElementById("listadoReparaciones");
			const rows = table.querySelectorAll("tbody tr");

			// Asegurarse de que la página sea válida
			if (page >= 1 && page <= totalPages) {
				currentPage = page;
				displayTable(rows);
				updatePaginationButtons(totalPages);
			}
		}

		function displayTable(rows) {
			const start = (currentPage - 1) * rowsPerPage;
			const end = start + rowsPerPage;

			// Mostrar solo las filas correspondientes a la página actual
			rows.forEach((row, index) => {
				row.style.display = index >= start && index < end ? "" : "none";
			});
		}

		function updatePaginationButtons(totalPages) {
			const prevButton = document.getElementById("prev-page");
			const nextButton = document.getElementById("next-page");
			const pageButtons = document.querySelectorAll(".page-btn");

			// Actualizar estado de botones "anterior" y "siguiente"
			prevButton.disabled = currentPage === 1;
			nextButton.disabled = currentPage === totalPages;

			// Resaltar el botón de la página actual
			pageButtons.forEach(button => {
				button.classList.toggle("active", Number(button.dataset.page) === currentPage);
			});
		}

		// Inicializar paginación al cargar la página
		document.addEventListener("DOMContentLoaded", setupPagination);
	</script>
</body>

</html>