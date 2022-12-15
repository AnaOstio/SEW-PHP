<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Calculadora Basica</title>
    <meta name = "author" content="Ana Fernandez Ostio, UO275780" />
    <meta name="description" content="Calculadora básica para SEW-JS" />
    <meta name="keywords" content="calculadora,calculadora basica">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CalculadoraMilan.css" />
</head>

<body>
    <h1>CALCULADORA BÁSICA</h1>


    <?php 
        session_start();
        class Calculadora{
            protected $pantalla;
            protected $op1;
            protected $op2;
            protected $ope;
            protected $mostrar;
            protected $memoria;
            protected $cRaiz;
            protected $contador;
            protected $esMult;
            protected $esDiv;
            protected $contDiv;
            protected $resultado;
            protected $hayResta;
            protected $raiz;
            protected $aux;

            public function __construct(){
                $this->aux = 0;
                $this->pantalla="";
                $this->op1="";
                $this->op2="";
                $this->ope="";
                $this->mostrar=false;
                $this->memoria=0;
                $this->cRaiz="";
                $this->contador=2;
                $this->esMult=false;
                $this->esDiv=false;
                $this->contDiv=-1;
                $this->resultado=false;
                $this->hayResta=false;
                $this->raiz=false;
            }


            public function getPantalla(){
                return $this->pantalla;
            }

            public function botonC()
            {
                $this->aux = 0;
                $this->pantalla=0;
                $this->op1="";
                $this->op2="";
                $this->ope="";
                $this->mostrar=false;
                $this->memoria=0;
                $this->cRaiz="";
                $this->contador=2;
                $this->esMult=false;
                $this->esDiv=false;
                $this->contDiv=-1;
                $this->resultado=false;
                $this->hayResta=false;
                $this->raiz=false;
            }

            public function botonCE(){
                // borra el contenido que hay en la pantalla
                $this->pantalla=0;
            }

            public function mrc(){
                $this->pantalla = $this->memoria . "";
            }

            public function mMas(){
                try{
                    $res = $this->memoria . "+" . $this->pantalla;
                    $this->memoria = eval("return $res ;");
                    $this->pantalla = $this->memoria ;
                } catch (Exception $e) {
                    $this->pantalla = "ERROR";
                    $this->aux = 0;
                    $this->pantalla=0;
                    $this->op1="";
                    $this->op2="";
                    $this->ope="";
                    $this->mostrar=false;
                    $this->memoria=0;
                    $this->cRaiz="";
                    $this->contador=2;
                    $this->esMult=false;
                    $this->esDiv=false;
                    $this->contDiv=-1;
                    $this->resultado=false;
                    $this->hayResta=false;
                    $this->raiz=false;
                }
            }

            public function mMenos(){
                try{
                    $res = $this->memoria . "-" . $this->pantalla;
                    $this->memoria = eval("return $res ;");
                    $this->pantalla = $this->memoria ;
                } catch (Exception $e) {
                    $this->pantalla = "ERROR";
                    $this->aux = 0;
                    $this->pantalla=0;
                    $this->op1="";
                    $this->op2="";
                    $this->ope="";
                    $this->mostrar=false;
                    $this->memoria=0;
                    $this->cRaiz="";
                    $this->contador=2;
                    $this->esMult=false;
                    $this->esDiv=false;
                    $this->contDiv=-1;
                    $this->resultado=false;
                    $this->hayResta=false;
                    $this->raiz=false;
                }
            }

            public function botonMasMenos(){
                $enPantalla =  $this->pantalla;
                try{
                    $cambio = $enPantalla . "*" . "-1";
                    $total = eval("return $cambio; ");
                    $this->pantalla = $total;
                    $this->op1 = $total;
                }catch(Exception $e){
                    $this->pantalla = "ERROR";
                    $this->op1 = "";
                    $this->op2 = "";
                    $this->ope = "";
                    $this->memoria = "";
                    $this->mostrar = false;
                    $this->contador = 2;
                    $this->esMult = false;
                    $this->contDiv = -1;
                    $this->esDiv = false;
                    $this->resultado = false;
                    $this->aux = 0;
                }
            }

            public function punto(){
                $punto = '.';
                $this->pantalla .= $punto;
            }

            public function digitos($number){

                if( $this->pantalla === '-' && $this->ope === "-"){
                    $this->pantalla .= $number;
                } elseif ($this->pantalla == '+'  || $this->pantalla == '*' || $this->pantalla == '/' || $this->pantalla == '%' || $this->pantalla == '-'){
                        $this->pantalla = $number;
                } elseif($this->raiz){
                    $this->op1 = $this->pantalla;
                    $this->ope = "*";
                    $this->pantalla = $number;
                } else {
                    if($this->mostrar) {
                        $this->pantalla = $number;
                        $this->mostrar = false;
                    } else {
                        if($this->pantalla === 0){
                            $this->pantalla = $number;
                        } else {
                            $this->pantalla .= $number ;
                        }
                    }
                }
                
            }

            public function suma(){
                if(strlen($this->op1) == 0){
                    $this->ope = '+';
                    $this->op1 = $this->pantalla;
                    $this->pantalla = '+';
                } else {
                    $this->op2 = $this->pantalla;
                    try {
                        $res = $this->op1 . $this->ope . $this->op2;
                        $total = eval("return $res ;");
                        $this->op1 = $res;
                        $this->ope = "+";
                        $this->mostrar = true;
                        $this->pantalla = $res . $this->ope;
                    } catch (Exception $e) {
                        $this->pantalla = "ERROR";
                        $this->aux = 0;
                        $this->pantalla=0;
                        $this->op1="";
                        $this->op2="";
                        $this->ope="";
                        $this->mostrar=false;
                        $this->memoria=0;
                        $this->cRaiz="";
                        $this->contador=2;
                        $this->esMult=false;
                        $this->esDiv=false;
                        $this->contDiv=-1;
                        $this->resultado=false;
                        $this->hayResta=false;
                        $this->raiz=false;
                    }
                }
            }


            public function division(){
                if(strlen($this->op1) == 0){
                    $this->ope = '/';
                    $this->op1 = $this->pantalla;
                    $this->pantalla = '/';
                } else {
                    $this->op2 = $this->pantalla;
                    try {
                        $res = $this->op1 . $this->ope . $this->op2;
                        $total = eval("return $res ;");
                        $this->op1 = res;
                        $this->ope = "/";
                        $this->mostrar = true;
                        $this->pantalla = res . "/";
                    } catch (Exception $e) {
                        $this->pantalla = "ERROR";
                        $this->op1 = "";
                        $this->op2 = "";
                        $this->ope = "";
                        $this->memoria = "";
                        $this->mostrar = false;
                        $this->contador = 2;
                        $this->esMult = false;
                        $this->contDiv = -1;
                        $this->esDiv = false;
                        $this->resultado = false;
                        $this->aux = 0;
                    }
                }
            }

            public function multiplicacion(){
                if(strlen($this->op1) == 0){
                    $this->ope = '*';
                    $this->op1 = $this->pantalla;
                    $this->pantalla = '*';
                } else {
                    $this->op2 = $this->pantalla;
                    try {
                        $res = $this->op1 . $this->ope . $this->op2;
                        $total = eval("return $res ;");
                        $this->op1 = res;
                        $this->ope = "*";
                        $this->mostrar = true;
                        $this->pantalla = res . "*";
                    } catch (Exception $e) {
                        $this->pantalla = "ERROR";
                        $this->op1 = "";
                        $this->op2 = "";
                        $this->ope = "";
                        $this->memoria = "";
                        $this->mostrar = false;
                        $this->contador = 2;
                        $this->esMult = false;
                        $this->contadorDiv = -1;
                        $this->esDiv = false;
                        $this->resultado = false;
                        $this->aux = 0;
                    }
                }
            }

            public function resta(){
                if(strlen($this->op1) == 0){
                    $this->ope = '-';
                    $this->op1 = $this->pantalla;
                    $this->pantalla = '-';
                    } else {
                    if($this->pantalla === '+' ||  $this->pantalla === '*' 
                        || $this->pantalla === '/' || $this->pantalla === '%' || $this->pantalla == '-'){
                        $this->pantalla =  "-";
                    } else {
                        $this->operando2 = $this->pantalla;
                        try {
                            $res = $this->op1 . $this->ope . $this->op2;
                         $total = eval("return $res ;");
                            $this->op1 = $total;
                            $this->ope = "-";
                            $this->mostrar = true;
                            $this->pantalla = $total; + "-";
                        } catch (Exception $e) {
                            $this->pantalla = "ERROR";
                            $this->op1 = "";
                            $this->op2 = "";
                            $this->ope = "";
                            $this->memoria = "";
                            $this->mostrar = false;
                            $this->contador = 2;
                            $this->esMult = false;
                            $this->contadorDiv = -1;
                            $this->esDiv = false;
                            $this->resultado = false;
                            $this->aux = 0;
                        }
                    }
                }
            }

            public function botonRaizCuadrada(){
                $res = $this->pantalla . '**' . "(1/2)";
                $total = eval("return $res ;");
                $this->pantalla = $total;
                $this->raiz = true;
                $this->ope = "*";
                $this->op1  = res;
            }

            public function botonPorcentaje(){

                if(strlen($this->op1) == 0){
                    $this->ope = '*';
                    $res = $this->pantalla . "/" . 100;
                    $this->op1 = eval("return $res ;");
                    $this->pantalla = '%';
                } else {
                    $this->op2 = $this->pantalla;
        
                    $result = "";
                    switch($this->ope){
                        case '-':
                            $result = $this->op1 + (($this->op1*$this->op2)/100);
                            break;
                        case '*':
                            $result = $this->op1 * $this->op2 /100;
                            break;
                        case '+':
                            $result = $this->op1 +(($this->op1*$this->op2)/100);
                            break;
                        case '/':
                            $result = $this->op1 * 100 / $this->op2;
                            break;
                    }
        
                    try{
                        $res = eval(result);
                        $this->pantalla = $res;
                        $this->op1 = $res;
                        $this->ope = '';
                        $this->op2 = "";
                        $this->mostrar = true;
                    } catch (Exception $e) {
                        $this->pantalla = "ERROR";
                        $this->op1 = "";
                        $this->op2 = "";
                        $this->ope = "";
                        $this->memoria = "";
                        $this->mostrar = false;
                        $this->contador = 2;
                        $this->esMult = false;
                        $this->contadorDiv = -1;
                        $this->esDiv = false;
                        $this->resultado = false;
                        $this->aux = 0;
                    }
                }
            
            }

            public function igual(){
        
                if($this->mostrar){
                    $this->pantalla = substr($this->pantalla, 0, strlen($this->pantalla) - 1);
                    $this->op1="";
                    $this->mostrar=false;
                } else {
                    $this->op2= $this->pantalla;
                    if(($this->op2 == '*')){
                        $this->esMult=true;
                    } else if ($this->contador >= 3){
                        $this->esMult=true;
                    } else if ( $this->op2 == '/') {
                        $this->esDiv=true;
                    } else if ($this->contDiv  <= -2){
                        $this->esDiv=true;
                    } else {
                        $this->esMult=false;
                        $this->esDiv=false;
                    }
                    
                    if($this->esMult){
                        $res = $this->op1 . "**" . $this->contador;
                        $total = eval("return $res ;");
                        $this->pantalla = $total;
                        $this->contador .= $this->contador + 1;
                        $this->op2 = "*";
                    } else if($this->esDiv){
                        $res = $this->op1 . "**" . $this->contadorDiv;
                        $total = eval("return $res ;");
                        $this->pantalla = $total;
                        $this->contadorDiv = this->contadorDiv - 1;
                        $this->op2 = "*";
                    } else if($this->raiz){
                        $this->op2 = this->pantalla;
                        $res = this->op1 . this->ope . this->op2;
                        $total = eval("return $res ;");
                        $this->pantalla = $total;
                        $this->raiz = false;
                    } else{
                        
                        try{
                            if($this->resultado){
                                if($this->op2 != $this->pantalla){
                                    $res = $this->op1 . $this->ope . $this->aux;
                                } else {
                                    $res = $this->op1 . $this->ope . $this->aux;
                                }
                                $total = eval("return $res;");
                                $this->op1 = $total;
                                $this->pantalla = $total;
                            } else {
                                
                                if($this->op1 === ''){
                                    $this->op1 = $this->pantalla;
                                    $res = $this->op1 . "**" . $this->contador;
                                    echo "<script>console.log( 'Debug Objects: " . $res . "' );</script>"; 
                                    echo "<script>console.log( 'Debug Objects: " . $this->op1  . "' );</script>"; 
                                    echo "<script>console.log( 'Debug Objects: " . $this->contador . "' );</script>"; 
                                    $total = eval("return $res ;");
                                    $this->pantalla = $total;
                                    $this->contador = $this->contador + 1;
                                    $this->op2 = "*";
                                    $this->esMult = true;
                                } else {
                                    $this->op2 = $this->pantalla;
                                    if($this->op2 == '-' && $this->ope == '-'){
                                        $res = $this->op1 . $this->op2;
                                    } else {
                                        $res = $this->op1 . $this->ope . $this->op2;
                                    }
                                    try {
                                        $total = eval("return $res;");
                                        $this->pantalla = $total;
                                        $this->op1 =  $total;
                                        $this->aux = $this->op2;
                                        $this->resultado = true;

                                    } catch (Exception $e) {
                                        $this->pantalla = "ERROR";
                                        $this->aux = 0;
                                        $this->pantalla=0;
                                        $this->op1="";
                                        $this->op2="";
                                        $this->ope="";
                                        $this->mostrar=false;
                                        $this->memoria=0;
                                        $this->cRaiz="";
                                        $this->contador=2;
                                        $this->esMult=false;
                                        $this->esDiv=false;
                                        $this->contDiv=-1;
                                        $this->resultado=false;
                                        $this->hayResta=false;
                                        $this->raiz=false;
                                    }

                                    
                                }
                            }
                        } catch (Exception $e) {
                            $this->pantalla = "ERROR";
                            $this->aux = 0;
                            $this->pantalla=0;
                            $this->op1="";
                            $this->op2="";
                            $this->ope="";
                            $this->mostrar=false;
                            $this->memoria=0;
                            $this->cRaiz="";
                            $this->contador=2;
                            $this->esMult=false;
                            $this->esDiv=false;
                            $this->contDiv=-1;
                            $this->resultado=false;
                            $this->hayResta=false;
                            $this->raiz=false;
                        }
                    }
                }
            }

        }

        $pantalla = "0";
        $milan = new Calculadora();

        if(count($_POST) > 0){
            if(isset($_SESSION['milan'])){
            }else {
                $_SESSION['milan'] = new Calculadora();
            }

            if (isset($_POST['punto'])) $_SESSION['milan']->punto();
            if (isset($_POST['mrc'])) $_SESSION['milan']->mrc();
            if (isset($_POST['m+'])) $_SESSION['milan']->mMas();
            if (isset($_POST['m-'])) $_SESSION['milan']->mMenos();
            if (isset($_POST['masMenos'])) $_SESSION['milan']->botonMasMenos();
            if (isset($_POST['botonC'])) $_SESSION['milan']->botonC();
            if (isset($_POST['botonCE'])) $_SESSION['milan']->botonCE();
            if (isset($_POST['nueve'])) $_SESSION['milan']->digitos(9);
            if (isset($_POST['ocho'])) $_SESSION['milan']->digitos(8);
            if (isset($_POST['siete'])) $_SESSION['milan']->digitos(7);
            if (isset($_POST['seis'])) $_SESSION['milan']->digitos(6);
            if (isset($_POST['cinco'])) $_SESSION['milan']->digitos(5);
            if (isset($_POST['cuatro'])) $_SESSION['milan']->digitos(4);
            if (isset($_POST['tres'])) $_SESSION['milan']->digitos(3);
            if (isset($_POST['dos'])) $_SESSION['milan']->digitos(2);
            if (isset($_POST['uno'])) $_SESSION['milan']->digitos(1);
            if (isset($_POST['cero'])) $_SESSION['milan']->digitos(0);
            if (isset($_POST['suma'])) $_SESSION['milan']->suma();
            if (isset($_POST['resta'])) $_SESSION['milan']->resta();
            if (isset($_POST['div'])) $_SESSION['milan']->division();
            if (isset($_POST['mul'])) $_SESSION['milan']->multiplicacion();
            if (isset($_POST['raiz'])) $_SESSION['milan']->botonRaizCuadrada();
            if (isset($_POST['porcentaje'])) $_SESSION['milan']->botonPorcentaje();
            if (isset($_POST['igual'])) $_SESSION['milan']->igual();
            $pantalla = $_SESSION['milan']->getPantalla();
        }


        echo "<script>console.log( 'Debug Objects: " . $pantalla . "' );</script>"; 


        echo "
            <form action = '#' method='post' name='calculadora'>
            <label for = 'pantalla'>Calculadora Milan by Nata</label>
            <input type='text'    name='pantalla' value='$pantalla' id='pantalla' readonly />
            <input type='submit'  value='C'   name='botonC'/>
            <input type='submit'  value='CE'  name='botonCE'/>
            <input type='submit'  value='+/-' name='masMenos'/>
            <input type='submit'  value='√' name='raiz'  />
            <input type='submit'  value='%'  name='porcentaje' />
            <input type='submit'  value='7'  name='siete'/>
            <input type='submit'  value='8'  name='ocho' />
            <input type='submit'  value='9'   name='nueve'/>
            <input type='submit'  value='x'   name='mul'/>
            <input type='submit'  value='/'   name='div'/>
            <input type='submit'  value='4'   name='cuatro'/>
            <input type='submit'  value='5' name='cinco'  />
            <input type='submit'  value='6'  name='seis' />
            <input type='submit'  value='-'  name='resta'/>
            <input type='submit'  value='MRC' name='mrc'/>
            <input type='submit'  value='1'  name='uno'/>
            <input type='submit'  value='2'  name='dos'/>
            <input type='submit'  value='3'  name='tres'/>
            <input type='submit'  value='+'   name='suma' />
            <input type='submit'  value='M-'  name='m-' />
            <input type='submit'  value='0'  name='cero'  />
            <input type='submit'  value='·'   name='punto'/>
            <input type='submit'  value='='  name='igual' />
            <input type='submit'  value='M+'  name='m+'/>
            </form>
        ";
    ?>
</body>
</html>