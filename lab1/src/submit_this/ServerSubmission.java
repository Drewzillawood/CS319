package submit_this;

import java.awt.image.BufferedImage;
import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.ByteArrayInputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.nio.ByteBuffer;
import java.util.Scanner;

import javax.imageio.ImageIO;

public class ServerSubmission {

	public static void main(String[] args) {
		
		ServerSocket serverSocket = null;
		int clientNum = 0;
		
		// 1. Create a new server socket
		try {
			
			serverSocket = new ServerSocket(4444);
			
		} catch (IOException e) {
			
			// Exit if unable to connect
			System.out.println("Could not listen on port: 4444");
			System.exit(-1);
			
		}	
		
		// Server is always waiting to provide service
		while(true) {
		
			Socket clientSocket = null;
			try {
				
				// Wait for client to connect to server
				clientSocket = serverSocket.accept();
				
				Thread t = new Thread(new ClientHandler(clientSocket, clientNum));
				t.start();
				
			} catch (IOException e) {
				
				System.out.println("Accept failed: 4444");
				System.exit(-1);
				
			}
			
		}

	}

}

class ClientHandler implements Runnable {
	
	Socket s; // Socket on the server side that connects to the client
	int num;  // Number for identity purposes
	
	ClientHandler(Socket s, int n) {
		
		this.s = s;
		num = n;
		
	}
	
	public void run() {
		
		Scanner in;
		Scanner intIn;
		InputStream ips;
		
		try {
			
			// Use the socket to read what the client has sent
			in = new Scanner(new BufferedInputStream(s.getInputStream()));
			intIn = new Scanner(new BufferedInputStream(s.getInputStream()));
			ips = s.getInputStream();
			String clientMessage = in.nextLine();
			
			int coin = Integer.parseInt(intIn.nextLine());
			String msg = intIn.nextLine();

			// Print what was sent by the client
			System.out.println("Message from Client " + ++num + ":" + clientMessage);
			
			if(coin == 2) {
				
				byte[] sizeAr = new byte[4];
				ips.read(sizeAr);
				int size = ByteBuffer.wrap(sizeAr).asIntBuffer().get();
				
				byte[] imageAr = new byte[size];
				ips.read(imageAr);
				
				BufferedImage img = ImageIO.read(new ByteArrayInputStream(imageAr));
				
				ImageIO.write(img, "jpg", new File("U:\\cs319\\workspace\\lab1\\pictures\\" + msg));
				
				
			} 
			
			// Need to find what the line number should be
			File file = new File("chat.txt");
			FileWriter fileIO;
			
			/* 
			* Necessary for instance of empty file
			* to provide proper numbering
			*/
			if(fileLength(file) == 0) {
				
				fileIO = new FileWriter(file, false);
				
			} else {
			
				fileIO = new FileWriter(file, true);
			
			}
			
			// Create the complete message
			clientMessage = (fileLength(file) + 1) + ".) " + clientMessage + ": " + msg + "\n";
			
			// Write to file
			fileIO.write(clientMessage);
			fileIO.close();
			
		} catch (IOException e) {
			
			e.printStackTrace();
			
		}
		
	}
	
	private int fileLength(File file) throws FileNotFoundException {
		
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
