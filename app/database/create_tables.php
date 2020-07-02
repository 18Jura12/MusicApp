<?php

// Stvaramo tablice u bazi (ako već ne postoje od ranije).
require_once __DIR__ . '/db.class.php';

create_table_users();
create_table_channels();
create_table_messages();

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

	if( has_table( 'project_users' ) )
		exit( 'Tablica project_users vec postoji. Obrisite ju pa probajte ponovno.' );


	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_users (' .
			'username varchar(10) NOT NULL PRIMARY KEY,' .
			'email varchar(50) NOT NULL,' .
			'country varchar(30) NOT NULL,' .
			'password_hash varchar(255) NOT NULL,'.
			'registration_sequence varchar(20) NOT NULL,' .
			'has_registered int)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_users]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_users.<br />";
}


function create_table_songs()
{			'' .
	'' .
	$db = DB::getConnection();

	if( has_table( 'project_songs' ) )
		exit( 'Tablica project_songs vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_songs (' .
			'id_song int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'name varchar(50) NOT NULL)' .
			'artist varchar(20) NOT NULL)' .
			'country varchar(30) NOT NULL)' .
			'year datetime NOT NULL)' .
			'genre varchar(20) NOT NULL)' .
			'thumbs_up int NOT NULL)' .
			'link_video varchar(100) NOT NULL)' .
			'link_lyrics varchar(100) NOT NULL)' .
			'link_image varchar(100) NOT NULL)' .
			'semifinal_place int' .
			'semifinal_points int' .
			'final_place int' .
			'final_points int' .
			'fan_points int not null'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_songs]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_songs.<br />";
}


function create_table_messages()
{
	$db = DB::getConnection();

	if( has_table( 'project_messages' ) )
		exit( 'Tablica project_messages vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_messages (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'username varchar(10) NOT NULL' .
			'id_song INT NOT NULL,' .
			'content varchar(1000) NOT NULL,' .
			'thumbs_up INT NOT NULL,' .
			'thumbs_down INT NOT NULL,' .
			'date DATETIME NOT NULL)'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_messages]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_messages.<br />";
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
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'username varchar(10) NOT NULL' .
			'id_song INT NOT NULL,'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_actions]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_actions.<br />";
}


function create_table_playlists()
{
	$db = DB::getConnection();

	if( has_table( 'project_playlists' ) )
		exit( 'Tablica project_playlists vec postoji. Obrisite ju pa probajte ponovno.' );

	try
	{
		$st = $db->prepare( 
			'CREATE TABLE IF NOT EXISTS project_playlists (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'username varchar(10) NOT NULL' .
			'songs_counter int' .
			'songs varchar(3000) NOT NULL,'
		);

		$st->execute();
	}
	catch( PDOException $e ) { exit( "PDO error [create project_playlists]: " . $e->getMessage() ); }

	echo "Napravio tablicu project_playlists.<br />";
}


?> 
