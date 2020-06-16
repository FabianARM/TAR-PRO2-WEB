<?php

/**
 *
 * Copyright (c) 2005-2015, Braulio Jos  Solano Rojas
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 *      Redistributions of source code must retain the above copyright notice, this list of
 *      conditions and the following disclaimer.
 *      Redistributions in binary form must reproduce the above copyright notice, this list of
 *      conditions and the following disclaimer in the documentation and/or other materials
 *      provided with the distribution.
 *      Neither the name of the Solsoft de Costa Rica S.A. nor the names of its contributors may
 *      be used to endorse or promote products derived from this software without specific
 *      prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND
 * CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 * NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 *
 * @version $Id$
 * @copyright 2005-2015
 */


/**
 * HolaMundo Clase que implementa el t pico primer ejemplo de programaci n en todo lenguaje.
 *
 * @package SoapDiscovery
 * @author Braulio Jos  Solano Rojas
 * @copyright Copyright (c) 2005-2015 Braulio Jos  Solano Rojas
 * @version $Id$
 * @access public
 **/
class Ahorcado {
        private $palabraSeleccionada = "";
        private $nombreJugador = "";
        private $palabraOculta = "";
        private $turnosRestantes = 5;
        private $exitos = "";
        private $gano = 0;
        private $arraytiempos = [];
        private $arrayNombreTiempo = [];
        private $palabras = array(
                1 => "perro",
                2 => "gato",
                3 => "elefante",
                4 => "lobo",
                5 => "perico",
                6 => "serpiente",
                7 => "garrapata",
                8 => "oso",
                9 => "tigre",
                10 => "pantera",
                11 => "zorro",
                12 => "vaca",
                13 => "conejo",
                14 => "leon",
                15 => "ornitorrinco",
                16 => "canguro",
                17 => "ñandu"
        );

        /**
         * Ahorcado::__construct() Constructor de la clase Ahorcado.
         *
         * @return string
         **/
        public function __construct() {
                $this->palabraSeleccionada =  $this->palabras[rand(1, 16)];
                $this->palabraOculta = "";
        }

        /**
         * Ahorcado::verificarLetra() verifica si la letra se encuentra en la palabra.
         *
         * @param string $letra
         * @return string
         **/
        public function verificarLetra($letra = ""){

                $arrayPalabra = str_split($this->palabraSeleccionada);
                $aux = FALSE;

                for($i = 0; $i < strlen($this->palabraSeleccionada); $i++)
                {
                        if($arrayPalabra[$i] == $letra){
                                $this->palabraOculta[$i] = $letra;
                                $aux = TRUE;
                        }
                }
                if($aux == FALSE){
                        $this->turnosRestantes -= 1;
                }
                return $this->palabraOculta;
        }


        /**
         * Ahorcado::getIntentosRestantes() Devuelve cantidad de intentos que faltan.
         *
         * @return int
         **/
        public function getIntentosRestantes(){
                return $this->turnosRestantes;
        }


        /**
         * Ahorcado::verificarSiGano() Devuelve 1 si gano, 0 si no.
         *
         * @return int
         **/
        public function verificarSiGano(){
                if($this->palabraOculta === $this->palabraSeleccionada){
                        return 1;
                }else{
                        return 0;
                }
        }

        /**
         * Ahorcado::getPalabraOculta() Devuelve una palabra al azar oculta con _.
         *
         * @return string
         **/
        public function getPalabraOculta(){
                for($i=0; $i < strlen($this->palabraSeleccionada); $i++)
                {
                        $this->palabraOculta .= "*";
                }
                return $this->palabraOculta ;
        }

        /**
         * Ahorcado::getPalabras() Devuelve una palabra al azar.
         *
         * @return string
         **/
        public function getPalabra(){
                return $this->palabraSeleccionada;
        }

        /**
         * Ahorcado::guardarNombre() Guarda el nombre del jugador.
         *
         **/
        public function guardarNombre($nombre = ""){
                $this->nombreJugador = $nombre;
        }

        /**
         * Ahorcado::getNombre() Devuelve el nombre del jugador.
         *
         * @return string
         **/
        public function getNombre(){
                return $this->nombreJugador;
        }

        /**
         * Ahorcado::guardarTiempo() guarda el tiempo del jugador si es de los mejores 10.
         *
         **/
        public function guardarTiempo($nombre = "", $tiempoC = "")
        {
                $tiempo = (int)$tiempoC;
                $nombreTiempo = $nombre.":".(string)$tiempo;
                $ya =FALSE;
                $auxArray = [];
                $contador = 0;

                for($i = 0; $i < count($this->arrayNombreTiempo); $i++){
                        if($ya == FALSE){
                                $aux = explode(":", $this->arrayNombreTiempo[$i]);
                                if((int)$aux[1] <= $tiempo){
                                        array_push($auxArray, $this->arrayNombreTiempo[$i]);
                                        $contador+=1;
                                }else{
                                        array_push($auxArray, $nombreTiempo);
                                        if(count($auxArray)<10){
                                                array_push($auxArray, $this->arrayNombreTiempo[$i]);
                                        }
                                        $ya = TRUE;
                                }
                        }else{
                                array_push($auxArray, $this->arrayNombreTiempo[$i]);
                        }
                }
                if(count($auxArray)>10){
                        for($i = 10; $i < count($auxArray); $i++){
                                unset($auxArray[$i]);
                        }
                }

                $this->arrayNombreTiempo = $auxArray;
                $archivo = fopen("mejoresTiempos.csv", "w+");
                        fwrite($archivo, "");
                        fputcsv($archivo, $this->arrayNombreTiempo, ',');
                fclose($archivo);
        }

        /**
         * Ahorcado::mayorTiempo() Devuelve indice del menor tiempo en el array.
         *
         * @return int
         **/
        public function mayorTiempo(){

                $archivo = fopen("mejoresTiempos.csv", "r");
                $this->arrayNombreTiempo = fgetcsv($archivo);
                for($i = 0; $i < count($this->arrayNombreTiempo); $i++){
                        $aux = explode(":", $this->arrayNombreTiempo[$i]);
                        $this->arraytiempos[$i]= $aux[1];
                }
                fclose($archivo);

                $mayorTiempo = $this->arraytiempos[0];
                for($i = 1; $i < count($this->arraytiempos); $i++){
                        if($mayorTiempo < $this->arraytiempos[$i]){
                                $mayorTiempo = $this->arraytiempos[$i];
                                $index = $i;
                        }
                }
                return (int)$mayorTiempo;
        }

        /**
         * Ahorcado::getNombre() Devuelve el nombre del jugador.
         *
         * @return string
         **/
        public function getTodo(){
                $archivo = fopen("mejoresTiempos.csv", "r");
                $this->arrayNombreTiempo2 = fgetcsv($archivo);
                fclose($archivo);

                for($i = 0; $i < count($this->arrayNombreTiempo2); $i++)
                {
                        $todo .= $this->arrayNombreTiempo2[$i]."\n";
                }
                return $todo;
        }

        /**
         * Ahorcado::getNombre() Devuelve el nombre del jugador.
         *
         **/
        public function reset(){
        $this->palabraSeleccionada =  $this->palabras[rand(1, 12)];
        $this->nombreJugador = "";
        $this->palabraOculta = "";
        $this->turnosRestantes = 5;
        $this->exitos = "";
        $this->gano = 0;
        $this->arraytiempos = [];
        $this->arrayNombreTiempo = [];
        }

}