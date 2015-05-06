#line 1 "C:/Users/ApolloZa/Desktop/lockker/u2.c"

int i = 0;

void check_key();

void main(){

 ANSEL = 0;
 ANSELH = 0;
 TRISA = 0b11111111;
 TRISB = 0b00111111;
 TRISC = 0b10111111;
 TRISD = 0b01111111;
 UART1_Init(9600);

 while(1){
 if(PORTA.F0 == 1 && PORTA.F1 == 1 && PORTA.F2 == 1 && PORTA.F3 == 1 && PORTA.F4 == 1 && PORTA.F5 == 1
 && PORTB.F0 == 1 && PORTB.F1 == 1 && PORTB.F2 == 1 && PORTB.F3 == 1 && PORTB.F4 == 1 && PORTB.F5 == 1){
 PORTD.F7 = 1;
 }else{
 PORTD.F7 = 0;
 }

 check_key();
 delay_ms(500);

 }
}

void check_key(){
 for(i = 1; i < 13; i++){
 while(PORTD.F6 == 0){}
 if(i == 1){
 if(PORTC.F0 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 2){
 if(PORTC.F1 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 3){
 if(PORTC.F2 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 4){
 if(PORTC.F3 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 5){
 if(PORTD.F0 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 6){
 if(PORTD.F1 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 7){
 if(PORTD.F2 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 8){
 if(PORTD.F3 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 9){
 if(PORTC.F4 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 10){
 if(PORTC.F5 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 11){
 if(PORTD.F4 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }else if (i == 12){
 if(PORTD.F5 == 1){
 UART1_Write('1') ;
 }else{
 UART1_Write('0') ;
 }
 }
 }


}
