$(function() {
    console.log('読み込みOK');
    deleteEvent();

    $('.btn-outline-secondary').on('click', function(e) {
        console.log('検索開始');
        e.preventDefault();
        let formData = $('#search-form').serialize();
        loadTableSorter('new-table');
        
        
        $.ajax({
            url: 'products/',
            type: 'GET',
            data: formData,
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'html'

        }).done(function(data) {
            console.log('成功');
            // console.log(data);
            let newTable = $(data).find('#products-table');
            $('#products-table').replaceWith(newTable);
            loadTableSorter();
            deleteEvent();

        }).fail(function() {
            alert('通信失敗');
        });
    });
});