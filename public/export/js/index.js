    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ]

        });
      
      $('.btn-copy').click(function(){
        $('.buttons-copy').trigger('click');
      });
      $('.btn-csv').click(function(){
        $('.buttons-csv').trigger('click');
      });
      $('.btn-excel').click(function(){
        $('.buttons-excel').trigger('click');
      });
      $('.btn-pdf').click(function(){
        $('.buttons-pdf').trigger('click');
      });
      $('.btn-print').click(function(){
        $('.buttons-print').trigger('click');
      });
    });