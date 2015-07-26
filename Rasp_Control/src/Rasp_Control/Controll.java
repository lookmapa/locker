package Rasp_Control;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.ParseException;

import com.mysql.jdbc.util.ResultSetUtil;
import com.pi4j.io.gpio.PinState;

public  class Controll  implements Runnable {

	private String driver="com.mysql.jdbc.Driver";
	//private String url="jdbc:mysql://192.168.1.199/locker?characterEncoding=UTF-8";
	private String url="jdbc:mysql://172.17.131.250/locker?characterEncoding=UTF-8";
	private String id="raspberry";
	private String pass="1234";
	private ResultSet rs = null;
	private Connect_DB db = null;
	private char ch_send[] = {'r','0','0','0','0','0','0','0','0','0','0','0','0'};
	private char ch_read[] = new char[13];
	private String status[] = {"start","empty-0","empty-0","empty-0","empty-0","empty-0","empty-0","empty-0","empty-0","empty-0","empty-0","empty-0","empty-0"};
	private Integer h_remind[] = {0,0,0,0,0,0,0,0,0,0,0,0,0};
	//private Integer room[] = new Integer[13];
	@Override
	public void run() {

		ControlGpio gpio = new ControlGpio();
		Rfid rfid = new Rfid();
		SerialPort s_port = new SerialPort();
		DateTime dt = new DateTime();
		
		try {
			 db = new Connect_DB(driver, url, id, pass);
		} catch (ClassNotFoundException | SQLException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
				
		while(true){			
			
			try {
				if(gpio.pin_input(2) == PinState.HIGH){
					System.out.println("\nPlease Touch Cards !!");
					gpio.pin_high(3);
					String str = rfid.read();			    
					rs = db.getData("*","config");
					rs.next();
					if(rs.getString("Status").equals("wait")){
						System.out.println("Web");
						gpio.pin_low(3);
						s_port.send_data('p');
						Thread.sleep(500);
						db.updateData("config", "Data = '"+str+"'","Data = ''");
					}else{
						System.out.println("Micro");
						System.out.println("RFID TAG : "+str);
						
						ResultSet rs_date = db.getData("*","datetime");
						rs_date.next();
						String day =  dt.getDay(rs_date.getString("date"));//dt.getDay();
						String date =  rs_date.getString("date");//dt.getDate();
						String datetime = dt.getdDateTime();
						String time = rs_date.getString("time");//dt.getTime();
						String clock[] = time.split(":");
						String sqltime = "";
						String total = "";
						String sql = "";
						String year = "";
						String term = "";
						
						rs = db.getData("Year,Term", "setdate", "sDate <= '"+date+"' and eDate >= '"+date+"'");
						rs.next();
						if(rs.getRow()>0){ // เช็คค่าปี เทอม
							
							year = rs.getString("Year");
						    term = rs.getString("Term");
							System.out.println("ปี "+year); /////////////////////////////////////
							if( Integer.parseInt(time.substring(0,2)) < 12 && Integer.parseInt(time.substring(0,2)) >= 7){
								sqltime = "12:00:00";
							}else if( Integer.parseInt(time.substring(0,2)) < 17 ){
								sqltime = "17:00:00";
							}else if( Integer.parseInt(time.substring(0,2)) < 22 ){
								sqltime = "22:00:00";
							}
						}												
						rs = db.getData("*","account" ,"RfidTag = '"+str+"'" );
						rs.next();						
						for(int i= 1; i<= 12; i++){ // เซ็ตค่าเริ่มต้น
							ch_send[i] = '0';
							status[i] = "empty-0";
							h_remind[i] = 0; 
						}	
						
						if(rs.getRow()>0){ // เช็คว่าบัตรนี่มีรหัสไหม		
							String no = rs.getString("No");
							while(gpio.pin_input(2) == PinState.LOW){}
							if(Integer.parseInt(rs.getString("Level")) == 1){ // อนุญาติใช้ห้องนอกเวลาไหม
								gpio.pin_low(3);
								s_port.send_data('p');
								Thread.sleep(500);	
								System.out.println("อนุญาติ");	
								
								rs = db.getData_Join("*","account" , "history_numberlocker on account.No = history_numberlocker.No_account","account.No = '"+rs.getString("No")+"'" );
								while (rs.next()) { // กำหนดหมายเลขเปิดตู้
									for (int i = 1 ;i<=12 ; i++){
										if( i == Integer.parseInt(rs.getString("No_number")) ){
											ch_send[i] = '1';
											i = 13;
										}
									}
								}
							}else{
								gpio.pin_low(3);
								s_port.send_data('p');
								Thread.sleep(500);
								System.out.println("ไม่อนุญาติ");
							}
				
							/*------------------------------- ตรวจสอบว่าเคยเปิดห้องแบบแจ้งหรือไม่ --------------------------------------------------------------------*/
							sql = "`history`.No_account = "+no+" and `End` is null and Status = 'แจ้ง'";
							rs = db.getData_Join("`number_locker`.No as n_no,`history`.No as h_no,overtime_room.No as o_no","history","`overtime_room` on `history`.`No_overtime`= `overtime_room`.No join `number_locker` on `overtime_room`.Room = `number_locker`.Number_Room",sql);
							rs.next();
							if( rs.getRow() > 0 ){ // เช็คว่าเคยเปิดห้องแบบแจ้งไหม
								rs.beforeFirst();
								while(rs.next()){
									ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
									status[Integer.parseInt(rs.getString("n_no"))] = "มีขอใช้ห้องนอกเวลา-"+rs.getString("o_no");
									h_remind[Integer.parseInt(rs.getString("n_no"))] = Integer.parseInt(rs.getString("h_no"));
								}
							}else{
								System.out.println("ไม่เคยเปิดห้องแบบแจ้ง");
							}
							/*------------------------------------------------------------------------------------------------------------------------*/
						
							/*------------------------------- ตรวจสอบว่าเคยเปิดห้องแบบตารางสอนหรือไม่ --------------------------------------------------------------------*/
							sql = "No_account = "+no+" and`End` is null and (Status = 'เข้าสอนตรงเวลา' or Status = 'เข้าสอนสาย')";
							rs = db.getData("No_numberlocker,No,Status","history",sql);
							rs.next();
							if( rs.getRow() > 0 ){ // เช็คว่าเคยเปิดห้องไหม
								rs.beforeFirst();
								System.out.println("เคยเปิดห้อง");
								while(rs.next()){
									ch_send[Integer.parseInt(rs.getString("No_numberlocker"))] = '1';
									status[Integer.parseInt(rs.getString("No_numberlocker"))] = "มีสอน-"+rs.getString("No");
								}	
							}else{
								System.out.println("ไม่เคยเปิดห้อง");
							}
							/*------------------------------------------------------------------------------------------------------------------------*/
							
							/*------------------------------- ตรวจสอบว่าเวลานี้มีตารางสอนหรือไม่ --------------------------------------------------------------------*/
								sql = "No_account = "+no+" and Year = "+year+" and Term = "+term+" and Day = '"+day+"' and Time_End > '"+Double.parseDouble(clock[0]+"."+clock[1])+"' group by subject_timetable.No order by Time_Begin asc limit 0,1";
							System.out.println(sql); /////////////////////////////////////
								rs = db.getData_Join("Time_Begin,number_locker.No as n_no,subject_timetable.No as st_no","subject_timetable" , "number_locker on Number_Room = Room",sql );
								rs.next();
								if( rs.getRow() > 0 ){
									ResultSet rs1 = db.getData("*","history","No_timetable = "+rs.getString("st_no")+" and Begin > '"+date+" 00:00' and Begin < '"+date+" 23:59'");
									rs1.next();
									if( rs1.getRow() == 0 ){ // เช็คตารางสอนว่ามีเวลานี้ไหม
										ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
										status[Integer.parseInt(rs.getString("n_no"))] = "มีสอน-"+rs.getString("n_no")+"-"+rs.getString("st_no")+"-"+rs.getString("Time_Begin");
										System.out.println("มีตารางสอน");
									}else{
										System.out.println("ไม่มีตารางสอนเวลานี้");
									}
								}
							/*------------------------------------------------------------------------------------------------------------------------*/
							
							/*------------------------------- ตรวจสอบว่าเวลานี้มีการขอใช้ห้องหรือไม่ --------------------------------------------------------------------*/
							String cut_time[] = sqltime.split(":");
							sql = "Date = '"+date+"' and Time_End > '"+time+"' and No_account = "+no;
							rs = db.getData_Join("Time_Begin,Time_End,Room,overtime_room.No as o_no,number_locker.No as n_no","overtime_room","number_locker on Number_Room = Room",sql);
							rs.next();
							if( rs.getRow() > 0){ // รายการห้องที่ขอไว้ทั้งหมดวันนี้
								ResultSet rsh = db.getData("*", "history", "No_overtime = "+rs.getString("o_no")+" and End is not null");
								rsh.next();
								if( rsh.getRow() == 0){
								rs.beforeFirst();
								while(rs.next()){
									String cut_time_rs[] = rs.getString("Time_Begin").split(":");
									sql = "Year = "+year+" and Term = "+term+" and Day = '"+day+"' and Room = "+rs.getString("Room")+" and Time_Begin < "+Double.parseDouble(cut_time_rs[0]+"."+cut_time_rs[1]);
									ResultSet rs_st = db.getData("No","subject_timetable", sql);
									rs_st.next();
									if( rs_st.getRow() == 0){ // ตรวจสอบห้องนี้ ก่อนหน้านี้ว่างไหม
										System.out.println(rs.getString("o_no")+" ห้องว่าง");
										ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
										status[Integer.parseInt(rs.getString("n_no"))] = "มีขอใช้ห้องนอกเวลา-"+rs.getString("o_no");
									}else{
										sql = "No_timetable = "+rs_st.getString("No")+" and Year = "+year+" and Term = "+term+" and ( Status = 'เข้าสอนตรงเวลา' or Status = 'เข้าสอนสาย' )"
											  + " and Begin >= '"+date+" 00:00:00' and Begin <= '"+date+" 23:59:59' and End is not null";
										ResultSet rs_h = db.getData("No", "history", sql);
										rs_h.next();
										if( rs_h.getRow() > 0){ // เช็คว่าเคยมีประวัติการสอนของห้องนี้รึยัง
											sql = "Date = '"+date+"' and Time_Begin <= '"+rs.getString("Time_Begin")+"' and Room = "+rs.getString("Room")+" and No != "+rs.getString("o_no");
											ResultSet rs_h2 = db.getData("*", "overtime_room", sql);
											rs_h2.next();
											if( rs_h2.getRow() > 0){ // เช็คว่ามีคนจองห้องนี้ก่อนหน้านี้ไหม
												ResultSet rs_h3 = db.getData("No_account,End","history","No_overtime = "+rs_h2.getString("No"));
												rs_h3.next();
												if( rs_h3.getRow() == 0){ // เช็คห้องนี้ว่ามีประวัติการเปิดห้องแบบแจ้งหรือยัง
														System.out.println(rs.getString("o_no")+" ห้องไม่ว่าง4 มีประวัติการเปิดห้องแบบแจ้ง ห้องนี้แล้ว");
												}else{
													if( rs_h3.getString("End") == null ){
														if( rs_h3.getString("No_account") == no){
															System.out.println(rs.getString("o_no")+" ห้องว่าง4 ");
															ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
															status[Integer.parseInt(rs.getString("n_no"))] = "มีขอใช้ห้องนอกเวลา-"+rs.getString("o_no");
														}else{
															System.out.println(rs.getString("o_no")+" ห้องไม่ว่าง5 มีประวัติการเปิดห้องแบบแจ้ง ห้องนี้แล้ว");
														}
													}else{
															System.out.println(rs.getString("o_no")+" ห้องว่าง6 ");
															ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
															status[Integer.parseInt(rs.getString("n_no"))] = "มีขอใช้ห้องนอกเวลา-"+rs.getString("o_no");
													}
												}
											}else{
												ResultSet rs_h3 = db.getData("No,End","history","No_overtime = "+rs.getString("o_no"));
												rs_h3.next();
												if( rs_h3.getRow() == 0){ // เช็คห้องนี้ว่ามีประวัติการเปิดห้องแบบแจ้งหรือยัง
													System.out.println(rs.getString("o_no")+" ห้องว่าง3");
													ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
													status[Integer.parseInt(rs.getString("n_no"))] = "มีขอใช้ห้องนอกเวลา-"+rs.getString("o_no");
												}else{
													if( rs_h3.getString("End") == null ){
														System.out.println(rs.getString("o_no")+" ห้องว่าง5 ");
														ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
														status[Integer.parseInt(rs.getString("n_no"))] = "มีขอใช้ห้องนอกเวลา-"+rs.getString("o_no");
													}else{
														System.out.println(rs.getString("o_no")+" ห้องไม่ว่าง3  มีประวัติการเปิดห้องแบบแจ้ง ห้องนี้แล้ว");
													}
												}
											}
										}else{
											System.out.println(rs.getString("o_no")+" ห้องไม่ว่าง");
										}
									}
								}
								}else{
									System.out.println("เปิดไปแล้วโว้ย");
								}
							}

							/*---------------------------------------------------------------------------------------------------------------------------------*/
							
							/*---------------------------------หมายเลขที่มีสิทธิเปิด-----------------------------------------------*/
							for (int i = 1; i <= 12 ;i++){
								System.out.println("["+ch_send[i]+","+status[i]+"]");
							}
							/*---------------------------------------------------------------------------------------------*/
							
							/*---------------------------------ส่งหมายเลขไปยัง micro-----------------------------------------------*/
							for (int i = 0 ;i<=12 ; i++){
								while(gpio.pin_input(2) == PinState.LOW){}
								s_port.send_data(ch_send[i]);
							}
							System.out.println();
							/*------------------------------------------------------------------------------------------------*/
							
							/*---------------------------------รับค่ากลับ micro-----------------------------------------------*/
							while(gpio.pin_input(1) == PinState.LOW){}
								 ch_read = s_port.read_data();
								for (int j = 0; j < 12 ; j++){
									System.out.print(ch_read[j]);
								}
							System.out.println();
							/*------------------------------------------------------------------------------------------------*/
						
							/*---------------------------------ตรวจสอบว่าเปิดตู้หรือปิดตู้-----------------------------------------------*/
							for (int i = 1; i <= 12 ;i++){
								if(ch_send[i] == '1'){ // เปิดตู้ไหนได้บ้าง
									String st[] = status[i].split("-"); // st = สถานะ,ห้อง,ตารางสอน,เวลาเริ่ม
									if(st[0].equals("มีสอน")){
										rs = db.getData("Max(No) as max","history","`End` is null and `No_numberlocker` = "+i);
										rs.next();
										if(ch_read[i-1] == '0'){// หยิบกุญแจ
											if(rs.getString("max") == null){ // เริ่มบันทึก
												if( Double.parseDouble(st[3]) >= Double.parseDouble(clock[0]+"."+clock[1]) ){ // เข้าสอนตรงเวลา
													sql = String.format("%s,%s,%s,%s,%s,%s,%s,'%s',%s,'%s','%s'",null,no,st[1],st[2],0,year,term,date+" "+time,null,"เข้าสอนตรงเวลา",null); // แก้เป็น date time ***********************************************
													db.insertData("history",sql);
												}else{ // เข้าสอนสาย
													sql = String.format("%s,%s,%s,%s,%s,%s,%s,'%s',%s,'%s','%s'",null,no,st[1],st[2],0,year,term,date+" "+time,null,"เข้าสอนสาย",null); // แก้เป็น date time ***********************************************
													db.insertData("history",sql);
												}
												System.out.println("เริ่มบันทึกใหม่");
											}else{
												System.out.println("หยิบไปแล้ว");
											}
										}else{// คืนกุญแจ
											rs = db.getData("No", "history", "end is null and Status = 'empty' and No_numberlocker = "+i);
											rs.next();
											if( rs.getRow() > 0){
												db.updateData("history","end ='"+date+" "+time+"'","No = "+rs.getString("No"));
											}else{
												db.updateData("history","end ='"+date+" "+time+"'","No = "+st[1]);
											}	
										}									
									}else if(st[0].equals("มีขอใช้ห้องนอกเวลา")){
										System.out.println("มีใช้ห้องนอกเวลา");
										rs = db.getData("Max(No) as max","history","`End` is null and `No_overtime` = "+st[1]);
										rs.next();
										if(ch_read[i-1] == '0'){// หยิบกุญแจ
											if(rs.getString("max") == null){ // เริ่มบันทึก
												sql = String.format("%s,%s,%s,%s,%s,%s,%s,'%s',%s,'%s','%s'",null,no,"0","0",st[1],year,term,date+" "+time,null,"แจ้ง",null); // แก้เป็น date time ***********************************************
												db.insertData("history",sql);
												System.out.println("เริ่มบันทึกใหม่");
											}else{
												System.out.println("หยิบไปแล้ว");
											}
										}else{// คืนกุญแจ
											db.updateData("history","end ='"+date+" "+time+"'","No = "+h_remind[i]);
										}										
									}else if(st[0].equals("empty")){
										int num = 0;
										if(ch_read[i-1] == '0'){// หยิบกุญแจ
											ResultSet rs_st = db.getData("No", "history", "End is null and No_numberlocker = "+i);
											rs_st.next();
											if( rs_st.getRow() > 0){ // ห้องที่จะเปิด มีตารางสอนเปิดอยู่รึป่าว
												num += 1;
											}
											
											sql = "End is null and number_locker.No = "+i;
											ResultSet rs_ot = db.getData_Join("history.No", "history", "`overtime_room` on `history`.`No_overtime`= `overtime_room`.No join `number_locker` on `overtime_room`.Room = `number_locker`.Number_Room",sql);
											rs_ot.next();
											if( rs_ot.getRow() > 0){ // ห้องที่จะเปิด มีตารางสอนเปิดอยู่รึป่าว
												num += 1;
											}
											
											if( num == 0){ // ห้องทั้ง2เปิดอยุ่รึป่าว
												sql = String.format("%s,%s,%s,%s,%s,%s,%s,'%s',%s,'%s','%s'",null,no,i,"0","0",year,term,date+" "+time,null,"empty",null); // แก้เป็น date time ***********************************************
												db.insertData("history",sql);
												System.out.println("เริ่มบันทึกใหม่2");
											}else{
												System.out.println("หยิบไปแล้ว");
											}
										}else{// คืนกุญแจ
											ResultSet rs_st = db.getData("No", "history", "End is null and No_numberlocker = "+i);
											rs_st.next();
											if( rs_st.getRow() > 0){ // ห้องที่มีตารางสอนหรือ empty
												rs_st.beforeFirst();
												while(rs_st.next()){
													db.updateData("history","end ='"+date+" "+time+"'","No = "+rs_st.getString("No"));
												}
											}
											
											sql = "End is null and number_locker.No = "+i;
											ResultSet rs_ot = db.getData_Join("history.No", "history", "`overtime_room` on `history`.`No_overtime`= `overtime_room`.No join `number_locker` on `overtime_room`.Room = `number_locker`.Number_Room",sql);
											rs_ot.next();
											if( rs_ot.getRow() > 0){ // ห้องที่ขอแบบแจ้ง
												rs_ot.beforeFirst();
												while(rs_ot.next()){
													db.updateData("history","end ='"+date+" "+time+"'","No = "+rs_ot.getString("history.No"));
												}
											}	
										}	
									}
								}else{
									System.out.println("ไม่ได้เปิด");
								}
							}
							/*----------------------------------------------------------------------------------------------------*/
							
						}else{
							while(gpio.pin_input(2) == PinState.LOW){}
							gpio.pin_low(3);
							s_port.send_data('n');
							Thread.sleep(500);
						}				
					}
				}
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (ParseException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}		
	}	
}
