<?php
try{
    include 'includes/DatabaseConnection.php';
    
    $sql = 'SELECT id, joketext, jokedate, image FROM joke';
    $jokes = $pdo->query($sql);
    $title = 'Joke list';

    ob_start();
    include 'templates/jokes.html.php';
    $output = ob_get_clean();

}catch (PDOException $e){
    $title = '\\an error has occured';
    $output='Database error: ' . $e->getMessage();
}
include 'templates/layout.html.php';