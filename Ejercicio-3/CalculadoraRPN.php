<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Calculadora RPN</title>
    <meta name = "author" content="Ana Fernandez Ostio, UO275780" />
    <meta name="description" content="Calculadora RPN para SEW-JS" />
    <meta name="keywords" content="calculadora,calculadora RPN, RPN">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CalculadoraRPN.css" />
</head>

<body>
    <h1>CALCULADORA RPN</h1>


    <?php 
        session_start();
        class CalculadoraRPN{

            protected $stack;
            protected $pantalla;
            protected $actual;

            public function __construct(){
                $this->stack = array();
                $this->actual = 0;
                $this->pantalla = "0";
            }

            public function botonC(){
                $this->stack = array();
                $this->actual = 0;
                $this->pantalla = "0";
            }

            public function enter(){
                $num = $this->actual;
                $cad = $num . "";
                if($cad != "NaN"){
                    array_unshift($this->stack, $num);
                    $this->pantalla .= PHP_EOL . "0";
                    $this->actual = 0;
                }
            }
            
            public function digitos($n){
               $last = substr($this->pantalla, -1);
               if($this->pantalla === "0"){
                    $this->pantalla = $n ."";
                    $this->actual = $n;
                } else if($last === "0" && substr(substr($this->pantalla, -2), 0, 1) ==  "\n"){
                    $this->pantalla = substr($this->pantalla, 0, strlen($this->pantalla) - 1) . $n;
                    $this->actual = $n;
                } else {
                    $this->pantalla .= $n;
                    $this->actual .= $n;
                }
            }

            public function punto(){
                if ($this->actual . "" != "NaN") {
                    if ($this->hayPunto() == false) {
                        $this->pantalla .= ".";
                        $this->actual = $this->actual . ".";
                    }
                }
            }

            public function suma(){
                if(count($this->stack) >= 2){
                    $ope1 = array_shift($this->stack);
                    $ope2 = array_shift($this->stack);
                    $total = $ope1 + $ope2;
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function multipliacion(){
                if(count($this->stack) >= 2){
                    $ope1 = array_shift($this->stack);
                    $ope2 = array_shift($this->stack);
                    $total = $ope2 * $ope1;
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function division(){
                if(count($this->stack) >= 2){
                    $ope1 = array_shift($this->stack);
                    $ope2 = array_shift($this->stack);
                    $total = $ope2 / $ope1;
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function resta(){
                if(count($this->stack) >= 2){
                    $ope1 = array_shift($this->stack);
                    $ope2 = array_shift($this->stack);
                    $total = $ope2 - $ope1;
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function actualizar(){
                array_unshift($this->stack, $this->actual);
                $this->pantalla = "";
                foreach ($this->stack as &$valor) {
                    $this->pantalla .= $valor . PHP_EOL;
                };
                $this->pantalla .= "0";
                $this->actual = 0;
            }


            private function hayPunto(){
                if (strpos(strval($this->actual), ".") !== false) {
                    return true;
                } else {
                    return false;
                }
            }

            public function getPantalla() {
                return $this->pantalla;
            }

            public function seno() {
                if (count($this->stack) >= 1) {
                    $num = array_shift($this->stack);
                    $total = sin($num);
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function coseno() {
                if (count($this->stack) >= 1) {
                    $num = array_shift($this->stack);
                    $total = cos($num);
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function tangente() {
                if (count($this->stack) >= 1) {
                    $num = array_shift($this->stack);
                    $total = tan($num);
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function aseno() {
                if (count($this->stack) >= 1) {
                    $num = array_shift($this->stack);
                    $total = asin($num);
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function acos() {
                if (count($this->stack) >= 1) {
                    $num = array_shift($this->stack);
                    $total = acos($num);
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function atan() {
                if (count($this->stack) >= 1) {
                    $num = array_shift($this->stack);
                    $total = atan($num);
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function logaritmo()
            {
                if (count($this->stack) >= 1) {
                    $num = array_shift($this->stack);
                    $total = log10($num);
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function neperiano()
            {
                if (count($this->stack) >= 1) {
                    $num = array_shift($this->stack);
                    $total = log($num);
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function raiz()
            {
                if (count($this->stack) >= 1) {
                    $num = array_shift($this->stack);
                    $total = sqrt($num);
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function xElevadoY(){
                if(count($this->stack) >= 2){
                    $ope1 = array_shift($this->stack);
                    $ope2 = array_shift($this->stack);
                    $total = $ope2 **  $ope1;
                    $this->actual = $total;
                    $this->actualizar();
                }
            }

            public function borrar(){
                if (substr($this->pantalla, -1) === "0" && substr(substr($this->pantalla, -2), 0, 1) === "\n") {
                    $this->pantalla =  $this->pantalla;
                } else if (substr(substr($this->pantalla, -2), 0, 1) === "\n") {
                    $this->pantalla = substr($this->pantalla, 0, strlen($this->pantalla) - 1);
                    $this->pantalla .= "0";
                } else if (substr($this->pantalla, 0, strlen($this->pantalla) - 1) === "") {
                    $this->pantalla = "0";
                } else {
                    $this->pantalla = substr($this->pantalla, 0, strlen($this->pantalla) - 1);
                }
                $this->actual = (int)$this->pantalla;
            }
        }

        $pantalla = "0";
        $milan = new CalculadoraRPN();

        if(count($_POST) > 0){
            if(isset($_SESSION['milan'])){
            }else {
                $_SESSION['milan'] = new CalculadoraRPN();
            }

            if (isset($_POST['punto'])) $_SESSION['milan']->punto();
            if (isset($_POST['arcsin'])) $_SESSION['milan']->aseno();
            if (isset($_POST['arcsos'])) $_SESSION['milan']->acos();
            if (isset($_POST['arctan'])) $_SESSION['milan']->atan();
            if (isset($_POST['seno'])) $_SESSION['milan']->seno();
            if (isset($_POST['cos'])) $_SESSION['milan']->coseno();
            if (isset($_POST['tan'])) $_SESSION['milan']->tangente();
            if (isset($_POST['botonC'])) $_SESSION['milan']->botonC();
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
            if (isset($_POST['mul'])) $_SESSION['milan']->multipliacion();
            if (isset($_POST['raiz'])) $_SESSION['milan']->raiz();
            if (isset($_POST['elevado'])) $_SESSION['milan']->xElevadoY();
            if (isset($_POST['enter'])) $_SESSION['milan']->enter();
            if (isset($_POST['borrar'])) $_SESSION['milan']->borrar();

            $pantalla = $_SESSION['milan']->getPantalla();
        }


        echo "<script>console.log( 'Debug Objects: " . $pantalla . "' );</script>"; 


        echo "
            <form action = '#' method='post' name='calculadora'>
            <label for = 'pantalla'>Calculadora RPN</label>
            <textarea name='pantalla' id='pantalla' rows='10' cols='50' disabled>$pantalla</textarea>
            <input type='submit'  value='ARCSIN'   name='arcsin'/>
            <input type='submit'  value='ARCCOS'  name='arccos'/>
            <input type='submit'  value='ARCTAN-' name='arctan'/>
            <input type='submit'  value='C' name='botonC'  />
            <input type='submit'  value='SIN'  name='seno' />
            <input type='submit'  value='COS'  name='cos'/>
            <input type='submit'  value='TAN'  name='tan' />
            <input type='submit'  value='⌫'   name='borrar'/>
            <input type='submit'  value='RAIZ'   name='raiz'/>
            <input type='submit'  value='X^Y'   name='elevado'/>
            <input type='submit'  value='LN'   name='logn'/>
            <input type='submit'  value='LOG' name='log'  />
            <input type='submit'  value='7'  name='siete' />
            <input type='submit'  value='8'  name='ocho'/>
            <input type='submit'  value='9' name='nueve'/>
            <input type='submit'  value='/'  name='div'/>
            <input type='submit'  value='4'  name='cuatro'/>
            <input type='submit'  value='5'  name='cinco'/>
            <input type='submit'  value='6'   name='seis' />
            <input type='submit'  value='*'  name='mul' />
            <input type='submit'  value='1'  name='uno'  />
            <input type='submit'  value='2'   name='dos'/>
            <input type='submit'  value='3'  name='tres' />
            <input type='submit'  value='-'  name='resta'/>
            <input type='submit'  value='.'  name='punto'/>
            <input type='submit'  value='0'  name='cero'/>
            <input type='submit'  value='ENTER'  name='enter'/>
            <input type='submit'  value='+'  name='suma'/>
            </form>
        ";
    ?>
</body>