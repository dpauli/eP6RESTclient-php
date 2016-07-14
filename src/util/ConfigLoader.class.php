<?php
/**
 * This file represents the class to load configuration files.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.2.0
 */
namespace ep6;

/**
 * This is the Configuration Loader class. Use it in static way.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @package ep6
 * @since 0.2.0
 * @subpackage Util
 */
class ConfigLoader {

	/**
	 * Loads the configuration file.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @param String The file name where configuration values are defined.
	 * @since 0.2.0
	 */
    public static function autoload($filename) {
        
        if (!InputValidator::isExistingFile($filename)) {
            return;
        }

        $handle = fopen($filename, "r");
        
        if (!$handle) {
			Logger::warning("ep6\ConfigLoader\nConfiguration file can't be opened.");
            return;
        }
        if (filesize($filename) == 0) {
			Logger::warning("ep6\ConfigLoader\nConfiguration file is empty.");
            return;
        }
        
        $configuration = fread($handle, filesize($filename));
        
        if (!$configuration) {
			Logger::warning("ep6\ConfigLoader\nConfiguration file can't be read.");
            return;
        }
        
        fclose($handle);
        
        $configArray = JSONHandler::parseJSON($configuration);
        
        if (!InputValidator::isEmptyArrayKey($configArray, "logging")) {
            
            if (!InputValidator::isEmptyArrayKey($configArray["logging"], "level")) {
                Logger::setLogLevel($configArray["logging"]["level"]);
            }
            
            if (!InputValidator::isEmptyArrayKey($configArray["logging"], "output")) {
                Logger::setOutput($configArray["logging"]["output"]);
            }
            
            if (!InputValidator::isEmptyArrayKey($configArray["logging"], "outputfile")) {
                Logger::setOutputFile($configArray["logging"]["outputfile"]);
            }
        }
    }
}
?>