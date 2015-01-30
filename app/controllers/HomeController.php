<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		$researchCase = ResearchCaseDim::lists('name', 'researchcasekey');
		$cases = ResearchCaseDim::caseData();
		// echo "<pre>";
		// var_dump($cases);
		// echo "</pre>";
		// return View::make('blank_page');
		return View::make('home/homepage2')
					->with('researchCase',$researchCase)
					->with('cases',$cases);
	}

	public function exportReport()
	{
		$pdf = new FPDF();
 
		// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวธรรมดา กำหนด ชื่อ เป็น angsana
		$pdf->AddFont('angsana','','angsa.php');
		 
		// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
		$pdf->AddFont('angsana','B','angsab.php');
		 
		// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
		$pdf->AddFont('angsana','I','angsai.php');
		 
		// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น angsana
		$pdf->AddFont('angsana','BI','angsaz.php');
		 
		//สร้างหน้าเอกสาร
		$pdf->AddPage();
		 
		// กำหนดฟอนต์ที่จะใช้  อังสนา ตัวธรรมดา ขนาด 12
		$pdf->SetFont('angsana','',12);
		// พิมพ์ข้อความลงเอกสาร
		$pdf->setXY( 10, 10  );
		$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'อังสนา ตัวธรรมดา ขนาด 12' ) );
		 
		$pdf->SetFont('angsana','B',16);
		$pdf->setXY( 10, 20  );
		$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'อังสนา ตัวหนา ขนาด 16' )  );
		 
		$pdf->SetFont('angsana','I',24);
		$pdf->setXY( 10, 30  );
		$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'อังสนา ตัวเอียง ขนาด 24' )  );
		 
		$pdf->SetFont('angsana','BI',32);
		$pdf->setXY( 10, 40  );
		$pdf->MultiCell( 0  , 0 , iconv( 'UTF-8','cp874' , 'อังสนา ตัวหนาเอียง ขนาด 32' )  );
		 
		$pdf->Output();
		exit;

		// $fpdf = new FPDF();
  //       $fpdf->AddPage();
  //       $fpdf->SetFont('Arial','B',16);
  //       $fpdf->Cell(40,10,'Hello World!');
  //       $fpdf->Output();
  //       exit;
	}

}
