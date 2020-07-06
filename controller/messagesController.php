<?php

require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/message.class.php';
require_once __DIR__ . '/../model/song.class.php';

class messagesController {
    public function obradi() {
        if( isset( $_POST['lajk'] ) ) {
            $id = $_POST['lajk'];
            $action = 'thumbs_down';
        } else if( isset( $_POST['dislajk'] ) ) {
            $id = $_POST['dislajk'];
            $action = 'thumbs_up';
        }

        $komentar = Message::find( 'id', $id );
        $song = Song::find( 'id_song', $komentar->id_song );
        $komentari = Message::where( 'id', $komentar->id_song );

        $vrijednost = $komentar->$action + 1;
        $komentar->$action = $vrijednost;
        $komentar->save();

        $godine = Song::column('year');
        $zemlje = Song::column('country');

        require_once __DIR__ . '/../view/songView.php';
        
    }
}

?>