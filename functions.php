<?php


/**
 * Получить массив с путями к файлам с нужным расширением, испольует рекурсию.
 *
 * @param [string] $dir
 * @param [array] $extensions
 * @param [array] $path
 * @return array
 */
function getTiles($dir, $extensions, &$path){
    $scannedDir = glob($dir.'/*');
    $paths = [];
    foreach ($scannedDir as $element):
        if(is_dir($element)):
            $paths[$dir] += getTiles($element, $extensions, $paths);
        elseif(in_array((new SplFileInfo($element))->getExtension(), $extensions)):
            $paths[$dir][] = basename($element);
        endif;
    endforeach;
    return $paths;
}

function recursionRenderTitles($tilesList){
    foreach($tilesList as $dirName => $elements):?>
        <div class="collapse dirname">
            <span><?=$dirName?></span>
            <div class="elements">
                <?php
                foreach($elements as $dName => $el):
                    if(is_array($el)):
                        recursionRenderTitles([$dName => $el]);
                    else:?>
                        <img src="<?=$dirName."/".$el?>" title="<?=$dirName."/".$el?>" width="64" onclick="selectTile(this);" />
                    <?php endif;
                endforeach;?>
            </div>
        </div>
    <?php endforeach;
}