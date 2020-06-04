<?php

namespace WPGMZA\TemplatedMarkerDescriptions;

class Marker extends \WPGMZA\ProMarker
{
	public function __construct($id_or_fields=-1, $read_mode=\WPGMZA\Crud::SINGLE_READ, $raw_data=false)
	{
		\WPGMZA\ProMarker::__construct($id_or_fields, $read_mode, $raw_data);
	}
	
	public function jsonSerialize()
	{
		$json = Parent::jsonSerialize();
		
		if(!empty($this->description) && !$this->useRawData)
		{
			// Do shortcodes
			$raw	= do_shortcode($this->description);
			
			// Parse HTML
			$doc	= new \WPGMZA\DOMDocument();
			
			// Populate elements
			$doc->loadHTML($raw);
			$doc->populate($this);
			
			// Populate attributes
			$xpath	= new \DOMXPath($doc);
			$atts	= $xpath->query("//@*");
			
			foreach($atts as $node)
			{
				$node->value = preg_replace_callback('/{([a-z_][a-z0-9_]*)}/', function($m) {
					
					$name = $m[1];
					
					if(!empty($this->{$name}))
						return $this->{$name};
					
					return $m[0];
					
				}, $node->value);
			}
			
			// Save
			$html	= $doc->saveInnerBody();
			
			$json['description'] = $html;
		}
		
		return $json;
	}
}

remove_all_actions('wpgmza_create_WPGMZA\\Marker');

add_action('wpgmza_create_WPGMZA\\Marker', function($id_or_fields=-1, $read_mode=\WPGMZA\Crud::SINGLE_READ, $raw_data=false) {
	
	return new Marker($id_or_fields, $read_mode, $raw_data);
	
}, 10, 3);
