<?php

// Stvaramo tablice u bazi (ako već ne postoje od ranije).
require_once __DIR__ . '/db.class.php';

// create_table_users();
// create_table_songs();
// create_table_messages();
// create_table_actions();
create_table_points();

exit( 0 );

// --------------------------
function has_table( $tblname )
{
	$db = DB::getConnection();
	
	try
	{
		$st = $db->prepare( 
			'SHOW TABLES LIKE :tblname'
		);

		$st->execute( array( 'tblname' => $tblname ) );
		if( $st->rowCount() > 0 )
			return true;
	}
	catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }

	return false;
}


function create_table_users()
{
	$db = DB::getConnection();

	if( has_table( 'musicUsers' ) )
		exit( 'Tablica musicUsers vec postoji. Obrisite ju pa probajte ponovno.' );


	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS musicUsers (' .
			'username varchar(10) NOT NULL PRIMARY KEY,' .
			'email varchar(50) NOT NULL,' .
			'country varchar(30) NOT NULL,' .
			'password_hash varchar(255) NOT NULL,'.
			'songs varchar(200) NOT NULL,'.
			'points varchar(50) NOT NULL,'.
			'registration_sequence varchar(20) NOT NULL,' .
			'has_registered int)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create musicUsers]: " . $e->getMessage() ); }

	echo "Napravio tablicu musicUsers.<br />";
}


function create_table_songs()
{			'' .
	'' .
	$db = DB::getConnection();

	if( has_table( 'musicSongs' ) )
		exit( 'Tablica musicSongs vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS musicSongs (' .
			'id_song int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'name varchar(50) NOT NULL,' .
			'artist varchar(20) NOT NULL,' .
			'country varchar(30) NOT NULL,' .
			'year datetime NOT NULL,' .
			'genre varchar(20) NOT NULL,' .
			'thumbs_up int NOT NULL,' .
			'link_video varchar(100) NOT NULL,' .
			'link_lyrics varchar(100) NOT NULL,' .
			'link_image varchar(100) NOT NULL,' .
			'semifinal_place int,' .
			'semifinal_points int,' .
			'final_place int,' .
			'final_points int,' .
			'fan_points int not null)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create musicSongs]: " . $e->getMessage() ); }

	echo "Napravio tablicu musicSongs.<br />";
}


function create_table_messages()
{
	$db = DB::getConnection();

	if( has_table( 'musicMessages' ) )
		exit( 'Tablica musicMessages vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS musicMessages (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'username varchar(10) NOT NULL,' .
			'id_song INT NOT NULL,' .
			'content varchar(1000) NOT NULL,' .
			'thumbs_up INT NOT NULL,' .
			'thumbs_down INT NOT NULL,' .
			'date DATETIME NOT NULL)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create musicMessages]: " . $e->getMessage() ); }

	echo "Napravio tablicu musicMessages.<br />";
}


function create_table_actions()
{
	$db = DB::getConnection();

	if( has_table( 'project_actions' ) )
		exit( 'Tablica project_actions vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_actions (' .
			'username varchar(10) PRIMARY KEY NOT NULL,' .
			'id_song INT PRIMARY KEY NOT NULL)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_actions]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_actions.<br />";
}

function create_table_points()
{
	$db = DB::getConnection();

	if( has_table( 'musicPoints' ) )
		exit( 'Tablica musicPoints vec postoji. Obrisite ju pa probajte ponovno.' );


	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS musicPoints (' .
			'username varchar(10) NOT NULL PRIMARY KEY,' .
			'godina2018 varchar(40) NOT NULL,' .
			'godina2019 varchar(40) NOT NULL)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create musicPoints]: " . $e->getMessage() ); }

	echo "Napravio tablicu musicPoints.<br />";
}

?> 
