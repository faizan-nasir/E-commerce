<?php

use Fpdf\Fpdf;

/**
 * Class to generate Documents in PDF Format.
 */
class PDF {

  // Instance variable to use for PDF generation
  private $pdf;

  /**
   * Constructor to initialize Fpdf object
   */
  function __construct() {
    // Initializing Fpdf object and adding empty page to it.
    $this->pdf = new Fpdf();
    $this->pdf->AddPage();
  }

  /**
   * Function to generate invoice pdf and store it on server.
   *
   * @param float $total
   *   Total bill amount
   * @param mixed $rows
   *   Associative array of cart items.
   * @param string $order_id
   *   Order id of the order.
   * 
   * @return bool
   *   Returns true on success and false otherwise.
   */
  public function generateBill(float $total, mixed $rows, string $order_id) {
    $count = 0;
    $this->pdf->Rect(5, 5, 200, 287);
    $this->pdf->SetFont('Arial', '', 12);
    $this->pdf->Cell(70, 10, 'Product name:', 1, 0, 'L', false, '');
    $this->pdf->Cell(40, 10, 'Price (Rs)', 1, 0, 'L', false, '');
    $this->pdf->Cell(30, 10, 'quantity', 1, 0, 'L', false, '');
    $this->pdf->Cell(50, 10, 'Amount (Rs)', 1, 1, 'L', false, '');
    foreach ($rows as $row) {
      $this->pdf->Cell(70, 10, $row['name'], 1, 0, 'L', false, '');
      $this->pdf->Cell(40, 10, $row['price'], 1, 0, 'L', false, '');
      $this->pdf->Cell(30, 10, $row['quantity'], 1, 0, 'L', false, '');
      $this->pdf->Cell(50, 10, $row['quantity']*$row['price'], 1, 1, 'L', false, '');
      $count += $row['quantity'];
    }
    $this->pdf->Cell(110, 10, 'Total:', 1, 0, 'L', false, '');
    $this->pdf->Cell(30, 10, $count, 1, 0, 'L', false, '');
    $this->pdf->Cell(50, 10, $total, 1, 0, 'L', false, '');
    try {
      $this->pdf->Output('F', "../static/pdf/{$order_id}.pdf");
      return true;
    }
    catch (Exception $e) {
      echo $e;
      return false;
    }
  }
}
