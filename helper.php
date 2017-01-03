<?php
/**
 * Helper class for Dir Reader! module
 *
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class ModLastArticlesHelper
{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */
    public static function getDirectory($params)
    {

        $data['introduction_text'] = $params->get( 'introduction_text' );
        $limit = $params->get( 'art_limit' );

        $cat_id = $params->get( 'category' );

        $articles = getArticlesByCatId($cat_id, $limit);

        $data['articles'] = $articles;

        return $data;

    }
}

function getArticlesByCatId($cat_id, $limit) {

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, title, introtext, images')
          ->from($db->quoteName('#__content'))
          ->where($db->quoteName('catid') . ' = ' . $cat_id)
          ->where($db->quoteName('state') . ' != ' . ' 0 ');
    $query->setLimit((int)$limit);
    $db->setQuery($query);

    return $db->loadObjectList();

}

function getArticlesByParentCatId($cat_id, $limit) {

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id')
          ->from($db->quoteName('#__categories'))
          ->where($db->quoteName('parent_id') . ' = ' . $cat_id);
    $query->setLimit((int)$limit);
    $db->setQuery($query);

    $results = $db->loadObjectList();

    $lenght = count($results);

    $categories = "(";

    $k = 0;
    foreach ($results as $r) {
      $categories .= $r->id ;
      if($k < $lenght - 1) $categories .= ',';
      $k++;
    }

    $categories .= ")";

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, title, introtext')
          ->from($db->quoteName('#__content'))
          ->where($db->quoteName('catid') . ' IN ' . $categories);
    $query->setLimit((int)$limit);
    $db->setQuery($query);

    // die(var_dump($db->loadObjectList()));

    return $db->loadObjectList();

}
