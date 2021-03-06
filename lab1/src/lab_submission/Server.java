package lab_submission;

import java.io.File;
import java.io.IOException;
import java.io.PrintWriter;
//package lab3;
import java.net.ServerSocket;
import java.net.Socket;

public class Server implements Runnable {

	private ServerSocket serverSocket = null;
	private Thread mainThread = null;
	private File file = new File("chat.txt");
	private PrintWriter writer;
	private ServerGUI frame;
	private Thread guiMessageThread;

	public Server(int port) {
		
		// Binding and starting server
		ServerSocket serverSocket = null; 
		int clientNum = 0;
		
		try {
			
			System.out.println("Binding to port " + port + ", please wait  ...");
			serverSocket = new ServerSocket(port);
			System.out.println("Server started: " + serverSocket);
			start();
			
		} catch (IOException ioe) {
			
			System.out.println("Can not bind to port " + port + ": " + ioe.getMessage());
			
		}
		
		while(true) {
			
			Socket clientSocket = null;
			
			
			
		}
		
	}

	public void run() {
		
		// TODO wait for a client or show error

	}

	public void start() {
		
		frame = new ServerGUI();
		frame.setVisible(true);
		// TODO launch a thread to read for new messages by the server

	}

	public void stop() {
		// TODO

	}

	private int findClient(int ID) {
		
		// TODO Find Client

		return -1;
		
	}

	public synchronized void handle(String input) {
		// TODO new message, send to clients and then write it to history

		// TODO update own gui

	}

	public synchronized void remove(int ID) {
		// TODO get the serverthread, remove it from the array and then
		// terminate it

	}

	private void addThread(Socket socket) {
		// TODO add new client

	}

	public static void main(String args[]) {
		
		Server server = null;
		server = new Server(1222);
		
	}
}