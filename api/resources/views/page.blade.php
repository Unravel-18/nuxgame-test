@extends('layout.app')
@section('content')
    <div class="container">
        <div class="content">
            <div class="form" style="flex-direction: row; justify-content: center">
                <button id="generate_new" >Generate New</button>
                <form class="deactivate" action="{{route('page-tokens.deactivate', $id)}}" method="POST">
                    @csrf
                    <button>Deactivate</button>
                </form>
                <button id="scum" >Imfeelinglucky</button>
                <button id="history" >History</button>
            </div>
            <br>
            <a href="" class="success-message"></a>
            <br>
            <div class="error-message"></div>
            <br>
            <div class="lucky">
                <div class="winner"></div>
                <div class="summ"></div>
                <div class="number"></div>
            </div>
            <br>
            <div id="result"></div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#generate_new').on('click', function () {
                $.ajax({
                    url: '{{route('page-tokens.generate-new', $id)}}',
                    method: 'GET',
                    success: function (response) {
                        $('.success-message').text(response.link);
                        $('.success-message').attr('href',response.link);
                        $('.success-message').show();
                        $('.error-message').hide();
                        $('.lucky').hide();
                    },
                    error: function (error) {
                        $('.error-message').text(error.responseJSON.message);
                        $('.error-message').show();
                        $('.success-message').hide();
                        $('.lucky').hide();
                    },
                });
            })
            $('#scum').on('click', function () {
                $.ajax({
                    url: '{{route('page-tokens.attempt-lucky', $id)}}',
                    method: 'GET',
                    success: function (response) {
                        $('.winner').text('Is winner: ' + response.data.is_winner);
                        $('.summ').text('Summ :' + response.data.winner_sum);
                        $('.number').text('Number' + response.data.rand_number);
                        $('.lucky').show();
                        $('.error-message').hide();
                    },
                    error: function (error) {
                        $('.error-message').text(error.responseJSON.message);
                        $('.error-message').show();
                        $('.success-message').hide();
                    },
                });
            });
            $('#history').on('click', function () {
                $.ajax({
                    url: '{{route('page-tokens.attempt-lucky.history', $id)}}',
                    method: 'GET',
                    success: function (response) {
                        $('#result').empty();

                        $.each(response.data, function (index, item) {
                            let card = `
            <div class="card">
                <p><strong>Is winner:</strong> ${item.is_winner}</p>
                <p><strong>Summ:</strong> ${item.winner_sum}</p>
                <p><strong>Number:</strong> ${item.rand_number}</p>
<hr>
            </div>
        `;
                            $('#result').append(card);
                            $('#result').show();
                        });

                        $('.lucky').hide();
                        $('.error-message').hide();
                    },

                    error: function (error) {
                        $('.error-message').text(error.responseJSON.message);
                        $('.error-message').show();
                        $('.success-message').hide();
                    },
                });
            });
            $('.deactivate').on('submit',function (event) {
                event.preventDefault();
                let form = $(this);
                let formData = form.serialize();
                let actionUrl = form.attr('action');
                $.post(actionUrl, formData, function (response) {
                    window.location.href = '{{route('index')}}'
                }).fail(function (error) {
                    $('.error-message').text(error.responseJSON.message);
                    $('.error-message').show();
                    $('.lucky').hide();
                    $('.success-message').hide();
                });
            });
        });
    </script>
@endsection
