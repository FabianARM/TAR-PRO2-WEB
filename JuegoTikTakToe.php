<?php 

require("BaseDatos.php");

class JuegoTikTakToe{
  
  public $puntosParaGanar = 3;
  public $tablero = array(); 
  public $tamanoTablero = 3; 
  // ToDo: contar segundos hasta la victoria
  public $tiempoActualSegundos = 10;  // Se tiene que llevar un conteo, de momento, quemado para pruebas
	public $idUsuario = "JUGADOR";
  
  function __construct()
  {
    $this->db = new BaseDatos();
    //Inicializamos el tablero, que es de tamaño 9*9 

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
        else
        {
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
    $this->tablero = $this->recuperarTablero($caracter); 
    $this->marcarEnTablero("X", $coordenadaX, $coordenadaY);// Jugada del jugador 
    $this->jugadaMaquina(); // Jugada de la mquina. 
    if($this->revisarGanador())
    {
      // Ganador, verificar si hay que guardarlo en los puntajes mas altos.
			// OJO: Se tiene que llamar cuando el jugador gane, no el caso de la maquina
      $this->verificarRecord();
    }
    return $this->tableroToString();
  }

  function verificarRecord()
  {
    $listaRecords = $this->db->leerRecords();
		$insertado = false;

		// Iterar sobre la lista de los tiempos
		for($posicion = 0; $posicion < sizeof($listaRecords); $posicion++)
		{
			$record = $listaRecords[$posicion];

				// Si mi tiempo es menor a alguno
			if($record->tiempo > $this->tiempoActualSegundos)
			{
				// Hacer append en el index actual
				array_splice( $listaRecords, $posicion, 0, array(new RecordModelo($this->idUsuario, $this->tiempoActualSegundos)) );

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
			array_push($listaRecords, new RecordModelo($this->idUsuario, $this->tiempoActualSegundos));
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
    //Iniciamos la matrix de decision. 
    $matrixDeDecision = array(); 
    for($indice = 0; $indice < ($this->tamanoTablero + 1) * ($this->tamanoTablero + 1); $indice++){
      $matrixDeDecision[$indice] = "";
    }
    //Se rellena la suma de las columnas
    for($indice = 0; $indice < $this->tamanoTablero; $indice++){
      $contadorDeCaracteres = 0; 
      for($indice2 = 0; $indice2 < $this->tamanoTablero; $indice2++){
        if($this->obtenerValorDePosicion($indice, $indice2) == $caracter){
           $contadorDeCaracteres++; 
        }
        $matrixDeDecision[$indice * $this->tamanoTablero + 3] = $contadorDeCaracteres; 
      }
    }
     //Se rellena la suma de las filas.
    for($indice = 0; $indice < $this->tamanoTablero; $indice++){
      $contadorDeCaracteres = 0; 
      for($indice2 = 0; $indice2 < $this->tamanoTablero; $indice2++){
        if($this->obtenerValorDePosicion($indice2, $indice) == $caracter){
           $contadorDeCaracteres++; 
        }
        $matrixDeDecision[3 * $this->tamanoTablero + $indice] = $contadorDeCaracteres; 
      }
    }
    $matrixDeDecision[3 * $this->tamanoTablero + 3] = $caracter; 
    return $matrixDeDecision; 
  }
  
  function revisarHeuristicaFilas($coordenadaY, $matrizDeDesicion)
  {
    $coordenadaX = 0; 
    while($coordenadaX < 3)
    {
      if($matrizDeDesicion[3 * $this->tamanoTablero + $coordenadaY] == 2)
      {
        if($this->obtenerValorDePosicion($coordenadaX, $coordenadaY) == "")
        { 
          $this->marcarOEnElTablero($coordenadaX, $coordenadaY);
          return true;
        }
      }
      $coordenadaX++;
    }
    return false; 
    
  }

  function revisarHeuristicaColumnas($coordenadaX, $matrizDeDesicion)
  {
    $coordenadaY = 0; 
    while($coordenadaY < 3)
    {
      if($matrizDeDesicion[$coordenadaX * $this->tamanoTablero + 3] == 2)
      {
        if($this->obtenerValorDePosicion($coordenadaX, $coordenadaY) == "")
        { 
          $this->marcarOEnElTablero($coordenadaX, $coordenadaY);
          return true;
        }
      }
      $coordenadaY++;
    }
    return false; 
  }
  function revisarHeuristicaDiagonales($matrizDeDesicion)
  {
    //Si en el centro del tablero hay una X debe examinar las esquinas
    if($this->obtenerValorDePosicion(1,1) == "X")
    {
      if($this->obtenerValorDePosicion(0,0) == "X")
      {
        $this->marcarOEnElTablero(2,2);
        return true;
      }
      if($this->obtenerValorDePosicion(2,2) == "X")
      {
        $this->marcarOEnElTablero(0,0);
        return true;
      }
      if($this->obtenerValorDePosicion(0,2) == "X")
      {
        $this->marcarOEnElTablero(2,0);
        return true;
      }
      if($this->obtenerValorDePosicion(2,0) == "X")
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
        return $this->revisarHeuristicaFilas(2, $matrizDeDesicion); 
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
        return $this->revisarHeuristicaColumnas(2, $matrizDeDesicion); 
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
              if($this->obtenerValorDePosicion($indice, $indice2) == "" && $indice != 1 && $indice2 != 1)
              {
                $this->marcarOEnElTablero($indice, $indice2); 
                return true; 
              }
            }
          }
        }   
      }
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

  function cambiarNombre(String $nombre)
  {
    $this->idUsuario = $nombre;
  }
}
?>