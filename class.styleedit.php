class cssEditor {
	public function editCss($defCss, $custCss, $selectors){

		preg_match_all( '/(?ims)([a-z0-9\s\.\,\:#_\-@]+)\{([^\}]*)\}/', $defCss, $defArray);
		$defStyle = array();
		foreach ($defArray[0] as $i => $x)
		{
			$selector = trim($defArray[1][$i]);
			$rules = explode(';', trim($defArray[2][$i]));
			$defStyle[$selector] = array();
				foreach ($rules as $strRule)
				{
					if (!empty($strRule))
					{
						$rule = explode(":", $strRule, 2);
						$defStyle[$selector][trim($rule[0])][] = trim($rule[1]);
					}
				}
		}
																	
		preg_match_all( '/(?ims)([a-z0-9\s\.\,\:#_\-@]+)\{([^\}]*)\}/', $custCss, $custArray);
		$custStyle = array();
			foreach ($custArray[0] as $i => $x)
			{
				$selector = trim($custArray[1][$i]);
				$rules = explode(';', trim($custArray[2][$i]));
				$custStyle[$selector] = array();
				foreach ($rules as $strRule)
				{
					if (!empty($strRule))
					{
						$rule = explode(":", $strRule, 2);
						$custStyle[$selector][trim($rule[0])][] = trim($rule[1]);
						
							if(array_key_exists('background-image', $custStyle[$selector])) {			
							preg_match_all('/https?:\/\/[^ ]+?(?:\.jpg|\.png|\.jpeg|\.bmp|\.gif)/', $strRule , $matches);
							if(filter_var($matches[0][0], FILTER_VALIDATE_URL) == true){							
								unset($custStyle[$selector]['background-image'][0]);
								$custStyle[$selector]['background-image'][0] = "url('" . $matches[0][0] . "')";
							}
							}
					
					}
				}
			}
									
			// replace any matched default style								
			$newStyle = array();
			foreach($selectors as $selector) {
				if(!empty($custStyle[$selector])) {
					$newStyle[$selector] = array_merge($defStyle[$selector] , $custStyle[$selector]);
				} else {
					$newStyle[$selector] = $defStyle[$selector];
				}
			}
			
			$cssContent = '';
			// rebuild the stylesheet's content									
				foreach($newStyle as $key => $rule) {
				$cssContent .= $key . "{";
				if(is_array($rule)) {
					foreach($rule as $k => $v){
						if(count($v) == 1) {
							$cssContent .= "\n " . $k . ': ' . str_replace(array("\\"), "", $v[0]) . ";";
						} else {
							foreach($v as $e){
								$cssContent .= "\n " . $k . ': ' . str_replace(array("\\"), "", $e) . ";";	
							}
						}
					}
				} else {
					$cssContent .= $rule;
				}
				$cssContent .= "\n}\r\n\r\n";									
			}
			

		return $cssContent;
	}
	
	public function getCssArray($defCss, $custCss, $selectors){
				preg_match_all( '/(?ims)([a-z0-9\s\.\,\:#_\-@]+)\{([^\}]*)\}/', $defCss, $defArray);
		$defStyle = array();
		foreach ($defArray[0] as $i => $x)
		{
			$selector = trim($defArray[1][$i]);
			$rules = explode(';', trim($defArray[2][$i]));
			$defStyle[$selector] = array();
				foreach ($rules as $strRule)
				{
					if (!empty($strRule))
					{
						$rule = explode(":", $strRule, 2);
						$defStyle[$selector][trim($rule[0])][] = trim($rule[1]);
					}
				}
		}
																	
		preg_match_all( '/(?ims)([a-z0-9\s\.\,\:#_\-@]+)\{([^\}]*)\}/', $custCss, $custArray);
		$custStyle = array();
			foreach ($custArray[0] as $i => $x)
			{
				$selector = trim($custArray[1][$i]);
				$rules = explode(';', trim($custArray[2][$i]));
				$custStyle[$selector] = array();
				foreach ($rules as $strRule)
				{
					if (!empty($strRule))
					{
						$rule = explode(":", $strRule, 2);
						$custStyle[$selector][trim($rule[0])][] = trim($rule[1]);
							if(array_key_exists('background-image', $custStyle[$selector])) {
							preg_match_all('/https?:\/\/[^ ]+?(?:\.jpg|\.png|\.jpeg|\.bmp|\.gif)/', $strRule , $matches);
							if(filter_var($matches[0][0], FILTER_VALIDATE_URL) == true){							
								unset($custStyle[$selector]['background-image'][0]);
								$custStyle[$selector]['background-image'][0] = "url('" . $matches[0][0] . "')";
							}
							}
					}
				}
	
			}
			

			$newStyle = array();
			foreach($selectors as $selector) {
				if(!empty($custStyle[$selector])) {
					$newStyle[$selector] = array_merge($defStyle[$selector] , $custStyle[$selector]);
				} else {
					$newStyle[$selector] = $defStyle[$selector];
				}
			}
			
			return $custStyle;
	}
}
