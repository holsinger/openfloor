<?php

/**
 * tpl plugin
 * @package tpl
 * @subpackage plugins
 */

/**
 * tpl {include_clipcache} function plugin
 *
 * Includes a template using private caching parameters. Must be registered as non-caching.
 *
 * @file        function.include_clipcache.php
 * @version     0.1.7 2006-May-11
 * @since       2005-APR-08
 *
 * @author      boots {jayboots ~ yahoo com}
 * @copyright   brainpower, boots, 2004-2006
 * @license     LGPL 2.1
 * @link        http://www.phpinsider.com/tpl-forum/viewtopic.php?p=19733#19733
 *
 * @param array $params
 * @param tpl $tpl
 *
 * This function observes the following tag attributes (in $params):
 *
 * #param file required template file
 * #param cache_id required specify cache build group
 * #param cache_lifetime required time to live for template part/group
 * #param ldelim optional specify the left delimiter to use for included content
 * #param rdelim optional specify the right delimiter to use for included content
 */
function tpl_function_include_clipcache($params, &$tpl)
{
    // validation
    foreach ( array( 'cache_id', 'file', 'cache_lifetime' ) as $required ) {

        if ( !array_key_exists( $required, $params ) ) {
            $tpl->trigger_error( "include_clipcache: '$required' param missing. Aborted.", E_USER_WARNING );

            return;
        }
    }

    // handle optional delimiters
    foreach ( array( 'rdelim'=>$tpl->right_delimiter, 'ldelim'=>$tpl->left_delimiter) as $optional=>$default ) {
        ${"_{$optional}"} = $default;
        $$optional = ( array_key_exists( $optional, $params ) )
            ? $params[$optional]
            : $default;
    }

		$tpl->compile_check=false;
    // save tpl environment as proposed by calling template
    $_caching = $tpl->cache;
    if(caching == 1){
    	$tpl->cache = 2;
    }

    $_cache_lifetime = $tpl->cache_lifetime;
    $tpl->cache_lifetime = $params['cache_lifetime'];

    $tpl->left_delimiter = $ldelim;
    $tpl->right_delimiter = $rdelim;

    // run the requested clipcache template
    $content = $tpl->fetch( $params['file'], $params['cache_id'] );

    // restore tpl environment as proposed by calling template
    $tpl->cache = $_caching;
    $tpl->cache_lifetime = $_cache_lifetime;
    $tpl->left_delimiter = $_ldelim;
    $tpl->right_delimiter = $_rdelim;

    return $content;
}
?>