<!DOCTYPE html>
<html lang="en">

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
		<h1 class="title">Listado de Clientes</h1>
		<button type="submit" class="btn btn-insertar" onclick="insertar()"><i class="fa-regular fa-user"></i>Nuevo
			Cliente</button>
		<div class="content">
			<table id="listadoClientes">
				<thead>
					<tr>
						<th>
							<h4>Nombre Apellido</h4>
						</th>
						<th>
							<h4>Teléfono</h4>
						</th>
						<th>
							<h4>Opciones</h4>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($listadoClientes) {
						foreach ($listadoClientes as $cliente) {
							echo "
							<tr>
								<td>$cliente->nombreApellido</td>
								<td>$cliente->telefono</td>

								<td class='opciones'>
									<button class='btn' onclick='verHistorial(`$cliente->idCliente`, `$cliente->nombreApellido`)' value='Historial'>Historial</button>
									<button class='btn' onclick='editar(`$cliente->idCliente`,`$cliente->nombreApellido`,`$cliente->telefono`)' value='Editar'>Editar</button>
									<button type='button' class='btn btn-eliminar' onclick='eliminar(`$cliente->idCliente`)'><i class='fa-regular fa-trash-can'></i></button>
								</td>
							</tr>";
						}
					} ?>
				</tbody>
			</table>
			<div id="pagination-controls"></div>
		</div>
		<div class="container-funciones" id="div-editar" style="display:none"> <!-- editar -->
			<div class="content-funciones">
				<div class="titulo-funciones">
					<h2>Editar Cliente</h2>
				</div>
				<div class="inputs">
					<input type="text" id="nombreApellido-editar" placeholder="Nombre y Apellido">
					<input type="text" id="telefono-editar" placeholder="Telefono">
					<button class="btn" id="btn-editar">Guardar</button>
					<button class="btn" id="btn-cancelar-editar">Cancelar</button>
				</div>
			</div>
		</div>
		<div class="container-funciones" id="div-insertar" style="display: none;"> <!-- insertar -->
			<div class="content-funciones">
				<div class="titulo-funciones">
					<h2>Añadir Cliente</h2>
				</div>
				<div class="inputs">
					<input type="text" id="nombreApellidoInsertar" placeholder="Nombre y Apellido" name="nombreApellido">
					<input type="text" id="telefonoInsertar" placeholder="Telefono" name="telefono">
				</div>

				<div class="buttons">
					<button class="btn" id="btn-insertar" value="insertar">Añadir</button>
					<button class="btn" id="btn-cancelar-insertar">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container container-historial" style="display: none;" id="tabla-historial"> <!-- historial -->
		<div class="div-cerrar">
			<button class="btn-cerrar" id="btn-cerrarHistorial" onclick="cerrarHistorial()"><i
					class="fa-solid fa-xmark"></i></button>
		</div>
		<div class="content">
			<table id="tabla-historial">
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
							<h4>Fecha Entrega</h4>
						</th>
						<th>
							<h4>Detalle</h4>
						</th>
						<th>
							<h4>Precio</h4>
						</th>
						<th>
							<h4>Opciones</h4>
						</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>



	<div class="container-funciones" id="div-editarH" style="display:none"> <!-- editar -->
		<div class="content-funciones">
			<div class="titulo-funciones">
				<h2>Editar Reparación Hitorial</h2>
			</div>
			<div class="inputs">
				<input type="text" id="idCliente-editar" list="dl-clientes" placeholder="Cliente">
				<datalist id="dl-clientes">
					<?php foreach ($listadoClientes as $cliente) {
						echo "<option value='$cliente->nombreApellido' id='cliente-$cliente->idCliente'></option>";
					} ?>
				</datalist>
				<select name="idEquipo-editarH" id="idEquipo-editarH">
					<option value="" selected disabled>Tipo de Equipo</option>
					<?php foreach ($listadoEquipos as $equipo) {
						echo "<option value='$equipo->idEquipo'>$equipo->nombre</option>";
					} ?>
				</select>
				<input type="date" name="fechaInicio-editarH" id="fechaInicio-editarH">
				<input type="date" name="fechaEntrega-editarH" id="fechaEntrega-editarH">
				<input type="number" name="precio-editarH" id="precio-editarH" placeholder="Precio">
				<input type="text" name="detalle-editarH" id="detalle-editarH" placeholder="detalle">
			</div>

			<div class="buttons">
				<button class="btn" id="btn-editarH">Guardar</button>
				<button class="btn" id="btn-cancelar-editarH">Cancelar</button>
			</div>
		</div>
	</div>
	</table>

	<div class="container-funciones" id="div-eliminar" style="display:none"> <!-- eliminar -->
		<div class="content-funciones">
			<div class="titulo-funciones">
				<h2>Eliminar Cliente</h2>
			</div>
			<span>¿Estás seguro de que quieres eliminar esta reparación?</span>
			<span style="color:red; margin-top:10px;font-weight: bold;">¡SE ELIMINARAN TODAS LAS REPARACIONES
				ASOCIADAS!</span>
			<table id="tabla-eliminar">
				<thead>
					<tr>
						<th>
							<h4>Cliente</h4>
						</th>
						<th>
							<h4>Teléfono</h4>
						</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>

			<div class="buttons">
				<button class="btn btn-eliminar" id="btn-eliminar">Eliminar</button>
				<button class="btn" id="btn-ver-reparaciones">Ver Reparaciones</button>
				<button class="btn" id="btn-cancelar-eliminar">Cancelar</button>
			</div>
		</div>
	</div>

	<div class="container-funciones" id="div-eliminarH" style="display:none"> <!-- eliminar Historial -->
		<div class="content-funciones">
			<div class="titulo-funciones">
				<h2>Eliminar Reparación</h2>
			</div>
			<span>¿Estás seguro de que quieres eliminar esta reparación?</span>
			<table id="tabla-eliminar-historial">
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
							<h4>Fecha Entrega</h4>
						</th>
						<th>
							<h4>Detalle</h4>
						</th>
						<th>
							<h4>Precio</h4>
						</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>

			<div class="buttons">
				<button class="btn btn-eliminar" id="btn-eliminarH">Eliminar</button>
				<button class="btn" id="btn-cancelar-eliminarH">Cancelar</button>
			</div>
		</div>
	</div>

	<script>
		<?php
		$cant = count($listadoClientes);
		$counter = 0;
		$htmlClientes = "";
		foreach ($listadoClientes as $cli) {
			$htmlClientes .= "{
				idCliente: '$cli->idCliente',
				nombreApellido: '',
				telefono: '',
				htmlEliminar: `<tr><td>$cli->nombreApellido</td><td>$cli->telefono</td></tr>`
				}";
			if (++$counter < $cant) {
				$htmlClientes .= ",";
			}
		}


		$cant = count($listadoHistorial);
		$counter = 0;
		$htmlHistorial = "";
		foreach ($listadoHistorial as $his) {
			$tam = strlen($his->precio);

			if ($tam > 3) {
				$reversed = strrev($his->precio);
				$resultado = "";

				for ($i = 0; $i < $tam; $i++) {
					$resultado .= $reversed[$i];
					if (($i + 1) % 3 == 0 && $i + 1 != $tam) {
						$resultado .= ".";
					}
				}

				$resultado = strrev($resultado);
				$precio = "$$resultado";
			} else {
				$precio = "$$his->precio";
			}



			$htmlHistorial .= "{
				idReparacion: '$his->idReparacion',
				idCliente: '$his->idCliente',
				html: `<tr><td>$his->nombreApellido</td><td>$his->equipo</td><td>$his->fechaInicio</td><td>$his->fechaEntrega</td><td>$his->detalle</td><td>$precio</td><td class='opciones'><input type='button' class='btn' value='Editar Historial' id='btn-editarHistorial' onclick='editarHistorial(\"" . $his->idReparacion . "\", \"" . $his->nombreApellido . "\", \"" . $his->idEquipo . "\", \"" . $his->fechaInicio . "\", \"" . $his->fechaEntrega . "\", \"" . $his->precio . "\", \"" . $his->detalle . "\")'><button type='button' class='btn btn-eliminar' value=' ' onclick='eliminarReparacion(\"$his->idReparacion\")'><i class='fa-regular fa-trash-can'></i></button></td></tr>`,
				htmlEliminar: `<tr><td>$his->nombreApellido</td><td>$his->equipo</td><td>$his->fechaInicio</td><td>$his->fechaEntrega</td><td>$his->detalle</td><td>$precio</td></tr>`
				}";
			if (++$counter < $cant) {
				$htmlHistorial .= ",";
			}
		}
		?>


		let containerHistorial = document.getElementById("tabla-historial");
		let HTMLHistorial = document.querySelector("#tabla-historial tbody");
		HTMLHistorial.innerHTML = "";
		containerHistorial.style.display = "none";
		let clientes = [<?php echo $htmlClientes ?>];
		let historial = [<?php echo $htmlHistorial ?>];

		for (let i = 0; i < historial.length; i++) {
			HTMLHistorial.innerHTML += historial[i].html;
		}




		function verHistorial(id, nombre) {
			let containerHistorial = document.getElementById("tabla-historial");
			let HTMLHistorial = document.querySelector("#tabla-historial tbody");
			HTMLHistorial.innerHTML = "";
			containerHistorial.style.display = "flex";

			for (let i = 0; i < historial.length; i++) {
				if (historial[i].idCliente == id) {
					HTMLHistorial.innerHTML += historial[i].html;
				}
			}
			if (HTMLHistorial.innerHTML == "") {
				HTMLHistorial.innerHTML = nombre + " no tiene reparaciones asignadas";
			}

			document.getElementById("btn-cerrarHistorial").addEventListener("click", () => {
				containerHistorial.style.display = "none";
			});
		}

		function editarHistorial(id, cliente, idEquipo, fechaInicio, fechaEntrega, precio, detalle) {
			let containerEditarH = document.getElementById("div-editarH");
			document.getElementById("idCliente-editarH").value = cliente;
			document.getElementById("idEquipo-editarH").value = idEquipo;
			document.getElementById("fechaInicio-editarH").value = fechaInicio;
			document.getElementById("fechaEntrega-editarH").value = fechaEntrega;
			document.getElementById("precio-editarH").value = precio;
			document.getElementById("detalle-editarH").value = detalle;
			containerEditarH.style.display = "flex";

			document.getElementById("btn-editarH").addEventListener("click", () => {
				let clienteNombre = document.getElementById("idCliente-editarH").value;
				let idEquipo = document.getElementById("idEquipo-editarH").value;
				let fechaInicio = document.getElementById("fechaInicio-editarH").value;
				let fechaEntrega = document.getElementById("fechaEntrega-editarH").value;
				let precio = document.getElementById("precio-editarH").value;
				let detalle = document.getElementById("detalle-editarH").value;

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
				} else if (idCliente && idEquipo && fechaInicio && fechaEntrega && precio && detalle) {
					let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/clienteControlador.php?action=editarReparacion&idReparacion=${id}&idCliente=${idCliente}&idEquipo=${idEquipo}&fechaInicio=${fechaInicio}&fechaEntrega=${fechaEntrega}&precio=${precio}&detalle=${detalle}`, 'popupWindow', 'width=60,height=40');

					window.addEventListener("message", (e) => {
						if (e.data === "consultaCompleta") {
							location.reload();
						}
					});
				} else alert("Ingrese todos los datos");
			});


			document.getElementById("btn-cancelar-editarH").addEventListener("click", () => {
				containerEditarH.style.display = "none";
			});

		}

		function editar(id, idCliente, telefono) {
			let containerEditar = document.getElementById("div-editar");
			document.getElementById("nombreApellido-editar").value = idCliente;
			document.getElementById("telefono-editar").value = telefono;
			containerEditar.style.display = "flex";

			document.getElementById("btn-editar").addEventListener("click", () => {
				let cliente = document.getElementById("nombreApellido-editar").value;
				let telefono = document.getElementById("telefono-editar").value;
				if (cliente && telefono) {
					let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/clienteControlador.php?action=editar&idCliente=${id}&nombreApellido=${cliente}&telefono=${telefono}`, 'popupWindow', 'width=60,height=40');

					window.addEventListener("message", (e) => {
						if (e.data === "consultaCompleta") {
							location.reload();
						}
					});
				} else alert("Ingrese todos los datos");
			});

			document.getElementById("btn-cancelar-editar").addEventListener("click", () => {
				containerEditar.style.display = "none";
			})
		};

		function insertar() {
			let containerInsertar = document.getElementById("div-insertar");
			containerInsertar.style.display = "flex";
			document.getElementById("nombreApellidoInsertar").focus();

			document.getElementById("btn-insertar").addEventListener("click", () => {
				let cliente = document.getElementById("nombreApellidoInsertar").value;
				let telefono = document.getElementById("telefonoInsertar").value;
				if (cliente && telefono) {
					let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/clienteControlador.php?action=insertar&nombreApellido=${cliente}&telefono=${telefono}`, 'popupWindow', 'width=60,height=40');

					window.addEventListener("message", (e) => {
						if (e.data === "consultaCompleta") {
							location.reload();
						}
					});
				} else alert("Ingrese todos los datos");
			});

			document.getElementById("btn-cancelar-insertar").addEventListener("click", (e) => {
				containerInsertar.style.display = "none";
			})
		};



		function eliminar(id) {

			let containerClientes = document.getElementById("tabla-eliminar");
			let HTMLClientes = document.querySelector("#tabla-eliminar tbody");
			HTMLClientes.innerHTML = "";
			containerClientes.style.display = "flex";

			for (let i = 0; i < clientes.length; i++) {
				if (clientes[i].idCliente == id) {
					HTMLClientes.innerHTML = clientes[i].htmlEliminar;
					break;
				}
			}

			let containerEliminar = document.getElementById("div-eliminar");
			containerEliminar.style.display = "flex";

			document.getElementById("btn-eliminar").addEventListener("click", () => {
				if (confirm("¿Seguro? No hay vuelta atras!")) {
					let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/clienteControlador.php?action=eliminar&idCliente=${id}`, 'popupWindow', 'width=60,height=40');

					window.addEventListener("message", (e) => {
						if (e.data === "consultaCompleta") {
							location.reload();
						}
					});
				} else {
					containerEliminar.style.display = "none";
				}
			});

			document.getElementById("btn-ver-reparaciones").addEventListener("click", () => {
				containerEliminar.style.display = "none";
				verHistorial(id);
			});

			document.getElementById("btn-cancelar-eliminar").addEventListener("click", () => {
				containerEliminar.style.display = "none";
			})
		};

		function eliminarReparacion(id) {

			let containerHistorial = document.getElementById("tabla-eliminar-historial");
			let HTMLHistorial = document.querySelector("#tabla-eliminar-historial tbody");
			HTMLHistorial.innerHTML = "";
			containerHistorial.style.display = "flex";

			for (let i = 0; i < historial.length; i++) {
				if (historial[i].idReparacion == id) {
					HTMLHistorial.innerHTML = historial[i].htmlEliminar;
					break;
				}
			}

			let containerEditar = document.getElementById("div-eliminarH");
			containerEditar.style.display = "flex";

			document.getElementById("btn-eliminarH").addEventListener("click", () => {
				let popup = window.open(`https://tecnicapuan.edu.ar/bob/bios/controlador/reparacionControlador.php?action=eliminar&idReparacion=${id}`, 'popupWindow', 'width=60,height=40');

				window.addEventListener("message", (e) => {
					if (e.data === "consultaCompleta") {
						location.reload();
					}
				});
			});

			document.getElementById("btn-cancelar-eliminarH").addEventListener("click", () => {
				containerEditar.style.display = "none";
			})
		};

		const rowsPerPage = 5; // Cantidad de filas por página
		let currentPage = 1; // Página actual

		function setupPagination() {
			const table = document.getElementById("listadoClientes");
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
			const table = document.getElementById("listadoClientes");
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