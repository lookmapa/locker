package Rasp_Control;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class Connect_DB  {

private String url;    
private String id;
private String pass;
private String driver;
private Connection con;
private ResultSet rs;
private Statement stmt ;

Connect_DB(String driver,String url,String id,String pass) throws ClassNotFoundException, SQLException{
     this.url = url;
     this.id = id;
     this.pass = pass;
     this.driver = driver;
     Class.forName(this.driver);
     con = DriverManager.getConnection(this.url,this.id,this.pass);
}
      
      public void setURL(String url){
          this.url = url;
      }
     
      public void setID(String id){
          this.id = id;
      }
      
      public void setPASS(String pass){
          this.pass = pass;
      }
      
      public void setDRIVER(String driver) throws ClassNotFoundException{
          this.driver = driver;
          Class.forName(this.driver);
      }
     
      public void setConnect()throws SQLException{
            con = DriverManager.getConnection(url,id,pass);
      }
      
      public void close() throws SQLException{
          con.close();
      }
      
      public String getURL(){
          return url;    
      }
      
      public String getID(){
          return id;
      }
      
      public String getPASS(){
          return pass;
      }
      
      public String getDRIVER(){
          return driver;
      }
      public Connection getConnect(){
          return con;
      }
      
      public ResultSet getData(String field,String table)throws SQLException{  
           String SQL = String.format("SELECT %s FROM %s ",field,table);
           stmt = con.createStatement();
           rs = stmt.executeQuery(SQL);
        return rs;
      }
      
      public ResultSet getData(String field,String table,String where)throws SQLException{  
          String SQL = String.format("SELECT %s FROM %s WHERE %s",field,table,where);
          //System.out.println(SQL);
          stmt = con.createStatement();
          rs = stmt.executeQuery(SQL);
       return rs;
     }
      
     public ResultSet getData_Join(String field,String table,String table_join,String where) throws SQLException{
    	  String SQL = String.format("SELECT %s FROM %s join %s where %s",field,table,table_join,where);
    	  //System.out.println(SQL);
    	  stmt = con.createStatement();
          rs = stmt.executeQuery(SQL);
       return rs;   	 
     }
      
      
     public void insertData(String table,String data)throws SQLException{  
        String SQL = String.format("INSERT INTO %s VALUES(%s)",table,data);
        //System.out.println(SQL);
        stmt = con.createStatement();
        stmt.executeUpdate(SQL);
     }
     
     public void updateData(String table,String data,String where)throws SQLException{  
         String SQL = String.format("UPDATE %s SET %s WHERE %s",table,data,where);
         //System.out.println(SQL);
         stmt = con.createStatement();
         stmt.executeUpdate(SQL);
      }
} 

  