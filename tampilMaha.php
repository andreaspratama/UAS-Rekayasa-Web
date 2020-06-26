<?php
    function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    $send = curl("http://localhost/json/getMaha.php");

    $data = json_decode($send, true);

    echo "<h1 align=center>UAS Praktikum</h1>";
    echo "<table border=2 width=900 height=200 align=center>";
    echo "<tr align=center>";
    echo "<th>NIM</th>";
    echo "<th>NAMA</th>";
    echo "<th>JURUSAN</th>";
    echo "</tr>";
    foreach($data as $row){
        echo "<tr align=center>
            <td>$row[nim]</td>
            <td>$row[nama]</td>
            <td>$row[jurusan]</td>
            </tr>";
    }
    echo "</table>";
?>    