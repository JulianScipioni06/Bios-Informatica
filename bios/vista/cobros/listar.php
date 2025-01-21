<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../menu/menu.css">
	<link rel="stylesheet" href="../css/listar.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bios Informatica</title>
</head>

<body>
	<nav>
		<?php include "../menu/menu.php"; ?>
	</nav>
	<div class="container">
		<h1 class="title">Listado de Cobros</h1>
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
							<h4>Fecha Inicio</h4>
						</th>
						<th>
							<h4>Precio</h4>
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
							<td>$";
							$tam = strlen($rep->precio); // esto en parte es mio, en parte no (la idea, y prototipo son mios, el resultado final no ajshdjasd)
					
							if ($tam > 3) {
								$reversed = strrev($rep->precio);
								$resultado = "";

								for ($i = 0; $i < $tam; $i++) {
									$resultado .= $reversed[$i];
									if (($i + 1) % 3 == 0 && $i + 1 != $tam) {
										$resultado .= ".";
									}
								}

								$resultado = strrev($resultado);
								echo $resultado;
							} else {
								echo $rep->precio;
							}


							echo "</td>
							<td>$rep->detalle</td>
							<td class='opciones'>
								<input type='button' class='btn' value='Cobrar' onclick='cobrar(`$rep->idReparacion`, `$rep->precio`)'>
								<input type='button' class='btn' value='Editar' onclick='editar(`$rep->idReparacion`, `$rep->nombreApellido`, `$rep->idEquipo`, `$rep->fechaInicio`, `$rep->precio`, `$rep->detalle`)'>
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
				<h2>Editar Cobro</h2>
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
				<input type="date" name="fechaInicio-editar" id="fechaInicio-editar">
				<input type="number" name="precio-editar" id="precio-editar" placeholder="Precio">
				<textarea type="text" name="detalle-editar" id="detalle-editar" placeholder="detalle"></textarea>
			</div>

			<div class='buttons'>
				<button class="btn" id="btn-editar">Guardar</button>
				<button class="btn" id="btn-cancelar-editar">Cancelar</button>
			</div>
		</div>
	</div>

	<div class="container-funciones" id="div-cobrar" style="display:none"> <!-- cobrar -->
		<div class="content-funciones">
			<div class="titulo-funciones">
				<h2>Cobrado</h2>
			</div>
			<div class="inputs">
				<input type="date" name="fechaEntrega" id="fechaEntrega" placeholder="fechaEntrega">
				<input type="number" name="precio-cobrar" id="precio-cobrar" placeholder="Precio">
			</div>

			<div class='buttons'>
				<button class="btn" id="btn-cobrar">Guardar</button>
				<button class="btn" id="btn-cancelar-cobrar">Cancelar</button>
			</div>
		</div>
	</div>

	<script>
		function cobrar(id, precio) {
			let containerCobrar = document.getElementById("div-cobrar");
			document.getElementById("precio-cobrar").value = precio;
			containerCobrar.style.display = "flex";
			document.getElementById("fechaEntrega").focus();

			document.getElementById("btn-cobrar").addEventListener("click", () => {
				let fechaEntrega = document.getElementById("fechaEntrega").value;
				let precio = document.getElementById("precio-cobrar").value;
				if (fechaEntrega && precio) {
					let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/cobrosControlador.php?action=cobrar&idReparacion=${id}&fechaEntrega=${fechaEntrega}&precio=${precio}`, 'popupWindow', 'width=60,height=40');

					window.addEventListener("message", (e) => {
						if (e.data === "consultaCompleta") {
							location.reload();
						}
					});
				} else alert("Ingresa una Fecha de Entrega");
			});

			document.getElementById("btn-cancelar-cobrar").addEventListener("click", () => {
				containerCobrar.style.display = "none";
			});
		}


		function editar(id, cliente, idEquipo, fechaInicio, precio, detalle) {
			let containerEditar = document.getElementById("div-editar");
			document.getElementById("idCliente-editar").value = cliente;
			document.getElementById("idEquipo-editar").value = idEquipo;
			document.getElementById("fechaInicio-editar").value = fechaInicio;
			document.getElementById("precio-editar").value = precio;
			document.getElementById("detalle-editar").value = detalle;
			containerEditar.style.display = "flex";

			document.getElementById("btn-editar").addEventListener("click", () => {
				let clienteNombre = document.getElementById("idCliente-editar").value;
				let idEquipo = document.getElementById("idEquipo-editar").value;
				let fechaInicio = document.getElementById("fechaInicio-editar").value;
				let precio = document.getElementById("precio-editar").value;
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
				} else if (idCliente && idEquipo && fechaInicio && precio && detalle) {
					let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/cobrosControlador.php?action=editar&idReparacion=${id}&idCliente=${idCliente}&idEquipo=${idEquipo}&fechaInicio=${fechaInicio}&precio=${precio}&detalle=${detalle}`, 'popupWindow', 'width=60,height=40');

					window.addEventListener("message", (e) => {
						if (e.data === "consultaCompleta") {
							location.reload();
						}
					});
				} else alert("Ingrese todos los datos");
			});


			document.getElementById("btn-cancelar-editar").addEventListener("click", () => {
				containerEditar.style.display = "none";
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