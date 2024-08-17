@extends('layouts.app')

@section('title', 'Miejsca wkłucia')
@section('header', 'Miejsca wkłucia')
@section('addButton')

@endsection

@push('scripts')
    <script>
        function onFantomClick(event) {
            console.log(event)
            const pin = document.createElement("div");
            pin.classList.add("pin");
            // pin.style.top = event.offsetY;
            // pin.style.left = event.offsetX;
            pin.setAttribute("style", `top: ${event.offsetY}px; left: ${event.offsetX}px;`)
            document.getElementById("fantom-container").appendChild(pin);

        }

        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("fantom").addEventListener("click", onFantomClick)

        })
    </script>
@endpush

@push('styles')
    <style>
        #fantom-container {
            position: relative;
            display: inline-block;
        }

        #fantom {
            display: block;
        }

        .pin {
            position: absolute;
            width: 4px;
            height: 4px;
            background-color: red;
            /*top: 20px; !* Replace with your y coordinate *!*/
            /*left: 10px; !* Replace with your x coordinate *!*/
        }
    </style>
@endpush

@section('content')
    <body class="font-sans text-gray-900 antialiased">
        <div id="fantom-container">
            <img src="human.svg" alt="Human" id="fantom">
        </div>
    </body>
@endsection
