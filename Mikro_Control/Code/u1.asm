
_main:

;u1.c,16 :: 		void main() {
;u1.c,18 :: 		ANSEL  = 0;
	CLRF       ANSEL+0
;u1.c,19 :: 		ANSELH = 0;
	CLRF       ANSELH+0
;u1.c,20 :: 		TRISA = 0b11111111;
	MOVLW      255
	MOVWF      TRISA+0
;u1.c,21 :: 		TRISB = 0b00111111;
	MOVLW      63
	MOVWF      TRISB+0
;u1.c,22 :: 		TRISC = 0b10000001;
	MOVLW      129
	MOVWF      TRISC+0
;u1.c,23 :: 		TRISD = 0b00000000;
	CLRF       TRISD+0
;u1.c,24 :: 		INTCON.GIE = 1;
	BSF        INTCON+0, 7
;u1.c,25 :: 		INTCON.PEIE = 1;
	BSF        INTCON+0, 6
;u1.c,26 :: 		PIE1.RCIE = 1;
	BSF        PIE1+0, 5
;u1.c,27 :: 		UART1_Init(9600);
	MOVLW      25
	MOVWF      SPBRG+0
	BSF        TXSTA+0, 2
	CALL       _UART1_Init+0
;u1.c,28 :: 		Sound_Init(&PORTB, 6);
	MOVLW      PORTB+0
	MOVWF      FARG_Sound_Init_snd_port+0
	MOVLW      6
	MOVWF      FARG_Sound_Init_snd_pin+0
	CALL       _Sound_Init+0
;u1.c,29 :: 		reset_value();
	CALL       _reset_value+0
;u1.c,31 :: 		while(1){
L_main0:
;u1.c,32 :: 		if(flag == 1){
	MOVLW      0
	XORWF      _flag+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__main127
	MOVLW      1
	XORWF      _flag+0, 0
L__main127:
	BTFSS      STATUS+0, 2
	GOTO       L_main2
;u1.c,33 :: 		if(ch == 'p'){
	MOVF       _ch+0, 0
	XORLW      112
	BTFSS      STATUS+0, 2
	GOTO       L_main3
;u1.c,34 :: 		sound_pas();
	CALL       _sound_pas+0
;u1.c,35 :: 		sound_stop();
	CALL       _sound_stop+0
;u1.c,36 :: 		}else if (ch == 'n'){
	GOTO       L_main4
L_main3:
	MOVF       _ch+0, 0
	XORLW      110
	BTFSS      STATUS+0, 2
	GOTO       L_main5
;u1.c,37 :: 		PORTB.F7 = 1;
	BSF        PORTB+0, 7
;u1.c,38 :: 		sound_not();
	CALL       _sound_not+0
;u1.c,39 :: 		sound_stop();
	CALL       _sound_stop+0
;u1.c,40 :: 		}else{
	GOTO       L_main6
L_main5:
;u1.c,41 :: 		open_door();
	CALL       _open_door+0
;u1.c,42 :: 		while(PORTC.F0 == 0){
L_main7:
	BTFSC      PORTC+0, 0
	GOTO       L_main8
;u1.c,43 :: 		sound_warning();
	CALL       _sound_warning+0
;u1.c,44 :: 		}
	GOTO       L_main7
L_main8:
;u1.c,45 :: 		sound_stop();
	CALL       _sound_stop+0
;u1.c,46 :: 		check_key();
	CALL       _check_key+0
;u1.c,47 :: 		}
L_main6:
L_main4:
;u1.c,48 :: 		reset_value();
	CALL       _reset_value+0
;u1.c,49 :: 		}
L_main2:
;u1.c,50 :: 		delay_ms(1000);
	MOVLW      6
	MOVWF      R11+0
	MOVLW      19
	MOVWF      R12+0
	MOVLW      173
	MOVWF      R13+0
L_main9:
	DECFSZ     R13+0, 1
	GOTO       L_main9
	DECFSZ     R12+0, 1
	GOTO       L_main9
	DECFSZ     R11+0, 1
	GOTO       L_main9
	NOP
	NOP
;u1.c,51 :: 		}
	GOTO       L_main0
;u1.c,52 :: 		}
L_end_main:
	GOTO       $+0
; end of _main

_sound_pas:

;u1.c,54 :: 		void sound_pas(){
;u1.c,55 :: 		Sound_Play(2750, 300);
	MOVLW      190
	MOVWF      FARG_Sound_Play_freq_in_hz+0
	MOVLW      10
	MOVWF      FARG_Sound_Play_freq_in_hz+1
	MOVLW      44
	MOVWF      FARG_Sound_Play_duration_ms+0
	MOVLW      1
	MOVWF      FARG_Sound_Play_duration_ms+1
	CALL       _Sound_Play+0
;u1.c,56 :: 		}
L_end_sound_pas:
	RETURN
; end of _sound_pas

_sound_not:

;u1.c,58 :: 		void sound_not(){
;u1.c,59 :: 		Sound_Play(2750, 250);
	MOVLW      190
	MOVWF      FARG_Sound_Play_freq_in_hz+0
	MOVLW      10
	MOVWF      FARG_Sound_Play_freq_in_hz+1
	MOVLW      250
	MOVWF      FARG_Sound_Play_duration_ms+0
	CLRF       FARG_Sound_Play_duration_ms+1
	CALL       _Sound_Play+0
;u1.c,60 :: 		Delay_ms(100);
	MOVLW      130
	MOVWF      R12+0
	MOVLW      221
	MOVWF      R13+0
L_sound_not10:
	DECFSZ     R13+0, 1
	GOTO       L_sound_not10
	DECFSZ     R12+0, 1
	GOTO       L_sound_not10
	NOP
	NOP
;u1.c,61 :: 		Sound_Play(2750, 250);
	MOVLW      190
	MOVWF      FARG_Sound_Play_freq_in_hz+0
	MOVLW      10
	MOVWF      FARG_Sound_Play_freq_in_hz+1
	MOVLW      250
	MOVWF      FARG_Sound_Play_duration_ms+0
	CLRF       FARG_Sound_Play_duration_ms+1
	CALL       _Sound_Play+0
;u1.c,62 :: 		}
L_end_sound_not:
	RETURN
; end of _sound_not

_sound_warning:

;u1.c,64 :: 		void sound_warning(){
;u1.c,65 :: 		Sound_Play(2750, 300);
	MOVLW      190
	MOVWF      FARG_Sound_Play_freq_in_hz+0
	MOVLW      10
	MOVWF      FARG_Sound_Play_freq_in_hz+1
	MOVLW      44
	MOVWF      FARG_Sound_Play_duration_ms+0
	MOVLW      1
	MOVWF      FARG_Sound_Play_duration_ms+1
	CALL       _Sound_Play+0
;u1.c,66 :: 		}
L_end_sound_warning:
	RETURN
; end of _sound_warning

_sound_stop:

;u1.c,68 :: 		void sound_stop(){
;u1.c,69 :: 		Sound_Play(0, 0);
	CLRF       FARG_Sound_Play_freq_in_hz+0
	CLRF       FARG_Sound_Play_freq_in_hz+1
	CLRF       FARG_Sound_Play_duration_ms+0
	CLRF       FARG_Sound_Play_duration_ms+1
	CALL       _Sound_Play+0
;u1.c,70 :: 		}
L_end_sound_stop:
	RETURN
; end of _sound_stop

_reset_value:

;u1.c,72 :: 		void reset_value(){
;u1.c,73 :: 		PORTD.F0 =  PORTD.F1 = PORTD.F2 = PORTD.F3 = PORTD.F4 = PORTD.F5 = PORTD.F6 = PORTD.F7 = 1;
	BSF        PORTD+0, 7
	BTFSC      PORTD+0, 7
	GOTO       L__reset_value133
	BCF        PORTD+0, 6
	GOTO       L__reset_value134
L__reset_value133:
	BSF        PORTD+0, 6
L__reset_value134:
	BTFSC      PORTD+0, 6
	GOTO       L__reset_value135
	BCF        PORTD+0, 5
	GOTO       L__reset_value136
L__reset_value135:
	BSF        PORTD+0, 5
L__reset_value136:
	BTFSC      PORTD+0, 5
	GOTO       L__reset_value137
	BCF        PORTD+0, 4
	GOTO       L__reset_value138
L__reset_value137:
	BSF        PORTD+0, 4
L__reset_value138:
	BTFSC      PORTD+0, 4
	GOTO       L__reset_value139
	BCF        PORTD+0, 3
	GOTO       L__reset_value140
L__reset_value139:
	BSF        PORTD+0, 3
L__reset_value140:
	BTFSC      PORTD+0, 3
	GOTO       L__reset_value141
	BCF        PORTD+0, 2
	GOTO       L__reset_value142
L__reset_value141:
	BSF        PORTD+0, 2
L__reset_value142:
	BTFSC      PORTD+0, 2
	GOTO       L__reset_value143
	BCF        PORTD+0, 1
	GOTO       L__reset_value144
L__reset_value143:
	BSF        PORTD+0, 1
L__reset_value144:
	BTFSC      PORTD+0, 1
	GOTO       L__reset_value145
	BCF        PORTD+0, 0
	GOTO       L__reset_value146
L__reset_value145:
	BSF        PORTD+0, 0
L__reset_value146:
;u1.c,74 :: 		PORTC.F2 = PORTC.F3 = PORTC.F4 = PORTC.F5 = 1;
	BSF        PORTC+0, 5
	BTFSC      PORTC+0, 5
	GOTO       L__reset_value147
	BCF        PORTC+0, 4
	GOTO       L__reset_value148
L__reset_value147:
	BSF        PORTC+0, 4
L__reset_value148:
	BTFSC      PORTC+0, 4
	GOTO       L__reset_value149
	BCF        PORTC+0, 3
	GOTO       L__reset_value150
L__reset_value149:
	BSF        PORTC+0, 3
L__reset_value150:
	BTFSC      PORTC+0, 3
	GOTO       L__reset_value151
	BCF        PORTC+0, 2
	GOTO       L__reset_value152
L__reset_value151:
	BSF        PORTC+0, 2
L__reset_value152:
;u1.c,75 :: 		PORTB.F7 = 0;
	BCF        PORTB+0, 7
;u1.c,76 :: 		PORTC.F1 =  1;
	BSF        PORTC+0, 1
;u1.c,77 :: 		count = 1;
	MOVLW      1
	MOVWF      _count+0
	MOVLW      0
	MOVWF      _count+1
;u1.c,78 :: 		flag = 0;
	CLRF       _flag+0
	CLRF       _flag+1
;u1.c,79 :: 		}
L_end_reset_value:
	RETURN
; end of _reset_value

_open_door:

;u1.c,81 :: 		void open_door(){
;u1.c,82 :: 		for ( i = 1; i< 13 ; i++){
	MOVLW      1
	MOVWF      _i+0
	MOVLW      0
	MOVWF      _i+1
L_open_door11:
	MOVLW      128
	XORWF      _i+1, 0
	MOVWF      R0+0
	MOVLW      128
	SUBWF      R0+0, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door154
	MOVLW      13
	SUBWF      _i+0, 0
L__open_door154:
	BTFSC      STATUS+0, 0
	GOTO       L_open_door12
;u1.c,83 :: 		if(str[i] == '1' ){
	MOVF       _i+0, 0
	ADDLW      _str+0
	MOVWF      FSR
	MOVF       INDF+0, 0
	XORLW      49
	BTFSS      STATUS+0, 2
	GOTO       L_open_door14
;u1.c,84 :: 		if(i == 1){
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door155
	MOVLW      1
	XORWF      _i+0, 0
L__open_door155:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door15
;u1.c,85 :: 		PORTC.F2 = 0;
	BCF        PORTC+0, 2
;u1.c,86 :: 		}else if(i == 2){
	GOTO       L_open_door16
L_open_door15:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door156
	MOVLW      2
	XORWF      _i+0, 0
L__open_door156:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door17
;u1.c,87 :: 		PORTC.F3 = 0;
	BCF        PORTC+0, 3
;u1.c,88 :: 		}else if(i == 3){
	GOTO       L_open_door18
L_open_door17:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door157
	MOVLW      3
	XORWF      _i+0, 0
L__open_door157:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door19
;u1.c,89 :: 		PORTD.F0 = 0;
	BCF        PORTD+0, 0
;u1.c,90 :: 		}else if(i == 4){
	GOTO       L_open_door20
L_open_door19:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door158
	MOVLW      4
	XORWF      _i+0, 0
L__open_door158:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door21
;u1.c,91 :: 		PORTD.F1 = 0;
	BCF        PORTD+0, 1
;u1.c,92 :: 		}else if(i == 5){
	GOTO       L_open_door22
L_open_door21:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door159
	MOVLW      5
	XORWF      _i+0, 0
L__open_door159:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door23
;u1.c,93 :: 		PORTD.F2 = 0;
	BCF        PORTD+0, 2
;u1.c,94 :: 		}else if(i == 6){
	GOTO       L_open_door24
L_open_door23:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door160
	MOVLW      6
	XORWF      _i+0, 0
L__open_door160:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door25
;u1.c,95 :: 		PORTD.F3 = 0;
	BCF        PORTD+0, 3
;u1.c,96 :: 		}else if(i == 7){
	GOTO       L_open_door26
L_open_door25:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door161
	MOVLW      7
	XORWF      _i+0, 0
L__open_door161:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door27
;u1.c,97 :: 		PORTC.F4 = 0;
	BCF        PORTC+0, 4
;u1.c,98 :: 		}else if(i == 8){
	GOTO       L_open_door28
L_open_door27:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door162
	MOVLW      8
	XORWF      _i+0, 0
L__open_door162:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door29
;u1.c,99 :: 		PORTC.F5 = 0;
	BCF        PORTC+0, 5
;u1.c,100 :: 		}else if(i == 9){
	GOTO       L_open_door30
L_open_door29:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door163
	MOVLW      9
	XORWF      _i+0, 0
L__open_door163:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door31
;u1.c,101 :: 		PORTD.F4 = 0;
	BCF        PORTD+0, 4
;u1.c,102 :: 		}else if(i == 10){
	GOTO       L_open_door32
L_open_door31:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door164
	MOVLW      10
	XORWF      _i+0, 0
L__open_door164:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door33
;u1.c,103 :: 		PORTD.F5 = 0;
	BCF        PORTD+0, 5
;u1.c,104 :: 		}else if(i == 11){
	GOTO       L_open_door34
L_open_door33:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door165
	MOVLW      11
	XORWF      _i+0, 0
L__open_door165:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door35
;u1.c,105 :: 		PORTD.F6 = 0;
	BCF        PORTD+0, 6
;u1.c,106 :: 		}else if(i == 12){
	GOTO       L_open_door36
L_open_door35:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door166
	MOVLW      12
	XORWF      _i+0, 0
L__open_door166:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door37
;u1.c,107 :: 		PORTD.F7 = 0;
	BCF        PORTD+0, 7
;u1.c,108 :: 		}
L_open_door37:
L_open_door36:
L_open_door34:
L_open_door32:
L_open_door30:
L_open_door28:
L_open_door26:
L_open_door24:
L_open_door22:
L_open_door20:
L_open_door18:
L_open_door16:
;u1.c,109 :: 		}else{
	GOTO       L_open_door38
L_open_door14:
;u1.c,110 :: 		if(i == 1){
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door167
	MOVLW      1
	XORWF      _i+0, 0
L__open_door167:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door39
;u1.c,111 :: 		PORTC.F2 = 1;
	BSF        PORTC+0, 2
;u1.c,112 :: 		}else if(i == 2){
	GOTO       L_open_door40
L_open_door39:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door168
	MOVLW      2
	XORWF      _i+0, 0
L__open_door168:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door41
;u1.c,113 :: 		PORTC.F3 = 1;
	BSF        PORTC+0, 3
;u1.c,114 :: 		}else if(i == 3){
	GOTO       L_open_door42
L_open_door41:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door169
	MOVLW      3
	XORWF      _i+0, 0
L__open_door169:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door43
;u1.c,115 :: 		PORTD.F0 = 1;
	BSF        PORTD+0, 0
;u1.c,116 :: 		}else if(i == 4){
	GOTO       L_open_door44
L_open_door43:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door170
	MOVLW      4
	XORWF      _i+0, 0
L__open_door170:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door45
;u1.c,117 :: 		PORTD.F1 = 1;
	BSF        PORTD+0, 1
;u1.c,118 :: 		}else if(i == 5){
	GOTO       L_open_door46
L_open_door45:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door171
	MOVLW      5
	XORWF      _i+0, 0
L__open_door171:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door47
;u1.c,119 :: 		PORTD.F2 = 1;
	BSF        PORTD+0, 2
;u1.c,120 :: 		}else if(i == 6){
	GOTO       L_open_door48
L_open_door47:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door172
	MOVLW      6
	XORWF      _i+0, 0
L__open_door172:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door49
;u1.c,121 :: 		PORTD.F3 = 1;
	BSF        PORTD+0, 3
;u1.c,122 :: 		}else if(i == 7){
	GOTO       L_open_door50
L_open_door49:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door173
	MOVLW      7
	XORWF      _i+0, 0
L__open_door173:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door51
;u1.c,123 :: 		PORTC.F4 = 1;
	BSF        PORTC+0, 4
;u1.c,124 :: 		}else if(i == 8){
	GOTO       L_open_door52
L_open_door51:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door174
	MOVLW      8
	XORWF      _i+0, 0
L__open_door174:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door53
;u1.c,125 :: 		PORTC.F5 = 1;
	BSF        PORTC+0, 5
;u1.c,126 :: 		}else if(i == 9){
	GOTO       L_open_door54
L_open_door53:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door175
	MOVLW      9
	XORWF      _i+0, 0
L__open_door175:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door55
;u1.c,127 :: 		PORTD.F4 = 1;
	BSF        PORTD+0, 4
;u1.c,128 :: 		}else if(i == 10){
	GOTO       L_open_door56
L_open_door55:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door176
	MOVLW      10
	XORWF      _i+0, 0
L__open_door176:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door57
;u1.c,129 :: 		PORTD.F5 = 1;
	BSF        PORTD+0, 5
;u1.c,130 :: 		}else if(i == 11){
	GOTO       L_open_door58
L_open_door57:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door177
	MOVLW      11
	XORWF      _i+0, 0
L__open_door177:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door59
;u1.c,131 :: 		PORTD.F6 = 1;
	BSF        PORTD+0, 6
;u1.c,132 :: 		}else if(i == 12){
	GOTO       L_open_door60
L_open_door59:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__open_door178
	MOVLW      12
	XORWF      _i+0, 0
L__open_door178:
	BTFSS      STATUS+0, 2
	GOTO       L_open_door61
;u1.c,133 :: 		PORTD.F7 = 1;
	BSF        PORTD+0, 7
;u1.c,134 :: 		}
L_open_door61:
L_open_door60:
L_open_door58:
L_open_door56:
L_open_door54:
L_open_door52:
L_open_door50:
L_open_door48:
L_open_door46:
L_open_door44:
L_open_door42:
L_open_door40:
;u1.c,135 :: 		}
L_open_door38:
;u1.c,82 :: 		for ( i = 1; i< 13 ; i++){
	INCF       _i+0, 1
	BTFSC      STATUS+0, 2
	INCF       _i+1, 1
;u1.c,136 :: 		}
	GOTO       L_open_door11
L_open_door12:
;u1.c,137 :: 		delay_ms(5000);
	MOVLW      26
	MOVWF      R11+0
	MOVLW      94
	MOVWF      R12+0
	MOVLW      110
	MOVWF      R13+0
L_open_door62:
	DECFSZ     R13+0, 1
	GOTO       L_open_door62
	DECFSZ     R12+0, 1
	GOTO       L_open_door62
	DECFSZ     R11+0, 1
	GOTO       L_open_door62
	NOP
;u1.c,138 :: 		}
L_end_open_door:
	RETURN
; end of _open_door

_check_key:

;u1.c,141 :: 		void check_key(){
;u1.c,142 :: 		PORTB.F7 = 1;
	BSF        PORTB+0, 7
;u1.c,143 :: 		for(i = 1; i < 13; i++){
	MOVLW      1
	MOVWF      _i+0
	MOVLW      0
	MOVWF      _i+1
L_check_key63:
	MOVLW      128
	XORWF      _i+1, 0
	MOVWF      R0+0
	MOVLW      128
	SUBWF      R0+0, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key180
	MOVLW      13
	SUBWF      _i+0, 0
L__check_key180:
	BTFSC      STATUS+0, 0
	GOTO       L_check_key64
;u1.c,144 :: 		if(i == 1){
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key181
	MOVLW      1
	XORWF      _i+0, 0
L__check_key181:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key66
;u1.c,145 :: 		if(PORTA.F0 == 1){
	BTFSS      PORTA+0, 0
	GOTO       L_check_key67
;u1.c,146 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,147 :: 		}else{
	GOTO       L_check_key68
L_check_key67:
;u1.c,148 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,149 :: 		}
L_check_key68:
;u1.c,150 :: 		}else if (i == 2){
	GOTO       L_check_key69
L_check_key66:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key182
	MOVLW      2
	XORWF      _i+0, 0
L__check_key182:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key70
;u1.c,151 :: 		if(PORTA.F1 == 1){
	BTFSS      PORTA+0, 1
	GOTO       L_check_key71
;u1.c,152 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,153 :: 		}else{
	GOTO       L_check_key72
L_check_key71:
;u1.c,154 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,155 :: 		}
L_check_key72:
;u1.c,156 :: 		}else if (i == 3){
	GOTO       L_check_key73
L_check_key70:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key183
	MOVLW      3
	XORWF      _i+0, 0
L__check_key183:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key74
;u1.c,157 :: 		if(PORTA.F2 == 1){
	BTFSS      PORTA+0, 2
	GOTO       L_check_key75
;u1.c,158 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,159 :: 		}else{
	GOTO       L_check_key76
L_check_key75:
;u1.c,160 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,161 :: 		}
L_check_key76:
;u1.c,162 :: 		}else if (i == 4){
	GOTO       L_check_key77
L_check_key74:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key184
	MOVLW      4
	XORWF      _i+0, 0
L__check_key184:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key78
;u1.c,163 :: 		if(PORTA.F3 == 1){
	BTFSS      PORTA+0, 3
	GOTO       L_check_key79
;u1.c,164 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,165 :: 		}else{
	GOTO       L_check_key80
L_check_key79:
;u1.c,166 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,167 :: 		}
L_check_key80:
;u1.c,168 :: 		}else if (i == 5){
	GOTO       L_check_key81
L_check_key78:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key185
	MOVLW      5
	XORWF      _i+0, 0
L__check_key185:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key82
;u1.c,169 :: 		if(PORTA.F4 == 1){
	BTFSS      PORTA+0, 4
	GOTO       L_check_key83
;u1.c,170 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,171 :: 		}else{
	GOTO       L_check_key84
L_check_key83:
;u1.c,172 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,173 :: 		}
L_check_key84:
;u1.c,174 :: 		}else if (i == 6){
	GOTO       L_check_key85
L_check_key82:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key186
	MOVLW      6
	XORWF      _i+0, 0
L__check_key186:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key86
;u1.c,175 :: 		if(PORTA.F5 == 1){
	BTFSS      PORTA+0, 5
	GOTO       L_check_key87
;u1.c,176 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,177 :: 		}else{
	GOTO       L_check_key88
L_check_key87:
;u1.c,178 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,179 :: 		}
L_check_key88:
;u1.c,180 :: 		}else if (i == 7){
	GOTO       L_check_key89
L_check_key86:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key187
	MOVLW      7
	XORWF      _i+0, 0
L__check_key187:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key90
;u1.c,181 :: 		if(PORTB.F0 == 1){
	BTFSS      PORTB+0, 0
	GOTO       L_check_key91
;u1.c,182 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,183 :: 		}else{
	GOTO       L_check_key92
L_check_key91:
;u1.c,184 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,185 :: 		}
L_check_key92:
;u1.c,186 :: 		}else if (i == 8){
	GOTO       L_check_key93
L_check_key90:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key188
	MOVLW      8
	XORWF      _i+0, 0
L__check_key188:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key94
;u1.c,187 :: 		if(PORTB.F1 == 1){
	BTFSS      PORTB+0, 1
	GOTO       L_check_key95
;u1.c,188 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,189 :: 		}else{
	GOTO       L_check_key96
L_check_key95:
;u1.c,190 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,191 :: 		}
L_check_key96:
;u1.c,192 :: 		}else if (i == 9){
	GOTO       L_check_key97
L_check_key94:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key189
	MOVLW      9
	XORWF      _i+0, 0
L__check_key189:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key98
;u1.c,193 :: 		if(PORTB.F2 == 1){
	BTFSS      PORTB+0, 2
	GOTO       L_check_key99
;u1.c,194 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,195 :: 		}else{
	GOTO       L_check_key100
L_check_key99:
;u1.c,196 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,197 :: 		}
L_check_key100:
;u1.c,198 :: 		}else if (i == 10){
	GOTO       L_check_key101
L_check_key98:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key190
	MOVLW      10
	XORWF      _i+0, 0
L__check_key190:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key102
;u1.c,199 :: 		if(PORTB.F3 == 1){
	BTFSS      PORTB+0, 3
	GOTO       L_check_key103
;u1.c,200 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,201 :: 		}else{
	GOTO       L_check_key104
L_check_key103:
;u1.c,202 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,203 :: 		}
L_check_key104:
;u1.c,204 :: 		}else if (i == 11){
	GOTO       L_check_key105
L_check_key102:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key191
	MOVLW      11
	XORWF      _i+0, 0
L__check_key191:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key106
;u1.c,205 :: 		if(PORTB.F4 == 1){
	BTFSS      PORTB+0, 4
	GOTO       L_check_key107
;u1.c,206 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,207 :: 		}else{
	GOTO       L_check_key108
L_check_key107:
;u1.c,208 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,209 :: 		}
L_check_key108:
;u1.c,210 :: 		}else if (i == 12){
	GOTO       L_check_key109
L_check_key106:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key192
	MOVLW      12
	XORWF      _i+0, 0
L__check_key192:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key110
;u1.c,211 :: 		if(PORTB.F5 == 1){
	BTFSS      PORTB+0, 5
	GOTO       L_check_key111
;u1.c,212 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,213 :: 		}else{
	GOTO       L_check_key112
L_check_key111:
;u1.c,214 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u1.c,215 :: 		}
L_check_key112:
;u1.c,216 :: 		}
L_check_key110:
L_check_key109:
L_check_key105:
L_check_key101:
L_check_key97:
L_check_key93:
L_check_key89:
L_check_key85:
L_check_key81:
L_check_key77:
L_check_key73:
L_check_key69:
;u1.c,143 :: 		for(i = 1; i < 13; i++){
	INCF       _i+0, 1
	BTFSC      STATUS+0, 2
	INCF       _i+1, 1
;u1.c,217 :: 		}
	GOTO       L_check_key63
L_check_key64:
;u1.c,218 :: 		PORTB.F7 = 0;
	BCF        PORTB+0, 7
;u1.c,220 :: 		}
L_end_check_key:
	RETURN
; end of _check_key

_interrupt:
	MOVWF      R15+0
	SWAPF      STATUS+0, 0
	CLRF       STATUS+0
	MOVWF      ___saveSTATUS+0
	MOVF       PCLATH+0, 0
	MOVWF      ___savePCLATH+0
	CLRF       PCLATH+0

;u1.c,222 :: 		void interrupt(){
;u1.c,223 :: 		if(PIR1.RCIF) {
	BTFSS      PIR1+0, 5
	GOTO       L_interrupt113
;u1.c,224 :: 		while(UART1_Data_Ready() == 1){
L_interrupt114:
	CALL       _UART1_Data_Ready+0
	MOVF       R0+0, 0
	XORLW      1
	BTFSS      STATUS+0, 2
	GOTO       L_interrupt115
;u1.c,225 :: 		PORTC.F1 = 0;
	BCF        PORTC+0, 1
;u1.c,226 :: 		if( count == 1){
	MOVLW      0
	XORWF      _count+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__interrupt195
	MOVLW      1
	XORWF      _count+0, 0
L__interrupt195:
	BTFSS      STATUS+0, 2
	GOTO       L_interrupt116
;u1.c,227 :: 		ch = UART1_Read();
	CALL       _UART1_Read+0
	MOVF       R0+0, 0
	MOVWF      _ch+0
;u1.c,228 :: 		count++;
	INCF       _count+0, 1
	BTFSC      STATUS+0, 2
	INCF       _count+1, 1
;u1.c,229 :: 		}else{
	GOTO       L_interrupt117
L_interrupt116:
;u1.c,230 :: 		if(ch == 'r'){
	MOVF       _ch+0, 0
	XORLW      114
	BTFSS      STATUS+0, 2
	GOTO       L_interrupt118
;u1.c,231 :: 		str[count-1] = UART1_Read();
	MOVLW      1
	SUBWF      _count+0, 0
	MOVWF      R0+0
	MOVLW      0
	BTFSS      STATUS+0, 0
	ADDLW      1
	SUBWF      _count+1, 0
	MOVWF      R0+1
	MOVF       R0+0, 0
	ADDLW      _str+0
	MOVWF      FLOC__interrupt+0
	CALL       _UART1_Read+0
	MOVF       FLOC__interrupt+0, 0
	MOVWF      FSR
	MOVF       R0+0, 0
	MOVWF      INDF+0
;u1.c,232 :: 		count++;
	INCF       _count+0, 1
	BTFSC      STATUS+0, 2
	INCF       _count+1, 1
;u1.c,233 :: 		}
L_interrupt118:
;u1.c,234 :: 		}
L_interrupt117:
;u1.c,236 :: 		if(ch == 'p'){
	MOVF       _ch+0, 0
	XORLW      112
	BTFSS      STATUS+0, 2
	GOTO       L_interrupt119
;u1.c,237 :: 		count = 14;
	MOVLW      14
	MOVWF      _count+0
	MOVLW      0
	MOVWF      _count+1
;u1.c,238 :: 		}else if(ch == 'n'){
	GOTO       L_interrupt120
L_interrupt119:
	MOVF       _ch+0, 0
	XORLW      110
	BTFSS      STATUS+0, 2
	GOTO       L_interrupt121
;u1.c,239 :: 		count = 14;
	MOVLW      14
	MOVWF      _count+0
	MOVLW      0
	MOVWF      _count+1
;u1.c,240 :: 		}else if (ch != 'r'){
	GOTO       L_interrupt122
L_interrupt121:
	MOVF       _ch+0, 0
	XORLW      114
	BTFSC      STATUS+0, 2
	GOTO       L_interrupt123
;u1.c,241 :: 		count = 1;
	MOVLW      1
	MOVWF      _count+0
	MOVLW      0
	MOVWF      _count+1
;u1.c,242 :: 		}
L_interrupt123:
L_interrupt122:
L_interrupt120:
;u1.c,244 :: 		if(count == 14){
	MOVLW      0
	XORWF      _count+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__interrupt196
	MOVLW      14
	XORWF      _count+0, 0
L__interrupt196:
	BTFSS      STATUS+0, 2
	GOTO       L_interrupt124
;u1.c,245 :: 		PORTC.F1 = 0;
	BCF        PORTC+0, 1
;u1.c,246 :: 		flag = 1;
	MOVLW      1
	MOVWF      _flag+0
	MOVLW      0
	MOVWF      _flag+1
;u1.c,247 :: 		}else{
	GOTO       L_interrupt125
L_interrupt124:
;u1.c,248 :: 		PORTC.F1 = 1;
	BSF        PORTC+0, 1
;u1.c,249 :: 		}
L_interrupt125:
;u1.c,250 :: 		}
	GOTO       L_interrupt114
L_interrupt115:
;u1.c,251 :: 		}
L_interrupt113:
;u1.c,252 :: 		}
L_end_interrupt:
L__interrupt194:
	MOVF       ___savePCLATH+0, 0
	MOVWF      PCLATH+0
	SWAPF      ___saveSTATUS+0, 0
	MOVWF      STATUS+0
	SWAPF      R15+0, 1
	SWAPF      R15+0, 0
	RETFIE
; end of _interrupt
