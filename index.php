<?php
function generarSopaDeLetras($tamaño = 15) {
    $letras = range('A', 'Z');
    $sopa = array_fill(0, $tamaño, array_fill(0, $tamaño, ''));
    $palabras = ['PHP', 'JAVA', 'HTML', 'CSS', 'MYSQL','KAREN','MILENE','GATO','PERRO','CAT'];

    // Insertar palabras en la sopa
    foreach ($palabras as $palabra) {
        $insertado = false;
        while (!$insertado) {
            $direccion = rand(0, 1);
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

    foreach ($sopa as &$fila) {
        foreach ($fila as &$celda) {
            if ($celda == '') {
                $celda = $letras[array_rand($letras)];
            }
        }
    }

    return $sopa;
}

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
            background-image: url('img/fondo.jpg');
            background-size: cover;
            color: white;
        }

        .sopa {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(15, 40px);
            grid-gap: 7px;
            justify-content: center;
        }

        .celda {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ccc;
            cursor: pointer;
            color: #333;
        }

        .celda.seleccionada {
            background-color: rgba(0, 128, 0, 0.7);
            color: white;
        }

        .palabras {
            margin-top: 20px;
        }

        .palabra {
            display: inline-block;
            margin: 10px;
            font-size: 20px;
            font-weight: bold;
            background-color: #98c6b7; /* Fondo claro para las palabras */
            padding: 5px 10px;
            border-radius: 5px;
        }

        #winMessage {
            display: none;
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50; /* Verde brillante para el mensaje de victoria */
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


<div class="palabras">
    <div class="palabra" id="PHP">PHP</div>
    <div class="palabra" id="JAVA">JAVA</div>
    <div class="palabra" id="HTML">HTML</div>
    <div class="palabra" id="CSS">CSS</div>
    <div class="palabra" id="MYSQL">MYSQL</div>
    <div class="palabra" id="KAREN">KAREN</div>
    <div class="palabra" id="MILENE">MILENE</div>
    <div class="palabra" id="GATO">GATO</div>
    <div class="palabra" id="PERRO">PERRO</div>
    <div class="palabra" id="CAT">CAT</div>
</div>


<div id="winMessage">¡Has encontrado todas las palabras!</div>


<script>
    const celdas = document.querySelectorAll('.celda');
    const palabras = ['PHP', 'JAVA', 'HTML', 'CSS', 'MYSQL','KAREN','MILENE','GATO','PERRO','CAT'];
    let letrasSeleccionadas = {};

    palabras.forEach(palabra => {
        letrasSeleccionadas[palabra] = new Set();
    });

    celdas.forEach(celda => {
        celda.addEventListener('click', () => {
            celda.classList.toggle('seleccionada');
            verificarPalabra(celda);
        });
    });

    function verificarPalabra(celda) {
        const letra = celda.innerText;

        // Revisar las palabras
        palabras.forEach(palabra => {
            if (celda.innerText === letra) {
                letrasSeleccionadas[palabra].add(letra);
                if (letrasSeleccionadas[palabra].size === palabra.length) {
                    comprobarVictoria();
                }
            }
        });
    }

    function comprobarVictoria() {

        let palabrasEncontradas = 0;
        palabras.forEach(palabra => {
            if (letrasSeleccionadas[palabra].size === palabra.length) {
                palabrasEncontradas++;
            }
        });

        if (palabrasEncontradas === palabras.length) {
            document.getElementById('winMessage').style.display = 'block';
        }
    }
</script>

</body>
</html>
