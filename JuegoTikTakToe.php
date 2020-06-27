<?php 

require("BaseDatos.php");

class JuegoTikTakToe{
  
  public $puntosParaGanar = 3;
  public $tablero = array(); 
  public $tamanoTablero = 3; 
  
  function __construct()
  {
    $this->db = new BaseDatos();
    //Inicializamos el tablero, que es de tamaño 9*9 

  }
  
  function getTablero(){
    return $this->tablero;
  }
  
  function marcarEnTablero($caracter, $coordenadaX, $coordenadaY){
    //print("Hola estoy marcando en :".$coordenadaX.$coordenadaY.$caracter);
    $this->tablero[$coordenadaX * $this->tamanoTablero + $coordenadaY] = $caracter;
  }
  
  function obtenerValorDePosicion($coordenadaX, $coordenadaY){
    //print("||||".$coordenadaX.$coordenadaY);
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
              return $this->obtenerValorDePosicion($coordenadaX,$coordenadaY);
            }
          }
          $coordenadaY++;
        }
        else
        {
          if($this->obtenerValorDePosicion($coordenadaX,$coordenadaY) != "" && $this->obtenerValorDePosicion($coordenadaX,$coordenadaY) == $this->obtenerValorDePosicion($coordenadaX + 1,$coordenadaY - 1)){
            $contador++; 
            if($contador == $this->puntosParaGanar){
              return $this->obtenerValorDePosicion($coordenadaX,$coordenadaY);
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
    return "";  
  }
  
  function revisarHorizontal(){
    $contador = 1; 
    for($indice = 0; $indice < $this->tamanoTablero - 1; $indice++){
      for($indice2 = 0; $indice2 < $this->tamanoTablero - 1; $indice2++){
         if($this->obtenerValorDePosicion($indice ,$indice2) != "" && $this->obtenerValorDePosicion($indice,$indice2) == $this->obtenerValorDePosicion($indice,$indice2 + 1)){
             $contador++;
             if($contador ==  $this->puntosParaGanar){
               return $this->obtenerValorDePosicion($indice,$indice2);
             }
         }
      }
      $contador = 1; 
    }
    return "";
  }
  
  function revisarVertical(){
    $contador = 1; 
    for($indice = 0; $indice < $this->tamanoTablero - 1; $indice++){
      for($indice2 = 0; $indice2 < $this->tamanoTablero - 1; $indice2++){
         if($this->obtenerValorDePosicion($indice2, $indice) != "" && $this->obtenerValorDePosicion($indice2,$indice) == $this->obtenerValorDePosicion($indice2 + 1,$indice)){
             $contador++;
             if($contador ==  $this->puntosParaGanar){
               return $this->obtenerValorDePosicion($indice2,$indice);
             }
         }
      }
      $contador = 1; 
    }
    return ""; 
  }
  
  function movimientoValido(){
    
  }
  
<<<<<<< HEAD
  function revisarGanador($tablero){
    $this->tablero = $this->recuperarTablero($tablero);
=======
  function revisarGanador()
  {
>>>>>>> 03feffb4bb29edf487dfbca6b6b70bbf4843ddf5
    $diagonales = $this->revisarDiagonales(); 
    $vertical =  $this->revisarVertical();
    $horizontal = $this->revisarHorizontal(); 
    if($diagonales != "")
    {
      return $diagonales; 
    }
    else
    {
      if($vertical != "")
      {
        return $vertical; 
      }
      else
      {
        if($horizontal != "")
        {
          return $horizontal;
        }
      }
    }
      
    return "";
     
  }
  
  function marcarXEnTablero($coordenadaX, $coordenadaY){
    $this->marcarEnTablero("X", $coordenadaX, $coordenadaY); 
  }
  
  function marcarOEnElTablero($coordenadaX, $coordenadaY){
    $this->marcarEnTablero("O", $coordenadaX, $coordenadaY);
  }
  
  function turno($coordenadaX, $coordenadaY, $tablero)
  {
 
    $this->tablero = $this->recuperarTablero($caracter); 
    $this->marcarEnTablero("X", $coordenadaX, $coordenadaY);// Jugada del jugador 
<<<<<<< HEAD
    $this->jugadaMaquina(); // Jugada de la mquina.
    if($this->revisarGanador())
    {
      // Ganador, verificar si hay que guardarlo en los puntajes mas altos.
			// OJO: Se tiene que llamar cuando el jugador gane, no el caso de la maquina
      $this->verificarRecord();
    }
=======
    $this->jugadaMaquina(); // Jugada de la mquina. 
    
>>>>>>> 03feffb4bb29edf487dfbca6b6b70bbf4843ddf5
    return $this->tableroToString();
  }

  function verificarRecord($idUsuario, $tiempoActualSegundos)
  {
    $listaRecords = $this->db->leerRecords();
		$insertado = false;

		// Iterar sobre la lista de los tiempos
		for($posicion = 0; $posicion < sizeof($listaRecords); $posicion++)
		{
			$record = $listaRecords[$posicion];

				// Si mi tiempo es menor a alguno
			if($record->tiempo > $tiempoActualSegundos)
			{
				// Hacer append en el index actual
				array_splice( $listaRecords, $posicion, 0, array(new RecordModelo($idUsuario, $tiempoActualSegundos)) );

				// Si el tamanno de la lista es 10, eliminar el elemento onceavo
				if(sizeof($listaRecords) > 10)
				{
					unset($listaRecords[sizeof($listaRecords) - 1]);
				}
				
				$insertado = true;
				break;
			}	
		}
		
		// Si hay menos de 10 elementos y no se inserto nada. Caso en que tiempoActual sea mayor que los de la lista.
		// Si hay mas de 10 elementos, ni siquiera entro al record.
		if(sizeof($listaRecords) < 10 && $insertado == false)
		{
			array_push($listaRecords, new RecordModelo($idUsuario, $tiempoActualSegundos));
		}
    
    // Limpio el archivo y guardo la lista
		$this->db->guardarRecords($listaRecords);
  }
  
  
  function obtenerRecords()
  {
    $listaRecords = $this->db->leerRecords();
    $resultado = "";
    
    for($posicion = 0; $posicion < sizeof($listaRecords); $posicion++)
    {
      $record = $listaRecords[$posicion];
      
      $resultado = $resultado.$record->nombre.",".$record->tiempo.";";
    }  
    return $resultado;
  }
    
  function armarMatrizDeDecision($caracter){
    $tamanoMatrixDecision = $this->tamanoTablero + 1;
    //Iniciamos la matrix de decision. 
      
    $matrixDeDecision = array(); 
    for($indice = 0; $indice < ($this->tamanoTablero + 1) * ($this->tamanoTablero + 1); $indice++){
      $matrixDeDecision[$indice] = "";
    }

    //Se rellena la suma de las filas
    for($indice = 0; $indice < $this->tamanoTablero; $indice++){
      $contadorDeCaracteres = 0; 
      for($indice2 = 0; $indice2 < $this->tamanoTablero; $indice2++){
        if($this->obtenerValorDePosicion($indice, $indice2) == $caracter){
           $contadorDeCaracteres++; 
        }
      }
      $matrixDeDecision[$indice * $tamanoMatrixDecision + 3] = $contadorDeCaracteres; 
    }
        
     //Se rellena la suma de las columnas.
    for($indice = 0; $indice < $this->tamanoTablero; $indice++){
      $contadorDeCaracteres = 0; 
      for($indice2 = 0; $indice2 < $this->tamanoTablero; $indice2++){
        if($this->obtenerValorDePosicion($indice2, $indice) == $caracter){
           $contadorDeCaracteres++; 
        }
      }
      $matrixDeDecision[3 * $tamanoMatrixDecision + $indice] = $contadorDeCaracteres; 
    }

    //
    $matrixDeDecision[3 * $tamanoMatrixDecision + 3] = $caracter; // El caracter con el que se hizo el contero.
    return $matrixDeDecision; 
  }
  
  function revisarHeuristicaFilas($coordenadaY, $matrizDeDesicion)
  {
    $tamanoMatrixDecision = $this->tamanoTablero + 1;
    $coordenadaX = 0; 
    if($matrizDeDesicion[3 * $tamanoMatrixDecision + $coordenadaY] == 2)
    {
      while($coordenadaX < 3)
      {
        if($this->obtenerValorDePosicion($coordenadaX, $coordenadaY) == "")
        { 

          $this->marcarOEnElTablero($coordenadaX, $coordenadaY);
          return true;
        }
        $coordenadaX++;
      }

    }
    return false; 
  }

  function revisarHeuristicaColumnas($coordenadaX, $matrizDeDesicion)
  {
    $tamanoMatrixDecision = $this->tamanoTablero + 1;
    $coordenadaY = 0;
    if($matrizDeDesicion[$coordenadaX * $tamanoMatrixDecision + 3] == 2) //Obtenemos la cantidad de caracteres que hay de un tipo en una fila. 
    {
      while($coordenadaY < 3)
      {
          if($this->obtenerValorDePosicion($coordenadaX, $coordenadaY) == "")
          { 

            $this->marcarOEnElTablero($coordenadaX, $coordenadaY);
            return true;
          }
          $coordenadaY++;
      }
    }
    return false; 
  }
  function revisarHeuristicaDiagonales($matrizDeDesicion)
  {
    $tamanoMatrixDecision = $this->tamanoTablero + 1;
    //Si en el centro del tablero hay una X debe examinar las esquinas
    if($this->obtenerValorDePosicion(1,1) == "X")
    {
      if($this->obtenerValorDePosicion(0,0) == "X" && $this->obtenerValorDePosicion(2,2) == "")
      {
        $this->marcarOEnElTablero(2,2);
        return true;
      }
      if($this->obtenerValorDePosicion(2,2) == "X" && $this->obtenerValorDePosicion(0,0) == "")
      {
        $this->marcarOEnElTablero(0,0);
        return true;
      }
      if($this->obtenerValorDePosicion(0,2) == "X" && $this->obtenerValorDePosicion(2,0) == "" )
      {
        $this->marcarOEnElTablero(2,0);
        return true;
      }
      if($this->obtenerValorDePosicion(2,0) == "X" && $this->obtenerValorDePosicion(0,2) == "")
      {
        $this->marcarOEnElTablero(0,2);
        return true;
      }
    }
    return false;
  }
  function revisionHeurisiticas($matrizDeDesicion)
  {
    //Posiciones de interes (3, Y) y (X, 3)
    //$coordenadaX * $this->tamanoTablero + $coordenadaY
    //Heuristica #1  // Si en una fila hay un 2 tiene que marcar porque va a perder o va a ganar. 
    if($this->revisarHeuristicaFilas(0, $matrizDeDesicion) == false)
    {
      if($this->revisarHeuristicaFilas(1, $matrizDeDesicion) == false)
      {
         if($this->revisarHeuristicaFilas(2, $matrizDeDesicion) == true)
         {
           return true; 
         } 
      }
      else
      {
        return true;
      }
    }
    else
    {
      return true; 
    }
    //Fin de heuristica #1
    //Inicio segunda heuristica #2 // Si en una columna hay un dos 
    if($this->revisarHeuristicaColumnas(0, $matrizDeDesicion) == false)
    {
      if($this->revisarHeuristicaColumnas(1, $matrizDeDesicion) == false)
      {
         if($this->revisarHeuristicaColumnas(2, $matrizDeDesicion) == true)
         {
           return true; 
         } 
      }
      else
      {
        return true; 
      }
    }
    else
    {
      return true; 
    }
    //Fin de heuristica #2
    //Inicio de la tercera heuristica #3 
    return $this->revisarHeuristicaDiagonales($matrizDeDesicion);
  }
  
  
  function jugadaMaquina()
  {
    $matrizDeX = $this->armarMatrizDeDecision("X");
     
    $matrizDeO = $this->armarMatrizDeDecision("O");
    //Revisamos heuristica para opcion de ganar.  
    if($this->revisionHeurisiticas($matrizDeO) == false)
    {
      if($this->revisionHeurisiticas($matrizDeX) == false)
      { 
        if($this->obtenerValorDePosicion(1, 1) == "")
        {
          $this->marcarOEnElTablero(1, 1);
          return true;
        }
        else
        {  
          for($indice = 0; $indice < $this->tamanoTablero; $indice++)
          {
            for($indice2 = 0; $indice2 < $this->tamanoTablero; $indice2++)
            {
              if($this->obtenerValorDePosicion($indice, $indice2) == "")
              {
                $this->marcarOEnElTablero($indice, $indice2);
                return true; 
              }
            }
          }
        }   
      }
      else
      {
        return true; 
      }
    }
    else
    {
      return true; 
    }
    return false;
  }

  function limpiarTablero(){
    for($indice = 0; $indice < $this->tamanoTablero * $this->tamanoTablero; $indice++){
      $this->tablero[$indice] = "";
    }
  }
  
  function tableroToString(){
    $tableroToString = "";
    for($indice = 0; $indice < $this->tamanoTablero; $indice++){
      for($indice2 = 0; $indice2 < $this->tamanoTablero; $indice2++){
        if($this->obtenerValorDePosicion($indice, $indice2) == ""){
          $tableroToString = $tableroToString."_";
        }
        else{
          $tableroToString = $tableroToString.$this->obtenerValorDePosicion($indice, $indice2);  
        }
      }
    }
    return $tableroToString; 
  }
  
  function recuperarTablero($entradaTablero){
    $split = str_split($entradaTablero);
    for($indice = 0; $indice < 9; $indice++){
      if($split[$indice] == "_"){//Si lo que hay es un _ eso significa que en el tablero debe haber un espacio en blanco. 
        $split[$indice] = "";
      }
      else{// Si lo que hay es un caracter debe mantenerlo. 
        $split[$indice] = $split[$indice];
      }
    }
    return $split;
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
?>
