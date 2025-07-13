@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="mx-auto max-w-md px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white shadow-md">
            <div class="border-b border-gray-200 p-4 sm:p-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 text-center">Login</h2>
                <p class="mt-1 text-sm text-gray-600 text-center">Entre com suas credenciais</p>
            </div>

            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="@error('email') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-3 py-3 sm:py-2 text-base sm:text-sm transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                            placeholder="seu@email.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                        <input type="password" id="password" name="password" required
                            class="@error('password') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-3 py-3 sm:py-2 text-base sm:text-sm transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                            placeholder="Digite sua senha">
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Lembrar-me</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="space-y-4">
                        <button type="submit"
                            class="w-full rounded-lg bg-blue-600 px-4 py-3 text-base font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Demo credentials info -->
        <div class="mt-6 rounded-lg bg-blue-50 p-4">
            <h3 class="text-sm font-medium text-blue-900 mb-2">Credenciais de demonstração:</h3>
            <p class="text-sm text-blue-700">
                <strong>Email:</strong> admin@contacts.com<br>
                <strong>Senha:</strong> password123
            </p>
        </div>
    </div>
@endsection