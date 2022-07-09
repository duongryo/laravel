<!-- Order code -->
@if(isset($merchantId) )
@if(isset($invoiceId) && isset($amount))
<img src="https://www.shareasale.com/sale.cfm?tracking={{ $invoiceId }}&amount={{ $amount }}&merchantID={{ $merchantId }}&skulist={{ $sku }}&transtype=sale" width="1" height="1">
<script>
    setTimeout(() => {
        document.location.href = "/";
    }, 5000)
</script>
@endif
<script src="https://www.dwin1.com/19038.js" type="text/javascript" defer="defer"></script>
@endif