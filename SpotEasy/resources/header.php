  <div class="inner">
          <a href="home"> <h3 class="masthead-brand">SpotEasy</h3></a>
          <nav class="nav nav-masthead justify-content-center">

			   <?php 
                
			   
			   
              	function setActive($var) {
              	    if (getLanguageSet()==$var) {
              	       return "active";
              	    } else {
              	        return "";
              	    }
              	}
              	
              	function replaceURL($var, $ToReplace) {
              	    $actualURL = $_SERVER['REQUEST_URI'];
              	    $actualURL =  explode('?',$actualURL)[0];
              	    $actualURL =  explode('/',$actualURL);
              	    $actualURL = $actualURL[count($actualURL)-1];
              	    return $actualURL.'?lang='.$var;
              	}
              	
              	$languages = array("ch", "en", "de");
              	foreach ($languages as $key ) {
              	    $url = replaceURL($key, 'lang');
              	    echo '<a class="nav-link '.setActive($key).' languages" href="'.$url.'">'.$key.'</a>';
              	}
              	
        
              	
              	?>
				

              	

            
          </nav>
          
          
        </div>
