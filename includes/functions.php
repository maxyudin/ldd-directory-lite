<?php

/**
 *
 */

function lddlite_icon( $label, $url = '', $title = '' )
{

    $icon = LDDLITE_URL . '/public/icons' . $label . '.png';

    if ( !file_exists( $icon ) )
        return false;

    $output = '<img src="' . $icon . '" />';

    if ( !empty( $url ) )
    {
        $title = ( empty( $title ) ) ? '' : sprintf( ' title="%s" ', htmlspecialchars( $title ) );
        $output = sprintf( '<a href="%1$s" %2$s class="ldd-link ldd-icon">%3$s</a>', esc_url( $url ), $title, $output );
    }

    return $output;

}


/**
 * This function looks for any macros wrapped in a double set of curly braces and defined in
 * an associative array passed to it. All macros are replaced or removed and the template is
 * returned.
 * @since 1.3.13
 *
 * @TODO This could be an object, with a single method, allowing us to build it as we went?
 * @param string $tpl_file Relative file path to the template we're parsing
 * @param array $replace Our find and replace array
 * @return bool|string
 */
function lddlite_parse_template( $tpl_file, $replace )
{

    // Create an absolute path to our template file
    $template = LDDLITE_TEMPLATES . '/' . str_replace( '/', '_', $tpl_file ) . '.' . LDDLITE_TPL_EXT;

    // If the template doesn't exist, return false
    if (!file_exists($template))
        return false;

    // Let's get to work!
    $body = file_get_contents($template);

    if (is_array($replace))
    {
        foreach ($replace as $macro => $value)
        {
            $body = str_replace('{{'.$macro.'}}', $value, $body);
        }
    }

    // Remove all occurrences of macros that have not been replaced
    $body = preg_replace('/\{{2}.*?\}{2}/', "", $body);

    return $body; // Sounds creepy.

}