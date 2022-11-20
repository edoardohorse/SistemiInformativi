<?php
// require('./fpdf/fpdf.php');
require('./fpdf/mc_table.php');
require_once('./php/annuncio.php');
require_once('./php/preventivo.php');

$MARGIN_TOP = 10;
$MARGIN_LEFT = $MARGIN_RIGHT = 5;

function printTables($pdf, Annuncio $annuncio = null, Preventivo $preventivo = null){
    // Column headings
    $headerRiepilogo = array("Venditore", "Titolo", "Descrizione", "Luogo lavoro", "Dimensione Giardino", "Tempistica", "Scadenza");
    $headerServizio = array("Professionista","Descrizione", "Compenso",  "Totale");
    // Data loading
    $dataRiepilogo  = ["Giandomenico Monopoli", "Piantaggione zucchine", "Ho un campo di zucchine",
                        "Grottaglie", "15mq", "1 settimana", "08-01-2020"];

    $dataServizio   = ["Edoardo Cavallo", "Sono bravo con le zucchine", iconv('UTF-8', 'windows-1252', "150€"),iconv('UTF-8', 'windows-1252', "150€")];
    
    // header

    $pdf->Ln();
    $pdf->SetFillColor(239,244,239);
    $pdf->SetWidths([35,30,40,30,25,20,20]);
    $pdf->Row($headerRiepilogo,'DF');

    $pdf->SetWidths([35,30,40,30,25,20,20]);
    $pdf->SetAligns(['L','L','L','L','L','L','L']);
    $pdf->Row($dataRiepilogo);

    // data

    $pdf->Ln();
    $pdf->SetFillColor(239,244,239);
    $pdf->SetWidths([50,50,50,50]);
    $pdf->Row($headerServizio,'DF');

    $pdf->SetWidths([50,50,50,50]);
    $pdf->SetAligns(['L','L','L','L','L','L','L']);
    $pdf->Row($dataServizio);
}


class PDF extends PDF_MC_Table{

// Colored table
    function FancyTable($header, $data){
        global $MARGIN_TOP, $MARGIN_LEFT, $MARGIN_RIGHT;  

        // Colors, line width and bold font
        $this->SetFillColor(239,244,239);
        $this->SetTextColor(128,128,128);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');

        $margins = $MARGIN_LEFT + $MARGIN_RIGHT;
        // Header
        $w = ($this->GetPageWidth()-$margins)/count($header);
        var_dump($header,$data);
        
        $this->SetWidths([40,30,40,30,20,20,20]);
        $this->Row($header);

        // for($i=0;$i<count($header);$i++){
            /* $this->MultiCell($w,12,$header[$i],1,'C',true);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetXY($x + $w, $y); */
            // $this->MultiCell($w,12,$header[$i],1,0,'C',true);
        // }


    /*   $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        $w = ($this->GetPageWidth()-$margins)/count($data[0]);
        foreach($data as $row){
            // var_dump($row);
            foreach($row as $key=>$value){
                $this->Cell($w,6,$value,'LR',0,'L',$fill);
            }
            
            $this->Ln();
            $fill = !$fill;
        } */
        // Closing line
        $this->Cell(0,0,'','T');
    }
}

$pdf = new PDF();

$pdf->AddPage();
$pdf->SetFont("Arial",'',9);
$pdf->SetMargins($MARGIN_LEFT, $MARGIN_TOP, $MARGIN_RIGHT);
$pdf->SetAutoPageBreak(true);
// $pdf->FancyTable($headerRiepilogo,$dataRiepilogo);

printTables($pdf);

/* $pdf->Ln(2);
$pdf->FancyTable($headerServizio,$dataServizio); */

$pdf->Output();


?>