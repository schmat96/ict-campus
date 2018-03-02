  <div class="inner">
          <h3 class="masthead-brand">SpotEasy</h3>
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
              	    $query = $_GET;
              	    $query[$ToReplace] = $var;
              	    $query_result = http_build_query($query);
              	    $actualURL =  explode('?',$actualURL)[0];
              	    return $actualURL.'?'.$query_result;
              	}
              	
              	$languages = array("ch", "en", "de");
              	foreach ($languages as $key ) {
              	    $url = replaceURL($key, 'lang');
              	    echo '<a class="nav-link '.setActive($key).'" href="'.$url.'">'.$key.'</a>';
              	}
              	
        
              	
              	?>
				

              	

            
          </nav>
        </div>