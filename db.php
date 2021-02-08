<?php

/**
** Класс конфигурации базы данных
*/
class DB {

	const USER = "";
	const PASS = "";
	const HOST = "localhost";
	const DB   = "";

	public static function connToDB() {

		$user = self::USER;
		$pass = self::PASS;
		$host = self::HOST;
		$db   = self::DB;

		$conn = new PDO("mysql:dbname=$db;host=$host", $user, $pass);
		$conn->query('SET NAMES utf8');
		$conn->query('SET CHARACTER_SET utf8_unicode_ci');

		return $conn;

	}
}