<?php

/**
 * Modelo Direccion.
 *
 */
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
    
    print("JAJAJAJAJA");
    
    return $listaTiempos;
	}
}