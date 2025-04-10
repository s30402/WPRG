<?php

function manageDirectory($path, $dirName, $operation = "read") {
    
    if (substr($path, -1) !== "/") {
        $path .= "/";
    }
    
    $fullPath = $path . $dirName;
    $message = "";
    
    if ($operation === "read") {

        if (!is_dir($fullPath)) {
            $message = "Katalog <strong>$fullPath</strong> nie istnieje.";
        } else {
            $elements = scandir($fullPath);

            $elements = array_diff($elements, array('.', '..'));
            if (empty($elements)) {
                $message = "Katalog <strong>$fullPath</strong> jest pusty.";
            } else {
                $message = "Elementy w katalogu <strong>$fullPath</strong>:<br><ul>";
                foreach ($elements as $element) {
                    $message .= "<li>$element</li>";
                }
                $message .= "</ul>";
            }
        }
    } elseif ($operation === "create") {

        if (is_dir($fullPath)) {
            $message = "Katalog <strong>$fullPath</strong> już istnieje.";
        } else {
            if (mkdir($fullPath, 0777, true)) {
                $message = "Katalog <strong>$fullPath</strong> został utworzony pomyślnie.";
            } else {
                $message = "Nie udało się utworzyć katalogu <strong>$fullPath</strong>.";
            }
        }
    } elseif ($operation === "delete") {

        if (!is_dir($fullPath)) {
            $message = "Katalog <strong>$fullPath</strong> nie istnieje.";
        } else {

            $elements = scandir($fullPath);
            $elements = array_diff($elements, array('.', '..'));
            if (!empty($elements)) {
                $message = "Katalog <strong>$fullPath</strong> nie jest pusty, nie można go usunąć.";
            } else {
                if (rmdir($fullPath)) {
                    $message = "Katalog <strong>$fullPath</strong> został usunięty pomyślnie.";
                } else {
                    $message = "Nie udało się usunąć katalogu <strong>$fullPath</strong>.";
                }
            }
        }
    } else {
        $message = "Nieznana operacja: <strong>$operation</strong>.";
    }
    
    return $message;
}


if (isset($_GET['path']) && isset($_GET['dirname'])) {
    $path = $_GET['path'];
    $dirname = $_GET['dirname'];

    $operation = isset($_GET['operation']) ? $_GET['operation'] : "read";
    
    $result = manageDirectory($path, $dirname, $operation);
    echo "<h1>Wynik operacji</h1>";
    echo "<p>$result</p>";
    
} else {
    echo "Nie podano wszystkich wymaganych parametrów.";
}

?>
