<?php
// Función para generar una sopa de letras de tamaño 10x10
function generarSopaDeLetras($tamaño = 10) {
    $letras = range('A', 'Z');
    $sopa = array_fill(0, $tamaño, array_fill(0, $tamaño, ''));

    // Palabras a encontrar
    $palabras = ['PHP', 'JAVA', 'HTML', 'CSS', 'MYSQL'];

    // Insertar palabras en la sopa
    foreach ($palabras as $palabra) {
        $insertado = false;
        while (!$insertado) {
            $direccion = rand(0, 1);  // 0 = Horizontal, 1 = Vertical
            $fila = rand(0, $tamaño - 1);
            $columna = rand(0, $tamaño - 1);
            $longitud = strlen($palabra);

            if ($direccion == 0 && $columna + $longitud <= $tamaño) {
                // Insertar horizontalmente
                $puedeInsertar = true;
                for ($i = 0; $i < $longitud; $i++) {
                    if ($sopa[$fila][$columna + $i] != '') {
                        $puedeInsertar = false;
                        break;
                    }
                }

                if ($puedeInsertar) {
                    for ($i = 0; $i < $longitud; $i++) {
                        $sopa[$fila][$columna + $i] = $palabra[$i];
                    }
                    $insertado = true;
                }
            } elseif ($direccion == 1 && $fila + $longitud <= $tamaño) {
                // Insertar verticalmente
                $puedeInsertar = true;
                for ($i = 0; $i < $longitud; $i++) {
                    if ($sopa[$fila + $i][$columna] != '') {
                        $puedeInsertar = false;
                        break;
                    }
                }

                if ($puedeInsertar) {
                    for ($i = 0; $i < $longitud; $i++) {
                        $sopa[$fila + $i][$columna] = $palabra[$i];
                    }
                    $insertado = true;
                }
            }
        }
    }

    // Rellenar los espacios vacíos con letras aleatorias
    foreach ($sopa as &$fila) {
        foreach ($fila as &$celda) {
            if ($celda == '') {
                $celda = $letras[array_rand($letras)];
            }
        }
    }

    return $sopa;
}

// Llamamos a la función para generar la sopa
$sopa = generarSopaDeLetras();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sopa de Letras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        .sopa {
            display: grid;
            grid-template-columns: repeat(10, 30px);
            grid-gap: 5px;
            justify-content: center;
        }

        .celda {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .celda.seleccionada {
            background-color: #c0f0c0;
        }

        .palabras {
            margin-top: 20px;
        }

        .palabra {
            display: inline-block;
            margin: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Sopa de Letras</h1>
<p>Haz clic en las letras para seleccionarlas.</p>

<!-- Sopa de Letras -->
<div class="sopa">
    <?php
    // Generar y mostrar la sopa de letras
    foreach ($sopa as $fila) {
        foreach ($fila as $letra) {
            echo "<div class='celda'>$letra</div>";
        }
    }
    ?>
</div>

<!-- Palabras a buscar -->
<div class="palabras">
    <div class="palabra">PHP</div>
    <div class="palabra">JAVA</div>
    <div class="palabra">HTML</div>
    <div class="palabra">CSS</div>
    <div class="palabra">MYSQL</div>
</div>

<!-- JavaScript para interactividad -->
<script>
    const celdas = document.querySelectorAll('.celda');
    celdas.forEach(celda => {
        celda.addEventListener('click', () => {
            celda.classList.toggle('seleccionada');
        });
    });
</script>

</body>
</html>
