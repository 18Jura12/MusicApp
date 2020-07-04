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

        foreach( $pjesme as $pjesma ) {
            $song =  Song::find( 'id_song', $pjesma );
            $songs[] = $song;
        }

        require_once __DIR__ . '/../view/songList.php';
    }
}

?>