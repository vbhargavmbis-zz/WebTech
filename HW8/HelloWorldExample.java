/* $Id: HelloWorldExample.java,v 1.2 2001/11/29 18:27:25 remm Exp $
 *
 */
import java.net.*;
import java.io.*;
import java.text.*;
import java.util.*;
import javax.servlet.*;
import javax.servlet.http.*;

import org.json.JSONException;
import org.json.JSONObject;
import org.json.XML;
/**
 * The simplest possible servlet.
 *
 * @author James Duncan Davidson
 */

public class HelloWorldExample extends HttpServlet 
{


    public void doGet(HttpServletRequest request, HttpServletResponse response)
        throws IOException, ServletException
    {
	// response.setCharacterEncoding("UTF-8");
	 response.setContentType("application/json");
	 String query= request.getParameter("query");
	 String type=request.getParameter("type");
	 PrintWriter out = response.getWriter();
	 query=query.replace(' ','+');
	// out.println(query);
	 
	String inp,xml="",xml2="";
	// String urlString = "/home/scf-04/bhargavv/apache2/htdocs/hw6php.php";
     URL url = new URL("http://cs-server.usc.edu:28743/hw8php.php?query="+query+"&type="+type);
     URLConnection urlConnection = url.openConnection();
     urlConnection.setAllowUserInteraction(false);
     InputStream urlStream = url.openStream();
	 BufferedReader br = new BufferedReader(new InputStreamReader(urlStream));
	 
	
	 while((inp = br.readLine())!=null)
	 {	
	   xml+=inp;
	
//	   xml+="\n";
	 }
	// out.println(xml);
	// out.println("\n\n\n"); 
	 br.close();
	try 
    {                      
      JSONObject jsonObj = null;                      
      jsonObj = XML.toJSONObject(xml);
      String json = jsonObj.toString();             
      out.println(json);
                       
    }
	catch (JSONException e)
	{
     e.printStackTrace();
    }

    }
}



