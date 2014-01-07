<!doctype html>
<html>
<meta charset="UTF-8">
 <?php
 //  echo $_GET["query"];
 
   if($_GET["query"]=="")
   {
     
   }
   else
   {

    $query=str_replace(' ','+',$_GET["query"]);
    if($_GET["type"]=="artists")
	{
     $url = "http://www.allmusic.com/search/artists";
	 
	 
     $html = file_get_contents("http://www.allmusic.com/search/".$_GET["type"]."/".$query); 
  
     if(preg_match("/<table.*?>.*?<\/[\s]*table>/s", $html, $table_html))
	 {
	         echo "<div align=\"center\"><h1>Search Result</h1>";
	 echo "<b>\"".$_GET["query"]."\" of type \"".$_GET["type"]."\"</b><br><br>";
     preg_match_all("/<tr.*?>(.*?)<\/[\s]*tr>/s", $table_html[0], $matches);

  //print_r($matches);
    $table = array();
    $div_matches=array();
    $img_matches=array();
    $info_matches=array();
    $name_matches=array();
    $link_matches=array();
    $artist_name=array();
    echo "<table border=2 align=\"center\"><tr><th>Image</th><th>Name</th><th>Genre(s)</th><th>Year(s)</th><th>Details</th></tr>";

 //echo count($matches[0]);
    $i=0;
    foreach($matches[1] as $row_html)
    {
 //   preg_match("/<div class=\"image\">(.*?)<\/div>/s", $matches[1][0], $div_matches);
      if(preg_match("/<img src=\"(.*?)\"/", $matches[1][$i], $img_matches))
	  {
	    echo "<tr align=\"center\"><td><img src=\"".$img_matches[1]."\"</td>";
	   }
	  else
	  {
	    echo "<tr align=\"center\"><td>N/A</td>";
	  }
	  if(preg_match("/<div class=\"name\">(.*?)<\/div>/s", $matches[1][$i], $name_matches))
	  {
	    if(preg_match("/}}\">(.*?)<\/a>/", $name_matches[0], $artist_name))
	    {
	      echo "<td>$artist_name[1]</td>";	
	    }
		else
		{
		//  echo"<td>N/A</td>";
		}
   }
	  if(preg_match("/<div class=\"info\">(.*?)<\/div>/s", $matches[1][$i], $info_matches))
	  { 
	    list($genre,$year)=explode("<br/>", $info_matches[1]);
	    $length=strlen($genre);
		
		if($length!=46)
		{
		    echo "<td>$genre</td>";  
		}
		else
		{
		 echo "<td>N/A</td>";
		}
		$length=strlen($year);
		if($length!=47)
		{
		
		  echo "<td>$year</td>";
		  
		 
		}
		else
		{
		   echo "<td>N/A</td>";
		}
        
	  }
	  if(preg_match("/<div class=\"name\">(.*?)<\/div>/s", $matches[1][$i], $name_matches))
	  {
	    if(preg_match("/<a href=\"(.*?)\" data-tooltip/s", $name_matches[0], $link_matches))
	    {
	      echo "<td><a href=\"$link_matches[1]\">Details</a></td></tr>";
	    }
		else
		{
		  echo "<td>N/A</td>";
		}
	}	
	  
    
	$row = array();
	$i++;

   }

   echo "</table>";
   }
    
	 else
	 {
	   echo "<div align=\"center\"><h1>Search Result</h1>";
	   echo "<b>\"".$_GET["query"]."\" of type \"".$_GET["type"]."\"<br>";
	   echo "<h2>No Discography found!</h2></div>";
	 }
	}
	//END FOR ARTISTS
   else if($_GET["type"]=="albums")// FOR ALBUMS!!!!!!!!!!!!!!!	
	{
	
     $url = "http://www.allmusic.com/search/albums";
     $html = file_get_contents("http://www.allmusic.com/search/".$_GET["type"]."/".$query); 
  
   if(preg_match("/<table.*?>.*?<\/[\s]*table>/s", $html, $table_html))
   {
          echo "<div align=\"center\"><h1>Search Result</h1>";
	 echo "<b>\"".$_GET["query"]."\" of type \"".$_GET["type"]."\"</b><br><br>";
     preg_match_all("/<tr.*?>(.*?)<\/[\s]*tr>/s", $table_html[0], $matches);

  //print_r($matches);
    $table = array();
    $div_matches=array();
    $img_matches=array();
    $info_matches=array();
    $name_matches=array();
    $link_matches=array();
    $artist_name=array();
	$title_name=array();
    echo "<table border=2 align=\"center\"><tr><th>Image</th><th>Title</th><th>Artist</th><th>Genre(s)</th><th>Year</th><th>Details</th></tr>";

 //echo count($matches[0]);
    $i=0;
    foreach($matches[1] as $row_html)
    {
 //   preg_match("/<div class=\"image\">(.*?)<\/div>/s", $matches[1][0], $div_matches);
      if(preg_match("/<img src=\"(.*?)\"/", $matches[1][$i], $img_matches))
	  {
	    echo "<tr align=\"center\"><td><img src=\"".$img_matches[1]."\"</td>";
	   }
	  else
	  {
	    echo "<tr align=\"center\"><td>N/A</td>";
	  }
	  if(preg_match("/<div class=\"title\">(.*?)<\/div>/s", $matches[1][$i], $name_matches))
	  {
	    if(preg_match("/}}\">(.*?)<\/a>/", $name_matches[0], $title_name))
	    {
	      echo "<td>$title_name[1]</td>";
	    }
		else
		{
	//	  echo "<td>N/A</td>";
		}
	   }
	   if(preg_match("/<div class=\"artist\">(.*?)<\/div>/s", $matches[1][$i], $name_matches))
	   {
	    if(preg_match("/\">(.*?)<\/a>/", $name_matches[0], $artist_name))
	    {
		//$length=strlen($artist_name[1]);
		  echo "<td>$artist_name[1]";
	      while(preg_match("/\/ <a href(.*?)<\/div>/", $name_matches[0], $temp))
		  {
		    if(preg_match("/\">(.*?)<\/a>/", $temp[0], $artist_name))
		    {
		      preg_match("/\">(.*?)<\/div>/", $temp[0], $name_matches);
		      echo ", $artist_name[1]";
		    }
		  }
		  
		}
		else
		{
		  echo "<td>$name_matches[1]</td>";
		}
		echo "</td>";
	  }
	  if(preg_match("/<div class=\"info\">(.*?)<\/div>/s", $matches[1][$i], $info_matches))
	  {
	    list($year,$genre)=explode("<br/>", $info_matches[1]);
	     $length=strlen($genre);
		
		if($length!=29)
		{
		    echo "<td>$genre</td>";  
		}
		else
		{
		 echo "<td>N/A</td>";
		}
		$length=strlen($year);
		if($length!=33)
		{		
		  echo "<td>$year</td>";		 
		}
		else
		{
		   echo "<td>N/A</td>";
		}
		 
		
	  }
	  if(preg_match("/<div class=\"title\">(.*?)<\/div>/s", $matches[1][$i], $name_matches))
	  {
	    if(preg_match("/<a href=\"(.*?)\" data-tooltip/s", $name_matches[0], $link_matches))
	    {
	      echo "<td><a href=\"$link_matches[1]\">Details</a></td></tr>";
	    }
		
	  }	
	  
    
	$row = array();
	$i++;
	}
  }
	else
	 {
	   echo "<div align=\"center\"><h1>Search Result</h1>";
	   echo "<b>\"".$_GET["query"]."\" of type \"".$_GET["type"]."\"<br>";
	   echo "<h2>No Discography found!</h2></div>";
	 }
   
  }// END OF ALBUMS!!!!
  
  else if($_GET["type"]=="songs")// FOR SONGS 	SONGS	SONGS	SONGS	SONGS	!!!!!!!!!!!!!!!	
	{
	
     $url = "http://www.allmusic.com/search/songs";
     $html = file_get_contents("http://www.allmusic.com/search/".$_GET["type"]."/".$query); 
  
   if(preg_match("/<table.*?>.*?<\/[\s]*table>/s", $html, $table_html))
   {
          echo "<div align=\"center\"><h1>Search Result</h1>";
	 echo "<b>\"".$_GET["query"]."\" of type \"".$_GET["type"]."\"</b><br><br>";
     preg_match_all("/<tr.*?>(.*?)<\/[\s]*tr>/s", $table_html[0], $matches);

  //print_r($matches);
    $table = array();
    $sample_matches=array();
    $img_matches=array();
    $info_matches=array();
    $name_matches=array();
    $link_matches=array();
    $artist_name=array();
	$title_name=array();
	$perf_matches=array();
	$comp_name=array();
	$temp=array();
	
    echo "<table border=2 align=\"center\"><tr><th>Sample</th><th>Title</th><th>Performer</th><th>Composer(s)</th><th>Details</th></tr>";

 //echo count($matches[0]);
    $i=0;
    foreach($matches[1] as $row_html)
    {

      if(preg_match("/<div class=\"type\">(.*?)<\/div>/s", $matches[1][$i], $temp))//SAMPLE LINK
	  {
	    if(preg_match("/<a href=\"(.*?)\"/s",  $temp[0],$sample_matches))
		{
	      echo "<tr align=\"center\"><td><a href=\"$sample_matches[1]\">Play Sample</a></td>";
		}	   
	  else
	  {
	    echo "<tr align=\"center\"><td>N/A</td>";
	  }
	 }
	 // TITLE OF SONG
	  if(preg_match("/<div class=\"title\">(.*?)<\/div>/s", $matches[1][$i], $name_matches))
	  {
	    if(preg_match("/&quot;(.*?)&quot;<\/a>/", $name_matches[0], $title_name))
	    {
	      echo "<td>$title_name[1]</td>";
	    }
		else
		{
		  echo "<td>N/A</td>";
		}
	   }
	   //PERFORMER
	    if(preg_match("/<span class=\"performer\">by <a href(.*?)<\/span>/s", $matches[1][$i], $perf_matches))
	  {
	     if(preg_match("/\">(.*?)<\/a>/", $perf_matches[1], $artist_name))
	     {	
		   echo "<td>$artist_name[1]";
		   while(preg_match("/\/ <a href(.*?)<\/span>/", $perf_matches[0], $temp))
		   {
		     if(preg_match("/\">(.*?)<\/a>/", $temp[0], $artist_name))
		     {
		       preg_match("/\">(.*?)<\/span>/", $temp[0], $perf_matches);
		       echo ", $artist_name[1]";
		      }
		    }
	      }
	     else
	     {
		   
	        echo "<td>N/A";
		
	      }
		echo "</td>";
	   }
	   
		else
		{
		  if(preg_match("/<div class=\"title\">(.*?)<\/div>/s", $matches[1][$i], $name_matches))
	      {
	        if(preg_match("/&quot;(.*?)&quot;<\/a>/", $name_matches[0], $title_name))
	        {
		      echo "<td>N/A</td>";
		     }
		   }
		}
	   
	  
	  //COMPOSER
	  if(preg_match("/<div class=\"info\">(.*?)<\/div>/s", $matches[1][$i], $info_matches))
	  {
	    if(preg_match("/\">(.*?)<\/a>/", $info_matches[0], $comp_name))
		{
		  echo "<td>$comp_name[1]";
		  while(preg_match("/\/ <a href(.*?)<\/div>/", $info_matches[0], $temp))
		  {
		    if(preg_match("/\">(.*?)<\/a>/", $temp[0], $comp_name))
		    {
		      preg_match("/\">(.*?)<\/div>/", $temp[0], $info_matches);
		      echo ", $comp_name[1]";
		    }
		   }
		
		 
		echo "</td>";
		}
		else
		{
		  echo "<td>N/A</td>";
		}    
     
	  }
	  if(preg_match("/<div class=\"title\">(.*?)<\/div>/s", $matches[1][$i], $name_matches))
	  {
	    if(preg_match("/href=\"(.*?)\">/s", $name_matches[0], $link_matches))
	    {
	      echo "<td><a href=\"".$link_matches[1]."\">Details</a></td></tr>";
	    }
		else
		{
		  echo "<td>N/A</td>";
		}
	  }	
	  
    
	$row = array();
	$i++;
	}
  }
   else
	 {
	   echo "<div align=\"center\"><h1>Search Result</h1>";
	   echo "<b>\"".$_GET["query"]."\" of type \"".$_GET["type"]."\"<br>";
	   echo "<h2>No Discography found!</h2></div>";
	 }
  }
 }
?>
</html>