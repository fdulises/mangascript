<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
interface dbConnector{
    public function connect($host, $user, $pass, $dbname);
    //public function disconnect();
    public function getErrorNo();
    public function getError();
    public function query($q);
    public function numRows($result);
    public function fetchArray($result);
    //public function isConnected();
    public function escape($var);
    public function getInsertedID();
    //public function changeDB($database);
    //public function setCharset($charset);
}
