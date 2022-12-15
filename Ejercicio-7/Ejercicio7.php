<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Ejercicio 6 PHP</title>
    <meta name="author" content="Ana Fernandez Ostio, UO275780" />
    <meta name="description" content="Consumo de servicios web sobre el gas natural" />
    <meta name="keywords" content="gas natural,api gas natural, ng, EIA, precio año mes gas natural">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Ejercicio7.css" />
</head>

<body>
    <?php
    session_start();

    class Ejercicio7 {

        protected $servername;
        protected $username;
        protected $password;
        protected $db;

        public $torneo;

        public function __construct($torneo){
            $this->servername = "localhost";
            $this->username = "DBUSER2022";
            $this->password = "DBPSWD2022";
            $this->torneo = $torneo;
            echo "<script>console.log( 'Debug Objects: " . $this->torneo . "' );</script>"; 
        }


        public function conexion(){

            $this->db = new mysqli($this->servername, $this->username, $this->password);
            if($this ->db->connect_error) {
                return false;  
            }  else {
                return true;    
            }
        }

        public function getTorneos(){
            $cad = "<select name='select' title = 'torneo'>";

            $this->conexion();
            $this->db->select_db('ejercicio-7');

            $query = "SELECT nombreTorneo FROM `torneo`";

            $result = $this->db->query($query);

            if($result->fetch_assoc() != NULL){
                $result->data_seek(0);
                while($fila = $result->fetch_assoc()){
                    $cad .= "<option value = '". $fila["nombreTorneo"] . "' title = '". $fila["nombreTorneo"] ."'>" . $fila['nombreTorneo'] . "</option>";
                }
            }

            $cad .= "</select>";
            return $cad;
        }

        public function getClasificacion(){

            $this->conexion();
            $this->db->select_db('ejercicio-7');

            echo "<script>console.log( 'Debug Objects: " . $this->torneo . "' );</script>"; 

            $query = "SELECT equipo.nombreEquipo, equipo.puntos FROM equipo, torneo 
                        where equipo.nombreTorneo = torneo.nombreTorneo and torneo.nombreTorneo = ? GROUP BY equipo.nombreEquipo, equipo.puntos ORDER by equipo.puntos DESC;";

            $prepare = $this->db->prepare($query);
            $prepare->bind_param('s', $this->torneo);
            $prepare->execute();
            $result = $prepare->get_result();
            $cad = "<ol>";

            if($result->fetch_assoc() != NULL){
                $result->data_seek(0);
                while($fila = $result->fetch_assoc()){
                    $cad .= "<li>". $fila['nombreEquipo'] . '-' . $fila['puntos'] . 'pts.' ."</li>";
                }
            }

            $cad .= "</ol>";
            $prepare->close();
            return $cad;
        }

        public function buscarClub($club){
            $this->conexion();
            $this->db->select_db('ejercicio-7');

            $query = "SELECT * FROM equipo WHERE nombreEquipo = ?";
            $prepare = $this->db->prepare($query);
            $prepare->bind_param('s', $club);
            $prepare->execute();
            $result = $prepare->get_result();

            if ($result->fetch_assoc() != NULL) {
                return true;
            } else {
                return false;
            }
        }


        public function sacarInfoClub($club){
            $cad = "<h3>Informacion del Club: " . $club . "</h3>";

            $query = "select equipo.puntos, equipo.pais, equipo.nombreTorneo, patrocinador.nombreEmpresa, patrocinador.cantidad 
                    from equipo, patrocinador 
                    WHERE equipo.nombreEquipo = ? and equipo.nombrePatro = patrocinador.nombreEmpresa;";

            $prepare = $this->db->prepare($query);
            $prepare->bind_param('s', $club);
            $prepare->execute();       
            $result = $prepare->get_result();
            $cad = "<ul>";

            if($result->fetch_assoc() != NULL){
                $result->data_seek(0);
                while($fila = $result->fetch_assoc()){
                    $cad .= "<li> Puntos ". $fila['puntos'] . ' en el Torneo ' . $fila['nombreTorneo'] . '.' ."</li>";
                    $cad .= "<li> Tiene como principal patrocinador a ". $fila['nombreEmpresa'] . ' que ha ofrecido una cantidad de ' . $fila['cantidad'] . '€.' ."</li>";
                }
            }

            $cad .= "</ul>";
            $cad .= "<h4>Partidos jugados como local</h4>";
            $cad .= "<ul>";
            $query = "select * from partido where partido.equipoLocal = ?;";
            $prepare = $this->db->prepare($query);
            $prepare->bind_param('s', $club);
            $prepare->execute();       
            $result = $prepare->get_result();


            if($result->fetch_assoc() != NULL){
                $result->data_seek(0);
                while($fila = $result->fetch_assoc()){
                    $cad .= "<li> Equipo visitante ". $fila['equipoVisitante'] . '. Resultado: ' . $fila['resultado'] . ', fecha: '. $fila['fecha'] ."</li>";
                }
            }
            $cad .= "</ul>";

            $cad .= "<h4>Partidos jugados como visitante</h4>";
            $cad .= "<ul>";
            $query = "select * from partido where partido.equipoVisitante = ?;";
            $prepare = $this->db->prepare($query);
            $prepare->bind_param('s', $club);
            $prepare->execute();       
            $result = $prepare->get_result();


            if($result->fetch_assoc() != NULL){
                $result->data_seek(0);
                while($fila = $result->fetch_assoc()){
                    $cad .= "<li> Equipo local ". $fila['equipoLocal'] . '. Resultado: ' . $fila['resultado'] . ', fecha: '. $fila['fecha'] ."</li>";
                }
            }
            $cad .= "</ul>";


            $cad .= "<h4>Plantilla del equipo</h4>";
            $cad .= "<ul>";
            $query = "SELECT jugador.nombre, jugador.apellidos, jugador.anotaciones 
                    from jugador, equipo 
                    where jugador.nombreEquipo = equipo.nombreEquipo AND equipo.nombreEquipo = ?;";
            $prepare = $this->db->prepare($query);
            $prepare->bind_param('s', $club);
            $prepare->execute();       
            $result = $prepare->get_result();


            if($result->fetch_assoc() != NULL){
                $result->data_seek(0);
                while($fila = $result->fetch_assoc()){
                    $cad .= "<li> Jugador: ". $fila['nombre'] . ' ' . $fila['apellidos'] . ', Anotaciones: '. $fila['anotaciones'] ."</li>";
                }
            }
            $cad .= "</ul>";

            $prepare->close();
            return $cad;
        }

        public function maximoAnotador(){

            $this->conexion();
            $this->db->select_db('ejercicio-7');

            $query = "SELECT jugador.nombre, jugador.apellidos, jugador.anotaciones 
            from jugador, equipo 
            WHERE jugador.nombreEquipo = equipo.nombreEquipo and equipo.nombreTorneo = ? 
            GROUP by jugador.nombre, jugador.apellidos, jugador.anotaciones 
            ORDER by jugador.anotaciones DESC LIMIT 1;";

            $prepare = $this->db->prepare($query);
            $prepare->bind_param('s', $this->torneo);
            $prepare->execute();       
            $result = $prepare->get_result();
            $cad = "";

            if($result->fetch_assoc() != NULL){
                $result->data_seek(0);
                while($fila = $result->fetch_assoc()){
                    $cad .= "<p>El presente maximo anotador es: ". $fila['nombre'] . ' ' . $fila['apellidos'] . ', Anotaciones: '. $fila['anotaciones'] . "</p>";
                }
            }

            $prepare->close();
            return $cad;
        }

    }

    
    if (isset($_SESSION['bases'])) {
    } else {
        $_SESSION['bases'] = new Ejercicio7("Champions League");
    }

    $torneos =  $_SESSION['bases']->getTorneos();
    $clasificacion = "";
    $infoClub = "";
    $anotador = "";
    if (count($_POST) > 0) {
        if (isset($_POST['cambio'])){
            $torneo = $_REQUEST['select'];
            $_SESSION['bases'] = new Ejercicio7($torneo);
            $clasificacion = $_SESSION['bases']->getClasificacion();
        } 

        if (isset($_POST['obtencion'])){
            if($_SESSION['bases']->buscarClub($_POST['datos'])){
                $infoClub = $_SESSION['bases']->sacarInfoClub($_POST['datos']);
            } else {
                $infoClub = "<p>No existe ese club</p>";
            }
        } 

        if (isset($_POST['anotador'])){
            $clasificacion =  $_SESSION['bases']->getClasificacion();
            $anotador = $_SESSION['bases']->maximoAnotador();
        } 

    } else {
        $torneos =  $_SESSION['bases']->getTorneos();
        $clasificacion =  $_SESSION['bases']->getClasificacion();
    }
    

    ?>

    <h1>TORNEOS</h1>
    <main>
        <section>
            <h2>Seleccione un torneo para poder visualizar la classificacion</h2>
            <form method="POST">
                <?php echo "$torneos"; ?>
                <input type="submit" name= "cambio" value="Cambiar Torneo" />
            </form>
        </section>
        <section>
            <h2>Clasificacion del torneo seleccinado</h2>
            <?php echo "$clasificacion"; ?>
            <h3>Máximo anotador del presente torneo</h3>
            <form method="POST">
                <input type="submit" name= "anotador" value="Obtener" />
            </form>
            <?php echo "$anotador"; ?>
        </section>
        <section>
            <h2>Buscar informacion de un club en especifico</h2>
            <form method="POST">
                <label for="club">Introzca el nombre de un CLUB</label>
                <input type="text" name="datos" id="club"/>
                <input type="submit" name= "obtencion" value="Aceptar" />
            </form>
            <?php echo "$infoClub"; ?>
        </section>
    </main>
</body>
</html>