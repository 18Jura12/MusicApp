<?php

require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/song.class.php';
require_once __DIR__ . '/../model/playlist.class.php';

class songsController {

    public function playlist() {

        $user = User::find( 'username', $_SESSION['korisnik'] );
        $playlista = Playlist::find( 'username', $user->username );

        $pjesme = explode(" ", $playlista->songs);
        $songs = [];
        $novo = [];

        foreach( $pjesme as $pjesma ) {
            $song =  Song::find( 'id_song', $pjesma );
            if( isset( $_POST['ukloni'] ) && $_POST['ukloni'] === $song->id_song ) {
                continue;
            }
            $songs[] = $song;
            $novo[] = $song->id_song;
        }

        $playlista->songs = implode(" ", $novo );
        //print_r($playlista);

        $playlista->save();        

        require_once __DIR__ . '/../view/songList.php';
    }
}

?>