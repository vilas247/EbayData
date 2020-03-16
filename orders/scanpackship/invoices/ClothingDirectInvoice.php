<div id="Clothing-Direct" style="display: none;">
    <div>
        <table id="CDcompanyAddress_ppi">


            <tbody>
                <tr>
                    <td>3/4 Spillmans Court</td>
                </tr>
                <tr>
                    <td>Middle Spillmans</td>
                </tr>
                <tr>
                    <td>Stroud,Glos</td>
                </tr>
                <tr>
                    <td>GL5 3RU</td>
                </tr>
                <tr>
                    <td>Tel:01453 297510</td>
                </tr>
				<tr>
					<td id="CDemail_ppi"></td>
				</tr>
                <tr>
					<td CDemail></td>
                </tr>
            </tbody>
        </table>

        <table id="CDOrderInfo_ppi">
            <tbody>
                <tr>
                    <td>Order No:&nbsp;<span id="orderid_ppi"></span></td>
                </tr>
                <tr>
                    <td>Order VIA:&nbsp;<span id="saleschannel_ppi"></span></td>
                </tr>
                <tr>
                    <td>Order Date:&nbsp;<span id="purchasedate_ppi"></span></td>
                </tr>
				<tr id="CDcustomer_ppi"></tr>
                <tr ng-if="aData.invoice.shippingaddreses.shippingaddress.name!==undefined  && aData.invoice.shippingaddreses.shippingaddress.name!==null && aData.invoice.shippingaddreses.shippingaddress.name!=='' ">
                    <td>Customer:&nbsp;<span ng-bind-html="aData.invoice.shippingaddreses.shippingaddress.name"></span></td>
                </tr>

            </tbody>
        </table>

        <table id="CDProductInfo_ppi">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>BIN</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody id="multipleorders_ppi">
            </tbody>
        </table>

        <table id="CDTotalPriceVat_ppi" style="border:1px solid #ddd9d9;">
            <tbody>
				<tr>
                    <td>Sub total:</td>
                    <td>GBP <span id="subtotalprice_ppi"></span></td>
                </tr>
				<tr>
                    <td>Postage & Packing</td>
                    <td>GBP <span id="postagepacking_ppi"></span></td>
                </tr>
				<tr>
                    <td>VAT @ 20%</td>
                    <td>GBP <span id="postagepacking_ppi"></span></td>
                </tr>
				<tr>
                    <td>Order Total</td>
                    <td>GBP <span id="ordertotal_ppi"></span></td>
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td><span id="CDpaymentmethod_ppi"></span></td>
                </tr>
            </tbody>
        </table>

        <table id="CDShipingAddress_ppi">
            <thead>
                <tr>
                    <td>Deliver To:</td>
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

        <table id="CDPelStickerAddress_ppi">
            <tbody>
                <tr>
                    <td><span id="CDshipname_ppi"></span></span></td>
                </tr>

                <tr>
                    <td><span id="CDshipaddress1_ppi"></span></span></td>
                </tr>

                <tr>
                    <td><span id="CDshipaddress2_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="CDshipcity_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="CDshipstateorregion_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="CDshippostcode_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="CDshipcountryname_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="CDshipphone_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="CDshipemail_ppi"></span></td>
                </tr>

            </tbody>
        </table>


        <table id="newvat_ppi">
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