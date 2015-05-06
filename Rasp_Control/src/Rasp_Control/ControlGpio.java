package Rasp_Control;

import com.pi4j.io.gpio.GpioController;
import com.pi4j.io.gpio.GpioFactory;
import com.pi4j.io.gpio.GpioPinDigitalInput;
import com.pi4j.io.gpio.GpioPinDigitalOutput;
import com.pi4j.io.gpio.PinPullResistance;
import com.pi4j.io.gpio.PinState;
import com.pi4j.io.gpio.RaspiPin;


public class ControlGpio {

	private GpioController gpio = GpioFactory.getInstance();
    private GpioPinDigitalInput pin1 = gpio.provisionDigitalInputPin(RaspiPin.GPIO_01,PinPullResistance.PULL_DOWN);
    private GpioPinDigitalInput pin2 = gpio.provisionDigitalInputPin(RaspiPin.GPIO_02, PinPullResistance.PULL_DOWN);
    private GpioPinDigitalOutput pin3 = gpio.provisionDigitalOutputPin(RaspiPin.GPIO_03,PinState.LOW);
    
   // SerialPort s_port = new SerialPort();
	public void pin_high(int pin){
    	switch (pin){
    		case 3: pin3.high(); break;
    			
    	}
    	
    }
    
    public void pin_low(int pin){
    	switch (pin){
    		case 3: pin3.low(); break;
    			
    	}
    	
    }
    
    public PinState pin_input(int pin){
    	switch (pin){
    		case 1: return pin1.getState();
    		case 2: return pin2.getState();
    		default : return null;
    	}
		
    }

    

    
    public void pin_shutdow(){
    	gpio.shutdown();
    }
    

}
