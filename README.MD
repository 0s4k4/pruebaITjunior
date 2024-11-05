
# PRUEBA IT JUNIOR






## INSTALACION Y CONFIGURACION DEL PROYECTO

### Descarga del proyecto

Clona el repositorio de Git o descarga el proyecto en el directorio donde se encuentra el servicio de Apache/PHP:

```bash
  git clone https://github.com/0s4k4/pruebaITjunior.git

  cd pruebaITjunior
```

### Estructura del Proyecto
El proyecto tiene la siguiente estructura de carpetas:

```bash
pruebaITjunior/
├── api
│   ├── db.php
│   └── index.php
├── css
│   └── style.css
├── database
│   └── database.sql
├── database.sql
├── index.php
├── js
│   └── app.js
└── php
    ├── config.php
    ├── delete-data.php
    ├── edit-data.php
    ├── get-total-count.php
    ├── insert-data.php
    ├── select-data.php
    └── update-data.php
```
### Configuración de Archivos de Conexión a la Base de Datos

Es necesario editar los archivos /php/config.php y /api/db.php para establecer la conexión a la base de datos.

/api/db.php

```php
<?php
$localhost = "172.29.77.95";  ///se selecciona el host
$username = "admin"; //el username del server
$password = "admin123"; //password del server
$database = "pruebaIT"; //base de datos

$conn = new mysqli($localhost, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]));
}
?>


```

/php/config.php


```php
<?php

$localhost="172.29.77.95"; //direccion del host de la base de datos
$username="admin"; //usuario de la base de datos
$password="admin123"; //password de la base de datos
$database="pruebaIT";  //base de datos

$conn = new mysqli($localhost, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>

```

### Configuración de la Base de Datos

Dentro de la carpeta database se encuentra el archivo database.sql, que contiene la estructura y datos de ejemplo de la base de datos. El contenido del archivo es el siguiente

```sql
CREATE DATABASE IF NOT EXISTS `pruebaIT` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pruebaIT`;

-- Estructura de la tabla pruebaIT.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `user_name` varchar(255) DEFAULT NULL,
  `user_age` varchar(255) DEFAULT NULL,
  `user_country` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

-- Datos de ejemplo en la tabla pruebaIT.users
DELETE FROM `users`;
INSERT INTO `users` (`id`, `user_name`, `user_age`, `user_country`) VALUES
    (1, 'JORGE LUIS PIÑA FLORENCIO', '20', 'Mexico'),
    (15, 'Magda Ramirez', '12', 'México');

    
```

Puedes ejecutar el archivo .sql en tu gestor de base de datos o copiar y pegar el código para crear la base de datos y sus registros de ejemplo.

## USO DE LA API

Puedes utilizar Postman para probar los endpoints de la API . A continuación se describen los pasos para interactuar con la API.

### Configuración de la Autenticación

Antes de realizar las solicitudes, asegúrate de configurar la autenticación en Postman:

1. **Selecciona el tipo de autenticación:**
   - Ve a la pestaña "Authorization".
   - En el menú desplegable "Type", selecciona "Basic Auth".

2. **Ingresa las credenciales:**
   - **Username:** `admin`
   - **Password:** `admin123`

### 1. Obtener la lista de todos los usuarios

- **Método:** `GET`
- **URL:** `http://172.29.77.95/pruebaITjunior/api/index.php/users`
- **Descripción:** Este endpoint devuelve una lista de todos los usuarios en formato JSON.
  
**Ejemplo de solicitud en Postman:**
- Selecciona el método `GET`.
- Ingresa la URL mencionada.
- Se configura la autenticación con como se indica en el punto de arriba con el username como admin y la password como admin123 
- Haz clic en "Send".



Al realizar una solicitud al endpoint para obtener la lista de usuarios, la API devuelve una respuesta en formato JSON similar a la siguiente:

```json
[
    {
        "id": "1",
        "user_name": "JORGE LUIS PIÑA FLORENCIO",
        "user_age": "20",
        "user_country": "Mexico"
    },
    {
        "id": "15",
        "user_name": "Magda Ramirez",
        "user_age": "12",
        "user_country": "México"
    },
    {
        "id": "17",
        "user_name": "Juan",
        "user_age": "30",
        "user_country": "México"
    }
]
```
### 2. Agregar un Nuevo Usuario

1. **Método:** POST  
2. **URL:** `http://172.29.77.95/pruebaITjunior/api/index.php/users`  
3. **Descripción:** Este endpoint permite agregar un nuevo usuario.

#### Ejemplo de solicitud en Postman:

- Selecciona el método **POST**.
- Ingresa la URL mencionada.
- Ve a la pestaña **Body**, selecciona **raw** y luego **JSON** (en el menú desplegable).

- Se configura la autenticación con como se indica en el punto de arriba con el username como admin y la password como admin123

- Copia y pega el siguiente cuerpo de ejemplo:


```json
{
    "user_name": "Nuevo Usuario",
    "user_age": "25",
    "user_country": "México"
}

```

- Haz clic en "Send".

Si todo marcha bien se visualiza una respuesta similar a esta


```json
{
    "message": "Usuario agregado exitosamente",
    "id": 18
}
```

### Eliminar un Usuario por su ID

1. **Método:** DELETE  

2. **URL:** `http://172.29.77.95/pruebaITjunior/api/index.php/users/{id}`

3. **Descripción:** Este endpoint permite eliminar un usuario especificando su ID.

#### Ejemplo de solicitud en Postman:

- Selecciona el método **DELETE**.
- Reemplaza `{id}` con el ID del usuario que deseas eliminar en la URL.
- Ingresa la URL modificada.
- Se configura la autenticación con como se indica en el punto de arriba con el username como admin y la password como admin123

- Haz clic en **Send**.


#### Demostracion de delete
- Ingresa la siguiente URL: `http://172.29.77.95/pruebaITjunior/api/index.php/users/18`.

- Se carga la configuracion previamente dicha para delete 

- Haz clic en **Send**.

Si va todo bien se regresa la siguiente respuesta. 

```json
{
    "message": "Usuario agregado exitosamente",
    "id": 18
}
```

En caso de que exista un problema da el siguiente resultado 

```json
{
    "error": "Usuario no encontrado"
}

```

### GRACIAS POR LEER EL README, CUALQUIER DUDA MI CORREO ES soulbosss@gmail.com