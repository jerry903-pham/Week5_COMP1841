<?php
include 'includes/DatabaseConnection.php';

try {
    // ----------------------------------------------------
    // 1. HANDLE FORM SUBMISSION (UPDATE JOKE)
    // ----------------------------------------------------
    if (isset($_POST['joketext'])) {
        
        // --- Image Upload Logic ---
        $image_name = $_POST['current_image']; // Start with the existing image name
        
        if ($_FILES['image']['error'] === 0) {
            // A new file was uploaded successfully
            $image_name = $_FILES['image']['name'];
            $target_dir = '../week4/images/'; // Set your target directory
            $target_file = $target_dir . basename($image_name);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        } elseif (isset($_POST['remove_image']) && $_POST['remove_image'] == 'yes') {
            // The user explicitly checked a box to remove the image
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