<?php
require_once 'auth.php';
require_once 'navbar.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Producto</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: rgba(186, 186, 210, 0.9);
            background-image: url('R.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: overlay;
        }
        .container {
            background-color: rgba(207, 129, 129, 0.85);
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .error { color: red; font-size: 0.8em; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea, select {
            padding: 8px; width: 100%; box-sizing: border-box;
            border: 1px solid #ddd; border-radius: 4px;
            font-size: 15px; background-color: white;
        }
        textarea { min-height: 80px; }
        select {
            appearance: none; -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23555' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center; cursor: pointer;
        }
        select:focus { border-color: rgb(11,116,181); outline: none; box-shadow: 0 0 0 3px rgba(11,116,181,0.15); }
        .radio-group { display: flex; gap: 25px; margin-top: 5px; flex-wrap: wrap; }
        .radio-option { display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal; font-size: 15px; }
        .radio-option input[type="radio"] { width: 18px; height: 18px; accent-color: rgb(11,116,181); cursor: pointer; }
        .checkbox-group { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 5px; }
        .checkbox-option { display: flex; align-items: center; gap: 8px; font-weight: normal; font-size: 15px; cursor: pointer; }
        .checkbox-option input[type="checkbox"] { width: 18px; height: 18px; accent-color: rgb(11,116,181); cursor: pointer; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 4px; font-size: 16px; transition: background 0.3s; }
        button:hover { background: #45a049; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        .loading-spinner { display: none; text-align: center; padding: 12px; }
        .spinner-circle { width: 38px; height: 38px; border: 4px solid #ddd; border-top-color: rgb(11,116,181); border-radius: 50%; animation: spin 0.8s linear infinite; display: inline-block; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loading-text { margin-top: 8px; font-size: 14px; color: #444; }
        .alert-overlay { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
        .alert-overlay.show { display: flex; }
        .alert-box { background: white; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); width: 90%; max-width: 400px; overflow: hidden; animation: popIn 0.2s ease; }
        @keyframes popIn { from { transform: scale(0.85); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .alert-header { padding: 18px 22px 10px; display: flex; align-items: center; gap: 12px; }
        .alert-header.success { border-top: 5px solid #4CAF50; }
        .alert-header.error   { border-top: 5px solid #f44336; }
        .alert-header.warning { border-top: 5px solid #ff9800; }
        .alert-icon { font-size: 32px; }
        .alert-title { font-size: 18px; font-weight: bold; color: #2c3e50; }
        .alert-body { padding: 6px 22px 18px; font-size: 15px; color: #555; }
        .alert-footer { padding: 12px 22px; background: #f9f9f9; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #eee; }
        .alert-btn { padding: 8px 22px; border: none; border-radius: 6px; font-size: 14px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .alert-btn.confirm { background: rgb(11,116,181); color: white; }
        .alert-btn.confirm:hover { background: #0a5fa0; }
        .alert-btn.cancel { background: #e0e0e0; color: #333; }
        .alert-btn.cancel:hover { background: #ccc; }
    </style>
</head>
<body>
<div class="container">
    <h1>Registro de Productos</h1>
    <form id="formProducto">

        <div class="form-group">
            <label for="Id_producto">ID Producto*:</label>
            <input type="text" id="Id_producto" name="Id_producto" placeholder="Ej: P001">
            <span id="error-id" class="error"></span>
        </div>

        <div class="form-group">
            <label for="Nombre">Nombre*:</label>
            <input type="text" id="Nombre" name="Nombre" placeholder="Nombre del producto">
            <span id="error-nombre" class="error"></span>
        </div>

        <div class="form-group">
            <label for="Descripcion">Descripcion: <small>(opcional)</small></label>
            <textarea id="Descripcion" name="Descripcion" placeholder="Descripcion del producto..."></textarea>
        </div>

        <!-- SELECT / SPINNER -->
        <div class="form-group">
            <label for="Categoria">Categoria*:</label>
            <select id="Categoria" name="Categoria">
                <option value="">-- Seleccione una categoria --</option>
                <option value="Electronica">Electronica</option>
                <option value="Alimentos">Alimentos</option>
                <option value="Ropa">Ropa</option>
                <option value="Hogar">Hogar</option>
                <option value="Herramientas">Herramientas</option>
                <option value="Papeleria">Papeleria</option>
                <option value="Otros">Otros</option>
            </select>
            <span id="error-categoria" class="error"></span>
        </div>

        <div class="form-group">
            <label for="precioUnitario">Precio Unitario*:</label>
            <input type="number" id="precioUnitario" name="precioUnitario" step="0.01" min="0" placeholder="0.00">
            <span id="error-precio" class="error"></span>
        </div>

        <div class="form-group">
            <label for="Cantidad">Cantidad:</label>
            <input type="number" id="Cantidad" name="Cantidad" min="0" placeholder="0">
        </div>

        <div class="form-group">
            <label for="Existencia">Existencia:</label>
            <input type="number" id="Existencia" name="Existencia" min="0" placeholder="0">
        </div>

        <!-- RADIO BUTTONS -->
        <div class="form-group">
            <label>Estado del Producto*:</label>
            <div class="radio-group">
                <label class="radio-option">
                    <input type="radio" name="Estado" value="Activo" checked> Activo
                </label>
                <label class="radio-option">
                    <input type="radio" name="Estado" value="Inactivo"> Inactivo
                </label>
                <label class="radio-option">
                    <input type="radio" name="Estado" value="Agotado"> Agotado
                </label>
            </div>
        </div>

        <!-- CHECKBOXES -->
        <div class="form-group">
            <label>Caracteristicas:</label>
            <div class="checkbox-group">
                <label class="checkbox-option">
                    <input type="checkbox" name="caracteristicas" value="Nuevo"> Nuevo
                </label>
                <label class="checkbox-option">
                    <input type="checkbox" name="caracteristicas" value="Oferta"> En Oferta
                </label>
                <label class="checkbox-option">
                    <input type="checkbox" name="caracteristicas" value="Destacado"> Destacado
                </label>
                <label class="checkbox-option">
                    <input type="checkbox" name="caracteristicas" value="Perecedero"> Perecedero
                </label>
            </div>
        </div>

        <div class="loading-spinner" id="loadingSpinner">
            <div class="spinner-circle"></div>
            <div class="loading-text">Guardando producto...</div>
        </div>

        <button type="button" onclick="confirmarGuardar()">Guardar Producto</button>
    </form>
</div>

<!-- ALERT DIALOG - Confirmacion -->
<div class="alert-overlay" id="dialogConfirmar">
    <div class="alert-box">
        <div class="alert-header warning">
            <span class="alert-icon">?</span>
            <span class="alert-title">Confirmar registro</span>
        </div>
        <div class="alert-body">Esta seguro de que desea guardar este producto?</div>
        <div class="alert-footer">
            <button class="alert-btn cancel"  onclick="cerrarDialog('dialogConfirmar')">Cancelar</button>
            <button class="alert-btn confirm" onclick="validarYEnviar()">Si, guardar</button>
        </div>
    </div>
</div>

<!-- ALERT DIALOG - Exito -->
<div class="alert-overlay" id="dialogExito">
    <div class="alert-box">
        <div class="alert-header success">
        
            <span class="alert-title">Producto guardado!</span>
        </div>
        <div class="alert-body">El producto fue registrado exitosamente en el sistema.</div>
        <div class="alert-footer">
            <button class="alert-btn confirm" onclick="cerrarDialog('dialogExito')">Aceptar</button>
        </div>
    </div>
</div>

<!-- ALERT DIALOG - Error -->
<div class="alert-overlay" id="dialogError">
    <div class="alert-box">
        <div class="alert-header error">
            <span class="alert-icon">X</span>
            <span class="alert-title">Error</span>
        </div>
        <div class="alert-body" id="dialogErrorMsg">Ocurrio un error al guardar el producto.</div>
        <div class="alert-footer">
            <button class="alert-btn confirm" onclick="cerrarDialog('dialogError')">Aceptar</button>
        </div>
    </div>
</div>

<script>
    function abrirDialog(id)  { document.getElementById(id).classList.add('show');    }
    function cerrarDialog(id) { document.getElementById(id).classList.remove('show'); }

    function confirmarGuardar() {
        document.querySelectorAll('.error').forEach(el => el.textContent = '');
        const id        = document.getElementById('Id_producto').value.trim();
        const nombre    = document.getElementById('Nombre').value.trim();
        const categoria = document.getElementById('Categoria').value;
        const precio    = document.getElementById('precioUnitario').value;
        let valido = true;

        if (!id)       { document.getElementById('error-id').textContent = 'Debe ingresar un ID'; valido = false; }
        if (!nombre)   { document.getElementById('error-nombre').textContent = 'Debe ingresar un nombre'; valido = false; }
        if (!categoria){ document.getElementById('error-categoria').textContent = 'Debe seleccionar una categoria'; valido = false; }
        if (!precio || parseFloat(precio) < 0) { document.getElementById('error-precio').textContent = 'Debe ingresar un precio valido'; valido = false; }

        if (!valido) return;
        abrirDialog('dialogConfirmar');
    }

    function validarYEnviar() {
        cerrarDialog('dialogConfirmar');
        document.getElementById('loadingSpinner').style.display = 'block';

        const checkboxes = document.querySelectorAll('input[name="caracteristicas"]:checked');
        const caracteristicas = Array.from(checkboxes).map(cb => cb.value).join(', ');
        const estado = document.querySelector('input[name="Estado"]:checked').value;

        const data = {
            Id_producto:     document.getElementById('Id_producto').value.trim(),
            Nombre:          document.getElementById('Nombre').value.trim(),
            'Descripción':   document.getElementById('Descripcion').value.trim(),
            Categoria:       document.getElementById('Categoria').value,
            precioUnitario:  parseFloat(document.getElementById('precioUnitario').value) || 0,
            Cantidad:        parseInt(document.getElementById('Cantidad').value) || 0,
            Existencia:      parseInt(document.getElementById('Existencia').value) || 0,
            Estado:          estado,
            Caracteristicas: caracteristicas
        };

        fetch('facturacion.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en el servidor');
            return response.json();
        })
        .then(resultado => {
            document.getElementById('loadingSpinner').style.display = 'none';
            if (resultado.error) {
                document.getElementById('dialogErrorMsg').textContent = resultado.error;
                abrirDialog('dialogError');
            } else {
                abrirDialog('dialogExito');
                document.getElementById('formProducto').reset();
            }
        })
        .catch(() => {
            document.getElementById('loadingSpinner').style.display = 'none';
            document.getElementById('dialogErrorMsg').textContent = 'Hubo un problema al conectar con el servidor.';
            abrirDialog('dialogError');
        });
    }

    document.querySelectorAll('.alert-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('show');
        });
    });
</script>
</body>
</html>