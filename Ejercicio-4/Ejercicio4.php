<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Precio Gas Natural</title>
    <meta name="author" content="Ana Fernandez Ostio, UO275780" />
    <meta name="description" content="Consumo de servicios web sobre el gas natural" />
    <meta name="keywords" content="gas natural,api gas natural, ng, EIA, precio año mes gas natural">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Ejercicio4.css" />
</head>

<body>
    <h1>Precio de Gas Natural</h1>
    <?php
        class GasNatural
        {
            protected $data;
            protected $meses;
            protected $json;

            public function __construct()
            {
                
                $url = "http://api.eia.gov/series/?api_key=yUn1nEGsnmt13rLSK53wtlbMwwaglJ1dq9cBSwbn&series_id=NG.N3010US3.M";
                $datos = file_get_contents($url);
                $this->json = json_decode($datos);
                $this->data = $this->json->series[0]->data;
            }

            public function getPrecio($fechaConsulta)
            {
                $fechaFormateada = explode("-", $fechaConsulta);
                $fechaFormateada = $fechaFormateada[0] . $fechaFormateada[1];
                $precio = 0.0;
                for ($i = 0; $i < sizeof($this->data); $i++) {
                    for ($j = 0; $j < sizeof($this->data[0]); $j++) {
                        if ($this->data[$i][$j] == $fechaFormateada) {
                            $precio = $this->data[$i][1];
                            break;
                        }
                    }
                }
                return $precio;
            }
        }
        $gas = new GasNatural();
        
        $fechaConsulta = "aaaa-MM";
        $precioMes = 0.00;
        if (count($_POST) > 0) {
            $precioMes = $gas->getPrecio($_POST["fecha"]);
        }
        echo " 
            <main>
                <section>
                    <h3>Datos sobre el precio del Gas Natural</h3>
                    <p>Para consultar el precio del gas natural en un mes en concreto: </p>
                    <p>El formato concreto para que se realice de forma efizar la consulta, debe ser: aaaa-MM, siendo aaaa, el año correspondiente y MM el mes</p>
                    <p>Del mes actual y de mes anterior al actual no exisen datos disponibles</p>
                        <form action='#' method='post' name='calculadora'>
                            <label for='cantidad'>Inserte aquí la fecha:</label> 
                            <input  id='cantidad'  name='fecha' value = $fechaConsulta />
                            <input type='submit' name = 'botonConsultar' value='Consultar'>
                            <p>El precio de ese mes fue de $precioMes $ </p>
                        </form>
                </section>
                <footer>API EIA</footer>
            </main>
        ";
    ?>

</body>

</html>