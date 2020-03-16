<div id="basic-ebay" style="display: none;">
    <div>
        <table id="ebayreturnaddress_ppi">
            <tbody>
                <tr>
                    <td>
                        Send to:
                    </td>
                </tr>
                <tr>
                    <td><span id="invoicetoname_ppi"></span></span></td>
                </tr>

                <tr>
                    <td><span id="invoicetoaddress1_ppi"></span></span></td>
                </tr>

                <tr>
                    <td><span id="invoicetoaddress2_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="invoicetocity_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="invoicetostateorregion_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="invoicetopostcode_ppi"></span></td>
                </tr>

                <tr>
                    <td><span id="invoicetocountryname_ppi"></span></td>
                </tr>

            </tbody>
        </table>

        <table id="ebayDash_ppi">
            <tbody>
                <tr>
                    <td>Date</td>
                    <td>Record#</td>
                </tr>
                <tr>
                    <td><span id="purchasedate_ppi"></span></td>
                    <td><span id="orderid_ppi"></td>
                </tr>
            </tbody>
        </table>
		<?php
			$order_item = array();
			$sub_total = 0;
			if(isset($row_details['orderitems']['item'][0])){
				$order_item = $row_details['orderitems']['item'];
			}else{
				$order_item[] = $row_details['orderitems']['item'];
			}
		?>
        <table id="ebayorder_ppi">
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Item #</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="multipleorders_ppi">
            </tbody>
        </table>

        <table id="ebayEmptyTable_ppi">
            <tbody>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            <tbody>
        </table>
        <table id="ebaytotalprice_ppi" style="border:1px solid #ddd9d9;">
            <tbody>
                <tr>
                    <td>Subtotal:</td>
                    <td>
                        <span id="totalprice_ppi"></span>
                    </td>
                </tr>
                <tr>
                    <td >
                        <span>
                            Postage & packaging(<span id="shippingservice_ppi"></span>):
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Seller discounts (-) or charges (+):</span>
                    </td>
                    <td><span>0.00</span></td>
                </tr>

                <tr>
                    <td>Total:</td>
                    <td><span id="grandtotal_ppi"></span></td>
                </tr>

            </tbody>
        </table>

        <table id="newebay_ppi">
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