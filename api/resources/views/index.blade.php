@extends('layout.app')
@section('content')
    <div class="container">
        <div class="content">
            <form class="form" action="{{route('register')}}" method="POST">
                @csrf
                <label for="username">
                    Username
                    <input id="username" type="text" name="username">
                </label>
                <label for="phone">
                    Phone
                    <input id="phone" type="text" name="phone">
                </label>
                <button type="submit">Register</button>
            </form>
            <br>
            <a href="" class="success-message"></a>
            <br>
            <div class="error-message"></div>


        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.form').on('submit',function (event) {
                event.preventDefault();
                let form = $(this);
                let formData = form.serialize();
                let actionUrl = form.attr('action');

                $.post(actionUrl, formData, function (response) {
                    $('.success-message').text(response.link);
                    $('.success-message').attr('href',response.link);
                    $('.success-message').show();
                    $('.error-message').hide();
                }).fail(function (error) {
                    $('.error-message').text(error.responseJSON.message);
                    $('.error-message').show();
                    $('.success-message').hide();
                });

            });
        });
    </script>
@endsection
