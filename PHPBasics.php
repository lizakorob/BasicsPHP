<?php
$parentDirectory = dirname($_SERVER['PHP_SELF']);
enterIntoDirectory($parentDirectory, 0);

function enterIntoDirectory($enteredDirectory, $level)
{
    foreach (new DirectoryIterator($enteredDirectory) as $fileInfo) {
        if ($fileInfo->isDot()) continue;
        $directoryContent = $fileInfo->getFilename();
        exploreDirectory($enteredDirectory, $directoryContent, $level);
    }
}

function exploreDirectory($enteredDirectory, $directoryContent, $level)
{
    $folderPath = $enteredDirectory.'/'.$directoryContent;
    formatString($directoryContent, $level);
    if (is_dir($folderPath) && !(is_link($folderPath))) {
        enterIntoDirectory($enteredDirectory.'/'.$directoryContent, $level + 1);
    }
}

function formatString($directoryContent, $level)
{
    $tab = '    ';
    $format = '|—%s';
    if (php_sapi_name() == 'cli') {
        echo str_repeat($tab, $level), sprintf($format, $directoryContent.PHP_EOL);
    }
    else
        echo '<span style=margin-left:', (int)$level * 20, 'px;>'.sprintf($format, $directoryContent).'</span><br>';
}
