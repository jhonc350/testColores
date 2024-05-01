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

    function hexToLab( $hex ) {
        list( $r, $g, $b ) = hexToRgb( $hex );
        // Convertir RGB a XYZ
        $r = $r / 255.0;
        $g = $g / 255.0;
        $b = $b / 255.0;
        $r = ( $r > 0.04045 ) ? pow( ( $r + 0.055 ) / 1.055, 2.4 ) : $r / 12.92;
        $g = ( $g > 0.04045 ) ? pow( ( $g + 0.055 ) / 1.055, 2.4 ) : $g / 12.92;
        $b = ( $b > 0.04045 ) ? pow( ( $b + 0.055 ) / 1.055, 2.4 ) : $b / 12.92;
        $r = $r * 100;
        $g = $g * 100;
        $b = $b * 100;
        $x = $r * 0.4124564 + $g * 0.3575761 + $b * 0.1804375;
        $y = $r * 0.2126729 + $g * 0.7151522 + $b * 0.0721750;
        $z = $r * 0.0193339 + $g * 0.1191920 + $b * 0.9503041;
        // Convertir XYZ a LAB
        $x = $x / 95.047;
        $y = $y / 100.000;
        $z = $z / 108.883;
        $x = ( $x > 0.008856 ) ? pow( $x, 1 / 3 ) : ( 7.787 * $x ) + ( 16 / 116 );
        $y = ( $y > 0.008856 ) ? pow( $y, 1 / 3 ) : ( 7.787 * $y ) + ( 16 / 116 );
        $z = ( $z > 0.008856 ) ? pow( $z, 1 / 3 ) : ( 7.787 * $z ) + ( 16 / 116 );
        $l = ( 116 * $y ) - 16;
        $a = 500 * ( $x - $y );
        $b = 200 * ( $y - $z );
        return [ $l, $a, $b ];
    }

    function colorDistanceCIELAB( $color1, $color2 ) {
        list( $l1, $a1, $b1 ) = hexToLab( $color1 );
        list( $l2, $a2, $b2 ) = hexToLab( $color2 );
        // Calcular la distancia CIELAB
        $dl = $l2 - $l1;
        $da = $a2 - $a1;
        $db = $b2 - $b1;
        $distance = sqrt( $dl * $dl + $da * $da + $db * $db );
        return $distance;
    }

    function colorsCombinationCIELAB( $color1, $color2 ) {
        $distance = colorDistanceCIELAB( $color1, $color2 );
        // Convertir la distancia a un valor entre 0 y 1
        $quality = 1 - ( $distance / 100 ); // Dividido por 100 para ajustar el rango de distancia
        $resultado[ 'mensaje' ] = "La calidad de su combinación es: " . round( $quality, 2 );
        $resultado[ 'resultado' ] = 1;
        echo json_encode( $resultado );
    }

    colorsCombinationCIELAB( $color1, $color2 );


} else {
    header( "refresh:1; url=../page_404.html" );
    die();
}
?>