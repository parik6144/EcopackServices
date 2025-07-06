<?php
$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
$consigneeId = $_REQUEST['consignee_id'];
 $from_date = $_REQUEST['date_from'];
 $to_date = $_REQUEST['date_to'];
?>
<!-- SheetJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<style> td { text-align: center; } th { text-align: center; }</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12"><br/>
            <div class="ibox">
                <div class="ibox-title">
                    <h2 style="display: inline-block;">Consignee Ledger Report</h2>
<!--                    <button type="button" class="btn btn-primary btn-sm" id="export-button" style="float: right;">Export PDF</button>-->
                    <button type="button" class="btn btn-primary" id="export-pdf-button">Export PDF</button>
                </div>
                <div class="ibox-content" id="ibox-content-id">
                    <table class="table table-bordered first-table">
                        <tr>
                            <td style="vertical-align: middle;">
                                <img src="http://ecopackservices.com/uploads/EcoPack1.png" width="150">
                                <p style="margin: 0;">ECOPACK SERVICES PVT LTD</p>
                                <p style="margin: 0;">GST No: 20AAECE1697G1ZV</p>
                            </td>

                            <td style="text-align: center;">
                                <h2>Ledger</h2>
                                <p>Party : <?php echo $consigneeDetails['consignee']['consignee'][0]['consignee_name']; ?></p>
                                <p>Date Range: <?php echo $from_date; ?> to <?php echo $to_date; ?></p>
                            </td>
                            <td style="text-align: right;">
                                <p>Date: <?php echo $ledger_date; ?></p>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th colspan="2">Tr. Date</th>
                            <th>Type</th>
                            <th>Invoice/Pay Vou No.</th>
                            <th>Service Vendor Description</th>
                            <th>Debit Amt.</th>
                            <th>Credit Amt.</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $debit_total = 0;
                            $credit_total = 0;
                            ?>
                            <tr>
                                <td><?php echo $i=1; ?></td>
                                <td colspan="2"><?php echo date('d-m-Y', strtotime($ledger_records['opening_balance_array']['transaction_date'])); ?></td>
                                <td><?php echo $ledger_records['opening_balance_array']['record_type']; ?></td>
                                <td><?php echo $ledger_records['opening_balance_array']['transaction_inv_no']; ?></td>
                                <td><?php echo $ledger_records['opening_balance_array']['consignee_name'].'<br>'.$ledger_records['opening_balance_array']['consignee_billing_name']; ?></td>
                                <td><?php echo $ledger_records['opening_balance_array']['record_type'] == 'Opening_Balance' && $ledger_records['opening_balance_array']['debit_amount']!=0 ? number_format($ledger_records['opening_balance_array']['debit_amount'], 2) : '-'; ?></td>
                                <td><?php echo $ledger_records['opening_balance_array']['record_type'] == 'Opening_Balance' && $ledger_records['opening_balance_array']['credit_amount']!=0 ? number_format($ledger_records['opening_balance_array']['credit_amount'], 2) : '-'; ?></td>
                                <?php
                                // sum of invoices debit amounts.
                                if ($ledger_records['opening_balance_array']['record_type'] == 'Opening_Balance') { $debit_total += $ledger_records['opening_balance_array']['debit_amount'];  }
                                // sum of payments credit amounts.
                                //if ($ledger_records['opening_balance_array']['record_type'] == 'Opening_Balance') { $credit_total += $ledger_records['opening_balance_array']['credit_amount']; }
                                ?>
                            </tr>
                            <?php $i++;
                            $i = 2; foreach($ledger_records['combined_array'] as $record) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td colspan="2"><?php echo date('d-m-Y', strtotime($record['transaction_date'])); ?></td>
                                <td><?php //echo $record['record_type']; ?>
                                  <?php
                                    // sum of invoices debit amounts.
                                    if ($record['record_type'] == 'invoice') { echo $record['record_type']; }
                                    // sum of payments credit amounts.
                                    if ($record['record_type'] == 'payment') { echo $record['record_type'].' behalf of :'.$record['transaction_id']; }
                                    ?>
                                </td>
                                <td><?php echo $record['transaction_inv_no']; ?></td>
                                <td><?php echo $record['consignee_name'].'<br>'.$record['consignee_billing_name']; ?></td>
                                <td><?php echo $record['record_type'] == 'invoice' ? number_format($record['transaction_amt'], 2) : '-'; ?></td>
                                <td><?php echo $record['record_type'] == 'payment' ? number_format($record['transaction_amt'], 2) : '-'; ?></td>

                                <?php
                                // sum of invoices debit amounts.
                               if ($record['record_type'] == 'invoice') { $debit_total += $record['transaction_amt'];  }
                                // sum of payments credit amounts.
                               if ($record['record_type'] == 'payment') { $credit_total += $record['transaction_amt']; }
                               ?>
                            </tr>
                        <?php $i++; } ?>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6"><strong>Total Debits:</strong></td>
                            <td><strong><?php echo number_format($debit_total, 2); ?></strong></td>
                            <td><strong>-</strong></td>
                        </tr>

                        <tr>
                            <td colspan="6"><strong>Total Credits:</strong></td>
                            <td><strong>-</strong></td>
                            <td><strong><?php echo number_format($credit_total, 2); ?></strong></td>
                        </tr>

                        <?php
                        $outstanding = $debit_total-$credit_total;
                        $outstanding_formatted = number_format(abs($outstanding), 2);
                        $outstanding_type = $outstanding < 0 ? 'Balance' : 'Balance';
                        //$outstanding_type = $outstanding < 0 ? 'Credit' : 'Debit';
                        ?>
                        <tr>
                            <td colspan="6"><strong>Outstanding <?php echo $outstanding_type; ?>:</strong></td>
                            <?php if ($outstanding < 0): ?>
                                <td><strong>-</strong></td>
                                <td><strong><?php echo $outstanding_formatted; ?></strong></td>
                            <?php else: ?>
                                <td><strong><?php echo $outstanding_formatted; ?></strong></td>
                                <td><strong>-</strong></td>
                            <?php endif; ?>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>

// Include the jsPDF library
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

// Create a button that exports the page to PDF on click
<button onclick="exportToPDF()">Export to PDF</button>

<script>
    function exportToPDF() {
        // Create a new jsPDF instance
        var doc = new jsPDF();

        // Get the HTML content of the entire page
        var html = document.documentElement.innerHTML;

        // Add the HTML content to the PDF
        doc.fromHTML(html, 15, 15, {
            'width': 170
        });

        // Save the PDF file
        doc.save('page.pdf');
    }
</script>



