<?php 
class JuegoTikTakToe{
  
  public $puntosParaGanar = 3;
  public $tablero = array(); 
  public $modoDeJuego; //Un jugador o multijugador
  public $tamanoTablero = 3; 
  
  function __construct($modoDeJuego){
    print("Si estoy ejecutandome ATTE: Constructor\n");
    //Inicializamos el tablero, que es de tamaño 9*9 
    for($indice = 0; $indice < $this->tamanoTablero * $this->tamanoTablero; $indice++){
      $this->tablero[$indice] = "";
    }
    //Y seleccionamos el modo de juego
   $this->$modoDeJuego = $modoDeJuego;  
  }
  
  function getTablero(){
    return $this->tablero;
  }
  
  function marcarEnTablero($caracter, $coordenadaX, $coordenadaY){
    $this->tablero[$coordenadaX * $this->tamanoTablero + $coordenadaY] = $caracter;
  }
  
  function obtenerValorDePosicion($coordenadaX, $coordenadaY){
    return $this->tablero[$coordenadaX * $this->tamanoTablero + $coordenadaY];
  }
  
  function revisarDiagonales(){  
    $coordenadaX = 0; 
    $coordenadaY = 0;
    $contador = 1;
    for($indice = 0; $indice < 2; $indice++){
      while($coordenadaX < 2){
        if($indice == 0){
          if($this->obtenerValorDePosicion($coordenadaX,$coordenadaY) != "" && $this->obtenerValorDePosicion($coordenadaX,$coordenadaY) == $this->obtenerValorDePosicion($coordenadaX + 1,$coordenadaY + 1)) {
            print("\n".$this->obtenerValorDePosicion($coordenadaX,$coordenadaY)." - ".$this->obtenerValorDePosicion($coordenadaX + 1,$coordenadaY + 1)."\n");
            $contador++; 
            if($contador == $this->puntosParaGanar){
              return true; 
            }
          }
          $coordenadaY++;
        }
        else{
          if($this->obtenerValorDePosicion($coordenadaX,$coordenadaY) != "" && $this->obtenerValorDePosicion($coordenadaX,$coordenadaY) == $this->obtenerValorDePosicion($coordenadaX + 1,$coordenadaY - 1)){
            $contador++; 
            if($contador == $this->puntosParaGanar){
              return true; 
            }
          }
          $coordenadaY--; 
        }
        $coordenadaX++; 
      }
      $coordenadaX = 0;
      $coordenadaY = 2; 
      $contador = 0;
    }
    return false; 
  }
  
  function revisarHorizontal(){
    $contador = 1; 
    for($indice = 0; $indice < $this->tamanoTablero - 1; $indice++){
      for($indice2 = 0; $indice2 < $this->tamanoTablero - 1; $indice2++){
         if($this->obtenerValorDePosicion($indice ,$indice2) != "" && $this->obtenerValorDePosicion($indice,$indice2) == $this->obtenerValorDePosicion($indice,$indice2 + 1)){
             $contador++;
             if($contador ==  $this->puntosParaGanar){
               return true;
             }
         }
      }
      $contador = 1; 
    }
  }
  
  function revisarVertical(){
    $contador = 1; 
    for($indice = 0; $indice < $this->tamanoTablero - 1; $indice++){
      for($indice2 = 0; $indice2 < $this->tamanoTablero - 1; $indice2++){
         if($this->obtenerValorDePosicion($indice2, $indice) != "" && $this->obtenerValorDePosicion($indice2,$indice) == $this->obtenerValorDePosicion($indice2 + 1,$indice)){
             $contador++;
             if($contador ==  $this->puntosParaGanar){
               return true;
             }
         }
      }
      $contador = 1; 
    }
  }
  
  function movimientoValido(){
    
  }
  
  function jugadaMaquina(){
    //Tiene que retornar las coordadas donde va jugar
  } 
  
  function revisarGanador(){
    if($this->revisarDiagonales() || $this->revisarVertical() || $this->revisarHorizontal()){
      return true; 
    }
    return false; 
  }
  
  function marcarXEnTablero($coordenadaX, $coordenadaY){
    $this->marcarEnTablero("X", $coordenadaX, $coordenadaY); 
  }
  
  function marcarOEnElTablero($coordenadaX, $coordenadaY){
    $this->marcarEnTablero("O", $coordenadaX, $coordenadaY);
  }
  
  function turno($coordenadaX, $coordenadaY, $caracter){
    if($caracter == "X"){
      $this->marcarXEnTablero($coordenadaX, $coordenadaY); 
    }
    else{
      $this->marcarYEnTablero($coordenadaX, $coordenadaY);
    }
    return $this->revisarGanador(); 
     
  }
  function limpiarTablero(){
    for($indice = 0; $indice < $this->tamanoTablero * $this->tamanoTablero; $indice++){
      $this->tablero[$indice] = "";
    }
  }
  
  function immprimirTablero(){
    for($indice = 0; $indice < $this->tamanoTablero; $indice++){
      for($indice2 = 0; $indice2 < $this->tamanoTablero; $indice2++){
        if($this->obtenerValorDePosicion($indice, $indice2) == ""){
          print("_");
        }
        else{
          print($this->obtenerValorDePosicion($indice, $indice2));  
        }
      }
      print(""."\n");
    }
  }
}

//Prueba 

$juego = new JuegoTikTakToe(1); 

/*print($juego->turno(0,0,"X"));

print($juego->turno(1,1,"X"));

print($juego->turno(2,2,"X"));
*/
  
if($juego->turno(0,0,"X") || $juego->turno(1,1,"X") || $juego->turno(2,1,"X") || $juego->turno(0,1,"X"))
{
  print("Gano\n");
}
else{
  print("No gano\n");
}
  
$juego->immprimirTablero();


?> 