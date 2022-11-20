<?php
// require('./fpdf/fpdf.php');
require('./fpdf/mc_table.php');
require_once('./php/annuncio.php');
require_once('./php/preventivo.php');

// verde = 223,234,223;
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

global $pdf;

function convertUTF8($text){
    return iconv('UTF-8', 'windows-1252', $text);
}

function printTables(PDF_MC_Table $pdf, Annuncio $annuncio = null, Preventivo $preventivo = null){
    $pdf->Ln(50);
    $pdf->SetFont("Arial",'',9);
    $pdf->SetTextColor(0,0,0);
    // Column headings
    $headerRiepilogo = array("Venditore", "Titolo", "Descrizione", "Luogo lavoro", "Dimensione Giardino", "Tempistica", "Scadenza");
    $headerServizio = array("Professionista","Descrizione", "Compenso",  "Totale");
    // Data loading
    $dataRiepilogo  = ["Giandomenico Monopoli", "Piantaggione zucchine", "Ho un campo di zucchine",
                        "Grottaglie", "15mq", "1 settimana", "08-01-2020"];

    $dataServizio   = ["Edoardo Cavallo", "Sono bravo con le zucchine", convertUTF8("150€"),convertUTF8("150€")];
    
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
    $pdf->SetAligns(['C','C','C','C']);
    $pdf->Row($headerServizio,'DF',10);

    $pdf->SetWidths([50,50,50,50]);
    $pdf->SetAligns(['L','L','L','L','L','L','L']);
    $pdf->RowSerivzio($dataServizio, 'D', 70);
}

function SetTextColorNero(){
    global $pdf;
    $pdf->SetTextColor(0,0,0);
}

function SetTextColorVerde(){
    global $pdf;
    $pdf->SetTextColor(223,234,223);
}

function SetTextColorGrigio(){
    global $pdf;
    $pdf->SetTextColor(100,101,106);
}

function SetFontDefault($size = 9){
    global $pdf;
    $pdf->SetFont("Arial",'',$size);
}

function intestazione(PDF_MC_Table $pdf, Annuncio $annuncio){
    global $pdf;
    $pdf->Ln(20);
    $pdf->SetFont('Arial','B',40);
    SetTextColorVerde();
    $pdf->Image('./img/logo.png',5, 5, -300);
    $pdf->Text(120, 30, 'Preventivo');
    
    SetTextColorNero();
    SetFontDefault(15);
    $pdf->Text(120, 40, "Data: {$annuncio->getTimestamp()}");
    $pdf->Text(120, 47, "Data scadenza: {$annuncio->getScadenza()}");
    $pdf->Text(120, 54, convertUTF8("Preventivo N°: {$annuncio->getId()}"));
    
}

function initPdf(Annuncio $annuncio = null, Preventivo $preventivo = null){
    ob_clean();
    $MARGIN_TOP = 10; $MARGIN_LEFT = 5; $MARGIN_RIGHT = 5;

    global $pdf;
    
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetMargins($MARGIN_LEFT, $MARGIN_TOP, $MARGIN_RIGHT);
    $pdf->SetAutoPageBreak(true);
    
    
    intestazione($pdf, $annuncio);
    printTables($pdf, $annuncio, $preventivo);
    
    
    $pdf->Output();

    return $pdf;
}
    
    
?>