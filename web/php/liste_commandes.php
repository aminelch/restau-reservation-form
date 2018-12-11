
<!--<legend>Liste des clients </legend>-->
<table class="table table-striped table-danger">
    <thead>
    <tr>
        <th scope="col">Nom et Prénom</th>
        <th scope="col">Télephone</th>
        <th scope="col">Civilité</th>
    </tr>
    </thead>
    <tbody>


<?php
require 'entites/Client.php';
$client = new Client();
$liste_client= $client->liste();

foreach ($liste_client as $c) {
    echo "<tr>";
    echo "<td>" .$c->id . "</td>";
    echo "<td>" .$c->nomprenom. "</td>";
    echo "<td>" .$c->telephone . "</td>";
    echo "<td>" .$c->civilite . "</td>";
    echo "</tr>";

}
?>
        </tbody>
            </table>