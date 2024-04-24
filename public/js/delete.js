$(function() {
    $('.btn-danger').on('click',function(e){
        console.log('OK');
        e.preventDefault();
        var deleteConfirm = confirm('削除してよろしいでしょうか？');

        if(deleteConfirm == true) {
            console.log('削除非同期開始');
            var clickEle = $(this);
            var productId = clickEle.attr('data-product_id');

            $.ajax({
                type: 'DELETE',
                url: '/products/delete/' + productId,
                dataType: 'json',
                data: {'_token': '{{ csrf_token() }}'},
                      
            })//通信が成功した時の処理
            .done(function() {
                console.log('削除通信成功');
                clickEle.parents('tr').remove();
            })

            .fail(function() {
                alert('エラーが発生しました');
            })
        } 
    });
});