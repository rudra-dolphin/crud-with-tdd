<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="container mt-3">
        <h3>Calculated Data List</h3>
        <table class="table table-bordered" id="calculationData">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Percentage</th>
                    <th>Result</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($calculationData as $dataObj)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $dataObj->amount }}</td>
                        <td>{{ $dataObj->percentage }}</td>
                        <td>{{ $dataObj->result }}</td>
                        <td><a href="{{ route('calculation.edit', $dataObj->id) }}"
                                class="btn btn-warning mx-2 btn-sm">Edit</a><a href="javascript(void(0))"
                                class="btn btn-danger delete btn-sm" data-id="{{ $dataObj->id }}">Delete</a></td>
                    </tr>
                @empty
                    <span>No Calculations</span>
                @endempty
        </tbody>
    </table>
    <a href="{{ route('calculation.create') }}" class="btn btn-primary">Add Calculation</a>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var deleteButton = $(this);
            var url = "{{ route('calculation.destroy', 'id') }}";
            url = url.replace('id', id);
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "delete",
                },
                success: function(response) {
                    deleteButton.closest('tr').remove();
                }
            })
        });
    });
</script>
</body>

</html>
