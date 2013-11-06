<?php
/*
 * 
 * Delicious Dotclear 2, plugin.  
 *
 * Classe permettant de fournir une série de liens en provenance de Delicious. 
 * Les liens appartiennent à un utilisateur et ont un tag. 
 *
 * @author: Pierre Bettens, Pinkilla 
 * (basé sur le travail de Nicolas Perriault (Gravatar)
 */
class deliciousClass extends dcUrlHandlers {
	const 
		//URL =
		//"http://feeds.delicious.com/html/USER/TAG?count=COUNT&tags=no&rssbutton=no";
    URL = "http://feeds.delicious.com/v2/rss/USER/TAG?plain&count=COUNT";

	/*
	 * Retourne une liste de lien en provenance de Delicious
	 * @param array, Attributs passés; user, tag, count
	 */
	public static function deliciousFct($attr) {

		// Chargement des paramètres
		$settings = self::get_settings(dirname(__FILE__) . '/settings.ini');

		// Paramètre par défaut ou paramètre choisi par l'utilisateur
		$user = array_key_exists('user',$attr) ? 
			$attr['user'] : $settings['delicious_user']; 
		$tag = array_key_exists('tag',$attr) ? 
			$attr['tag'] : $settings['delicious_tag']; 
		$count = array_key_exists('count',$attr) ? 
			$attr['count'] : $settings['delicious_count']; 
		$url = str_replace('USER', htmlentities($user), self::URL);
		$url = str_replace('TAG', htmlentities($tag), $url); 
		$url = str_replace('COUNT', htmlentities($count), $url); 

		return HttpClient::quickGet($url);
    }


  /**
   * Charge les paramètres depuis le fichier de configuration
   * Author Nicolas Perriault
   * @param  string  $config_file  Configuration file path
   * @return array
   */
  public static function get_settings($config_file) {
    return parse_ini_file($config_file);
  }



   /**
   * Ecrit les paramètres dans un fichier de configuration
   * Author Nicolas Perriault, revu par Pinkilla ... en fait non, rien changé
   * @param  string  $path         Chemin du fichier de conf
   * @param  array   $assoc_array  Tableau de données
   * @return boolean
   */
  public static function write_ini_file($path, $assoc_array) {
    $content = '';
    $sections = '';
    foreach ($assoc_array as $key => $item) {
      if (is_array($item)) {
        $sections .= "\n[{$key}]\n";
        foreach ($item as $key2 => $item2)
        {
          if (is_numeric($item2) || is_bool($item2))
            $sections .= "{$key2} = {$item2}\n";
          else
            $sections .= "{$key2} = \"{$item2}\"\n";
        }   
      } else {
        if(is_numeric($item) || is_bool($item))
          $content .= "{$key} = {$item}\n";
        else
          $content .= "{$key} = \"{$item}\"\n";
      }
    }   
    $content .= $sections;
    if (!$handle = fopen($path, 'w'))
    {
      return false;
    }
    if (!fwrite($handle, $content))
    {
      return false;
    }
    fclose($handle);
    return true;
  }


	/*
	 * Vérifie les permissions sur le fichier
	 */
	 public static function check_file_perms($config_file) {
	    $errors = array();
    	if (!file_exists($config_file) || !is_file($config_file)) {
			$errors[] = sprintf(
				__('The configuration file "%s" doesn\'t seem to exist or to be a file'), 
				$config_file);
		}
		if (!is_writable($config_file)) {
			$errors[] = sprintf(
			__('The configuration file "%s" is not writable by the webserver. Please check perms.'), 
			$config_file);
    	}
    	return $errors;
  }



}
?>
