1.¿De qué forma manejaste el login de usuarios? Explica con tus palabras por qué en tu página funciona de esa forma.
El login está manejado con PHP, MySQL y sesiones. En login.php, el sistema recibe el nombre de usuario y la contraseña desde un formulario, busca el usuario en la tabla usuario con una consulta SELECT, y si encuentra coincidencia compara la contraseña escrita con la guardada en la base de datos. Cuando son iguales, guarda en $_SESSIONel nombre del usuario y su id, y luego redirige a index.php. Después, en auth.php, se valida que exista $_SESSION['usuario']; si no existe, el sistema manda otra vez al usuario a login.php. Por eso la página funciona así: porque la sesión mantiene al usuario autenticado mientras navega, evitando que tenga que iniciar sesión en cada página. 
Con mis palabras, yo diría que el login funciona de esa forma porque la aplicación necesita identificar quién entró al sistema y recordar ese acceso durante toda la navegación. La base de datos verifica que el usuario exista y la sesión conserva temporalmente su identidad dentro del sistema. Así se protege el acceso a páginas internas como el panel principal o el listado de productos. 
También puedes mencionar algo importante si tu profesor valora análisis: en este proyecto la contraseña está guardada y comparada en texto plano, no con hash, porque en la tabla usuario aparecen contraseñas directamente almacenadas y en el login se usa una comparación simple if ($password === $user['password']). Funciona para fines académicos o de prueba, pero en un sistema real lo correcto sería usar contraseñas cifradas con hash. 

2. ¿Por qué es necesario para las aplicaciones web utilizar bases de datos en lugar de variables?
Es necesario usar bases de datos porque las variables normales solo guardan información de forma temporal mientras el programa se está ejecutando. En cambio, una base de datos permite guardar información de manera permanente, organizarla, consultarla, actualizarla y reutilizarla después, incluso cuando el usuario cierra la página o el servidor reinicia. En este proyecto, por ejemplo, los usuarios y los productos no podrían manejarse bien solo con variables, porque se necesita que queden registrados para futuros accesos, consultas, ediciones y listados. 
Además, las bases de datos permiten trabajar con muchos registros al mismo tiempo y relacionar información de forma ordenada. Si todo se manejara con variables, los datos se perderían al recargar la página y sería muy difícil administrar usuarios, inventario o facturación. Por eso, en aplicaciones web que manejan información real, la base de datos es la que da persistencia, control y escalabilidad.

3. ¿En qué casos sería mejor utilizar bases de datos para su solución y en cuáles utilizar otro tipo de datos temporales como cookies o sesiones?
Las bases de datos son mejores cuando la información debe quedar almacenada a largo plazo. Por ejemplo: cuentas de usuarios, contraseñas, productos, precios, existencias, facturas, historial de compras o cualquier dato que deba consultarse después. En tu proyecto se usan correctamente para guardar los usuarios y los productos, porque esa información debe permanecer en el sistema aunque el navegador se cierre. 
Las sesiones son mejores cuando se necesita guardar información temporal del usuario mientras está navegando dentro del sistema. En este caso se usan para recordar quién inició sesión, guardando $_SESSION['usuario'] y $_SESSION['id_usuario']. Eso no reemplaza la base de datos, sino que la complementa, porque la sesión solo conserva temporalmente el acceso del usuario autenticado. 
Las cookies serían útiles para datos pequeños que conviene recordar en el navegador, como idioma, tema visual, preferencias o mantener un recordatorio de inicio de sesión. Pero no son la mejor opción para guardar datos críticos del sistema, porque viven del lado del cliente y pueden ser manipuladas. Entonces, en resumen: base de datos para información permanente e importante; sesiones para control temporal de acceso; cookies para preferencias o recuerdos simples del navegador. Esta lógica coincide con la forma en que tu repositorio maneja la autenticación con sesiones y los datos principales con MySQL.

4. Describa brevemente sus tablas y los tipos de datos utilizados en cada campo; justifique la elección del tipo de dato para cada uno.
En la base de datos del repositorio aparecen dos tablas principales: productos y usuario. 
Tabla productos:
- Id_producto → varchar(10): se usa para guardar un código alfanumérico del producto, por ejemplo “P0978”. Se eligió varchar porque no siempre será un número puro.
- Nombre → varchar(100): almacena el nombre del producto. Se usa varchar porque es texto variable y no todos los nombres tienen la misma longitud.
- Descripción → varchar(100): guarda una descripción corta del producto. También se usa varchar porque es texto.
- precioUnitario → decimal(10,2): permite guardar valores monetarios con decimales exactos, por eso es mejor que float para precios.
- Cantidad → int(10): representa una cantidad numérica entera, por eso se usa entero.
- Existencia → int(10): también guarda cantidades enteras del inventario disponible, así que int es apropiado. Además, Id_producto es clave primaria porque identifica de forma única a cada producto. 
Tabla usuario:
- id → int(11) con AUTO_INCREMENT: sirve como identificador único de cada usuario. Se usa entero porque es eficiente para claves numéricas y el autoincremento evita repetir ids.
- nombre → varchar(100): almacena el nombre de usuario; se usa varchar porque la longitud puede variar.
- password → varchar(255): guarda la contraseña. Se eligió un tamaño amplio porque normalmente este campo también serviría para guardar contraseñas cifradas con hash, que ocupan más espacio.
- created_at → timestamp: registra automáticamente la fecha y hora de creación del usuario, lo cual ayuda a llevar control del registro. Además, id es clave primaria y nombre tiene restricción UNIQUE, para que no se repitan nombres de usuario. 

Cristian Yahir Campos Aparicio SMSS109222
Lindys Arely Martinez Herrera  SMSS170822
