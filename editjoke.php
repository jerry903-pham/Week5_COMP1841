<?php
include 'includes/DatabaseConnection.php';

try {

    if (isset($_POST['joketext'])) {
        $image_name = $_POST['current_image'];
        
        if ($_FILES['image']['error'] === 0) {
            $image_name = $_FILES['image']['name'];
            $target_dir = '../week4/images/';
            $target_file = $target_dir . basename($image_name);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        } elseif (isset($_POST['remove_image']) && $_POST['remove_image'] == 'yes') {
            $image_name = NULL;
        }

        // --- SQL UPDATE Query ---
        $sql = 'UPDATE joke 
                SET joketext = :joketext,
                    authorid = :authorid, 
                    image = :image 
                WHERE id = :id';
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':joketext', $_POST['joketext']);
        $stmt->bindValue(':authorid', $_POST['authorid']);
        $stmt->bindValue(':image', $image_name); // <-- ADDED: Bind image name
        $stmt->bindValue(':id', $_POST['jokeid']);
        
        $stmt->execute();
        
        header('location: jokes.php');
        exit(); 
        
    } else {
        // ----------------------------------------------------
        // 2. HANDLE PAGE LOAD (LOAD JOKE FOR EDITING)
        // ----------------------------------------------------
        
        // --- A. Get the joke details (including current authorid and image)
        $sql = 'SELECT * FROM joke WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
        $joke = $stmt->fetch();
        
        // --- B. Get ALL authors to populate the dropdown menu
        $authors = $pdo->query('SELECT id, name FROM author')->fetchAll();
        
        $title = 'Edit joke';

        ob_start();
        include 'templates/editjoke.html.php';
        $output = ob_get_clean();
    }
    
} catch (PDOException $e) {
    $title = 'Error has occurred';
    $output = 'Error editing joke: ' . $e->getMessage();
}

include 'templates/layout.html.php';
