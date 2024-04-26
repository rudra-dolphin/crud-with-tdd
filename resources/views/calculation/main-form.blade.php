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

    <style>
        body {
            background: #f7f7f7;
        }

        .form-box {
            max-width: 500px;
            margin: auto;
            padding: 50px;
            background: #ffffff;
            border: 10px solid #f2f2f2;
        }

        h1,
        p {
            text-align: center;
        }

        input,
        textarea {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h1>TDD</h1>
        <form action="{{ isset($id) ? route('calculation.update', $id) : route('calculation.store') }}" method="POST">
            @csrf
            @if (isset($id))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="amount">Amount</label>
                <input class="form-control @error('amount') is-invalid @enderror" id="amount" type="text"
                    value="{{ old('amount', $data->amount ?? '') }}" name="amount">
            </div>
            @error('amount')
                <span class="invalid-feedback" style="display: block !important" role="alert">{{ $message }}</span>
            @enderror
            <div class="form-group">
                <label for="percentage">Percentage</label>
                <input class="form-control @error('percentage') is-invalid @enderror" id="percentage" min="0"
                    max="100" step="any" type="text" name="percentage"
                    value="{{ old('percentage', $data->percentage ?? '') }}">
            </div>
            @error('percentage')
                <span class="invalid-feedback" style="display: block !important" role="alert">{{ $message }}</span>
            @enderror
            <div class="form-group">
                <label for="result">Result</label>
                <input class="form-control @error('result') is-invalid @enderror" id="result" min="0"
                    max="100" step="any" type="text" name="result" readonly
                    value="{{ old('result', $data->result ?? '') }}" value="{{ old('result', $data->result ?? '') }}">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Calculate</button>
            <a href="{{ route('calculation.index') }}" class="btn btn-warning mt-2">Home</a>
        </form>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document).on('input', '#percentage, #amount', function() {
                var result = $('#percentage').val() * $('#amount').val() / 100;
                $('#result').val(result);
            })
        });
    </script>
</body>

</html>
