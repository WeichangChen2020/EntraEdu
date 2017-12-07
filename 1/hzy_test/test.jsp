<%
	String username = request.getParameter("username");
	String password = request.getParameter("password");

	if (username == "xiaoming" && password == "123456") {
		out.println("Welcome " + username + " !");
	}
	else {
		out.println("sorry " + username + " Try again!");
	}


%>