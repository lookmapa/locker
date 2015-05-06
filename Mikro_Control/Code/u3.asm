
_main:

;u3.c,10 :: 		void main() {
;u3.c,12 :: 		ANSEL  = 0;
	CLRF       ANSEL+0
;u3.c,13 :: 		ANSELH = 0;
	CLRF       ANSELH+0
;u3.c,14 :: 		TRISA = 0b11111111;
	MOVLW      255
	MOVWF      TRISA+0
;u3.c,15 :: 		TRISB = 0b00111111;
	MOVLW      63
	MOVWF      TRISB+0
;u3.c,16 :: 		TRISC = 0b10000000;
	MOVLW      128
	MOVWF      TRISC+0
;u3.c,17 :: 		TRISD = 0b00000000;
	CLRF       TRISD+0
;u3.c,18 :: 		INTCON.GIE = 1;
	BSF        INTCON+0, 7
;u3.c,19 :: 		INTCON.PEIE = 1;
	BSF        INTCON+0, 6
;u3.c,20 :: 		PIE1.RCIE = 1;
	BSF        PIE1+0, 5
;u3.c,21 :: 		UART1_Init(9600);
	MOVLW      25
	MOVWF      SPBRG+0
	BSF        TXSTA+0, 2
	CALL       _UART1_Init+0
;u3.c,22 :: 		reset_port();
	CALL       _reset_port+0
;u3.c,23 :: 		reset_value();
	CALL       _reset_value+0
;u3.c,25 :: 		while(1){
L_main0:
;u3.c,27 :: 		if(flag == 1){
	MOVLW      0
	XORWF      _flag+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__main61
	MOVLW      1
	XORWF      _flag+0, 0
L__main61:
	BTFSS      STATUS+0, 2
	GOTO       L_main2
;u3.c,28 :: 		open_led();
	CALL       _open_led+0
;u3.c,29 :: 		reset_value();
	CALL       _reset_value+0
;u3.c,30 :: 		}
L_main2:
;u3.c,31 :: 		delay_ms(500);
	MOVLW      3
	MOVWF      R11+0
	MOVLW      138
	MOVWF      R12+0
	MOVLW      85
	MOVWF      R13+0
L_main3:
	DECFSZ     R13+0, 1
	GOTO       L_main3
	DECFSZ     R12+0, 1
	GOTO       L_main3
	DECFSZ     R11+0, 1
	GOTO       L_main3
	NOP
	NOP
;u3.c,32 :: 		}
	GOTO       L_main0
;u3.c,33 :: 		}
L_end_main:
	GOTO       $+0
; end of _main

_reset_port:

;u3.c,35 :: 		void reset_port(){
;u3.c,36 :: 		PORTC.F0 =  PORTC.F1 = PORTC.F2 = PORTC.F3 = PORTC.F4 = PORTC.F5 = 0;
	BCF        PORTC+0, 5
	BTFSC      PORTC+0, 5
	GOTO       L__reset_port63
	BCF        PORTC+0, 4
	GOTO       L__reset_port64
L__reset_port63:
	BSF        PORTC+0, 4
L__reset_port64:
	BTFSC      PORTC+0, 4
	GOTO       L__reset_port65
	BCF        PORTC+0, 3
	GOTO       L__reset_port66
L__reset_port65:
	BSF        PORTC+0, 3
L__reset_port66:
	BTFSC      PORTC+0, 3
	GOTO       L__reset_port67
	BCF        PORTC+0, 2
	GOTO       L__reset_port68
L__reset_port67:
	BSF        PORTC+0, 2
L__reset_port68:
	BTFSC      PORTC+0, 2
	GOTO       L__reset_port69
	BCF        PORTC+0, 1
	GOTO       L__reset_port70
L__reset_port69:
	BSF        PORTC+0, 1
L__reset_port70:
	BTFSC      PORTC+0, 1
	GOTO       L__reset_port71
	BCF        PORTC+0, 0
	GOTO       L__reset_port72
L__reset_port71:
	BSF        PORTC+0, 0
L__reset_port72:
;u3.c,37 :: 		PORTD.F0 = PORTD.F1 = PORTD.F2 = PORTD.F3 = PORTD.F4 = PORTD.F5 = 0;
	BCF        PORTD+0, 5
	BTFSC      PORTD+0, 5
	GOTO       L__reset_port73
	BCF        PORTD+0, 4
	GOTO       L__reset_port74
L__reset_port73:
	BSF        PORTD+0, 4
L__reset_port74:
	BTFSC      PORTD+0, 4
	GOTO       L__reset_port75
	BCF        PORTD+0, 3
	GOTO       L__reset_port76
L__reset_port75:
	BSF        PORTD+0, 3
L__reset_port76:
	BTFSC      PORTD+0, 3
	GOTO       L__reset_port77
	BCF        PORTD+0, 2
	GOTO       L__reset_port78
L__reset_port77:
	BSF        PORTD+0, 2
L__reset_port78:
	BTFSC      PORTD+0, 2
	GOTO       L__reset_port79
	BCF        PORTD+0, 1
	GOTO       L__reset_port80
L__reset_port79:
	BSF        PORTD+0, 1
L__reset_port80:
	BTFSC      PORTD+0, 1
	GOTO       L__reset_port81
	BCF        PORTD+0, 0
	GOTO       L__reset_port82
L__reset_port81:
	BSF        PORTD+0, 0
L__reset_port82:
;u3.c,38 :: 		}
L_end_reset_port:
	RETURN
; end of _reset_port

_reset_value:

;u3.c,40 :: 		void reset_value(){
;u3.c,41 :: 		PORTD.F6 = 1;
	BSF        PORTD+0, 6
;u3.c,42 :: 		count = 1;
	MOVLW      1
	MOVWF      _count+0
	MOVLW      0
	MOVWF      _count+1
;u3.c,43 :: 		flag = 0;
	CLRF       _flag+0
	CLRF       _flag+1
;u3.c,44 :: 		}
L_end_reset_value:
	RETURN
; end of _reset_value

_open_led:

;u3.c,46 :: 		void open_led(){
;u3.c,47 :: 		for ( i = 1; i< 13 ; i++){
	MOVLW      1
	MOVWF      _i+0
	MOVLW      0
	MOVWF      _i+1
L_open_led4:
	MOVLW      128
	XORWF      _i+1, 0
	MOVWF      R0+0
	MOVLW      128
	SUBWF      R0+0, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led85
	MOVLW      13
	SUBWF      _i+0, 0
L__open_led85:
	BTFSC      STATUS+0, 0
	GOTO       L_open_led5
;u3.c,48 :: 		if(str[i] == '1' ){
	MOVF       _i+0, 0
	ADDLW      _str+0
	MOVWF      FSR
	MOVF       INDF+0, 0
	XORLW      49
	BTFSS      STATUS+0, 2
	GOTO       L_open_led7
;u3.c,49 :: 		if(i == 1){
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led86
	MOVLW      1
	XORWF      _i+0, 0
L__open_led86:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led8
;u3.c,50 :: 		PORTC.F0 = 1;
	BSF        PORTC+0, 0
;u3.c,51 :: 		}else if(i == 2){
	GOTO       L_open_led9
L_open_led8:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led87
	MOVLW      2
	XORWF      _i+0, 0
L__open_led87:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led10
;u3.c,52 :: 		PORTC.F1 = 1;
	BSF        PORTC+0, 1
;u3.c,53 :: 		}else if(i == 3){
	GOTO       L_open_led11
L_open_led10:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led88
	MOVLW      3
	XORWF      _i+0, 0
L__open_led88:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led12
;u3.c,54 :: 		PORTC.F2 = 1;
	BSF        PORTC+0, 2
;u3.c,55 :: 		}else if(i == 4){
	GOTO       L_open_led13
L_open_led12:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led89
	MOVLW      4
	XORWF      _i+0, 0
L__open_led89:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led14
;u3.c,56 :: 		PORTC.F3 = 1;
	BSF        PORTC+0, 3
;u3.c,57 :: 		}else if(i == 5){
	GOTO       L_open_led15
L_open_led14:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led90
	MOVLW      5
	XORWF      _i+0, 0
L__open_led90:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led16
;u3.c,58 :: 		PORTD.F0 = 1;
	BSF        PORTD+0, 0
;u3.c,59 :: 		}else if(i == 6){
	GOTO       L_open_led17
L_open_led16:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led91
	MOVLW      6
	XORWF      _i+0, 0
L__open_led91:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led18
;u3.c,60 :: 		PORTD.F1 = 1;
	BSF        PORTD+0, 1
;u3.c,61 :: 		}else if(i == 7){
	GOTO       L_open_led19
L_open_led18:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led92
	MOVLW      7
	XORWF      _i+0, 0
L__open_led92:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led20
;u3.c,62 :: 		PORTD.F2 = 1;
	BSF        PORTD+0, 2
;u3.c,63 :: 		}else if(i == 8){
	GOTO       L_open_led21
L_open_led20:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led93
	MOVLW      8
	XORWF      _i+0, 0
L__open_led93:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led22
;u3.c,64 :: 		PORTD.F3 = 1;
	BSF        PORTD+0, 3
;u3.c,65 :: 		}else if(i == 9){
	GOTO       L_open_led23
L_open_led22:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led94
	MOVLW      9
	XORWF      _i+0, 0
L__open_led94:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led24
;u3.c,66 :: 		PORTC.F4 = 1;
	BSF        PORTC+0, 4
;u3.c,67 :: 		}else if(i == 10){
	GOTO       L_open_led25
L_open_led24:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led95
	MOVLW      10
	XORWF      _i+0, 0
L__open_led95:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led26
;u3.c,68 :: 		PORTC.F5 = 1;
	BSF        PORTC+0, 5
;u3.c,69 :: 		}else if(i == 11){
	GOTO       L_open_led27
L_open_led26:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led96
	MOVLW      11
	XORWF      _i+0, 0
L__open_led96:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led28
;u3.c,70 :: 		PORTD.F4 = 1;
	BSF        PORTD+0, 4
;u3.c,71 :: 		}else if(i == 12){
	GOTO       L_open_led29
L_open_led28:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led97
	MOVLW      12
	XORWF      _i+0, 0
L__open_led97:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led30
;u3.c,72 :: 		PORTD.F5 = 1;
	BSF        PORTD+0, 5
;u3.c,73 :: 		}
L_open_led30:
L_open_led29:
L_open_led27:
L_open_led25:
L_open_led23:
L_open_led21:
L_open_led19:
L_open_led17:
L_open_led15:
L_open_led13:
L_open_led11:
L_open_led9:
;u3.c,74 :: 		}else{
	GOTO       L_open_led31
L_open_led7:
;u3.c,75 :: 		if(i == 1){
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led98
	MOVLW      1
	XORWF      _i+0, 0
L__open_led98:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led32
;u3.c,76 :: 		PORTC.F0 = 0;
	BCF        PORTC+0, 0
;u3.c,77 :: 		}else if(i == 2){
	GOTO       L_open_led33
L_open_led32:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led99
	MOVLW      2
	XORWF      _i+0, 0
L__open_led99:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led34
;u3.c,78 :: 		PORTC.F1 = 0;
	BCF        PORTC+0, 1
;u3.c,79 :: 		}else if(i == 3){
	GOTO       L_open_led35
L_open_led34:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led100
	MOVLW      3
	XORWF      _i+0, 0
L__open_led100:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led36
;u3.c,80 :: 		PORTC.F2 = 0;
	BCF        PORTC+0, 2
;u3.c,81 :: 		}else if(i == 4){
	GOTO       L_open_led37
L_open_led36:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led101
	MOVLW      4
	XORWF      _i+0, 0
L__open_led101:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led38
;u3.c,82 :: 		PORTC.F3 = 0;
	BCF        PORTC+0, 3
;u3.c,83 :: 		}else if(i == 5){
	GOTO       L_open_led39
L_open_led38:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led102
	MOVLW      5
	XORWF      _i+0, 0
L__open_led102:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led40
;u3.c,84 :: 		PORTD.F0 = 0;
	BCF        PORTD+0, 0
;u3.c,85 :: 		}else if(i == 6){
	GOTO       L_open_led41
L_open_led40:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led103
	MOVLW      6
	XORWF      _i+0, 0
L__open_led103:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led42
;u3.c,86 :: 		PORTD.F1 = 0;
	BCF        PORTD+0, 1
;u3.c,87 :: 		}else if(i == 7){
	GOTO       L_open_led43
L_open_led42:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led104
	MOVLW      7
	XORWF      _i+0, 0
L__open_led104:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led44
;u3.c,88 :: 		PORTD.F2 = 0;
	BCF        PORTD+0, 2
;u3.c,89 :: 		}else if(i == 8){
	GOTO       L_open_led45
L_open_led44:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led105
	MOVLW      8
	XORWF      _i+0, 0
L__open_led105:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led46
;u3.c,90 :: 		PORTD.F3 = 0;
	BCF        PORTD+0, 3
;u3.c,91 :: 		}else if(i == 9){
	GOTO       L_open_led47
L_open_led46:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led106
	MOVLW      9
	XORWF      _i+0, 0
L__open_led106:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led48
;u3.c,92 :: 		PORTC.F4 = 0;
	BCF        PORTC+0, 4
;u3.c,93 :: 		}else if(i == 10){
	GOTO       L_open_led49
L_open_led48:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led107
	MOVLW      10
	XORWF      _i+0, 0
L__open_led107:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led50
;u3.c,94 :: 		PORTC.F5 = 0;
	BCF        PORTC+0, 5
;u3.c,95 :: 		}else if(i == 11){
	GOTO       L_open_led51
L_open_led50:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led108
	MOVLW      11
	XORWF      _i+0, 0
L__open_led108:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led52
;u3.c,96 :: 		PORTD.F4 = 0;
	BCF        PORTD+0, 4
;u3.c,97 :: 		}else if(i == 12){
	GOTO       L_open_led53
L_open_led52:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_led109
	MOVLW      12
	XORWF      _i+0, 0
L__open_led109:
	BTFSS      STATUS+0, 2
	GOTO       L_open_led54
;u3.c,98 :: 		PORTD.F5 = 0;
	BCF        PORTD+0, 5
;u3.c,99 :: 		}
L_open_led54:
L_open_led53:
L_open_led51:
L_open_led49:
L_open_led47:
L_open_led45:
L_open_led43:
L_open_led41:
L_open_led39:
L_open_led37:
L_open_led35:
L_open_led33:
;u3.c,100 :: 		}
L_open_led31:
;u3.c,47 :: 		for ( i = 1; i< 13 ; i++){
	INCF       _i+0, 1
	BTFSC      STATUS+0, 2
	INCF       _i+1, 1
;u3.c,101 :: 		}
	GOTO       L_open_led4
L_open_led5:
;u3.c,102 :: 		}
L_end_open_led:
	RETURN
; end of _open_led

_interrupt:
	MOVWF      R15+0
	SWAPF      STATUS+0, 0
	CLRF       STATUS+0
	MOVWF      ___saveSTATUS+0
	MOVF       PCLATH+0, 0
	MOVWF      ___savePCLATH+0
	CLRF       PCLATH+0

;u3.c,104 :: 		void interrupt(){
;u3.c,105 :: 		if(PIR1.RCIF) {
	BTFSS      PIR1+0, 5
	GOTO       L_interrupt55
;u3.c,106 :: 		PORTD.F6 = 0;
	BCF        PORTD+0, 6
;u3.c,107 :: 		while(UART1_Data_Ready() == 1){
L_interrupt56:
	CALL       _UART1_Data_Ready+0
	MOVF       R0+0, 0
	XORLW      1
	BTFSS      STATUS+0, 2
	GOTO       L_interrupt57
;u3.c,108 :: 		str[count] = UART1_Read();
	MOVF       _count+0, 0
	ADDLW      _str+0
	MOVWF      FLOC__interrupt+0
	CALL       _UART1_Read+0
	MOVF       FLOC__interrupt+0, 0
	MOVWF      FSR
	MOVF       R0+0, 0
	MOVWF      INDF+0
;u3.c,109 :: 		count++;
	INCF       _count+0, 1
	BTFSC      STATUS+0, 2
	INCF       _count+1, 1
;u3.c,110 :: 		if(count == 13){
	MOVLW      0
	XORWF      _count+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__interrupt112
	MOVLW      13
	XORWF      _count+0, 0
L__interrupt112:
	BTFSS      STATUS+0, 2
	GOTO       L_interrupt58
;u3.c,111 :: 		PORTD.F6 = 0;
	BCF        PORTD+0, 6
;u3.c,112 :: 		flag = 1;
	MOVLW      1
	MOVWF      _flag+0
	MOVLW      0
	MOVWF      _flag+1
;u3.c,113 :: 		}else{
	GOTO       L_interrupt59
L_interrupt58:
;u3.c,114 :: 		PORTD.F6 = 1;
	BSF        PORTD+0, 6
;u3.c,115 :: 		}
L_interrupt59:
;u3.c,116 :: 		}
	GOTO       L_interrupt56
L_interrupt57:
;u3.c,117 :: 		}
L_interrupt55:
;u3.c,118 :: 		}
L_end_interrupt:
L__interrupt111:
	MOVF       ___savePCLATH+0, 0
	MOVWF      PCLATH+0
	SWAPF      ___saveSTATUS+0, 0
	MOVWF      STATUS+0
	SWAPF      R15+0, 1
	SWAPF      R15+0, 0
	RETFIE
; end of _interrupt
