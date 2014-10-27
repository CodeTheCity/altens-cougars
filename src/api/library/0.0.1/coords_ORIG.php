<?php

if ( isset ( $_GET['room'] ) ) {

	switch ( $_GET['room'] ) {
	
		case 1:
		
			$data = array (
				array ( '1047', '411' ),
				array ( '1047', '228' ),
				array ( '1170', '228' ),
				array ( '1170', '411' ),
			);
		
		break;
		case 2:
		
			$data = array (
				array ( '704', '675' ),
				array ( '704', '208' ),
				array ( '1037', '208' ),
				array ( '1037', '674' ),
			);
		
		break;
		case 3:
		
			$data = array (
				array ( '297', '608' ),
				array ( '297', '210' ),
				array ( '453', '210' ),
				array ( '453', '550' ),
				array ( '420', '608' ),
			);
		
		break;
		case 4:
		
			$data = array (
				array ( '32', '674' ),
				array ( '33', '316' ),
				array ( '117', '316' ),
				array ( '117', '675' ),
			);
		
		break;
	
	}
	
	outputResponse ($data);

}

?>