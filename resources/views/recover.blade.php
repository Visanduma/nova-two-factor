@extends('nova-two-factor::layout.default')

@section('content')
<div class="content-center">
    <div class="mx-auto py-8 max-w-sm flex justify-center text-black">

    </div>

    <div class="py-6 px-1 md:px-2 lg:px-6">

        <form class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 max-w-[25rem] mx-auto" method="POST" action="{{ route('nova-two-factor.recover') }}">
            @csrf


            <h2 class="text-2xl text-center font-normal mb-6 text-90">{{ __('Recover from 2FA') }}</h2>
            <svg class="block mx-auto mb-6" xmlns="http://www.w3.org/2000/svg" width="100" height="2" viewBox="0 0 100 2">
                <path fill="#D8E3EC" d="M0 0h100v2H0z"></path>
            </svg>

            <div class="mb-6 ">
                <label class="block font-bold mb-2" for="password">{{ __('Recovery Code') }}</label>
                <input class="form-control form-input form-control-bordered w-full" id="password" type="text" name="recovery_code" required>
            </div>

            @if($errors->any())
                <p class="text-center font-semibold text-red-700 my-2">
                    {{ $errors->first() }}
                </p>
            @endif

            <button size="lg" align="center" component="button"
                    class="w-full flex justify-center shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 w-full flex justify-center cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 w-full flex justify-center shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 w-full flex justify-center"
                    type="submit"><span>{{ __('Recover my account') }}</span></button>

            <div class="flex mt-3">
                <div class="ml-auto">
                    <a class="text-gray-500" href="{{ config('nova.path') }}">
                        {{ __('Use OTP code') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
