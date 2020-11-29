@extends('backEnd.master') @section('mainContent')

    <div class="card">
        <div class="card-header">
            <h5>Balance Sheet</h5>
        </div>

        <div class="card-block" align="center">
            <div>
                <table style="padding: 30px;" width="70%" >
                    <thead>
                    <tr>
                        <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="2">White Paper</th>
                    </tr>
                    <tr>
                        <th style="text-align: center; font-size: 24px; font-weight: bold;" colspan="2">Balance Sheet</th>
                    </tr>
                    <tr>
                        <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="2">As at 06/30/2019</th>
                    </tr>
                    <tr>
                        <th style="border-bottom-width: 1px;"></th>
                        <th style="width: 80px; text-align: right; font-weight: bold; border-bottom-width: 1px;">06/30/2019</th>
                    </tr>
                    <tr>
                        <th colspan="2">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="font-weight: bold;" colspan="2">Assets</td>
                    </tr>
                    <tr>
                        <td>Billable expenses</td>
                        <td style="text-align: right;">-</td>
                    </tr>
                    <tr>
                        <td>Fixed assets</td>
                        <td style="text-align: right;">150,000</td>
                    </tr>
                    <tr>
                        <td>Fixed assets, accumulated depreciation</td>
                        <td style="text-align: right;">5,000</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total — Assets</td>
                        <td style="text-align: right; font-weight: bold; border-top-width: 1px; border-bottom-width: 1px; white-space: nowrap;">200,000</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="2">Less: Liabilities</td>
                    </tr>
                    <tr>
                        <td>Employee clearing account</td>
                        <td style="text-align: right;">10,000</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; border-top-width: 1px; border-bottom-width: 1px;">Net assets</td>
                        <td style="text-align: right; font-weight: bold; border-top-width: 1px; border-bottom-width: 1px; white-space: nowrap;">190,000</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="2">Equity</td>
                    </tr>
                    <tr>
                        <td>Retained earnings</td>
                        <td style="text-align: right;">160,000</td>
                    </tr>
                    <tr>
                        <td>Suspense</td>
                        <td style="text-align: right;">30,000</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total — Equity</td>
                        <td style="text-align: right; font-weight: bold; border-top-width: 1px; border-bottom-width: 1px; white-space: nowrap;">190,000</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; border-top-width: 1px; border-bottom-width: 1px;">Total equity</td>
                        <td style="text-align: right; font-weight: bold; border-top-width: 1px; border-bottom-width: 1px; white-space: nowrap;">190,000</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td style="text-align: center;" colspan="2">
                            <!--Page Counter-->
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
