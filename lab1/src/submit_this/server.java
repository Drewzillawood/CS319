package submit_this;

import java.io.IOException;
import java.io.PrintStream;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.Scanner;

public class server {

	public static void main(String[] args) throws IOException {
		
		ServerSocket serverSocket = new ServerSocket(1342); // keeps track of how many clients were created
		Socket ss = serverSocket.accept();
		
		Scanner sc = new Scanner(ss.getInputStream());
		int number = sc.nextInt();
		
		int temp = number * 2;
		
		PrintStream p = new PrintStream(ss.getOutputStream());
		p.println(temp);
		
	}
}


	
	


