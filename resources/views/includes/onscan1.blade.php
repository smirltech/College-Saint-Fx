<script> src = "{{ asset('vendor/onscan.js/onscan.min.js') }}"
    charset = "utf-8" >
        function decodeKey(key) {
            if (key >= 48 && key <= 57) {
                return key - 48;
            }
            //return undefined;
        }

    onScan.attachTo(document, {
        suffixKeyCodes: [13], // enter-key expected at the end of a scan
        reactToPaste: true,
        onScan: function (sCode) { // Alternative to document.addEventListener('scan')


            $('#barcode').val(sCode);

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
