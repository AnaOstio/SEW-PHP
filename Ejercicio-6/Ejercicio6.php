<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Ejercicio 6 PHP</title>
    <meta name="author" content="Ana Fernandez Ostio, UO275780" />
    <meta name="description" content="Consumo de servicios web sobre el gas natural" />
    <meta name="keywords" content="gas natural,api gas natural, ng, EIA, precio año mes gas natural">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Ejercicio6.css" />
</head>

<body>
    
    <?php
        session_start();
        class BaseDatos{

            protected $servername;
            protected $username;
            protected $password;

            protected $nombreTabla;

            protected $db;

            public function __construct(){
                $this->servername = "localhost";
                $this->username = "DBUSER2022";
                $this->password = "DBPSWD2022";
            }

            public function conexion(){

                $this->db = new mysqli($this->servername, $this->username, $this->password);
                if($this ->db->connect_error) {
                    return false;  
                }  else {
                    return true;    
                }
            }

            public function crearBase()
            {

                if ($this->conexion()) {
                    $cadenaSQL = "CREATE DATABASE IF NOT EXISTS pruebasusabilidad COLLATE utf8_spanish_ci";
                    if ($this->db->query($cadenaSQL) === TRUE) {
                        $this->nombreTabla = "pruebasusabilidad";
                        return "Base de datos 'pruebasusabilidad' creada con éxito";
                    }

                    if ($this->db->errno) {
                        return "Ha habido un problema con la creacion de la tabla";
                    }
                } else {
                    return "Ha habido un problema con la conexion";
                }
            }

            public function crearTabla(){
                $this->conexion();

                $this->nombreTabla = "pruebasusabilidad";
                $this->db->select_db($this->nombreTabla);
                $crearTabla = "CREATE TABLE IF NOT EXISTS persona ( 
                            dni VARCHAR(9) NOT NULL,
                            nombre VARCHAR(255) NOT NULL, 
                            apellidos VARCHAR(255) NOT NULL, 
                            email VARCHAR(255) NOT NULL,   
                            telefono VARCHAR(9) NOT NULL,  
                            edad VARCHAR(3) NOT NULL,  
                            sexo VARCHAR(1) NOT NULL,
                            nivelInformatico VARCHAR(2) NOT NULL,
                            tareaCompletada VARCHAR(2) NOT NULL,
                            tSec VARCHAR(20) NOT NULL,
                            comentarios VARCHAR(255) NOT NULL,   
                            propuestas VARCHAR(255) NOT NULL,   
                            valoracion VARCHAR(2) NOT NULL,   
                            PRIMARY KEY (dni))";
              
                if($this->db->query($crearTabla) === TRUE){
                    return "Tabla 'persona' creada con éxito";
                } else { 
                    return "ERROR en la creación de la tabla persona. Error : ". $this->db->error ;
                }   

            }

            public function insertarDatos($dni, $nombre, $apellido, $mail, $tel, $edad, $sexo, $nivel, $tiempo, $realizado, $comentarios, $propuestas, $valoracion){

                if($this->buscar($dni) != ''){
                    return "ya existe un usuario con el mismo DNI";
                }


                $this->conexion();
                $this->nombreTabla = "pruebasusabilidad";
                $this->db->select_db($this->nombreTabla);

                $campos = array($dni, $nombre, $apellido, $mail, $tel, $sexo, $edad, $nivel, $tiempo, $realizado, $comentarios, $propuestas, $valoracion);

                if($this->comprobarCampos($campos)){
                    $query = "INSERT INTO `persona`(`dni`, `nombre`, `apellidos`, `email`, 
                    `telefono`, `edad`, `sexo`, `nivelInformatico`, `tareaCompletada`, 
                        `tSec`, `comentarios`, `propuestas`, `valoracion`)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,? );";
                    $prepare = $this->db->prepare($query);
                    $prepare->bind_param(
                        'sssssssssssss',
                        $dni,
                        $nombre,
                        $apellido,
                        $mail,
                        $tel,
                        $edad,
                        $sexo,
                        $nivel,
                        $realizado,
                        $tiempo,
                        $comentarios,
                        $propuestas,
                        $valoracion

                    );
                    $execute = $prepare->execute();
                    $prepare->close();
                    if($execute){
                        return "Usuario insertado correctamente";
                    } else {
                        return "Ha habido un error insertado";
                    }
                } else {
                    return "Hay campos vacios";
                }
            }


            private function comprobarCampos($campos){
                foreach ($campos as $c){
                    if($c == ''){
                        return false;
                    }
                }
                return true;
            }

            public function buscar($dni){
                $this->conexion();
                $this->nombreTabla = "pruebasusabilidad";
                $this->db->select_db($this->nombreTabla);
                $query = 'SELECT * FROM `persona` WHERE dni = ?';
                $prepare = $this->db->prepare($query);
                $prepare->bind_param('s', $dni);
                $prepare->execute();
                $resultado = $prepare->get_result();

                if($resultado->fetch_assoc() != NULL){
                    $resultado->data_seek(0);
                    while($fila = $resultado->fetch_assoc()){
                        return "DNI: " . $fila["dni"] . ", Nombre: " . $fila["nombre"] . ", Apellido: " . $fila["apellidos"] . ", EMAIL: " . $fila["email"] . 
                        " Telefono: " . $fila["telefono"] . " EDAD: " . $fila["edad"] . " SEXO: " . $fila["sexo"] . " Nivel Informatico: " . $fila["nivelInformatico"] . 
                        " Tarea completada: " . $fila["tareaCompletada"] . " SEGUNDOS: " . $fila["tSec"] . " COMENTARIOS: " . $fila["comentarios"] 
                        . " PROPUESTAS: " . $fila["propuestas"] . " VALORACION: " . $fila["valoracion"];
                    }
                }

                $prepare->close();
            }

            public function eliminar($dni){
                if($this->buscar($dni) == ''){
                    return "usuario no existe";
                }

                $this->conexion();
                $this->nombreTabla = "pruebasusabilidad";
                $this->db->select_db($this->nombreTabla);
                $query = 'DELETE FROM `persona` WHERE dni = ?';
                $prepare = $this->db->prepare($query);
                $prepare->bind_param('s', $dni);
                $prepare->execute();
                $prepare->close();
                return "El usuario ha sido eliminado con exito" ;
            }

            public function exportar(){
                $this->conexion();
                $this->nombreTabla = "pruebasusabilidad";
                $this->db->select_db($this->nombreTabla);
                $query = 'SELECT * FROM `persona`';
                $result = $this->db->query($query);
                if($result->num_rows > 0){
                    $data = $result->fetch_assoc();
                    $csv[] = array_keys($data);
                    $result->data_seek(0);
                    while($data = $result->fetch_assoc()){
                        $csv[] = array_values($data);
                    }

                    header('Content-Type: application/csv');
                    header('Content-Disposition: attachment; filename="pruebasUsabilidad.csv";');
                    ob_end_clean();
                    $file = fopen('php://output', 'w');
                    foreach($csv as $line){
                        fputcsv($file, $line, ',');
                    }
                exit;
                }
                
            }
            public function generarInforme(){
                $this->conexion();
                $this->nombreTabla = "pruebasusabilidad";
                $this->db->select_db($this->nombreTabla);
                $tamaño = $this->db->query("SELECT COUNT(*) FROM `persona`")->fetch_row()[0];
                $edades = $this->db->query("SELECT SUM(edad) FROM `persona`")->fetch_row()[0];
                $media = $edades / $tamaño;

                // Hombres
                $hombres = $this->db->query("SELECT COUNT(*) FROM `persona` WHERE sexo = 'M'")->fetch_row()[0];
                $fHombres = $hombres / $tamaño * 100;
                // Muejres
                $mujeres = $this->db->query("SELECT COUNT(*) FROM `persona` WHERE sexo = 'F'")->fetch_row()[0];
                $fMujeres = $mujeres / $tamaño * 100;

                // Nivel medio
                $sumaNivel = $this->db->query("SELECT SUM(nivelInformatico) FROM `persona`")->fetch_row()[0];
                $mediaNivel = $sumaNivel / $tamaño;

                // Tiempos
                $tiemposTotales = $this->db->query("SELECT SUM(tSec) FROM `persona`")->fetch_row()[0];
                $mediaTiempos = $tiemposTotales / $tamaño;

                // Tarea Realizada
                $conseguidos = $this->db->query("SELECT Count(*) FROM `persona` WHERE tareaCompletada = 'Si'")->fetch_row()[0];
                $fCosneguidos = $conseguidos / $tamaño * 100;

                // Puntutacion
                $valoraciones = $this->db->query("SELECT SUM(valoracion) FROM `persona`")->fetch_row()[0];
                $mediaValoracion = $valoraciones / $tamaño;

                return "Edad media de los usuarios " . $media . ". Frecuencia de usuarios masculinos " . $fHombres 
                    . " y de mujeres " . $fMujeres . ". Media del nivel de informatica: " . $mediaNivel . ". Tiempo medio: " .
                    $mediaTiempos . " Cantidad de personas que han superado la prueba " . $fCosneguidos . ". Puntuacion 
                    media de la aplicacion: " . $mediaValoracion;

            }

            public function importarCSV($ruta){
                $this->conexion();
                $this->nombreTabla = "pruebasusabilidad";
                $this->db->select_db($this->nombreTabla);

                if ($this->db->connect_errno) {
                    exit();
                }

                if (($handle = fopen($ruta, "r")) !== FALSE) {
                    $cabecera = false;
                    while(($fila =   fgetcsv($handle)) !== FALSE){
                        if($cabecera){
                            $fila = explode(",", implode(',', $fila));
                            $query = "INSERT INTO `persona`(`dni`, `nombre`, `apellidos`, `email`, 
                                `telefono`, `edad`, `sexo`, `nivelInformatico`, `tareaCompletada`, 
                                `tSec`, `comentarios`, `propuestas`, `valoracion`)
                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,? );";
                            $prepare = $this->db->prepare($query);
                            for($i = 0; $i < count($fila); $i++){
                                $fila[$i] = str_replace('"', '', $fila[$i]);
                                echo "<script>console.log( 'Debug Objects: " . $fila[$i] . "' );</script>"; 
                            }    
                            $prepare->bind_param(
                                'sssssssssssss',
                                $fila[0],
                                $fila[1],
                                $fila[2],
                                $fila[3],
                                $fila[4],
                                $fila[5],
                                $fila[6],
                                $fila[7],
                                $fila[8],
                                $fila[9],
                                $fila[10],
                                $fila[11],
                                $fila[12]
        
                            );
                            $prepare->execute();
                        $prepare->close();
                        }
                        $cabecera = true;
                    }
                    fclose($handle);
                    return "El CSV ha sido importado con exito";
                }
            }

            public function modificarDatos($campo, $dato, $dni)
            {
                $this->conexion();
                $this->nombreTabla = "pruebasusabilidad";
                $this->db->select_db($this->nombreTabla);

                if ($this->db->connect_errno) {
                    exit();
                }

                if($dato != ""){
                    $query = "UPDATE persona SET $campo=? WHERE dni=?";
                    $prepare = $this->db->prepare($query);
                    $prepare->bind_param('ss', $dato, $dni);
                    $prepare->execute();
                    $prepare->close();
                }
            }
        }

        // Variables
        $crearBD = ""; 
        $eliminar = ""; 
        $tabla = "";
        $modificado = "";
        $importacion = "";
        $exportacion = "";
        $informe = "";
        $buscado = "";
        $insertado = "";

        $bd = new BaseDatos();
        if(count($_POST) > 0){
            if (isset($_POST['crearBase']))
                $crearBD = $bd->crearBase();
            
            if (isset($_POST['crearTabla']))
                $tabla = $bd->crearTabla();
                
            if (isset($_POST['insertarDatos']))
                $insertado = $bd->insertarDatos(
                    $_POST['Idni'],
                    $_POST['Inombre'],
                    $_POST['Iapellido'],
                    $_POST['Iemail'],
                    $_POST['Itel'],
                    $_POST['Iedad'],
                    $_POST['Isexo'],
                    $_POST['InIn'],
                    $_POST['Itmp'],
                    $_POST['Itarea'],
                    $_POST['Icom'],
                    $_POST['Iprop'], 
                    $_POST['Ival']
                );

            if (isset($_POST['buscarDato']))
                $buscado = $bd->buscar($_POST['buscarDni']);
            if (isset($_POST['eliminarData']))
                $eliminar = $bd->eliminar($_POST['eliminaDni']);
            if (isset($_POST['exportarData']))
                $bd->exportar();
                
            if (isset($_POST['informe']))
                $informe = $bd->generarInforme();
         
            if (isset($_POST['cargarDatos']))
                if($_FILES){
                    $path = $_FILES['archivo']['tmp_name'];
                    $importacion = $bd->importarCSV($path);
                    
                }
            
            if (isset($_POST['modificarDatos']))
                if($bd->buscar($_POST['Mdni']) != ""){

                    $bd->modificarDatos("nombre",  $_POST['Mnombre'],  $_POST['Mdni']);
                    $bd->modificarDatos("apellidos",  $_POST['Mapellido'],  $_POST['Mdni']);
                    $bd->modificarDatos("email",  $_POST['Memail'],  $_POST['Mdni']);
                    $bd->modificarDatos("telefono",  $_POST['Mtel'],  $_POST['Mdni']);
                    $bd->modificarDatos("edad",  $_POST['Medad'],  $_POST['Mdni']);
                    $bd->modificarDatos("sexo",  $_POST['Msexo'],  $_POST['Mdni']);
                    $bd->modificarDatos("nivelInformatico",  $_POST['MnIn'],  $_POST['Mdni']);
                    $bd->modificarDatos("tareaCompletada",  $_POST['Mtarea'],  $_POST['Mdni']);
                    $bd->modificarDatos("tSec",  $_POST['Mtmp'],  $_POST['Mdni']);
                    $bd->modificarDatos("comentarios",  $_POST['Mcom'],  $_POST['Mdni']);
                    $bd->modificarDatos("propuestas",  $_POST['Mprop'],  $_POST['Mdni']);
                    $bd->modificarDatos("valoracion",  $_POST['Mval'],  $_POST['Mdni']);

                    $modificado = "el usuario ha sido modificado con exito";
                } else {
                    $modificado = "No hay usuario con ese DNI";
                }
        }
    ?>
        
        <header>
            <h1>Ejercicio 6 PHP</h1>
            <nav>
                <ul>
                    <li><a href="#cBase">Crear Base de datos</a></li>
                    <li><a href="#cTabla">Crear Tabla</a></li>
                    <li><a href="#insertar">Insertar Datos</a></li>
                    <li><a href="#find">Buscar Datos</a></li>
                    <li><a href="#modificar">Modificar BBDD</a></li>
                    <li><a href="#eliminar">Eliminar BBDD</a></li>
                    <li><a href="#informe">Generar informe</a></li>
                    <li><a href="#load">Cargar datos a la BBDD</a></li>
                    <li><a href="#exportar">Exportar datos a la BBDD</a></li>
                </ul>
            </nav>
        </header>

        <section id = "cBase">
            <h2>Crear Base De Datos</h2>
            <form method="POST">
                <label for = "crear">Crear base de datos</label>
                <input type="submit" name="crearBase" value="Crear" id="crear" />
            </form>
            <p><?php echo "$crearBD" ;?></p>
        </section>

        <section id = "cTabla">
            <form method="POST">
                <h2>Crear Tabla</h2>
                <label for = "tabla">Crear Tabla</label>
                <input type="submit" name="crearTabla" value="Crear Tabla" id="tabla" />
            </form>
            <p><?php echo "$tabla" ;?></p>
        </section>

        <section id = "insertar">
            <h2>Insertar Datos Base De Datos</h2>
            <p>Los campos son OBLIGATOROS</p>
            <form method="POST">
                <label for = "nombreI">Nombre</label>
                <input type="text" name="Inombre" id="nombreI" />

                <label for = "apellidoI">Apellidos</label>
                <input type="text" name="Iapellido" id="apellidoI" />

                <label for = "dniI">DNI</label>
                <input type="text" name="Idni" id="dniI" />

                <label for = "emailI">Correo Electronico</label>
                <input type="text" name="Iemail" id="emailI" />

                <label for = "telI">Telefono</label>
                <input type="text" name="Itel" id="telI" />

                <label for = "edadI">Edad</label>
                <input type="text" name="Iedad" id="edadI" />

                <label for = "sexoI">Sexo</label>
                <input type="text" name="Isexo" id="sexoI" />

                <label for = "nInI">Nivel Informatico [0, 10]</label>
                <input type="text" name="InIn" id="nInI" />

                <label for = "tmpI">Tiempo medio prueba (segundos)</label>
                <input type="text" name="Itmp" id="tmpI" />

                <label for = "tareaI">¿Se completo la tarea? (No, Si)</label>
                <input type="text" name="Itarea" id="tareaI" />

                <label for = "comI">Comentarios</label>
                <input type="text" name="Icom" id="comI" />

                <label for = "propI">Propuestas de mejora</label>
                <input type="text" name="Iprop" id="propI" />

                <label for = "valI">Valoracion de la página [0, 10]</label>
                <input type="text" name="Ival" id="valI" />

                <input type="submit" name="insertarDatos" value="Insertar Datos"/>

            </form>
            <p><?php echo "$insertado" ;?></p>
        </section>

        <section id = "find">
            <h2>Buscar datos en la tabla</h2>
            <form method="POST">
                <label for="buscar">Dni a buscar</label>
                <input type="text" id="buscar" name="buscarDni" />
                <input type="submit" name="buscarDato" value="Buscar" />
            </form>
            <p><?php echo "$buscado" ;?></p>
        </section>

        <section id = "modificar">
            <h2>Modificar Datos de la BBDD</h2>
            <p>Hay que indicar el usuario a traves del DNI, por lo que es un campo obligatorio</p>
            <form method="POST">
                <label for = "dniM">DNI</label>
                <input type="text" name="Mdni" id="dniM" />

                <label for = "nombreM">Nombre</label>
                <input type="text" name="Mnombre" id="nombreM" />

                <label for = "apellidoM">Apellidos</label>
                <input type="text" name="Mapellido" id="apellidoM" />

                <label for = "emailM">Correo Electronico</label>
                <input type="text" name="Memail" id="emailM" />

                <label for = "telM">Telefono</label>
                <input type="text" name="Mtel" id="telM" />

                <label for = "edadM">Edad</label>
                <input type="text" name="Medad" id="edadM" />

                <label for = "sexoM">Sexo</label>
                <input type="text" name="Msexo" id="sexoM" />

                <label for = "nInM">Nivel Informatico [0, 10]</label>
                <input type="text" name="MnIn" id="nInM" />

                <label for = "tmpM">Tiempo medio prueba (segundos)</label>
                <input type="text" name="Mtmp" id="tmpM" />

                <label for = "tareaM">¿Se completo la tarea? (No, Si)</label>
                <input type="text" name="Mtarea" id="tareaM" />

                <label for = "comM">Comentarios</label>
                <input type="text" name="Mcom" id="comM" />

                <label for = "propM">Propuestas de mejora</label>
                <input type="text" name="Mprop" id="propM" />

                <label for = "valM">Valoracion de la página [0, 10]</label>
                <input type="text" name="Mval" id="valM" />

                <input type="submit" name="modificarDatos" value="Modificar Datos"/>
                
            </form>
            <p><?php echo "$modificado" ;?></p>
        </section>

        <section id = "eliminar">
            <h2>Eliminar de la BBDD</h2>
            <form method="POST">
                <label for="buscarEliminar">Dni del usuario eliminar</label>
                <input type="text" id="buscarEliminar" name="eliminaDni" />
                <input type="submit" name="eliminarData" value="Eliminar" />
            </form>
            <p><?php echo "$eliminar" ;?></p> 

        </section>
        <section id = "informe">
            <h2>Generar Informe</h2>
            <form method="POST">
                <input type="submit" name="informe" value="Generar Informe" />
            </form>
            <p><?php echo "$informe" ;?></p>
        </section>
        <section id = "load">
            <h2>Cargar datos de un CSV</h2>
            <?php
                echo "
                <form action='#' method='post' enctype='multipart/form-data'>
                    <label for='cargar'>Seleccione archivosa cargar </label>
                    <input type='file' id = 'cargar' name='archivo'/>
                    <input type='submit' name = 'cargarDatos' value='Cargar'/>
                    
                </form>";
            ?>
            <p><?php echo "$importacion" ;?></p>
        </section>
        <section id = "exportar">
            <h2>Exportar de la BBDD</h2>
            <form method="POST">
                
                <input type="submit" name="exportarData" value="Exportar" />
            </form>
        </section>

</body>

</html>