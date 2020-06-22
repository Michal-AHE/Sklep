$(function () {
    $('#addToCartButton').on('click', function () {
        var userId = $('#addToCartUserId').val();
        var productId = $('#addToCartProductId').val();
        var productAmount = $('#addToCartAmount').text();
        $.ajax({
            url: 'ajax/addToCart.php',
            dataType: 'json',
            data: {
                userId: userId,
                productId: productId,
                productAmount: productAmount
            },
            method: 'POST',
            success:function(responsedata){
               // process on data
               if (responsedata == 1)
               {
                   var infoData = fillCartInfoFields(productId);
                   $('#cartInfoImage').attr('src',infoData['productThumbnail']);
                   $('#cartInfoName').text(infoData['productName']);
                   $('#cartInfoAmount').text(productAmount);
                   $('#cartInfoValue').text((infoData['productPrice']*productAmount).toFixed(2));
                   $('#cartInfoBackground').show();
                   $('#addToCartAmount').text(1);
                   // location.reload();
               }
               else
               {
                   alert("Wystąpił problem");
                   $('#addToCartAmount').text(1);
                    location.reload();
               }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
            location.reload();
            }
        });
    });
});

$(function () {
    $('#addToCartIncrease').on('click', function () {
        $('#addToCartAmount').text(parseInt($('#addToCartAmount').text()) + 1);
    });
    $('#addToCartDecrease').on('click', function () {
        if (parseInt($('#addToCartAmount').text())>1)
        {
            $('#addToCartAmount').text(parseInt($('#addToCartAmount').text()) - 1);
        }
    });
    $('#cartInfoClose').on('click', function () {
        $('#cartInfoBackground').hide();
    });
});

function fillCartInfoFields(productId) {
    var output = "444";
    
    $.post({
            url: 'ajax/productInfo.php',
            dataType: 'json',
            data: {
                productId: productId
            },
            method: 'POST',
            async: false,
            success:function(data){
               output = data;
           }
       });
       return output;
    
    /*
    output = ($.ajax({
            url: 'ajax/productInfo.php',
            dataType: 'json',
            data: {
                productId: productId
            },
            method: 'POST',
            async: false,
            success:function(data){
               output = data;
               alert(output);
        return output;
           }
        }));*/
}