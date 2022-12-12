<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Calculadora Basica</title>
    <meta name = "author" content="Ana Fernandez Ostio, UO275780" />
    <meta name="description" content="Calculadora básica para SEW-JS" />
    <meta name="keywords" content="calculadora,calculadora basica">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CalculadoraCientifica.css" />
</head>

<body>
    <h1>CALCULADORA CIENTIFICA</h1>


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

        class CalculadoraCientifica extends Calculadora {

            //Atributos
            protected $pantalla;

            protected $flecha;

            protected $hyp;

            protected $e;

            protected $notacion;

            protected $memoria;

            // Hay que redefinir para los nombres de seno, cos, y tal
            protected $seno;
            protected $coseno;
            protected $tangente;
            protected $tipoGrado;

            protected $parentesis;

            public function __construct(){
                parent::__construct();
                $this->pantalla = "";
                $this->memoria = "";
                $this->flecha = false;
                $this->hyp = false;
                $this->e = false;
                $this->notacion = false;
                $this->seno = "sin";
                $this->coseno = "cos";
                $this->tangente = "tan";
                $this->tipoGrado = "DEG";
                $this->parentesis = false;
            }

            public function igual(){

            }

            public function punto(){
                $this->pantalla .= ".";
            }

            public function mrc(){
                
            }

            public function mMas(){
                
            }

            public function mMenos(){
                
            }

            public function botonMasMenos(){
                
            }

            public function botonC(){
                $this->pantalla = "0";
                $this->memoria = "";
                $this->flecha = false;
                $this->hyp = false;
                $this->e = false;
                $this->notacion = false;
                $this->seno = "sin";
                $this->coseno = "cos";
                $this->tangente = "tan";
                $this->tipoGrado = "DEG";
            }

            public function botonCE(){
                $this->pantalla = "0";
            }

            public function digitos($n){
                if($this->pantalla === 0 || $this->pantalla === "0"){
                    $this->pantalla = $n;
                } else {
                    $this->pantalla .= $n . "";
                }
            }

            public function suma(){
                $this->pantalla .= "+";
            }

            public function resta(){
                $this->pantalla .= "-";
            }

            public function multiplicacion(){
                $this->pantalla .= "*";
            }

            public function division(){
                $this->pantalla .= "/";
            }

            public function botonRaizCuadrada(){
                try {
                    $expresion = "return " . $this->pantalla . ";";
                    $total = eval($expresion);
                    $res = sqrt($total);
                    if (isset($res)){
                        $this->pantalla= $res;
                    }
                } catch (Exception $th) {
                    $this->pantalla = "ERROR";
                }
            }

            public function botonPorcentaje(){
                // Este se queda en blanco y ya que no hay   
            }

            public function limiparMem(){
                
            }

            public function changeGrados($gradoTipo){
                if($gradoTipo == "DEG"){
                    $this->tipoGrado = "RAD";
                }
            }

            public function chageHyp(){
                
            }

            public function shift(){
                
            }

            public function cambiarTipoPantalla(){
                
            }

            public function seno($numero){
                
            }

            public function coseno($numero){
                
            }

            public function tangente($numero){
                
            }

            public function toRad(){
                
            }

            public function notacionC(){
                
            }

            public function elevadoCuadrado(){
                $this->pantalla .= "**2";
            }

            public function xElevadoY(){
                $this->pantalla .= "**";
            }

            public function abrirParentesis(){
                if ($this->pantalla === 0 || $this->pantalla === "0" || $this->pantalla === "Error" || $this->pantalla === "NaN") {
                    $this->pantalla = "(";
                } else {
                    $this->pantalla .= "(";
                }
                $this->parentesis = true;
            }

            public function cerrarParentesis(){
                if($this->parentesis){
                    $this->pantalla .= ")";
                }
            }
            
            public function factorial(){
                $this->pantalla = $this->factorialRec($this->pantalla);
            }

            private function factorialRec($n){
                if($n==0){
                    return 1;   
                }
                return $n * $this->factorialRec($n-1);
            }

            public function btnPI(){
                if($this->pantalla === 0 || $this->pantalla === "0"){
                    $this->pantalla = pi();
                } else {
                    $this->pantalla .= pi() . "";
                }
            }

            public function mod(){
                $this->pantalla .= "%";
            }

            public function elevadoDiez(){
                $this->pantalla .= "10**";
            }

            public function log(){

                try {
                    $total = eval("return $this->pantalla ; ");
                    $res = log10($total);
                    if (isset($res)){
                        $this->pantalla= $res;
                    }
                } catch (Exception $th) {
                    $this->pantalla = "ERROR";
                }
                
            }

            public function exp(){
                $this->pantalla .= ",e+";
            }

            public function borrar(){
                $this->pantalla .= "";
                if(strlen($this->pantalla) > 0){
                    $this->pantalla = substr($this->pantalla, 0, strlen($this->pantalla) - 1);
                    if (strlen($this->pantalla) == 0) {
                        $this->pantalla = "0";
                    }
                }
            }

            public function getCoseno(){
                return $this->coseno;
            }

            public function getSeno(){
                return $this->seno;
            }

            public function getTan(){
                return $this->tangente;
            }

            public function getTipoGrado(){
                return $this->tipoGrado;
            }

            public function limpiarMemoria(){
                
            }

            public function saveMemoria(){
                
            }
            
        }

        
        $pantalla = "0";
        $milan = new CalculadoraCientifica();

        $cos = $milan->getCoseno();
        $sen = $milan->getSeno();
        $tan = $milan->getTan();
        $tipo = $milan->getTipoGrado();

        if(is_null($tipo)){
            $tipo = "DEG";
        }

        if(count($_POST) > 0){
            if(isset($_SESSION['cien'])){
            }else {
                $_SESSION['cien'] = new CalculadoraCientifica();
            }

            // Memoria
            if (isset($_POST['mrc'])) $_SESSION['cien']->mrc();
            if (isset($_POST['m+'])) $_SESSION['cien']->mMas();
            if (isset($_POST['m-'])) $_SESSION['cien']->mMenos();
            if (isset($_POST['limpiarMem'])) $_SESSION['cien']->limpiarMemoria();
            if (isset($_POST['toMemoria'])) $_SESSION['cien']->saveMemoria();

            // Digitos
            if (isset($_POST['nueve'])) $_SESSION['cien']->digitos(9);
            if (isset($_POST['ocho'])) $_SESSION['cien']->digitos(8);
            if (isset($_POST['siete'])) $_SESSION['cien']->digitos(7);
            if (isset($_POST['seis'])) $_SESSION['cien']->digitos(6);
            if (isset($_POST['cinco'])) $_SESSION['cien']->digitos(5);
            if (isset($_POST['cuatro'])) $_SESSION['cien']->digitos(4);
            if (isset($_POST['tres'])) $_SESSION['cien']->digitos(3);
            if (isset($_POST['dos'])) $_SESSION['cien']->digitos(2);
            if (isset($_POST['uno'])) $_SESSION['cien']->digitos(1);
            if (isset($_POST['cero'])) $_SESSION['cien']->digitos(0);

            if (isset($_POST['pi'])) $_SESSION['cien']->btnPI();


            // Borrar cosas
            if (isset($_POST['botonC'])) $_SESSION['cien']->botonC();
            if (isset($_POST['botonCE'])) $_SESSION['cien']->botonCE();
            if (isset($_POST['borrar'])) $_SESSION['cien']->borrar();

            // OP basicas
            if (isset($_POST['suma'])) $_SESSION['cien']->suma();
            if (isset($_POST['resta'])) $_SESSION['cien']->resta();
            if (isset($_POST['div'])) $_SESSION['cien']->division();
            if (isset($_POST['mul'])) $_SESSION['cien']->multiplicacion();
            
            // Op second
            if (isset($_POST['raiz'])) $_SESSION['cien']->botonRaizCuadrada();
            if (isset($_POST['cuadrado'])) $_SESSION['cien']->elevadoCuadrado();
            if (isset($_POST['xEy'])) $_SESSION['cien']->xElevadoY();
            if (isset($_POST['el10'])) $_SESSION['cien']->elevadoDiez();
            if (isset($_POST['exp'])) $_SESSION['cien']->exp();
            if (isset($_POST['log'])) $_SESSION['cien']->log();
            if (isset($_POST['mod'])) $_SESSION['cien']->mod();
            if (isset($_POST['fact'])) $_SESSION['cien']->factorial();

            // Tema Grados
            if(isset($_POST['sin'])) $_SESSION['cien']->seno(0);  
            if(isset($_POST['cos'])) $_SESSION['cien']->coseno(0);  
            if(isset($_POST['tan'])) $_SESSION['cien']->tangente(0);  

            if(isset($_POST['asin'])) $_SESSION['cien']->seno(1);  
            if(isset($_POST['acos']))$_SESSION['cien']->coseno(1);  
            if(isset($_POST['atan'])) $_SESSION['cien']->tangente(1);  

            if(isset($_POST['sinh']))$_SESSION['cien']->seno(2);  
            if(isset($_POST['cosh']))$_SESSION['cien']->coseno(2);  
            if(isset($_POST['tanh'])) $_SESSION['cien']->tangente(2);  

            if(isset($_POST['asinh'])) $_SESSION['cien']->seno(3);  
            if(isset($_POST['acosh'])) $_SESSION['cien']->coseno(3);  
            if(isset($_POST['atanh'])) $_SESSION['cien']->tangente(3); 

            // Cambio de grados
            if(isset($_POST['RAD'])) $_SESSION['cien']->changeGrados("RAD"); 
            if(isset($_POST['DEG'])) $_SESSION['cien']->changeGrados("DEG"); 
            if(isset($_POST['GRAD'])) $_SESSION['cien']->changeGrados("GRAD"); 

            // Cambio flecha
            if(isset($_POST['flecha'])) $_SESSION['cien']->shift(); 

            // Parentesis
            if(isset($_POST['abrir'])) $_SESSION['cien']->abrirParentesis(); 
            if(isset($_POST['cerrar'])) $_SESSION['cien']->cerrarParentesis(); 

            // Resto
            if (isset($_POST['masMenos'])) $_SESSION['cien']->botonMasMenos();
            if (isset($_POST['punto'])) $_SESSION['cien']->punto();
            if (isset($_POST['igual'])) $_SESSION['cien']->igual();
            $pantalla = $_SESSION['cien']->getPantalla();
        }


        echo "<script>console.log( 'Debug Objects: " . $tipo . "' );</script>"; 


        echo "
            <form action = '#' method='post' name='calculadora'>
            <label for = 'pantalla'>Calculadora Milan by Nata</label>
            <input type='text'    name='pantalla' value='$pantalla' id='pantalla' readonly />
            <input type='submit'  value='$tipo'   name='$tipo'/>
            <input type='submit'  value='HYP' name='hyp'/>
            <input type='submit'  value='F-E' name='notacion'/>
            <input type='submit'  value='MC' name='limpiarMem'/>
            <input type='submit'  value='MR' name='mrc'/>
            <input type='submit'  value='M+'  name='m+'/>
            <input type='submit'  value='M-'  name='m-' />
            <input type='submit'  value='MS' name='toMemoria'/>
            <input type='submit'  value='x^2'   name='cuadrado'/>
            <input type='submit'  value='x^y'   name='xEy'/>
            <input type='submit'  value='$sen'   name='$sen'/>
            <input type='submit'  value='$cos'   name='$cos'/>
            <input type='submit'  value='$tan'   name='$tan'/>
            <input type='submit'  value='√' name='raiz'  />
            <input type='submit'  value='10^x'   name='el10'/>
            <input type='submit'  value='EXP'   name='exp'/>
            <input type='submit'  value='LOG'   name='log'/>
            <input type='submit'  value='MOD'   name='mod'/>
            <input type='submit'  value='↑'   name='flecha'/>
            <input type='submit'  value='C'   name='botonC'/>
            <input type='submit'  value='CE'  name='botonCE'/>
            <input type='submit'  value='⌫'   name='borrar'/>
            <input type='submit'  value='/'   name='div'/>
            <input type='submit'  value='π'  name='pi'/>
            <input type='submit'  value='7'  name='siete'/>
            <input type='submit'  value='8'  name='ocho' />
            <input type='submit'  value='9'   name='nueve'/>
            <input type='submit'  value='x'   name='mul'/>
            <input type='submit'  value='!n'   name='fact'/>
            <input type='submit'  value='4'   name='cuatro'/>
            <input type='submit'  value='5' name='cinco'  />
            <input type='submit'  value='6'  name='seis' />
            <input type='submit'  value='-'  name='resta'/>
            <input type='submit'  value='+/-' name='masMenos'/>
            <input type='submit'  value='1'  name='uno'/>
            <input type='submit'  value='2'  name='dos'/>
            <input type='submit'  value='3'  name='tres'/>
            <input type='submit'  value='+'   name='suma' />
            <input type='submit'  value='('  name='abrir'  />
            <input type='submit'  value=')'  name='cerrar'  />
            <input type='submit'  value='0'  name='cero'  />
            <input type='submit'  value='·'   name='punto'/>
            <input type='submit'  value='='  name='igual' />
            </form>
        ";
    ?>
</body>