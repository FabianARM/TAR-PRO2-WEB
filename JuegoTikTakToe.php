<?php 

require("BaseDatos.php");

class JuegoTikTakToe{
  
  public $puntosParaGanar = 3;
  public $tablero = array(); 
  public $tamanoTablero = 3; 
  public $tiempoActualSegundos = 20;  // Se tiene que llevar un conteo, de momento, quemado para pruebas
  
  function __construct()
  {
    $this->db = new BaseDatos();
    //Inicializamos el tablero, que es de tamaño 9*9 
    for($indice = 0; $indice < $this->tamanoTablero * $this->tamanoTablero; $indice++){
      $this->tablero[$indice] = "";
    }
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
  
  function revisarDiagonales()
  {  
    $coordenadaX = 0; 
    $coordenadaY = 0;
    $contador = 1;
    for($indice = 0; $indice < 2; $indice++){
      while($coordenadaX < 2){
        if($indice == 0){
          if($this->obtenerValorDePosicion($coordenadaX,$coordenadaY) != "" && $this->obtenerValorDePosicion($coordenadaX,$coordenadaY) == $this->obtenerValorDePosicion($coordenadaX + 1,$coordenadaY + 1)) {
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
  
  function turno($coordenadaX, $coordenadaY, $caracter)
  {
    if($caracter == "X")
    {
      $this->marcarEnTablero("X", $coordenadaX, $coordenadaY);
    }
    else
    {
      $this->marcarEnTablero("O", $coordenadaX, $coordenadaY);
    }
    
    if($this->revisarGanador())
    {
      // Ganador, verificar si hay que guardarlo en los puntajes mas altos
      $this->verificarRecord();
    }
    
    
    return $this->revisarGanador(); 
     
  }
  
  function verificarRecord()
  {
    $listaRecords = $this->db->leerRecords();
    
    
    
    // Iterar sobre la lista de los tiempos
    for($posicion = 0; $posicion < sizeof($listaRecords); $posicion++)
    {
      $record = $listaRecords[$posicion];
        // Si mi tiempo es menor a alguno
      if($record->tiempo > $this->tiempoActualSegundos)
      {
        // Hacer append en el index actual
        array_splice( $listaRecords, $posicion, 0, array(new RecordModelo("MiIdentificador", $this->tiempoActualSegundos)) );
        
        // Si el tamanno de la lista es 10, eliminar el elemento onceavo
        if(sizeof($listaRecords) > 10)
        {
          unset($listaRecords[sizeof($listaRecords) - 1]);
        }
        
        break;
      }
    }
    
    for($posicion = 0; $posicion < sizeof($listaRecords); $posicion++)
    {
      $record = $listaRecords[$posicion];
      print($record->nombre);
    }
    
    // Limpio el archivo y guardo la lista
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

$juego = new JuegoTikTakToe(); 

/*print($juego->turno(0,0,"X"));
print($juego->turno(1,1,"X"));
print($juego->turno(2,2,"X"));
*/
  
if($juego->turno(0,0,"O") || $juego->turno(1,0,"O") || $juego->turno(2,0,"O"))
{
 // print("Gano\n");
}
else{
 // print("No gano\n");
}
  
//$juego->immprimirTablero();


?> 