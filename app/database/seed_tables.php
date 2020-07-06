<?php

// Popunjavamo tablice u bazi "probnim" podacima.
require_once __DIR__ . '/db.class.php';
//require_once __DIR__ . '/create_tables.php';


seed_table_users();
seed_table_musicSongs();

exit( 0 );

// ------------------------------------------

function seed_table_users()
{
	$db = DB::getConnection();

	// Ubaci neke korisnike unutra
	try
	{
		$st = $db->prepare( 'INSERT INTO musicUsers(username, email, country, password_hash, songs, points, registration_sequence, has_registered) VALUES (:username, :email, :country, :password_hash, :songs, :points, :registration_sequence, :has_registered)' );

		$st->execute( array( 'username' => 'mirko', 'email' => 'a@b.com', 'country' => 'Švedska', 'password_hash' => password_hash( 'mirkovasifra', PASSWORD_DEFAULT ), 'songs' => '1 7 9', 'points' => 0, 'registration_sequence' => 'qwertz12345', 'has_registered' => 1 ) );
		$st->execute( array( 'username' => 'slavko', 'email' => 'a@b.com', 'country' => 'Italija', 'password_hash' => password_hash( 'slavkovasifra', PASSWORD_DEFAULT ), 'songs' => '2 35', 'points' => 0, 'registration_sequence' => 'qwertz12345', 'has_registered' => 1 ) );
		$st->execute( array( 'username' => 'ana', 'email' => 'a@b.com', 'country' => 'Francuska', 'password_hash' => password_hash( 'aninasifra', PASSWORD_DEFAULT ), 'songs' => '35 81 42 9', 'points' => 0, 'registration_sequence' => 'qwertz12345', 'has_registered' => 1 ) );
		$st->execute( array( 'username' => 'maja', 'email' => 'a@b.com', 'country' => 'Moldavija', 'password_hash' => password_hash( 'majinasifra', PASSWORD_DEFAULT ), 'songs' => '6', 'points' => 0, 'registration_sequence' => 'qwertz12345', 'has_registered' => 1 ) );
		$st->execute( array( 'username' => 'pero', 'email' => 'a@b.com', 'country' => 'Latvija', 'password_hash' => password_hash( 'perinasifra', PASSWORD_DEFAULT ), 'songs' => '56 58 62 73 21 37', 'points' => 0, 'registration_sequence' => 'qwertz12345', 'has_registered' => 1 ) );
	}
	catch( PDOException $e ) { exit( "PDO error [insert musicUsers]: " . $e->getMessage() ); }

	echo "Ubacio u tablicu musicUsers.<br />";
}


// ------------------------------------------
function seed_table_musicSongs()
{
	$db = DB::getConnection();

	try
	{

		if ($fh = fopen('songs.txt', 'r')) {

			while (!feof($fh)) {

				$line = fgets($fh);
				$st = $db->prepare( 'INSERT INTO musicSongs VALUES ('.$line.')' );

				$st->execute();
			
			}
			fclose($fh);

		}
		
	}
	catch( PDOException $e ) { exit( "PDO error [musicSongs]: " . $e->getMessage() ); }

	echo "Ubacio u tablicu musicSongs.<br />";
}

?> 
 
 