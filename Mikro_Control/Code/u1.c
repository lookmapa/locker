unsigned char ch;
unsigned char str[13];
int count =1,i=1,flag=0;


void interrupt();
void reset_value();
void open_door();
void check_key();
void sound_pas();
void sound_not();
void sound_warning();
void sound_stop();


 void main() {

     ANSEL  = 0;
     ANSELH = 0;
     TRISA = 0b11111111;
     TRISB = 0b00111111;
     TRISC = 0b10000001;
     TRISD = 0b00000000;
     INTCON.GIE = 1;
     INTCON.PEIE = 1;
     PIE1.RCIE = 1;
     UART1_Init(9600);
     Sound_Init(&PORTB, 6);
     reset_value();
     
      while(1){
                if(flag == 1){
                        if(ch == 'p'){
                              sound_pas();
                              sound_stop();
                        }else if (ch == 'n'){
                              PORTB.F7 = 1;
                              sound_not();
                              sound_stop();
                        }else{
                              open_door();
                              while(PORTC.F0 == 0){
                                  sound_warning();
                              }
                              sound_stop();
                              check_key();
                        }
                        reset_value();
                }
                 delay_ms(1000);
       }
}

 void sound_pas(){
     Sound_Play(2750, 300);
}

void sound_not(){
     Sound_Play(2750, 250);
     Delay_ms(100);
     Sound_Play(2750, 250);
}

void sound_warning(){
     Sound_Play(2750, 300);
}

void sound_stop(){
     Sound_Play(0, 0);
}

void reset_value(){
      PORTD.F0 =  PORTD.F1 = PORTD.F2 = PORTD.F3 = PORTD.F4 = PORTD.F5 = PORTD.F6 = PORTD.F7 = 1;
      PORTC.F2 = PORTC.F3 = PORTC.F4 = PORTC.F5 = 1;
      PORTB.F7 = 0;
      PORTC.F1 =  1;
      count = 1;
      flag = 0;
}

void open_door(){
      for ( i = 1; i< 13 ; i++){
                     if(str[i] == '1' ){
                           if(i == 1){
                                 PORTC.F2 = 0;
                           }else if(i == 2){
                                 PORTC.F3 = 0;
                           }else if(i == 3){
                                 PORTD.F0 = 0;
                           }else if(i == 4){
                                 PORTD.F1 = 0;
                           }else if(i == 5){
                                 PORTD.F2 = 0;
                           }else if(i == 6){
                                 PORTD.F3 = 0;
                           }else if(i == 7){
                                 PORTC.F4 = 0;
                           }else if(i == 8){
                                 PORTC.F5 = 0;
                           }else if(i == 9){
                                 PORTD.F4 = 0;
                           }else if(i == 10){
                                 PORTD.F5 = 0;
                           }else if(i == 11){
                                 PORTD.F6 = 0;
                           }else if(i == 12){
                                 PORTD.F7 = 0;
                           }
                     }else{
                           if(i == 1){
                                 PORTC.F2 = 1;
                           }else if(i == 2){
                                 PORTC.F3 = 1;
                           }else if(i == 3){
                                 PORTD.F0 = 1;
                           }else if(i == 4){
                                 PORTD.F1 = 1;
                           }else if(i == 5){
                                 PORTD.F2 = 1;
                           }else if(i == 6){
                                 PORTD.F3 = 1;
                           }else if(i == 7){
                                 PORTC.F4 = 1;
                           }else if(i == 8){
                                 PORTC.F5 = 1;
                           }else if(i == 9){
                                 PORTD.F4 = 1;
                           }else if(i == 10){
                                 PORTD.F5 = 1;
                           }else if(i == 11){
                                 PORTD.F6 = 1;
                           }else if(i == 12){
                                 PORTD.F7 = 1;
                           }
                     }
      }
                 delay_ms(5000);
}


void check_key(){
     PORTB.F7 = 1;
     for(i = 1; i < 13; i++){
                if(i == 1){
                       if(PORTA.F0 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 2){
                       if(PORTA.F1 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 3){
                       if(PORTA.F2 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 4){
                       if(PORTA.F3 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 5){
                       if(PORTA.F4 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 6){
                       if(PORTA.F5 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 7){
                       if(PORTB.F0 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 8){
                       if(PORTB.F1 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 9){
                       if(PORTB.F2 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 10){
                       if(PORTB.F3 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 11){
                       if(PORTB.F4 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }else if (i == 12){
                       if(PORTB.F5 == 1){
                        UART1_Write('1') ;
                       }else{
                        UART1_Write('0') ;
                       }
                }
     }
     PORTB.F7 = 0;

}

void interrupt(){
     if(PIR1.RCIF) {
            while(UART1_Data_Ready() == 1){
                PORTC.F1 = 0;
                if( count == 1){
                     ch = UART1_Read();
                     count++;
                 }else{
                       if(ch == 'r'){
                             str[count-1] = UART1_Read();
                             count++;
                       }
                 }
                 
                 if(ch == 'p'){
                     count = 14;
                 }else if(ch == 'n'){
                     count = 14;
                 }else if (ch != 'r'){
                     count = 1;
                 }
                 
                 if(count == 14){
                    PORTC.F1 = 0;
                    flag = 1;
                 }else{
                    PORTC.F1 = 1;
                 }
           }
      }
}