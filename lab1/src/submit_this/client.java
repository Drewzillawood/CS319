package submit_this;

import java.io.IOException;
import java.io.PrintStream;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.Scanner;

public class client {

	public static void main(String args[]) throws UnknownHostException, IOException {
		
		Scanner sc = new Scanner(System.in); 					// Simple scanner to get number form user
		Socket s = new Socket("127.0.0.1", 4444);				// Socket to cooperate with
		Scanner sc1 = new Scanner(s.getInputStream());			// Scanner for using the actual socket
		System.out.print("Enter your message: ");				// Accepting number from the user
		String temp = sc.nextLine();								// Assign number from user
		
		/* Prepare to send the number to the actual server*/
		PrintStream p = new PrintStream(s.getOutputStream());   
		// Send the Message to server
		p.println(temp);
		
		// Print the result once received from server
		temp = sc1.nextLine();
		System.out.println(temp);
		
	}
	
}
