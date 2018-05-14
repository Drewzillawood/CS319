package lab1_servers;

//GOALS
//1. to show client code that connects to the server and sends it a message
//

import java.io.BufferedOutputStream;
import java.io.IOException;
import java.io.PrintWriter;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.Scanner;

public class MyClient {

	public static void main(String[] args) throws UnknownHostException,
			IOException {

		// 1. CONNECT TO THE SERVER AT PORT 4444 
		Socket socket = new Socket("localhost", 4444);
		printSocketInfo(socket);
		
		// 2. WRITE A MESSAGE TO THE SOCKET TO SEND TO THE SERVER
		Scanner s = new Scanner(System.in);
		System.out.print("TYPE STUFF: ");
		String temp = s.nextLine();
		PrintWriter out = new PrintWriter(new BufferedOutputStream(socket.getOutputStream()));
		out.println(temp);
		out.print("Client socket Local Address: " + socket.getLocalAddress() + ":" + socket.getLocalPort());
//		out.println("  Client socket Remote Address: " + socket.getRemoteSocketAddress());
		out.println("HEY THIS IS WHERE SHIT IS HAPPENING");
		socket.getOutputStream().flush();
		out.close(); // forces data from buffer to be sent to server
		
		
		// client dies here

	}

	static void printSocketInfo(Socket s) {
		System.out.print("Socket on Client Side: ");
		System.out.print("Local Address: " + s.getLocalAddress() + ":"
				+ s.getLocalPort());
		System.out.println("  Remote Address: " + s.getRemoteSocketAddress());
	}

}

