<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
    <%@page import="java.net.*" %>
<%@page import="java.io.*" %>
    
    <%
   
	        
	        String str="https://site2sms.p.mashape.com/index.php?uid="+session.getAttribute("uid").toString()+"&pwd="+session.getAttribute("password").toString()+"&phone="+session.getAttribute("phone").toString()+"&msg="+session.getAttribute("message").toString();
    URL dest = new URL(str);
    URLConnection yc = dest.openConnection();
    yc.setRequestProperty ("X-Mashape-Authorization", "CjrqMh8OVCKAJmaqoGS3S01xqg6YxgqJ");
   
    BufferedReader in = new BufferedReader(
 	        new InputStreamReader(yc.getInputStream()));

 	        String inputLine;
 	        while ((inputLine = in.readLine()) != null)
 	            System.out.println(inputLine);
 	        in.close();
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Insert title here</title>
</head>
<body>

</body>
</html>