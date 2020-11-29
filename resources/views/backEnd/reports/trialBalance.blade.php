@extends('backEnd.master')

@section('mainContent')

    <div class="card">

        <div class="card-header">
            <h5>Trial Balance</h5>
        </div>

        <div class="card-block" align="center">
            <div  >
                <table class="  m-0" width="70%">
                    <thead>
                    <tr>
                        <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="3">White Paper</th>
                    </tr>
                    <tr>
                        <th style="text-align: center; font-size: 24px; font-weight: bold;" colspan="3">Trial Balance</th>
                    </tr>
                    <tr>
                        <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="3">As at 06/30/2019</th>
                    </tr>
                    <tr>
                        <th colspan="3" scope="row">	</th>
                    </tr>
                    <tr>
                        <th scope="row" style="border-bottom-width: 1px; width: 60%;"></th>
                        <th scope="row" style="width: 15%; text-align: left; font-weight: bold; vertical-align: bottom; border-bottom-width: 1px;">Debit</th>
                        <th scope="row" style="width: 15%; text-align: left; font-weight: bold; vertical-align: bottom; border-bottom-width: 1px;">Credit</th>
                    </tr>
                    <tr>
                        <th colspan="3">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="font-weight: bold;">Income</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Billable expenses - markup</td>
                        <td></td>
                        <td>30,000.00</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Interest received</td>
                        <td></td>
                        <td>15,000.00</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Sales</td>
                        <td></td>
                        <td>120,000.00</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Expenses</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Accounting fees</td>
                        <td>1,000.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Advertising and promotion</td>
                        <td>700.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Bank charges</td>
                        <td>250.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Billable expenses - unrecoverable</td>
                        <td>-</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Computer equipment</td>
                        <td>15,000.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Donations</td>
                        <td>10,000.00</td>
                        <td></td>
                    </tr>
                    <tr><td>&nbsp;Electricity</td>
                        <td>8,000.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Entertainment</td>
                        <td>4,000.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Fixed assets - depreciation</td>
                        <td>17,000.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Fixed assets - loss on disposal</td>
                        <td>-</td>
                        <td></td>
                    </tr>
                    <tr><td>&nbsp;Legal fees</td>
                        <td>1,200.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Motor vehicle expenses</td>
                        <td>750.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Printing and stationery</td>
                        <td>700.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Rent</td>
                        <td>30,000.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Repairs and maintenance</td>
                        <td>15,000.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Telephone</td>
                        <td>1,500.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-top-width: 1px; border-bottom-width: 1px;"><span style="font-weight: bold;">Net profit (profit)</span></td>
                        <td style="text-align: left; font-weight: bold; border-top-width: 1px; border-bottom-width: 1px; white-space: nowrap;">60,000.00</td>
                        <td style="text-align: left; font-weight: bold; border-top: 2px; border-bottom-width: 2px; ;">0.00</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Assets</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Billable expenses</td>
                        <td>-</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Fixed assets</td>
                        <td>150,000.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;Fixed assets, accumulated depreciation</td>
                        <td>5,000.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Liabilities</td>
                    </tr>
                    <tr>
                        <td>Employee clearing account</td>
                        <td></td>
                        <td>10,000</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Equity</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Retained earnings</td>
                        <td></td>
                        <td>160,000.00</td>
                    </tr>
                    <tr>
                        <td>&nbsp;Suspense</td>
                        <td></td>
                        <td>30,000.00</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-top-width: 1px; border-bottom-width: 1px;"></td>
                        <td style="text-align: left; font-weight: bold; border-top-width: 1px; border-bottom-width: 1px; white-space: nowrap;">200,000.00</td>
                        <td style="text-align: left; font-weight: bold; border-top-width: 1px; border-bottom-width: 1px; white-space: nowrap;">200,000.00</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
