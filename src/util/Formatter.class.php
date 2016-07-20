<?php
/**
 * This file represents the Formatter class.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.2.0
 */
namespace ep6;
/**
 * This is a formatter class to preformat content.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @package ep6
 * @since 0.2.0
 * @subpackage Util
 */
class Formatter {

    /** @var String[] The attributes and values for the innerst HTML tag. */
    private $attributes = array();

    /** @var String[] The classes of the innerst tag attributes class. */
    private $classes = array();

    /** @var String|null The ID of the innerst tag attribute id. */
    private $ID = null;

    /** @var FormatterType[] Saves the used Formatters in the correct order. */
    private $usedFormatters = array();
    
    /**
     * Activate specific FormatterTypes.
     *
     * @param FormatterType The FormatterType which should be added.
	 * @since 0.2.0
     **/
    public function add($formatterType) {
		
		if (!InputValidator::isFormatterType($formatterType)) {
			return;
		}

        array_push($this->usedFormatters, $formatterType);
    }
	
    
    /**
     * Format a string with added FormatterTypes.
     *
     * @param String The string which should be formatted.
     * @return String The formatted string.
	 * @since 0.2.0
     **/
    public function format($stringToFormat) {
		
		# build additional attributes into the innerst tag
		$additionalAttributes = $this->ID ? ' id="' . $this->ID . '" ' : '';
		$classes = implode(" ", $this->classes);
		$additionalAttributes .= ($classes != "") ? ' class="' . $classes . '" ' : "";
		foreach($this->attributes as $attribute => $value) {
			$additionalAttributes .= ' ' . $attribute . '="' . $value . '" ';
		}
		
		foreach ($this->usedFormatters as $usedFormatter) {
			
			switch($usedFormatter) {
				case FormatterType::IMAGE:
					$stringToFormat = '<img src="' . $stringToFormat . '"' . $additionalAttributes . '/>';
					break;
				case FormatterType::BOLD:
					$stringToFormat = '<strong' . $additionalAttributes . '>' . $stringToFormat . '</strong>';
					break;
				case FormatterType::ITALIC:
					$stringToFormat = '<em' . $additionalAttributes . '>' . $stringToFormat . '</em>';
					break;
				case FormatterType::HYPERLINK:
					$stringToFormat = '<a href="' . $stringToFormat . '"' . $additionalAttributes . '/>';
					break;
				case FormatterType::NEWLINE:
					$stringToFormat = $stringToFormat . '<br' . $additionalAttributes . '/>';
					break;
				default:
					continue;
			}
			
			$additionalAttributes = "";
		}

        return $stringToFormat;
    }
    
    /**
     * Reset all predefined Formatters.
     *
	 * @since 0.2.0
     **/
    public function reset() {
        $this->usedFormatters = array();
		$this->ID = null;
		$this->resetClasses();
		$this->resetAttributes();
    }
    
    /**
     * Reset all setted attributes and values.
     *
	 * @since 0.2.0
     **/
    public function resetAttributes() {
		$this->attributes = array();
    }
    
    /**
     * Reset all setted classes.
     *
	 * @since 0.2.0
     **/
    public function resetClasses() {
		$this->classes = array();
    }
	
    /**
     * Add an HTML tag attribute and value.
     *
     * @param String The attribute to set.
     * @param String The value to set.
	 * @since 0.2.0
     **/
    public function setAttribute($attribute, $value) {

        $this->attributes[$attribute] = $value;
    }
	
    /**
     * Add an ID for this tag.
     *
     * @param String The ID to add to the innerst Formatter.
	 * @since 0.2.0
     **/
    public function setID($newID) {

        $this->ID = $newID;
    }
	
    /**
     * Add classes for this tag.
     *
     * @param String The class to set.
	 * @since 0.2.0
     **/
    public function setClass($newClass) {

        array_push($this->classes, $newClass);
    }
}
?>