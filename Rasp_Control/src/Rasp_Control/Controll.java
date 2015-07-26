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
						if(rs.getRow()>0){ // �礤�һ� ���
							
							year = rs.getString("Year");
						    term = rs.getString("Term");
							System.out.println("�� "+year); /////////////////////////////////////
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
						for(int i= 1; i<= 12; i++){ // �絤���������
							ch_send[i] = '0';
							status[i] = "empty-0";
							h_remind[i] = 0; 
						}	
						
						if(rs.getRow()>0){ // ����Һѵù�����������		
							String no = rs.getString("No");
							while(gpio.pin_input(2) == PinState.LOW){}
							if(Integer.parseInt(rs.getString("Level")) == 1){ // ͹حҵ�����ͧ�͡�������
								gpio.pin_low(3);
								s_port.send_data('p');
								Thread.sleep(500);	
								System.out.println("͹حҵ�");	
								
								rs = db.getData_Join("*","account" , "history_numberlocker on account.No = history_numberlocker.No_account","account.No = '"+rs.getString("No")+"'" );
								while (rs.next()) { // ��˹������Ţ�Դ���
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
								System.out.println("���͹حҵ�");
							}
				
							/*------------------------------- ��Ǩ�ͺ������Դ��ͧẺ��������� --------------------------------------------------------------------*/
							sql = "`history`.No_account = "+no+" and `End` is null and Status = '��'";
							rs = db.getData_Join("`number_locker`.No as n_no,`history`.No as h_no,overtime_room.No as o_no","history","`overtime_room` on `history`.`No_overtime`= `overtime_room`.No join `number_locker` on `overtime_room`.Room = `number_locker`.Number_Room",sql);
							rs.next();
							if( rs.getRow() > 0 ){ // ��������Դ��ͧẺ�����
								rs.beforeFirst();
								while(rs.next()){
									ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
									status[Integer.parseInt(rs.getString("n_no"))] = "�բ�����ͧ�͡����-"+rs.getString("o_no");
									h_remind[Integer.parseInt(rs.getString("n_no"))] = Integer.parseInt(rs.getString("h_no"));
								}
							}else{
								System.out.println("������Դ��ͧẺ��");
							}
							/*------------------------------------------------------------------------------------------------------------------------*/
						
							/*------------------------------- ��Ǩ�ͺ������Դ��ͧẺ���ҧ�͹������� --------------------------------------------------------------------*/
							sql = "No_account = "+no+" and`End` is null and (Status = '����͹�ç����' or Status = '����͹���')";
							rs = db.getData("No_numberlocker,No,Status","history",sql);
							rs.next();
							if( rs.getRow() > 0 ){ // ��������Դ��ͧ���
								rs.beforeFirst();
								System.out.println("���Դ��ͧ");
								while(rs.next()){
									ch_send[Integer.parseInt(rs.getString("No_numberlocker"))] = '1';
									status[Integer.parseInt(rs.getString("No_numberlocker"))] = "���͹-"+rs.getString("No");
								}	
							}else{
								System.out.println("������Դ��ͧ");
							}
							/*------------------------------------------------------------------------------------------------------------------------*/
							
							/*------------------------------- ��Ǩ�ͺ������ҹ���յ��ҧ�͹������� --------------------------------------------------------------------*/
								sql = "No_account = "+no+" and Year = "+year+" and Term = "+term+" and Day = '"+day+"' and Time_End > '"+Double.parseDouble(clock[0]+"."+clock[1])+"' group by subject_timetable.No order by Time_Begin asc limit 0,1";
							System.out.println(sql); /////////////////////////////////////
								rs = db.getData_Join("Time_Begin,number_locker.No as n_no,subject_timetable.No as st_no","subject_timetable" , "number_locker on Number_Room = Room",sql );
								rs.next();
								if( rs.getRow() > 0 ){
									ResultSet rs1 = db.getData("*","history","No_timetable = "+rs.getString("st_no")+" and Begin > '"+date+" 00:00' and Begin < '"+date+" 23:59'");
									rs1.next();
									if( rs1.getRow() == 0 ){ // �礵��ҧ�͹��������ҹ�����
										ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
										status[Integer.parseInt(rs.getString("n_no"))] = "���͹-"+rs.getString("n_no")+"-"+rs.getString("st_no")+"-"+rs.getString("Time_Begin");
										System.out.println("�յ��ҧ�͹");
									}else{
										System.out.println("����յ��ҧ�͹���ҹ��");
									}
								}
							/*------------------------------------------------------------------------------------------------------------------------*/
							
							/*------------------------------- ��Ǩ�ͺ������ҹ���ա�â�����ͧ������� --------------------------------------------------------------------*/
							String cut_time[] = sqltime.split(":");
							sql = "Date = '"+date+"' and Time_End > '"+time+"' and No_account = "+no;
							rs = db.getData_Join("Time_Begin,Time_End,Room,overtime_room.No as o_no,number_locker.No as n_no","overtime_room","number_locker on Number_Room = Room",sql);
							rs.next();
							if( rs.getRow() > 0){ // ��¡����ͧ�������������ѹ���
								ResultSet rsh = db.getData("*", "history", "No_overtime = "+rs.getString("o_no")+" and End is not null");
								rsh.next();
								if( rsh.getRow() == 0){
								rs.beforeFirst();
								while(rs.next()){
									String cut_time_rs[] = rs.getString("Time_Begin").split(":");
									sql = "Year = "+year+" and Term = "+term+" and Day = '"+day+"' and Room = "+rs.getString("Room")+" and Time_Begin < "+Double.parseDouble(cut_time_rs[0]+"."+cut_time_rs[1]);
									ResultSet rs_st = db.getData("No","subject_timetable", sql);
									rs_st.next();
									if( rs_st.getRow() == 0){ // ��Ǩ�ͺ��ͧ��� ��͹˹�ҹ����ҧ���
										System.out.println(rs.getString("o_no")+" ��ͧ��ҧ");
										ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
										status[Integer.parseInt(rs.getString("n_no"))] = "�բ�����ͧ�͡����-"+rs.getString("o_no");
									}else{
										sql = "No_timetable = "+rs_st.getString("No")+" and Year = "+year+" and Term = "+term+" and ( Status = '����͹�ç����' or Status = '����͹���' )"
											  + " and Begin >= '"+date+" 00:00:00' and Begin <= '"+date+" 23:59:59' and End is not null";
										ResultSet rs_h = db.getData("No", "history", sql);
										rs_h.next();
										if( rs_h.getRow() > 0){ // ��������ջ���ѵԡ���͹�ͧ��ͧ������ѧ
											sql = "Date = '"+date+"' and Time_Begin <= '"+rs.getString("Time_Begin")+"' and Room = "+rs.getString("Room")+" and No != "+rs.getString("o_no");
											ResultSet rs_h2 = db.getData("*", "overtime_room", sql);
											rs_h2.next();
											if( rs_h2.getRow() > 0){ // ������դ��ͧ��ͧ����͹˹�ҹ�����
												ResultSet rs_h3 = db.getData("No_account,End","history","No_overtime = "+rs_h2.getString("No"));
												rs_h3.next();
												if( rs_h3.getRow() == 0){ // ����ͧ�������ջ���ѵԡ���Դ��ͧẺ�������ѧ
														System.out.println(rs.getString("o_no")+" ��ͧ�����ҧ4 �ջ���ѵԡ���Դ��ͧẺ�� ��ͧ�������");
												}else{
													if( rs_h3.getString("End") == null ){
														if( rs_h3.getString("No_account") == no){
															System.out.println(rs.getString("o_no")+" ��ͧ��ҧ4 ");
															ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
															status[Integer.parseInt(rs.getString("n_no"))] = "�բ�����ͧ�͡����-"+rs.getString("o_no");
														}else{
															System.out.println(rs.getString("o_no")+" ��ͧ�����ҧ5 �ջ���ѵԡ���Դ��ͧẺ�� ��ͧ�������");
														}
													}else{
															System.out.println(rs.getString("o_no")+" ��ͧ��ҧ6 ");
															ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
															status[Integer.parseInt(rs.getString("n_no"))] = "�բ�����ͧ�͡����-"+rs.getString("o_no");
													}
												}
											}else{
												ResultSet rs_h3 = db.getData("No,End","history","No_overtime = "+rs.getString("o_no"));
												rs_h3.next();
												if( rs_h3.getRow() == 0){ // ����ͧ�������ջ���ѵԡ���Դ��ͧẺ�������ѧ
													System.out.println(rs.getString("o_no")+" ��ͧ��ҧ3");
													ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
													status[Integer.parseInt(rs.getString("n_no"))] = "�բ�����ͧ�͡����-"+rs.getString("o_no");
												}else{
													if( rs_h3.getString("End") == null ){
														System.out.println(rs.getString("o_no")+" ��ͧ��ҧ5 ");
														ch_send[Integer.parseInt(rs.getString("n_no"))] = '1';
														status[Integer.parseInt(rs.getString("n_no"))] = "�բ�����ͧ�͡����-"+rs.getString("o_no");
													}else{
														System.out.println(rs.getString("o_no")+" ��ͧ�����ҧ3  �ջ���ѵԡ���Դ��ͧẺ�� ��ͧ�������");
													}
												}
											}
										}else{
											System.out.println(rs.getString("o_no")+" ��ͧ�����ҧ");
										}
									}
								}
								}else{
									System.out.println("�Դ���������");
								}
							}

							/*---------------------------------------------------------------------------------------------------------------------------------*/
							
							/*---------------------------------�����Ţ������Է���Դ-----------------------------------------------*/
							for (int i = 1; i <= 12 ;i++){
								System.out.println("["+ch_send[i]+","+status[i]+"]");
							}
							/*---------------------------------------------------------------------------------------------*/
							
							/*---------------------------------�������Ţ��ѧ micro-----------------------------------------------*/
							for (int i = 0 ;i<=12 ; i++){
								while(gpio.pin_input(2) == PinState.LOW){}
								s_port.send_data(ch_send[i]);
							}
							System.out.println();
							/*------------------------------------------------------------------------------------------------*/
							
							/*---------------------------------�Ѻ��ҡ�Ѻ micro-----------------------------------------------*/
							while(gpio.pin_input(1) == PinState.LOW){}
								 ch_read = s_port.read_data();
								for (int j = 0; j < 12 ; j++){
									System.out.print(ch_read[j]);
								}
							System.out.println();
							/*------------------------------------------------------------------------------------------------*/
						
							/*---------------------------------��Ǩ�ͺ����Դ������ͻԴ���-----------------------------------------------*/
							for (int i = 1; i <= 12 ;i++){
								if(ch_send[i] == '1'){ // �Դ����˹���ҧ
									String st[] = status[i].split("-"); // st = ʶҹ�,��ͧ,���ҧ�͹,���������
									if(st[0].equals("���͹")){
										rs = db.getData("Max(No) as max","history","`End` is null and `No_numberlocker` = "+i);
										rs.next();
										if(ch_read[i-1] == '0'){// ��Ժ�ح�
											if(rs.getString("max") == null){ // ������ѹ�֡
												if( Double.parseDouble(st[3]) >= Double.parseDouble(clock[0]+"."+clock[1]) ){ // ����͹�ç����
													sql = String.format("%s,%s,%s,%s,%s,%s,%s,'%s',%s,'%s','%s'",null,no,st[1],st[2],0,year,term,date+" "+time,null,"����͹�ç����",null); // ���� date time ***********************************************
													db.insertData("history",sql);
												}else{ // ����͹���
													sql = String.format("%s,%s,%s,%s,%s,%s,%s,'%s',%s,'%s','%s'",null,no,st[1],st[2],0,year,term,date+" "+time,null,"����͹���",null); // ���� date time ***********************************************
													db.insertData("history",sql);
												}
												System.out.println("������ѹ�֡����");
											}else{
												System.out.println("��Ժ�����");
											}
										}else{// �׹�ح�
											rs = db.getData("No", "history", "end is null and Status = 'empty' and No_numberlocker = "+i);
											rs.next();
											if( rs.getRow() > 0){
												db.updateData("history","end ='"+date+" "+time+"'","No = "+rs.getString("No"));
											}else{
												db.updateData("history","end ='"+date+" "+time+"'","No = "+st[1]);
											}	
										}									
									}else if(st[0].equals("�բ�����ͧ�͡����")){
										System.out.println("������ͧ�͡����");
										rs = db.getData("Max(No) as max","history","`End` is null and `No_overtime` = "+st[1]);
										rs.next();
										if(ch_read[i-1] == '0'){// ��Ժ�ح�
											if(rs.getString("max") == null){ // ������ѹ�֡
												sql = String.format("%s,%s,%s,%s,%s,%s,%s,'%s',%s,'%s','%s'",null,no,"0","0",st[1],year,term,date+" "+time,null,"��",null); // ���� date time ***********************************************
												db.insertData("history",sql);
												System.out.println("������ѹ�֡����");
											}else{
												System.out.println("��Ժ�����");
											}
										}else{// �׹�ح�
											db.updateData("history","end ='"+date+" "+time+"'","No = "+h_remind[i]);
										}										
									}else if(st[0].equals("empty")){
										int num = 0;
										if(ch_read[i-1] == '0'){// ��Ժ�ح�
											ResultSet rs_st = db.getData("No", "history", "End is null and No_numberlocker = "+i);
											rs_st.next();
											if( rs_st.getRow() > 0){ // ��ͧ�����Դ �յ��ҧ�͹�Դ�����ֻ���
												num += 1;
											}
											
											sql = "End is null and number_locker.No = "+i;
											ResultSet rs_ot = db.getData_Join("history.No", "history", "`overtime_room` on `history`.`No_overtime`= `overtime_room`.No join `number_locker` on `overtime_room`.Room = `number_locker`.Number_Room",sql);
											rs_ot.next();
											if( rs_ot.getRow() > 0){ // ��ͧ�����Դ �յ��ҧ�͹�Դ�����ֻ���
												num += 1;
											}
											
											if( num == 0){ // ��ͧ���2�Դ�����ֻ���
												sql = String.format("%s,%s,%s,%s,%s,%s,%s,'%s',%s,'%s','%s'",null,no,i,"0","0",year,term,date+" "+time,null,"empty",null); // ���� date time ***********************************************
												db.insertData("history",sql);
												System.out.println("������ѹ�֡����2");
											}else{
												System.out.println("��Ժ�����");
											}
										}else{// �׹�ح�
											ResultSet rs_st = db.getData("No", "history", "End is null and No_numberlocker = "+i);
											rs_st.next();
											if( rs_st.getRow() > 0){ // ��ͧ����յ��ҧ�͹���� empty
												rs_st.beforeFirst();
												while(rs_st.next()){
													db.updateData("history","end ='"+date+" "+time+"'","No = "+rs_st.getString("No"));
												}
											}
											
											sql = "End is null and number_locker.No = "+i;
											ResultSet rs_ot = db.getData_Join("history.No", "history", "`overtime_room` on `history`.`No_overtime`= `overtime_room`.No join `number_locker` on `overtime_room`.Room = `number_locker`.Number_Room",sql);
											rs_ot.next();
											if( rs_ot.getRow() > 0){ // ��ͧ����Ẻ��
												rs_ot.beforeFirst();
												while(rs_ot.next()){
													db.updateData("history","end ='"+date+" "+time+"'","No = "+rs_ot.getString("history.No"));
												}
											}	
										}	
									}
								}else{
									System.out.println("������Դ");
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
