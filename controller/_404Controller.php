<?php 

//Klasa za prikaz nepostojeće stranice.
class _404Controller
{
    //Funkcija šalje prikazu nepostojeće stranice naslov.
    public function index()
    {
        $title = 'Pristupili ste nepostojećoj stranici.';

        require_once __DIR__ . '/../view/_404_index.php';
    }
}

?>