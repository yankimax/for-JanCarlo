<?php
require_once __DIR__ . "/functions.php";
$id = 0;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/style.css" />
    <script src="/js/jquery.js"> </script>
    <title>TileMapCreator</title>
</head>
<body>
    <div class="container">
        <div class="tileset">
            <div class="container">
                <div class="tableSettings">
                    <a id="addTr" onclick="addTr(0)">Добавить строку сверху</a>
                    <a id="addTr" onclick="addTr(1)">Добавить строку снизу</a>
                    <hr />
                    <a id="addTd" onclick="addTd(0)">Добавить столбец слева</a>
                    <a id="addTd" onclick="addTd(1)">Добавить столбец справа</a>
                </div>
                <div class="map">
                    <table border="1" id="tileset">
                        <tbody>
                            <?php for($a=0;$a<3;$a++): ?>
                            <tr>
                                <?php for($b=0;$b<3;$b++): ?>
                                <td id="<?=++$id?>" onclick="selectNode(this);"><img src="tiles/ground/4.png"></td>
                                <?php endfor;?>
                            </tr>
                            <?php endfor;?>
                        </tbody>
                    </table>
                    <input type="hidden" name="lastid" value="<?=$id?>" />
                </div>
                <div class="elementSettings">
                    <a id="unSelect" onclick="unSelect();">Снять выделение</a>
                    <div>
                        <form>
                            <span>Навигация:</span><br />
                            Можно вверх: <input type="radio" name="moving[up]" value="T" checked="checked"> Да <input type="radio" name="moving[up]" value="F" > Нет <br />
                            Можно вниз: <input type="radio" name="moving[down]" value="T" checked="checked"> Да <input type="radio" name="moving[down]" value="F" > Нет <br />
                            Можно влево: <input type="radio" name="moving[left]" value="T" checked="checked"> Да <input type="radio" name="moving[left]" value="F" > Нет <br />
                            Можно вправо: <input type="radio" name="moving[right]" value="T" checked="checked"> Да <input type="radio" name="moving[right]" value="F" > Нет <br />
                            <span>События:</span><br />
                            Тип события: 
                            <select name="event[type]">
                                <option value="">Нет события</option>
                                <option value="location">Смена локации</option>
                                <option value="monster">Встреча с монстром</option>
                                <option value="npc">Встреча с НПС</option>
                            </select><br />
                            Значение: <input type="text" name="event[value]" placeholder="ИД сущности" /><br />
                            Шанс: <input type="number" name="event[chance]" value="100" /><br />
                            <a onclick="saveSettings();">Сохранить</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tileslist">
            <?php
            $paths = [];
            recursionRenderTitles(getTiles("tiles", ["png"], $paths));
            ?>
        </div>
    </div>
    <div class="settings">&nbsp;</div>

    <script src="/js/code.js"></script>
</body>
</html>