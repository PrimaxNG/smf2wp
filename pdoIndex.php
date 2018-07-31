<?php
include ("application/control/pdoDB.php");

try {
  //build the query
  $stmt = $conn->query("SELECT * from smf_messages");
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  ## fetch assoc and fetch_obj can be used, below is set to default with above attribute
  while ($row = $stmt->fetch()) {
    echo  $row['title']. "<br />";
  }

  #Prepared statments
  $id=1;
  $sql="SELECT id, title from smf_messages where id=:id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(['id'=>$id]);

  #$title= $stmt->fetchAll(); // many
  $title= $stmt->fetch(); // One
  #var_dump($title);
  foreach ($title as $name) {
    echo $name['title']."<br />";
  }
  echo $title['title'];
  echo "<br />";
  ####
  #Prepared statments
  $sql="SELECT id, title from smf_messages";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  echo $iCount = $stmt->rowCount();

  ##Insert
  if ($iCount<20) {
    $title="TourneyHub";
    $title2="TeeServe Inc";

    $sql = "INSERT INTO smf_messages (title) VALUES (:title)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['title'=>$title]);

    $stmt->bindParam(':title', $title2);
    $stmt->execute();

    echo "Records Added successfully";

    ###Update
    $title="GroupHop";
    $id=$iCount;
    $sql = "UPDATE smf_messages SET title=:title WHERE id=:id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->execute();

    echo "<br />Records Updated successfully";

    ##DELETE
    ###Update
    $id=$iCount;
    $sql = "DELETE FROM smf_messages WHERE id=:id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo "<br />ID: ".$iCount." Record deleted successfully";
  }
  ###Search Data
  $search = "%Tee%";
  $sql="SELECT id, title from smf_messages where title like :search";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':search', $search);
  $stmt->execute();
  $title= $stmt->fetchAll(); // many
  foreach ($title as $name) {
    echo $name['title']."<br />";
  }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
