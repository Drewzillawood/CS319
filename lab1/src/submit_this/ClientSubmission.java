package submit_this;

import java.awt.image.BufferedImage;
import java.io.BufferedOutputStream;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.io.OutputStream;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.UnknownHostException;
import java.nio.ByteBuffer;
import java.util.Scanner;

import javax.imageio.ImageIO;

public class ClientSubmission {

	public static void main(String[] args) throws UnknownHostException, IOException {
		
		// Connecting to the server
		Socket socket = new Socket("localhost", 4444);
		Scanner s = new Scanner(System.in);
		Scanner s1 = new Scanner(System.in);
		
		// Prompt for the user to enter their username
		System.out.print("Enter your name: ");
		String usr = s.nextLine();
		
		Thread t = new Thread(new ClientHandler(socket, 0));
		t.start();
		
		if(usr.equals("admin")) {
			
			System.out.println("Hello admin: ");
			System.out.println("1.) Broadcast message to all clients.");
			System.out.println("2.) List messages so far.");
			System.out.println("3.) Delete a message.");
			int var = s1.nextInt();
			
			while(var > 4 || var < 0) {
				
				System.out.print("Please enter valid input: ");
				var = s1.nextInt();
				
			}
			
			// Prepare a PrintWriter to send information to server
			PrintWriter out = new PrintWriter(new BufferedOutputStream(socket.getOutputStream()));
					
			out.println(usr);
			out.flush();
			
			if (var == 1) {
				
				
						
			} else if (var == 2) {
				
				File file = new File("chat.txt");
				Scanner sc = new Scanner(file);
				while(sc.hasNextLine()) {
					
					System.out.println(sc.nextLine());
					
				}
				sc.close();
				
			} else if (var == 3) {
				
				System.out.print("Please enter line number to erase: ");
				int lineNum = s1.nextInt() - 1;
				File file = new File("chat.txt");
				String strArr[] = new String[fileLength(file) - 1];
				FileWriter fileIO;
				Scanner sc = new Scanner(file);
				
				/* 
				* Necessary for instance of empty file
				* to provide proper numbering
				*/
				if(fileLength(file) == 0) {
					
					fileIO = new FileWriter(file, false);
					
				} else {
				
					fileIO = new FileWriter(file, true);
				
				}
				
				int i = 0;
				while(sc.hasNextLine()) {
					
					if(i == lineNum) {
						
						sc.nextLine();
						
					} else {
						
						strArr[i] = sc.nextLine();
						
					}
					i++;
					
				}
				
				PrintWriter pw = new PrintWriter(file);
				pw.write("");
				pw.close();
				
				for(i = 0; i < strArr.length; i++) {
					
					Scanner scanner = new Scanner(strArr[i]);
					strArr[i] = (i+1) + ".)" + strArr[i].substring(3, strArr[i].length()) + "\n";
					scanner.close();
					fileIO.write(strArr[i]);
					
				}
				
				sc.close();
				fileIO.close();
				
			}
			
			
			s.close();
			s1.close();
			
		} else {
		
			// Prepare a PrintWriter to send information to server
			PrintWriter out = new PrintWriter(new BufferedOutputStream(socket.getOutputStream()));
			OutputStream outPS = socket.getOutputStream();	
			
			
			out.println(usr);
			out.flush();
		
			System.out.println("Would you like to: ");
			System.out.println("1.) Send a message to the server?");
			System.out.println("2.) Send a picture to the server?");
			int coin = s1.nextInt();
		
			if(coin == 1) {
			
				System.out.print("Please enter the message you wish to send: ");
				String msg = s.nextLine();
				out.println(coin);
				out.flush();
				out.println(msg);
				out.flush();
				out.close();
			
			} else if (coin == 2) {
			
				System.out.print("Please enter the file you wish to send: ");
				String msg = s.nextLine();
				out.println(coin);
				out.flush();
				out.println("new" + msg);
				out.flush();
				
				BufferedImage img = ImageIO.read(new File(msg));
				ByteArrayOutputStream bAOS = new ByteArrayOutputStream();
				ImageIO.write(img, "jpg", bAOS);
				
				byte[] size = ByteBuffer.allocate(4).putInt(bAOS.size()).array();
				outPS.write(size);
				outPS.write(bAOS.toByteArray());
				outPS.flush();
				out.println("new" + msg);
				out.flush();
				out.close();
				outPS.close();
			
			} 
		
		}
		
		socket.close();
		
	}
	
	private static int fileLength(File file) throws FileNotFoundException {
		
		int fileLength = 0;
		Scanner fileScanner = new Scanner(file);
		
		while(fileScanner.hasNextLine()) {
			
			fileLength++;
			fileScanner.nextLine();
			
		}
		
		fileScanner.close();
		return fileLength;
		
	}

}


