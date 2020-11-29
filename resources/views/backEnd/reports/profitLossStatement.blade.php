@extends('backEnd.master') @section('mainContent')

    <div class="card">

        <div class="card-header">
            <h5>Profit Loss Statement</h5>
        </div>

        <div class="card-block" align="center">
            <div>
                <table style="padding: 30px;" width="70%">
                    <thead>
                    <tr>
                        <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="2">White Paper</th>
                    </tr>
                    <tr>
                        <th style="text-align: center; font-size: 24px; font-weight: bold;" colspan="2">Profit and Loss Statement</th>
                    </tr>
                    <tr>
                        <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="2">For the period from 01/01/2019 to 06/30/2019</th>
                    </tr>
                    <tr>
                        <th style="border-bottom-width: 1px;"></th>
                        <th style="width: 80px; text-align: right; font-weight: bold; border-bottom-width: 1px;">01/01/2019</th>
                    </tr>
                    <tr>
                        <th colspan="2">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="font-weight: bold;" colspan="2">Income</td>
                    </tr>
                    <tr>
                        <td>Billable expenses - markup</td>
                        <td style="text-align: right;">30,000.00</td>
                    </tr>
                    <tr>
                        <td>Interest received</td>
                        <td style="text-align: right;">15,000.00</td>
                    </tr>
                    <tr>
                        <td>Sales</td>
                        <td style="text-align: right;">120,000.00</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total — Income</td>
                        <td style="text-align: right; font-weight: bold; border-bottom-width: 1px; white-space: nowrap;">165,000.00</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="2">Less: Expenses</td>
                    </tr>
                    <tr>
                        <td>Accounting fees</td>
                        <td style="text-align: right;">1,000.00</td>
                    </tr>
                    <tr>
                        <td>Advertising and promotion</td>
                        <td style="text-align: right;">700.00</td>
                    </tr>
                    <tr>
                        <td>Bank charges</td>
                        <td style="text-align: right;">250.00</td>
                    </tr>
                    <tr>
                        <td>Billable expenses - unrecoverable</td>
                        <td style="text-align: right;">-</td>
                    </tr>
                    <tr>
                        <td>Computer equipment</td>
                        <td style="text-align: right;">1,500.00</td>
                    </tr>
                    <tr>
                        <td>Donations</td>
                        <td style="text-align: right;">10,000.00</td>
                    </tr>
                    <tr>
                        <td>Electricity</td>
                        <td style="text-align: right;">8,000.00</td>
                    </tr>
                    <tr>
                        <td>Entertainment</td>
                        <td style="text-align: right;">4,000.00</td>
                    </tr>
                    <tr>
                        <td>Fixed assets - depreciation</td>
                        <td style="text-align: right;">17,000.00</td>
                    </tr>
                    <tr>
                        <td>Fixed assets - loss on disposal</td>
                        <td style="text-align: right;">-</td>
                    </tr>
                    <tr>
                        <td>Legal fees</td>
                        <td style="text-align: right;">1,200.00</td>
                    </tr>
                    <tr>
                        <td>Motor vehicle expenses</td>
                        <td style="text-align: right;">750.00</td>
                    </tr>
                    <tr>
                        <td>Printing and stationery</td>
                        <td style="text-align: right;">700.00</td>
                    </tr>
                    <tr>
                        <td>Rent</td>
                        <td style="text-align: right;">30,000.00</td>
                    </tr>
                    <tr>
                        <td>Repairs and maintenance</td>
                        <td style="text-align: right;">15,000.00</td>
                    </tr>
                    <tr>
                        <td>Telephone</td>
                        <td style="text-align: right;">1,500.00</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total — Expenses</td>
                        <td style="text-align: right; font-weight: bold; border-top-width: 1px; border-bottom-width: 1px; white-space: nowrap;">105,000.00</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; border-top-width: 1px; border-bottom-width: 1px;">Net profit (profit)</td>
                        <td style="text-align: right; font-weight: bold; border-top-width: 1px; border-bottom-width: 1px; white-space: nowrap;">60,000.00</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
