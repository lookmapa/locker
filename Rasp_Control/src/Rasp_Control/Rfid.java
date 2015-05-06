package Rasp_Control;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

public class Rfid {

	private Runtime rt;
	private Process pr;
	private String str = "";
	
	public String  read(){
		
		try {
			rt = Runtime.getRuntime();
			pr = rt.exec("sudo python Rfid_Read.py");
			BufferedReader bfr = new BufferedReader(new InputStreamReader(pr.getInputStream()));
			str = bfr.readLine();
			return str;
		} catch (IOException e) {
			return "fail";
		}
		
	}
}
