package Rasp_Control;

import com.pi4j.wiringpi.Serial;

public class SerialPort {

	private String DEFAULT_COM_PORT = "/dev/ttyAMA0";
	private int fd = -1;
	
	public SerialPort(){
		fd = Serial.serialOpen(DEFAULT_COM_PORT, 9600);
	}
	
	public void send_data(char c){
		Serial.serialPutchar(fd, c);
	}
	

	
	public char[] read_data(){
		char ch[] = new char[13];
		for(int i = 0; i<= 11; i++){
			ch[i] = (char)Serial.serialGetchar(fd);
		}
		return ch;

	}
	
	public void close(){
		Serial.serialClose(0);
	}
	
	
}
