<?php

require("RecordModelo.php");

class BaseDatos
{
	function leerRecords()
  {
		// Obtener las posiciones con los tiempos
    $listaTiempos = array();
		$archivo = fopen('records.txt', 'r');
		while($registro = fgets($archivo))
		{
			$modelo = explode(':', $registro);
			$listaTiempos[] = new RecordModelo($modelo[0], $modelo[1]);
		} // while
		fclose($archivo);
    
    return $listaTiempos;
	}
  
  function guardarRecords(array $listaRecords)
  {
    $archivo = fopen('records.txt', 'w');
    foreach($listaRecords as $record)
    {
      $linea = trim(preg_replace('/\s\s+/', '', $record->serialice()));
      
      fwrite($archivo, $linea."\n");
    }
    
    fclose($archivo);
  }
}