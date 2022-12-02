<?php
// include tmdb api Class
include '../class/tmdb.class.php';

// store variables recieved from ajax
$type = 'movie'; // to do: add other categotries, TV etc.
$method = $_POST['method'];
$input = $_POST['search'];

// send data to API
$tmdbapi = new TMBD();
if ($method == 'details') {
    $results = $tmdbapi->get_details($method, $type, $input); 
} else {
    $results = $tmdbapi->run_search($method, $type, $input);
}

if (!empty($results)) { echo $results; }