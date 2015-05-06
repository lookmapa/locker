
unsigned char str[13];
int count =1,i=1,flag=0;

void interrupt();
void reset_value();
void reset_port();
void open_led();

 void main() {

     ANSEL  = 0;
     ANSELH = 0;
     TRISA = 0b11111111;
     TRISB = 0b00111111;
     TRISC = 0b10000000;
     TRISD = 0b00000000;
     INTCON.GIE = 1;
     INTCON.PEIE = 1;
     PIE1.RCIE = 1;
     UART1_Init(9600);
     reset_port();
     reset_value();
      
      while(1){

                if(flag == 1){
                      open_led();
                      reset_value();
                }
                 delay_ms(500);
       }
}

void reset_port(){
      PORTC.F0 =  PORTC.F1 = PORTC.F2 = PORTC.F3 = PORTC.F4 = PORTC.F5 = 0;
      PORTD.F0 = PORTD.F1 = PORTD.F2 = PORTD.F3 = PORTD.F4 = PORTD.F5 = 0;
}

void reset_value(){
      PORTD.F6 = 1;
      count = 1;
      flag = 0;
}

void open_led(){
      for ( i = 1; i< 13 ; i++){
                     if(str[i] == '1' ){
                           if(i == 1){
                                 PORTC.F0 = 1;
                           }else if(i == 2){
                                 PORTC.F1 = 1;
                           }else if(i == 3){
                                 PORTC.F2 = 1;
                           }else if(i == 4){
                                 PORTC.F3 = 1;
                           }else if(i == 5){
                                 PORTD.F0 = 1;
                           }else if(i == 6){
                                 PORTD.F1 = 1;
                           }else if(i == 7){
                                 PORTD.F2 = 1;
                           }else if(i == 8){
                                 PORTD.F3 = 1;
                           }else if(i == 9){
                                 PORTC.F4 = 1;
                           }else if(i == 10){
                                 PORTC.F5 = 1;
                           }else if(i == 11){
                                 PORTD.F4 = 1;
                           }else if(i == 12){
                                 PORTD.F5 = 1;
                           }
                     }else{
                           if(i == 1){
                                 PORTC.F0 = 0;
                           }else if(i == 2){
                                 PORTC.F1 = 0;
                           }else if(i == 3){
                                 PORTC.F2 = 0;
                           }else if(i == 4){
                                 PORTC.F3 = 0;
                           }else if(i == 5){
                                 PORTD.F0 = 0;
                           }else if(i == 6){
                                 PORTD.F1 = 0;
                           }else if(i == 7){
                                 PORTD.F2 = 0;
                           }else if(i == 8){
                                 PORTD.F3 = 0;
                           }else if(i == 9){
                                 PORTC.F4 = 0;
                           }else if(i == 10){
                                 PORTC.F5 = 0;
                           }else if(i == 11){
                                 PORTD.F4 = 0;
                           }else if(i == 12){
                                 PORTD.F5 = 0;
                           }
                     }
      }
}

void interrupt(){
     if(PIR1.RCIF) {
        PORTD.F6 = 0;
            while(UART1_Data_Ready() == 1){
                 str[count] = UART1_Read();
                 count++;
                 if(count == 13){
                    PORTD.F6 = 0;
                    flag = 1;
                 }else{
                    PORTD.F6 = 1;
                 }
           }
      }
}