<div id="GizmozGadgetzInvoice" style="display: none;">
    <div ng-repeat="aData in xmlTempArr track by $index">
        <table id="GNGcompanylogo_ppi">
            <tbody>
                <tr>
                    <td><img src="images/monogram-log.png" style="max-height:70px; max-width: 260px;" /> </td>
                </tr>
            </tbody>
        </table>

        <table id="GNGdelivery_ppi">
            <thead>
                <tr>
                    <th>Delivery To</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span id="shipname_ppi"></span></span></td>
                </tr>

                <tr>
                    <td><span id="shipaddress1_ppi"></span></span></td>
                </tr>

                <tr>
                    <td><span id="shipaddress2_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="shipcity_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="shipstateorregion_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="shippostcode_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="shipcountryname_ppi"></span></td>
                </tr>
				<tr>
                    <td><span id="shipphone_ppi"></span></td>
                </tr>
				<tr>
                    <td><span id="shipemail_ppi"></span></td>
                </tr>
            </tbody>
        </table>

        <table id="GNGchannel_ppi" style="">
			<tbody>
                <tr>
                    <td>Ordered Source:</td>
                    <td><span id="saleschannel_ppi"></span></td>
                </tr>
                <tr>
                    <td>Order ID:</td>
                    <td><span id="orderid_ppi"></span></td>
                </tr>
                <tr>
                    <td>Order Date:</td>
                    <td><span id="purchasedate_ppi"></span></td>
                </tr>
            </tbody>
        </table>

        <table id="GNGbasic_ppi">
            <thead>
                <tr>
                    <td>Gizmoz n Gadgetz</td>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>Unit 22,</td>
                </tr>
                <tr>
                    <td>Riverside Business Centre (Rear Doors),</td>
                </tr>
                <tr>
                    <td>High Wycombe</td>
                </tr>
                <tr>
                    <td>Bucks</td>
                </tr>
                <tr>
                    <td>HP11 2QS</td>
                </tr>
                <tr>
                    <td>VAT: GB156675672</td>
                </tr>

            </tbody>
        </table>
        <table id="GNGorder_ppi">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Title</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
			<tbody id="multipleorders_ppi"></tbody>
        </table>

        <table id="GNGshippingservice_ppi">
            <tbody>
                <tr>
                    <td>DELIVERY BY STANDARD/EXPRESS:</td>
                    <td>
                        <span id="shippingservice_ppi"></span>
                    </td>
                </tr>
                <tr>
                    <td>PAYMENT BY:</td>
                    <td><span id="paymentmethod_ppi"></span></td>
                </tr>
            </tbody>
        </table>


        <table id="GNGtotalprice_ppi" style="border:1px solid #ddd9d9;">
			<tbody>
                <tr>
                    <td>Sub total:</td>
                    <td><span id="totalprice_ppi"></span></td>
                </tr>
                <tr>
                    <td>P &amp; P</td>
                    <td>0.0</td>
                </tr>
                <tr>
                    <td>Carriage</td>
                    <td><span id="vatprice_ppi"></span></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><span id="grandtotal_ppi"></span></td>
                </tr>
            </tbody>
        </table>

        <table id="GNGreturnaddress_ppi">
            <tbody>
                <tr>
                    <td></td>
                </tr>
            <tbody>
        </table>

        <table id="GNGboxreturnaddress_ppi">
            <tbody>
                <tr>
                    <td><span id="gnshipname_ppi"></span></span></td>
                </tr>

                <tr>
                    <td><span id="gnshipaddress1_ppi"></span></span></td>
                </tr>

                <tr>
                    <td><span id="gnshipaddress2_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="gnshipcity_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="gnshipstateorregion_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="gnshippostcode_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="gnshipcountryname_ppi"></span></td>
                </tr>

            </tbody>
        </table>
        <table id="GNGnew_ppi">
            <thead>
                <tr>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>