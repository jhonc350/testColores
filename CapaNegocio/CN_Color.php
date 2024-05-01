<?php
error_reporting( -1 );
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

    $color1 = $_POST[ "color1" ];
    $color2 = $_POST[ "color2" ];

    function hexToRgb( $hex ) {
        $hex = str_replace( "#", "", $hex );
        if ( strlen( $hex ) == 3 ) {
            $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
            $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
            $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
        } else {
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
        }
        return [ $r, $g, $b ];
    }

    function colorDistance( $color1, $color2 ) {
        list( $r1, $g1, $b1 ) = hexToRgb( $color1 );
        list( $r2, $g2, $b2 ) = hexToRgb( $color2 );
        // Calcular la distancia euclidiana en el espacio RGB
        $dr = $r1 - $r2;
        $dg = $g1 - $g2;
        $db = $b1 - $b2;
        $distance = sqrt( $dr * $dr + $dg * $dg + $db * $db ) / sqrt( 3 * 255 * 255 );
        return $distance;
    }

    function obtenerEmocionColor( $color ) {
        // Define los rangos de colores y las emociones asociadas
        $colorRangos = [
            [ 'start' => '#FF0000', 'end' => '#FF8000', 'emotion' => 'Energía' ], // Rojo - Naranja
            [ 'start' => '#FF8000', 'end' => '#FFFF00', 'emotion' => 'Felicidad' ], // Naranja - Amarillo
            [ 'start' => '#FFFF00', 'end' => '#80FF00', 'emotion' => 'Alegría' ], // Amarillo - Verde Claro
            [ 'start' => '#80FF00', 'end' => '#00FF80', 'emotion' => 'Frescura' ], // Verde Claro - Verde
            [ 'start' => '#00FF80', 'end' => '#00FFFF', 'emotion' => 'Tranquilidad' ], // Verde - Cian
            [ 'start' => '#00FFFF', 'end' => '#0080FF', 'emotion' => 'Paz' ], // Cian - Azul Claro
            [ 'start' => '#0080FF', 'end' => '#0000FF', 'emotion' => 'Calma' ], // Azul Claro - Azul
            [ 'start' => '#0000FF', 'end' => '#8000FF', 'emotion' => 'Seriedad' ], // Azul - Violeta Claro
            [ 'start' => '#8000FF', 'end' => '#FF00FF', 'emotion' => 'Misterio' ], // Violeta Claro - Magenta
            [ 'start' => '#FF00FF', 'end' => '#FF0080', 'emotion' => 'Romanticismo' ], // Magenta - Rosa
            [ 'start' => '#FF0080', 'end' => '#FF0000', 'emotion' => 'Pasión' ], // Rosa - Rojo
            // Agregar más rangos y emociones aquí
            [ 'start' => '#008000', 'end' => '#00FF00', 'emotion' => 'Crecimiento' ], // Verde - Verde Claro
            [ 'start' => '#FFFF80', 'end' => '#FFFF00', 'emotion' => 'Optimismo' ], // Amarillo - Amarillo Claro
            [ 'start' => '#FF8000', 'end' => '#FF4000', 'emotion' => 'Excitación' ], // Naranja - Naranja Oscuro
            [ 'start' => '#FFBF00', 'end' => '#FF8000', 'emotion' => 'Diversión' ], // Amarillo Oscuro - Naranja
            [ 'start' => '#FFA500', 'end' => '#FFBF00', 'emotion' => 'Entusiasmo' ], // Naranja - Amarillo Oscuro
            [ 'start' => '#0000FF', 'end' => '#000080', 'emotion' => 'Profundidad' ], // Azul - Azul Oscuro
        ];

        // Busca el rango de colores al que pertenece el color dado
        foreach ( $colorRangos as $rango ) {
            if ( $color >= $rango[ 'start' ] && $color <= $rango[ 'end' ] ) {
                return $rango[ 'emotion' ];
            }
        }

        // Si el color no está dentro de ningún rango definido, devuelve un valor por defecto o maneja el caso según sea necesario
        return 'Neutro';
    }

    function colorsCombination( $color1, $color2, $emo1, $emo2 ) {
        $distance = colorDistance( $color1, $color2 );
        // Convertir la distancia a un valor entre 0 y 1
        $quality = 1 - $distance;


        $resultado[ 'mensaje' ] = "La calidad de su combinación es: " . round( $quality, 2 ) . "<br>Los colores seleccionados representan las siguientes emociones:<br>Color 1: " . $emo1 . "<br>Color 2: " . $emo2;
        $resultado[ 'resultado' ] = 1;
        echo json_encode( $resultado );
    }

    $emocion1 = obtenerEmocionColor( $color1 );
    $emocion2 = obtenerEmocionColor( $color2 );
    colorsCombination( $color1, $color2, $emocion1, $emocion2 );

} else {
    header( "refresh:1; url=../page_404.html" );
    die();
}
?>