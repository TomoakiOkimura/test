$(function() {
    console.log('読み込みOK');
    
    $('btn-outline-secondary').on('click', function(e) {
        console.log('検索開始');
        e.preventDefault();
        let formData = $('#search-form').serialize();
        
        $.ajax({
            url: 'products/',
            type: 'GET',
            data: formData,
            dataType: 'html'
        }).done(function(data) {
            console.log('成功');
            let newTable = $(data).find('#products-table');
            $('#products-table').replaceWith(newTable);
            // loadSort();
            // deleteEvent();
        }).fail(function() {
            alert('通信失敗');
        });
    });
});