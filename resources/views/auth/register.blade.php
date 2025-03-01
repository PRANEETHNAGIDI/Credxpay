@extends('layouts.app')

@section('content')
<div>
    @include('components.header')
</div>
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-gray-800 p-8 rounded-xl">
        <div>
            <h2 class="text-center text-3xl font-extrabold text-white">Create your account</h2>
        </div>
        
        @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="profile_image" class="block text-sm font-medium text-gray-300">Profile Image</label>
                    <div class="mt-1 flex items-center">
                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-700">
                            <img id="preview" src="{{ asset('images/default-avatar.png') }}" alt="Profile preview" class="h-full w-full object-cover">
                        </span>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*" class="ml-5 text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-500 file:text-white hover:file:bg-teal-600"  onchange="previewImage(this)">
                    </div>
                </div>

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-300">First Name</label>
                    <input id="first_name" name="first_name" type="text"  class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-700 bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent sm:text-sm" value="{{ old('first_name') }}">
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-300">Last Name</label>
                    <input id="last_name" name="last_name" type="text"  class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-700 bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent sm:text-sm" value="{{ old('last_name') }}">
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                    <input id="username" name="username" type="text"  class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-700 bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent sm:text-sm" value="{{ old('username') }}">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-300">Phone Number</label>
                    <input id="phone" name="phone" type="tel"  class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-700 bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent sm:text-sm" value="{{ old('phone') }}">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email"  class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-700 bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent sm:text-sm" value="{{ old('email') }}">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password"  class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-700 bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent sm:text-sm">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"  class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-700 bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent sm:text-sm">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    Create Account
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-teal-500 hover:text-teal-400">
                        Sign in
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<div>
@include('components.footer')
</div>
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection