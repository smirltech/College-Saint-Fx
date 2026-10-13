<script>
    function decodeKey(key) {
        if (key >= 48 && key <= 57) {
            return key - 48;
        }
//return undefined;
    }

    function findByCode(sCode) {
        $.get("{{url('/api/item')}}/" + sCode + "/" + {{Auth::user()->company_id}}, function (data, status) {

            console.log(data);

            if (data) {

                $("#price").val(data.selling_price);
                $("#stock1").text(data.stock_qty + ' ' + data.u);
                $("#stock2").val(data.stock_qty);
                $("#stock3").val(1);

                $("#categories").parent().parent().hide();

                $("#items").html('<option value="' + data.id + '">' + data.name + '</option>');
            }
//loadStock()
        });
    }

    onScan.attachTo(document, {
        suffixKeyCodes: [13], // enter-key expected at the end of a scan
        reactToPaste: true,
        onScan: function (sCode) { // Alternative to document.addEventListener('scan')


// $('#barcode').val(sCode);

            findByCode(sCode);

            console.log('Scanned: ' + sCode);
        },
        keyCodeMapper: function (oEvent) {
            var key = decodeKey(oEvent.which);

            if (key !== undefined) {
                return key;
            }
// Fall back to the default decoder in all other cases
            return onScan.decodeKeyEvent(oEvent);
        },
        onKeyDetect: function (iKeyCode) { // output all potentially relevant key events - great for debugging!
            console.log('Pressed: ' + iKeyCode);
        }

    });


</script>
