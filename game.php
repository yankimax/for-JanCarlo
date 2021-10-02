<?php
session_start();
if(empty($_SESSION["user"])):
    $_SESSION["user"] = [2, 1, 1];
endif;

$user = $_SESSION["user"];
$map = json_decode(file_get_contents(__DIR__ . "/maps/".$user[2].".json"), true);
if(!empty($_GET["pos"])):
    var_dump($_GET["pos"]);
    if($_GET["pos"] == "U" && $map[$user[0]][$user[1]]["moving"]["up"] == "T"):
        $_SESSION["user"] = [--$user[0], $user[1], $user[2]];
    elseif($_GET["pos"] == "D" && $map[$user[0]][$user[1]]["moving"]["down"] == "T"):
        $_SESSION["user"] = [++$user[0], $user[1], $user[2]];
    elseif($_GET["pos"] == "L" && $map[$user[0]][$user[1]]["moving"]["left"] == "T"):
        $_SESSION["user"] = [$user[0], --$user[1], $user[2]];
    elseif($_GET["pos"] == "R" && $map[$user[0]][$user[1]]["moving"]["right"] == "T"):
        $_SESSION["user"] = [$user[0], ++$user[1], $user[2]];
    endif;
endif;

if(!empty($map[$user[0]][$user[1]]["event"]["type"])):
    switch($map[$user[0]][$user[1]]["event"]["type"]){
        case "location":
            $_SESSION["user"] = [0, 0, $map[$user[0]][$user[1]]["event"]["value"]];
            $map = json_decode(file_get_contents(__DIR__ . "/maps/".$user[2].".json"), true);
        break;
        case "monster":
            echo "С шансом " .  $map[$user[0]][$user[1]]["event"]["chance"] . " можно было бы встретить монстра " . $map[$user[0]][$user[1]]["event"]["value"];
        break;
        case "npc":
            echo "С шансом " .  $map[$user[0]][$user[1]]["event"]["chance"] . " можно было бы встретить NPC " . $map[$user[0]][$user[1]]["event"]["value"];
        break;
    }
endif;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" />
    <script src="/js/jquery.js"> </script>
    <title>MapNavigateExample</title>
</head>
<body>
    <?php 
        foreach($map as $trN => $tr):
            foreach($tr as $tdN => $td):
                if($trN == $user[0] && $tdN == $user[1]):
                    echo "<span class='user'>";
                        echo "<img src='{$td['sprite']}' />";
                        echo "<img src='tiles/1.png' />";
                    echo "</span>";
                else:
                    echo "<img src='{$td['sprite']}' />";
                endif;
            endforeach;
            echo "<br />";
        endforeach;
    ?>
    <div class="control">
        <a href="?pos=U">Вверх</a><br />
        <a href="?pos=L">Влево</a>
        <a href="?pos=R">Вправо</a><br />
        <a href="?pos=D">Вниз</a><br /><br />
        <a href="/game.php">Остаться здесь.</a>
    </div>
</body>
</html>