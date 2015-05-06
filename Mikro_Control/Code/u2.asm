
_main:

;u2.c,6 :: 		void main(){
;u2.c,8 :: 		ANSEL  = 0;
	CLRF       ANSEL+0
;u2.c,9 :: 		ANSELH = 0;
	CLRF       ANSELH+0
;u2.c,10 :: 		TRISA = 0b11111111;
	MOVLW      255
	MOVWF      TRISA+0
;u2.c,11 :: 		TRISB = 0b00111111;
	MOVLW      63
	MOVWF      TRISB+0
;u2.c,12 :: 		TRISC = 0b10111111;
	MOVLW      191
	MOVWF      TRISC+0
;u2.c,13 :: 		TRISD = 0b01111111;
	MOVLW      127
	MOVWF      TRISD+0
;u2.c,14 :: 		UART1_Init(9600);
	MOVLW      25
	MOVWF      SPBRG+0
	BSF        TXSTA+0, 2
	CALL       _UART1_Init+0
;u2.c,16 :: 		while(1){
L_main0:
;u2.c,17 :: 		if(PORTA.F0 == 1 && PORTA.F1 == 1 && PORTA.F2 == 1 && PORTA.F3 == 1 && PORTA.F4 == 1 && PORTA.F5 == 1
	BTFSS      PORTA+0, 0
	GOTO       L_main4
	BTFSS      PORTA+0, 1
	GOTO       L_main4
	BTFSS      PORTA+0, 2
	GOTO       L_main4
	BTFSS      PORTA+0, 3
	GOTO       L_main4
	BTFSS      PORTA+0, 4
	GOTO       L_main4
	BTFSS      PORTA+0, 5
	GOTO       L_main4
;u2.c,18 :: 		&& PORTB.F0 == 1 && PORTB.F1 == 1 && PORTB.F2 == 1 && PORTB.F3 == 1 && PORTB.F4 == 1 && PORTB.F5 == 1){
	BTFSS      PORTB+0, 0
	GOTO       L_main4
	BTFSS      PORTB+0, 1
	GOTO       L_main4
	BTFSS      PORTB+0, 2
	GOTO       L_main4
	BTFSS      PORTB+0, 3
	GOTO       L_main4
	BTFSS      PORTB+0, 4
	GOTO       L_main4
	BTFSS      PORTB+0, 5
	GOTO       L_main4
L__main59:
;u2.c,19 :: 		PORTD.F7 = 1;
	BSF        PORTD+0, 7
;u2.c,20 :: 		}else{
	GOTO       L_main5
L_main4:
;u2.c,21 :: 		PORTD.F7 = 0;
	BCF        PORTD+0, 7
;u2.c,22 :: 		}
L_main5:
;u2.c,24 :: 		check_key();
	CALL       _check_key+0
;u2.c,25 :: 		delay_ms(500);
	MOVLW      3
	MOVWF      R11+0
	MOVLW      138
	MOVWF      R12+0
	MOVLW      85
	MOVWF      R13+0
L_main6:
	DECFSZ     R13+0, 1
	GOTO       L_main6
	DECFSZ     R12+0, 1
	GOTO       L_main6
	DECFSZ     R11+0, 1
	GOTO       L_main6
	NOP
	NOP
;u2.c,27 :: 		}
	GOTO       L_main0
;u2.c,28 :: 		}
L_end_main:
	GOTO       $+0
; end of _main

_check_key:

;u2.c,30 :: 		void check_key(){
;u2.c,31 :: 		for(i = 1; i < 13; i++){
	MOVLW      1
	MOVWF      _i+0
	MOVLW      0
	MOVWF      _i+1
L_check_key7:
	MOVLW      128
	XORWF      _i+1, 0
	MOVWF      R0+0
	MOVLW      128
	SUBWF      R0+0, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key62
	MOVLW      13
	SUBWF      _i+0, 0
L__check_key62:
	BTFSC      STATUS+0, 0
	GOTO       L_check_key8
;u2.c,32 :: 		while(PORTD.F6 == 0){}
L_check_key10:
	BTFSC      PORTD+0, 6
	GOTO       L_check_key11
	GOTO       L_check_key10
L_check_key11:
;u2.c,33 :: 		if(i == 1){
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key63
	MOVLW      1
	XORWF      _i+0, 0
L__check_key63:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key12
;u2.c,34 :: 		if(PORTC.F0 == 1){
	BTFSS      PORTC+0, 0
	GOTO       L_check_key13
;u2.c,35 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,36 :: 		}else{
	GOTO       L_check_key14
L_check_key13:
;u2.c,37 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,38 :: 		}
L_check_key14:
;u2.c,39 :: 		}else if (i == 2){
	GOTO       L_check_key15
L_check_key12:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key64
	MOVLW      2
	XORWF      _i+0, 0
L__check_key64:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key16
;u2.c,40 :: 		if(PORTC.F1 == 1){
	BTFSS      PORTC+0, 1
	GOTO       L_check_key17
;u2.c,41 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,42 :: 		}else{
	GOTO       L_check_key18
L_check_key17:
;u2.c,43 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,44 :: 		}
L_check_key18:
;u2.c,45 :: 		}else if (i == 3){
	GOTO       L_check_key19
L_check_key16:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key65
	MOVLW      3
	XORWF      _i+0, 0
L__check_key65:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key20
;u2.c,46 :: 		if(PORTC.F2 == 1){
	BTFSS      PORTC+0, 2
	GOTO       L_check_key21
;u2.c,47 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,48 :: 		}else{
	GOTO       L_check_key22
L_check_key21:
;u2.c,49 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,50 :: 		}
L_check_key22:
;u2.c,51 :: 		}else if (i == 4){
	GOTO       L_check_key23
L_check_key20:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key66
	MOVLW      4
	XORWF      _i+0, 0
L__check_key66:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key24
;u2.c,52 :: 		if(PORTC.F3 == 1){
	BTFSS      PORTC+0, 3
	GOTO       L_check_key25
;u2.c,53 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,54 :: 		}else{
	GOTO       L_check_key26
L_check_key25:
;u2.c,55 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,56 :: 		}
L_check_key26:
;u2.c,57 :: 		}else if (i == 5){
	GOTO       L_check_key27
L_check_key24:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key67
	MOVLW      5
	XORWF      _i+0, 0
L__check_key67:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key28
;u2.c,58 :: 		if(PORTD.F0 == 1){
	BTFSS      PORTD+0, 0
	GOTO       L_check_key29
;u2.c,59 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,60 :: 		}else{
	GOTO       L_check_key30
L_check_key29:
;u2.c,61 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,62 :: 		}
L_check_key30:
;u2.c,63 :: 		}else if (i == 6){
	GOTO       L_check_key31
L_check_key28:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key68
	MOVLW      6
	XORWF      _i+0, 0
L__check_key68:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key32
;u2.c,64 :: 		if(PORTD.F1 == 1){
	BTFSS      PORTD+0, 1
	GOTO       L_check_key33
;u2.c,65 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,66 :: 		}else{
	GOTO       L_check_key34
L_check_key33:
;u2.c,67 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,68 :: 		}
L_check_key34:
;u2.c,69 :: 		}else if (i == 7){
	GOTO       L_check_key35
L_check_key32:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key69
	MOVLW      7
	XORWF      _i+0, 0
L__check_key69:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key36
;u2.c,70 :: 		if(PORTD.F2 == 1){
	BTFSS      PORTD+0, 2
	GOTO       L_check_key37
;u2.c,71 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,72 :: 		}else{
	GOTO       L_check_key38
L_check_key37:
;u2.c,73 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,74 :: 		}
L_check_key38:
;u2.c,75 :: 		}else if (i == 8){
	GOTO       L_check_key39
L_check_key36:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key70
	MOVLW      8
	XORWF      _i+0, 0
L__check_key70:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key40
;u2.c,76 :: 		if(PORTD.F3 == 1){
	BTFSS      PORTD+0, 3
	GOTO       L_check_key41
;u2.c,77 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,78 :: 		}else{
	GOTO       L_check_key42
L_check_key41:
;u2.c,79 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,80 :: 		}
L_check_key42:
;u2.c,81 :: 		}else if (i == 9){
	GOTO       L_check_key43
L_check_key40:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key71
	MOVLW      9
	XORWF      _i+0, 0
L__check_key71:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key44
;u2.c,82 :: 		if(PORTC.F4 == 1){
	BTFSS      PORTC+0, 4
	GOTO       L_check_key45
;u2.c,83 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,84 :: 		}else{
	GOTO       L_check_key46
L_check_key45:
;u2.c,85 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,86 :: 		}
L_check_key46:
;u2.c,87 :: 		}else if (i == 10){
	GOTO       L_check_key47
L_check_key44:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key72
	MOVLW      10
	XORWF      _i+0, 0
L__check_key72:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key48
;u2.c,88 :: 		if(PORTC.F5 == 1){
	BTFSS      PORTC+0, 5
	GOTO       L_check_key49
;u2.c,89 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,90 :: 		}else{
	GOTO       L_check_key50
L_check_key49:
;u2.c,91 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,92 :: 		}
L_check_key50:
;u2.c,93 :: 		}else if (i == 11){
	GOTO       L_check_key51
L_check_key48:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key73
	MOVLW      11
	XORWF      _i+0, 0
L__check_key73:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key52
;u2.c,94 :: 		if(PORTD.F4 == 1){
	BTFSS      PORTD+0, 4
	GOTO       L_check_key53
;u2.c,95 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,96 :: 		}else{
	GOTO       L_check_key54
L_check_key53:
;u2.c,97 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,98 :: 		}
L_check_key54:
;u2.c,99 :: 		}else if (i == 12){
	GOTO       L_check_key55
L_check_key52:
	MOVLW      0
	XORWF      _i+1, 0
	BTFSS      STATUS+0, 2
	GOTO       L__check_key74
	MOVLW      12
	XORWF      _i+0, 0
L__check_key74:
	BTFSS      STATUS+0, 2
	GOTO       L_check_key56
;u2.c,100 :: 		if(PORTD.F5 == 1){
	BTFSS      PORTD+0, 5
	GOTO       L_check_key57
;u2.c,101 :: 		UART1_Write('1') ;
	MOVLW      49
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,102 :: 		}else{
	GOTO       L_check_key58
L_check_key57:
;u2.c,103 :: 		UART1_Write('0') ;
	MOVLW      48
	MOVWF      FARG_UART1_Write_data_+0
	CALL       _UART1_Write+0
;u2.c,104 :: 		}
L_check_key58:
;u2.c,105 :: 		}
L_check_key56:
L_check_key55:
L_check_key51:
L_check_key47:
L_check_key43:
L_check_key39:
L_check_key35:
L_check_key31:
L_check_key27:
L_check_key23:
L_check_key19:
L_check_key15:
;u2.c,31 :: 		for(i = 1; i < 13; i++){
	INCF       _i+0, 1
	BTFSC      STATUS+0, 2
	INCF       _i+1, 1
;u2.c,106 :: 		}
	GOTO       L_check_key7
L_check_key8:
;u2.c,109 :: 		}
L_end_check_key:
	RETURN
; end of _check_key
