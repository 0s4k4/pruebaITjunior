<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Tecnica IT Junior</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="alerts">
            <div class="alert alert-success">gg</div>
            <div class="alert alert-danger">ee</div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="container">
            <h1>CRUD DE USUARIOS</h1>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3>Usuarios ( <span id="total"></span> )</h4>
                    <button class="btn btn-primary" id="create">CREAR USUARIO</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Pais</th>
                        <th>Editar</th>
                        <th>Elimninar</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                   
                </tbody>
            </table>
        </div>
    </div>

    <!-- create user model -->

    <!-- <div class="container"> -->
    <div class="modal" id="create-user">
    <div class="modal-body">
        <h3>Crear usuario</h3>
        <div class="form-group">
            <label for=""><b>NOMBRE</b></label>
            <input type="text" placeholder="Ingresa el nombre del usuario" id="name" class="form-control">
            <small class="error-message" id="name-error" style="color: red; display: none;">Por favor, ingresa un nombre válido.</small>
        </div>
        <div class="form-group">
            <label for=""><b>EDAD</b></label>
            <input type="number" placeholder="Ingresa la edad del usuario" id="age" class="form-control">
            <small class="error-message" id="age-error" style="color: red; display: none;">Por favor, ingresa una edad válida (número positivo).</small>
        </div>
        <div class="form-group">
            <label for=""><b>PAIS</b></label>
            <input type="text" placeholder="Ingresa el pais del usuario" id="country" class="form-control">
            <small class="error-message" id="country-error" style="color: red; display: none;">Por favor, ingresa un país válido.</small>
        </div>
        <div class="form-group buttons">
            <button class="btn btn-success" type="submit" id="save">Guardar</button>
            <button class="btn btn-danger" type="button" id="close">Cerrar</button>
        </div>
    </div>
</div>
    <!-- </div> -->

    <!-- edit user -->
    <div class="modal" id="update-user">
    <div class="modal-body">
        <h3>ACTUALIZAR USUARIO</h3>
        <div class="form-group">
            <label for=""><b>NOMBRE</b></label>
            <input type="text" placeholder="Ingresa el nombre del usuario" id="edit_name" class="form-control">
            <small class="error-message" id="edit_name-error" style="color: red; display: none;">Por favor, ingresa un nombre válido.</small>
            <input type="hidden" placeholder="Id" id="id" class="form-control">
        </div>
        <div class="form-group">
            <label for=""><b>EDAD</b></label>
            <input type="number" placeholder="Ingresa la edad del usuario" id="edit_age" class="form-control">
            <small class="error-message" id="edit_age-error" style="color: red; display: none;">Por favor, ingresa una edad válida (número positivo).</small>
        </div>
        <div class="form-group">
            <label for=""><b>PAIS</b></label>
            <input type="text" placeholder="Ingresa el país del usuario" id="edit_country" class="form-control">
            <small class="error-message" id="edit_country-error" style="color: red; display: none;">Por favor, ingresa un país válido.</small>
        </div>
        <div class="form-group buttons">
            <button class="btn btn-success" id="update" type="submit">ACTUALIZAR</button>
            <button class="btn btn-danger" type="button" id="update_close">CERRAR</button>
        </div>
    </div>
</div>


<!-- delete modal user -->

<div class="modal_delete" id="confirm-delete-modal" style="display: none;">
    <div class="modal-body-delete">
        <h3>¿Estás seguro de que deseas eliminar este usuario?</h3>
        <div class="form-group buttons">
            <button class="btn btn-danger" id="confirm-delete">Eliminar</button>
            <button class="btn btn-secondary" id="cancel-delete">Cancelar</button>
        </div>
    </div>
</div>

    <script src="js/app.js"></script>
</body>

</html>
