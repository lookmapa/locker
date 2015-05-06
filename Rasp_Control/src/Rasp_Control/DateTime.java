package Rasp_Control;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class DateTime {
	
	private Date date = new Date();
	private SimpleDateFormat sf ;
	
	public String getdDateTime(){
		sf = new SimpleDateFormat ("yyyy-MM-dd hh:mm:ss");
		return sf.format(date);
	}
	
	public String getDate(){
		sf = new SimpleDateFormat ("yyyy-MM-dd");
		return sf.format(date);
	}
	
	public String getTime(){
		sf = new SimpleDateFormat ("hh:mm:ss");
		return sf.format(date);
	}
	
	public String getDay(String data) throws ParseException{
		
		SimpleDateFormat sf = new SimpleDateFormat("yyyy-M-dd");
		Date d = sf.parse(data);
		sf = new SimpleDateFormat ("E");
		String day = sf.format(d);
		
		if(day.equals("Mon")){
			day = "จันทร์";
		}else if(day.equals("Tue")){
			day = "อังคาร";
		}else if(day.equals("Wed")){
			day = "พุธ";
		}else if(day.equals("Thu")){
			day = "พฤหัสบดี";
		}else if(day.equals("Fri")){
			day = "ศุกร์";
		}
		
		return day;
	}
	/*public String getDay(){
		sf = new SimpleDateFormat ("E");
		String day = sf.format(date);
		
		if(day.equals("Mon")){
			day = "จันทร์";
		}else if(day.equals("Tue")){
			day = "อังคาร";
		}else if(day.equals("Wed")){
			day = "พุธ";
		}else if(day.equals("Thu")){
			day = "พฤหัสบดี";
		}else if(day.equals("Fri")){
			day = "ศุกร์";
		}
		return day;
	}*/
			
}
