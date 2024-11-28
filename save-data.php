
<?php
$body = file_get_contents('php://input');
$request = json_decode($body, true);

try {
    $pdo = new PDO('mysql:host=localhost;dbname=task35', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $query = $pdo->prepare("INSERT INTO students (nik, name) VALUES (:nik, :name)");
    $query->bindValue(':nik', $request['nik'], PDO::PARAM_STR);
    $query->bindValue(':name', $request['name'], PDO::PARAM_STR);
    $query->execute();

    
    $id = $pdo->lastInsertId();
    $query = $pdo->prepare("SELECT * FROM students WHERE id = :id");
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
